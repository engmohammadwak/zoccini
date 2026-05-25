<?php

namespace App\Http\Controllers\Admin;

use App\Models\AllAd;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Expense;
use App\Models\Favorite;
use App\Models\Income;
use App\Models\Item;
use App\Models\Order;
use App\Models\Partner;
use App\Models\QaTopic;
use App\Models\Rate;
use App\Models\Report;
use App\Models\Restaurant;
use App\Models\SubscriptionUser;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserPoint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeController
{
    public function index()
    {
        if (Auth::user()->user_type == 12) {
            return redirect()->to(url('lhome'));
        }

        $user      = Auth::user();
        $userType  = $user->user_type;
        $isAdmin   = $userType == 1;
        $isRestaurant = $userType == 3;

        // Resolve restaurant id for restaurant users
        $restId = null;
        if ($isRestaurant) {
            $restaurant = Restaurant::where('restaurant_id', $user->id)->first();
            $restId = $restaurant ? $restaurant->id : $user->id;
        }

        // Subscription banner
        $subEndDay = null;
        if ($isRestaurant) {
            $sub = SubscriptionUser::where('user_id', $user->id)->where('status', 1)->first();
            $subEndDay = $sub ? $sub->end_day : null;
        }

        // ═══════════════════ ORDERS ═══════════════════
        $ordersQ = Order::query();
        if ($isRestaurant) $ordersQ->where('restaurants_id', $restId);

        $totalOrders     = (clone $ordersQ)->count();
        $ordersToday     = (clone $ordersQ)->whereDate('created_at', Carbon::today())->count();
        $ordersWeek      = (clone $ordersQ)->where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $ordersMonth     = (clone $ordersQ)->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $ordersCompleted = (clone $ordersQ)->where('status_id', 2)->count();
        $ordersPending   = (clone $ordersQ)->where('status_id', 1)->count();
        $ordersReserved  = (clone $ordersQ)->where('status_id', 3)->count();
        $ordersCancelled = (clone $ordersQ)->where('status_id', 4)->count();
        $ordersLast7     = (clone $ordersQ)->where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $ordersLast14    = (clone $ordersQ)->where('created_at', '>=', Carbon::now()->subDays(14))->count();
        $ordersLast30    = (clone $ordersQ)->where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $ordersYear      = (clone $ordersQ)->where('created_at', '>=', Carbon::now()->startOfYear())->count();
        $latestOrders    = (clone $ordersQ)->with(['user', 'restaurants', 'status'])->latest()->take(10)->get();

        // Charts data: last 14 days
        $ordersChartLabels = [];
        $ordersChartData   = [];
        $revenueChartData  = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $ordersChartLabels[] = $day->format('d/m');
            $dq = Order::whereDate('created_at', $day);
            if ($isRestaurant) $dq->where('restaurants_id', $restId);
            $ordersChartData[]  = $dq->count();
            $revenueChartData[] = (float)$dq->sum('final_price');
        }

        // Top restaurants by orders (admin)
        $topRestaurantsByOrders = collect();
        if ($isAdmin) {
            $topRestaurantsByOrders = Order::select('restaurants_id', DB::raw('count(*) as cnt'))
                ->with('restaurants')
                ->groupBy('restaurants_id')
                ->orderByDesc('cnt')
                ->take(5)
                ->get();
        }

        // ═══════════════════ REVENUE ═══════════════════
        $revQ = Order::where('status_id', 2);
        if ($isRestaurant) $revQ->where('restaurants_id', $restId);

        $revenueTotal  = (clone $revQ)->sum('final_price');
        $revenueToday  = (clone $revQ)->whereDate('created_at', Carbon::today())->sum('final_price');
        $revenueMonth  = (clone $revQ)->where('created_at', '>=', Carbon::now()->startOfMonth())->sum('final_price');
        $avgOrderValue = $totalOrders > 0 ? $revenueTotal / $totalOrders : 0;

        // ═══════════════════ USERS & RESTAURANTS ═══════════════════
        $totalUsers        = $isAdmin ? User::where('user_type', 2)->count() : 0;
        $newUsersToday     = $isAdmin ? User::where('user_type', 2)->whereDate('created_at', Carbon::today())->count() : 0;
        $newUsersWeek      = $isAdmin ? User::where('user_type', 2)->where('created_at', '>=', Carbon::now()->startOfWeek())->count() : 0;
        $totalRestaurants  = $isAdmin ? User::where('user_type', 3)->count() : 0;
        $activeRestaurants = $isAdmin ? Restaurant::where('active', 1)->count() : 0;
        $newRestWeek       = $isAdmin ? User::where('user_type', 3)->where('created_at', '>=', Carbon::now()->startOfWeek())->count() : 0;

        // ═══════════════════ ITEMS ═══════════════════
        $itemsQ = Item::query();
        if ($isRestaurant) $itemsQ->where('restaurant_id', $restId);
        $totalItems  = (clone $itemsQ)->count();
        $activeItems = (clone $itemsQ)->where('active', 1)->count();

        // ═══════════════════ RATINGS ═══════════════════
        $ratesQ = Rate::query();
        if ($isRestaurant) $ratesQ->where('restaurant_id', $restId);

        $totalRatings = (clone $ratesQ)->count();
        $avgRating    = (clone $ratesQ)->avg('rating') ?? 0;
        $rating5      = (clone $ratesQ)->where('rating', 5)->count();
        $rating4      = (clone $ratesQ)->whereBetween('rating', [4, 4.99])->count();
        $rating3      = (clone $ratesQ)->whereBetween('rating', [3, 3.99])->count();
        $ratingBelow3 = (clone $ratesQ)->where('rating', '<', 3)->count();

        $topRatedRestaurants = collect();
        if ($isAdmin) {
            $topRatedRestaurants = Rate::select('restaurant_id', DB::raw('avg(rating) as avg_rate'), DB::raw('count(*) as cnt'))
                ->with('restaurant')
                ->groupBy('restaurant_id')
                ->orderByDesc('avg_rate')
                ->take(5)
                ->get();
        }

        // ═══════════════════ COUPONS, FAVORITES, ADS ═══════════════════
        $totalCoupons  = class_exists(Coupon::class) ? Coupon::count() : 0;
        $activeCoupons = class_exists(Coupon::class) ? Coupon::where('active', 1)->count() : 0;

        $totalFavorites = class_exists(Favorite::class)
            ? ($isRestaurant ? Favorite::where('restaurant_id', $restId)->count() : Favorite::count())
            : 0;

        $totalAds  = class_exists(AllAd::class) ? AllAd::count() : 0;
        $activeAds = class_exists(AllAd::class) ? AllAd::where('status', 1)->count() : 0;

        // ═══════════════════ RESTAURANT-SPECIFIC ═══════════════════
        $restVisits    = 0;
        $restFavorites = 0;
        $restCartItems = 0;
        if ($isRestaurant) {
            $rest = Restaurant::find($restId);
            $restVisits    = $rest ? ($rest->visits ?? 0) : 0;
            $restFavorites = class_exists(Favorite::class) ? Favorite::where('restaurant_id', $restId)->count() : 0;
            $restCartItems = class_exists(CartItem::class)
                ? CartItem::whereHas('item', fn($q) => $q->where('restaurant_id', $restId))->count()
                : 0;
        }

        // ═══════════════════ FINANCE (admin) ═══════════════════
        $totalIncome    = 0;
        $incomeMonth    = 0;
        $totalExpense   = 0;
        $expenseMonth   = 0;
        $netProfit      = 0;
        $netProfitMonth = 0;
        if ($isAdmin) {
            if (class_exists(Income::class) && Schema::hasTable('incomes')) {
                $totalIncome = Income::sum('amount');
                $incomeMonth = Income::where('created_at', '>=', Carbon::now()->startOfMonth())->sum('amount');
            } else {
                $totalIncome = $revenueTotal;
                $incomeMonth = $revenueMonth;
            }
            if (class_exists(Expense::class) && Schema::hasTable('expenses')) {
                $totalExpense = Expense::sum('amount');
                $expenseMonth = Expense::where('created_at', '>=', Carbon::now()->startOfMonth())->sum('amount');
            }
            $netProfit      = $totalIncome - $totalExpense;
            $netProfitMonth = $incomeMonth - $expenseMonth;
        }

        // ═══════════════════ SUBSCRIPTIONS (admin) ═══════════════════
        $activeSubs    = 0;
        $expiredSubs   = 0;
        $subsThisMonth = 0;
        if ($isAdmin) {
            $activeSubs    = SubscriptionUser::where('status', 1)->count();
            $expiredSubs   = SubscriptionUser::where('status', '!=', 1)->count();
            $subsThisMonth = SubscriptionUser::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        }

        // ═══════════════════ SUPPORT TICKETS (admin) ═══════════════════
        $totalTickets  = 0;
        $openTickets   = 0;
        $closedTickets = 0;
        $latestTickets = collect();
        if ($isAdmin && class_exists(Ticket::class) && Schema::hasTable('tickets')) {
            $totalTickets  = Ticket::count();
            $openTickets   = Ticket::where('ticket_status_id', 1)->count();
            $closedTickets = Ticket::where('ticket_status_id', '!=', 1)->count();
            $latestTickets = Ticket::with(['user', 'status'])->latest()->take(8)->get();
        }

        // ═══════════════════ MISC (admin) ═══════════════════
        $totalContacts  = 0;
        $totalPartners  = 0;
        $totalReports   = 0;
        $pendingReports = 0;
        $totalQa        = 0;
        $openQa         = 0;
        $totalPoints    = 0;
        if ($isAdmin) {
            if (class_exists(\App\Models\Contact::class) && Schema::hasTable('contacts')) {
                $totalContacts = \App\Models\Contact::count();
            }
            if (class_exists(Partner::class) && Schema::hasTable('partners')) {
                $totalPartners = Partner::count();
            }
            if (class_exists(Report::class) && Schema::hasTable('reports')) {
                $totalReports   = Report::count();
                $pendingReports = Report::where('status', 0)->count();
            }
            if (class_exists(QaTopic::class) && Schema::hasTable('qa_topics')) {
                $totalQa = QaTopic::count();
                $openQa  = QaTopic::where('status', 'open')->count();
            }
            if (class_exists(UserPoint::class) && Schema::hasTable('user_points')) {
                $totalPoints = UserPoint::sum('points');
            }
        }

        return view('home', compact(
            'isAdmin', 'isRestaurant', 'subEndDay',
            'totalOrders', 'ordersToday', 'ordersWeek', 'ordersMonth',
            'ordersCompleted', 'ordersPending', 'ordersReserved', 'ordersCancelled',
            'ordersLast7', 'ordersLast14', 'ordersLast30', 'ordersYear',
            'latestOrders', 'topRestaurantsByOrders',
            'ordersChartLabels', 'ordersChartData', 'revenueChartData',
            'revenueTotal', 'revenueToday', 'revenueMonth', 'avgOrderValue',
            'totalUsers', 'newUsersToday', 'newUsersWeek',
            'totalRestaurants', 'activeRestaurants', 'newRestWeek',
            'totalItems', 'activeItems',
            'totalRatings', 'avgRating',
            'rating5', 'rating4', 'rating3', 'ratingBelow3',
            'topRatedRestaurants',
            'totalCoupons', 'activeCoupons', 'totalFavorites',
            'totalAds', 'activeAds',
            'restVisits', 'restFavorites', 'restCartItems',
            'totalIncome', 'incomeMonth', 'totalExpense', 'expenseMonth',
            'netProfit', 'netProfitMonth',
            'activeSubs', 'expiredSubs', 'subsThisMonth',
            'totalTickets', 'openTickets', 'closedTickets', 'latestTickets',
            'totalContacts', 'totalPartners',
            'totalReports', 'pendingReports',
            'totalQa', 'openQa', 'totalPoints'
        ));
    }
}
