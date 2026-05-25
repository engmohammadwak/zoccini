<?php

namespace App\Http\Controllers\Admin;

use App\Models\AllAd;
use App\Models\BecomePartner;
use App\Models\Cart;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Expense;
use App\Models\Favorite;
use App\Models\Income;
use App\Models\Item;
use App\Models\Order;
use App\Models\Point;
use App\Models\QaTopic;
use App\Models\Rate;
use App\Models\Reporting;
use App\Models\Restaurant;
use App\Models\SubscriptionUser;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController
{
    public function index()
    {
        if (Auth::user()['user_type'] == 12) {
            return redirect()->to(url('lhome'));
        }

        $isAdmin      = Auth::user()->user_type == 1;
        $isRestaurant = Auth::user()->user_type == 3;

        // Resolve restaurant auth id
        if ($isRestaurant) {
            $restaurant = Restaurant::where('restaurant_id', Auth::id())->first();
            $auth = $restaurant ? $restaurant->id : Auth::id();
        } else {
            $auth = Auth::id();
        }

        // ══════════════════════════════════════════════════
        //  SECTION 1 — USERS & RESTAURANTS
        // ══════════════════════════════════════════════════
        $totalUsers        = User::where('user_type', 2)->count();
        $totalRestaurants  = User::where('user_type', 3)->count();
        $newUsersToday     = User::where('user_type', 2)->whereDate('created_at', today())->count();
        $newUsersWeek      = User::where('user_type', 2)->where('created_at', '>=', now()->startOfWeek())->count();
        $newRestWeek       = User::where('user_type', 3)->where('created_at', '>=', now()->startOfWeek())->count();
        $activeRestaurants = Restaurant::where('active', 1)->count();

        // ══════════════════════════════════════════════════
        //  SECTION 2 — ORDERS
        // ══════════════════════════════════════════════════
        $ordersBase = $isRestaurant ? Order::where('restaurants_id', $auth) : Order::query();

        $totalOrders     = (clone $ordersBase)->count();
        $ordersToday     = (clone $ordersBase)->whereDate('created_at', today())->count();
        $ordersWeek      = (clone $ordersBase)->where('created_at', '>=', now()->startOfWeek())->count();
        $ordersMonth     = (clone $ordersBase)->where('created_at', '>=', now()->startOfMonth())->count();
        $ordersCompleted = (clone $ordersBase)->where('status_id', 2)->count();
        $ordersPending   = (clone $ordersBase)->where('status_id', 1)->count();
        $ordersCancelled = (clone $ordersBase)->where('status_id', 4)->count();
        $ordersReserved  = (clone $ordersBase)->where('status_id', 3)->count();
        $ordersLast7     = (clone $ordersBase)->where('created_at', '>=', now()->subDays(7))->count();
        $ordersLast14    = (clone $ordersBase)->where('created_at', '>=', now()->subDays(14))->count();
        $ordersLast30    = (clone $ordersBase)->where('created_at', '>=', now()->subDays(30))->count();
        $ordersYear      = (clone $ordersBase)->where('created_at', '>=', now()->startOfYear())->count();

        // Revenue
        $revenueTotal    = (clone $ordersBase)->where('status_id', 2)->sum('final_price');
        $revenueToday    = (clone $ordersBase)->where('status_id', 2)->whereDate('created_at', today())->sum('final_price');
        $revenueMonth    = (clone $ordersBase)->where('status_id', 2)->where('created_at', '>=', now()->startOfMonth())->sum('final_price');
        $revenueYear     = (clone $ordersBase)->where('status_id', 2)->where('created_at', '>=', now()->startOfYear())->sum('final_price');
        $avgOrderValue   = $ordersCompleted > 0 ? round($revenueTotal / $ordersCompleted, 2) : 0;

        // Orders by day for last 14 days (chart)
        $ordersByDay = (clone $ordersBase)
            ->where('created_at', '>=', now()->subDays(13))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $ordersChartLabels = [];
        $ordersChartData   = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $ordersChartLabels[] = now()->subDays($i)->format('d/m');
            $ordersChartData[]   = $ordersByDay[$day] ?? 0;
        }

        // Revenue by day for last 14 days (chart)
        $revenueByDay = (clone $ordersBase)
            ->where('status_id', 2)
            ->where('created_at', '>=', now()->subDays(13))
            ->selectRaw('DATE(created_at) as date, SUM(final_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $revenueChartData = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $revenueChartData[] = $revenueByDay[$day] ?? 0;
        }

        // Top 5 restaurants by orders (admin only)
        $topRestaurantsByOrders = $isAdmin
            ? Order::selectRaw('restaurants_id, COUNT(*) as cnt')
                ->groupBy('restaurants_id')
                ->orderByDesc('cnt')
                ->with('restaurants')
                ->limit(5)
                ->get()
            : collect();

        // Latest orders
        $latestOrders = $isRestaurant
            ? Order::where('restaurants_id', $auth)->latest()->with(['user', 'status'])->limit(8)->get()
            : Order::latest()->with(['user', 'restaurants', 'status'])->limit(8)->get();

        // ══════════════════════════════════════════════════
        //  SECTION 3 — ITEMS & CATEGORIES
        // ══════════════════════════════════════════════════
        $totalItems   = $isRestaurant ? Item::where('restaurant_id', $auth)->count() : Item::count();
        $activeItems  = $isRestaurant
            ? Item::where('restaurant_id', $auth)->where('active', 1)->count()
            : Item::where('active', 1)->count();

        // ══════════════════════════════════════════════════
        //  SECTION 4 — RATINGS
        // ══════════════════════════════════════════════════
        $totalRatings  = $isRestaurant ? Rate::where('restaurant_id', $auth)->count() : Rate::count();
        $avgRating     = $isRestaurant ? (Rate::where('restaurant_id', $auth)->avg('rating') ?? 0) : (Rate::avg('rating') ?? 0);
        $rating5       = $isRestaurant ? Rate::where('restaurant_id', $auth)->where('rating', 5)->count() : Rate::where('rating', 5)->count();
        $rating4       = $isRestaurant ? Rate::where('restaurant_id', $auth)->where('rating', 4)->count() : Rate::where('rating', 4)->count();
        $rating3       = $isRestaurant ? Rate::where('restaurant_id', $auth)->where('rating', 3)->count() : Rate::where('rating', 3)->count();
        $ratingBelow3  = $isRestaurant ? Rate::where('restaurant_id', $auth)->where('rating', '<', 3)->count() : Rate::where('rating', '<', 3)->count();

        // Top 5 rated restaurants (admin)
        $topRatedRestaurants = $isAdmin
            ? Rate::selectRaw('restaurant_id, AVG(rating) as avg_rate, COUNT(*) as cnt')
                ->groupBy('restaurant_id')
                ->having('cnt', '>=', 3)
                ->orderByDesc('avg_rate')
                ->with('restaurant')
                ->limit(5)
                ->get()
            : collect();

        // ══════════════════════════════════════════════════
        //  SECTION 5 — COUPONS
        // ══════════════════════════════════════════════════
        $totalCoupons   = Coupon::count();
        $activeCoupons  = Coupon::where('active', 1)->count();
        $expiredCoupons = Coupon::where('active', 0)->count();

        // ══════════════════════════════════════════════════
        //  SECTION 6 — FAVORITES
        // ══════════════════════════════════════════════════
        $totalFavorites = $isRestaurant
            ? Favorite::where('restaurant_id', $auth)->count()
            : Favorite::count();

        // Top favorited restaurants (admin)
        $topFavorited = $isAdmin
            ? Favorite::selectRaw('restaurant_id, COUNT(*) as cnt')
                ->groupBy('restaurant_id')
                ->orderByDesc('cnt')
                ->with('restaurant')
                ->limit(5)
                ->get()
            : collect();

        // ══════════════════════════════════════════════════
        //  SECTION 7 — TICKETS (SUPPORT)
        // ══════════════════════════════════════════════════
        $totalTickets  = Ticket::count();
        $openTickets   = Ticket::where('ticket_status_id', 1)->count();
        $closedTickets = Ticket::where('ticket_status_id', 2)->count();
        $latestTickets = Ticket::latest()->with(['user', 'status'])->limit(5)->get();

        // ══════════════════════════════════════════════════
        //  SECTION 8 — ADS
        // ══════════════════════════════════════════════════
        $totalAds  = AllAd::count();
        $activeAds = AllAd::where('status', 1)->count();

        // ══════════════════════════════════════════════════
        //  SECTION 9 — INCOME & EXPENSE
        // ══════════════════════════════════════════════════
        $totalIncome   = Income::sum('amount');
        $incomeMonth   = Income::where('created_at', '>=', now()->startOfMonth())->sum('amount');
        $totalExpense  = Expense::sum('amount');
        $expenseMonth  = Expense::where('created_at', '>=', now()->startOfMonth())->sum('amount');
        $netProfit     = $totalIncome - $totalExpense;
        $netProfitMonth= $incomeMonth - $expenseMonth;

        // ══════════════════════════════════════════════════
        //  SECTION 10 — SUBSCRIPTIONS
        // ══════════════════════════════════════════════════
        $activeSubs     = SubscriptionUser::where('status', 1)->count();
        $expiredSubs    = SubscriptionUser::where('status', 0)->count();
        $subsThisMonth  = SubscriptionUser::where('created_at', '>=', now()->startOfMonth())->count();

        // ══════════════════════════════════════════════════
        //  SECTION 11 — POINTS
        // ══════════════════════════════════════════════════
        $totalPoints = Point::sum('amount');

        // ══════════════════════════════════════════════════
        //  SECTION 12 — CONTACTS & PARTNERS & REPORTS
        // ══════════════════════════════════════════════════
        $totalContacts   = Contact::count();
        $totalPartners   = BecomePartner::count();
        $totalReports    = Reporting::count();
        $pendingReports  = Reporting::where('seen', 0)->count();

        // ══════════════════════════════════════════════════
        //  SECTION 13 — QA TOPICS
        // ══════════════════════════════════════════════════
        $openQa  = QaTopic::where('status', 0)->count();
        $totalQa = QaTopic::count();

        // ══════════════════════════════════════════════════
        //  SECTION 14 — RESTAURANT-SPECIFIC
        // ══════════════════════════════════════════════════
        if ($isRestaurant) {
            $restRecord      = Restaurant::find($auth);
            $restVisits      = $restRecord ? $restRecord->visits : 0;
            $restFavorites   = Favorite::where('restaurant_id', $auth)->count();
            $restCartItems   = Cart::where('restaurant_id', $auth)->count();
        } else {
            $restVisits    = 0;
            $restFavorites = 0;
            $restCartItems = 0;
        }

        // ══════════════════════════════════════════════════
        //  SUBSCRIPTION BANNER
        // ══════════════════════════════════════════════════
        $subEndDay = null;
        if ($isRestaurant) {
            $subEndDay = optional(SubscriptionUser::where('user_id', Auth::id())->where('status', 1)->first())->end_day;
        }

        return view('home', compact(
            // meta
            'isAdmin', 'isRestaurant',
            // users
            'totalUsers', 'totalRestaurants', 'newUsersToday', 'newUsersWeek', 'newRestWeek', 'activeRestaurants',
            // orders
            'totalOrders', 'ordersToday', 'ordersWeek', 'ordersMonth',
            'ordersCompleted', 'ordersPending', 'ordersCancelled', 'ordersReserved',
            'ordersLast7', 'ordersLast14', 'ordersLast30', 'ordersYear',
            'ordersChartLabels', 'ordersChartData',
            'revenueTotal', 'revenueToday', 'revenueMonth', 'revenueYear', 'avgOrderValue',
            'revenueChartData', 'topRestaurantsByOrders', 'latestOrders',
            // items
            'totalItems', 'activeItems',
            // ratings
            'totalRatings', 'avgRating', 'rating5', 'rating4', 'rating3', 'ratingBelow3', 'topRatedRestaurants',
            // coupons
            'totalCoupons', 'activeCoupons', 'expiredCoupons',
            // favorites
            'totalFavorites', 'topFavorited',
            // tickets
            'totalTickets', 'openTickets', 'closedTickets', 'latestTickets',
            // ads
            'totalAds', 'activeAds',
            // income/expense
            'totalIncome', 'incomeMonth', 'totalExpense', 'expenseMonth', 'netProfit', 'netProfitMonth',
            // subscriptions
            'activeSubs', 'expiredSubs', 'subsThisMonth',
            // points
            'totalPoints',
            // contacts
            'totalContacts', 'totalPartners', 'totalReports', 'pendingReports',
            // qa
            'openQa', 'totalQa',
            // restaurant-specific
            'restVisits', 'restFavorites', 'restCartItems',
            // sub banner
            'subEndDay'
        ));
    }
}
