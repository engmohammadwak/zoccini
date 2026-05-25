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
    /**
     * Resolve the actual table name from a model class safely.
     * Returns null if the class doesn't exist or the table doesn't exist in DB.
     */
    private function modelTable(string $class): ?string
    {
        if (!class_exists($class)) return null;
        $table = (new $class)->getTable();
        return Schema::hasTable($table) ? $table : null;
    }

    /** Find the best available price column in the orders table. */
    private function priceCol(): ?string
    {
        static $col = false;
        if ($col === false) {
            foreach (['final_price','total_price','total','price','amount','order_total'] as $c) {
                if (Schema::hasColumn('orders', $c)) { $col = $c; break; }
            }
            if ($col === false) $col = null;
        }
        return $col;
    }

    /** Safe sum — returns 0 if price column doesn't exist. */
    private function safeSum($query, ?string $col): float
    {
        if (!$col) return 0;
        return (float) $query->sum($col);
    }

    /** Safe column check — cached. */
    private function safeCol(string $table, string $col): bool
    {
        static $cache = [];
        $key = $table.'.'.$col;
        if (!isset($cache[$key])) {
            $cache[$key] = Schema::hasColumn($table, $col);
        }
        return $cache[$key];
    }

    public function index()
    {
        if (Auth::user()->user_type == 12) {
            return redirect()->to(url('lhome'));
        }

        $user         = Auth::user();
        $userType     = $user->user_type;
        $isAdmin      = $userType == 1;
        $isRestaurant = $userType == 3;
        $priceCol     = $this->priceCol();

        // Resolve restaurant id for restaurant users
        $restId = null;
        if ($isRestaurant) {
            $restaurant = Restaurant::where('restaurant_id', $user->id)->first();
            $restId = $restaurant ? $restaurant->id : $user->id;
        }

        // Subscription banner
        $subEndDay = null;
        if ($isRestaurant) {
            $subTable = $this->modelTable(SubscriptionUser::class);
            if ($subTable) {
                $sub = SubscriptionUser::where('user_id', $user->id)->where('status', 1)->first();
                $subEndDay = $sub ? $sub->end_day : null;
            }
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

        // Charts: last 14 days
        $ordersChartLabels = [];
        $ordersChartData   = [];
        $revenueChartData  = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $ordersChartLabels[] = $day->format('d/m');
            $dq = Order::whereDate('created_at', $day);
            if ($isRestaurant) $dq->where('restaurants_id', $restId);
            $ordersChartData[]  = $dq->count();
            $revenueChartData[] = $this->safeSum(clone $dq, $priceCol);
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

        $revenueTotal  = $this->safeSum(clone $revQ, $priceCol);
        $revenueToday  = $this->safeSum((clone $revQ)->whereDate('created_at', Carbon::today()), $priceCol);
        $revenueMonth  = $this->safeSum((clone $revQ)->where('created_at', '>=', Carbon::now()->startOfMonth()), $priceCol);
        $avgOrderValue = $totalOrders > 0 ? $revenueTotal / $totalOrders : 0;

        // ═══════════════════ USERS & RESTAURANTS ═══════════════════
        $totalUsers        = $isAdmin ? User::where('user_type', 2)->count() : 0;
        $newUsersToday     = $isAdmin ? User::where('user_type', 2)->whereDate('created_at', Carbon::today())->count() : 0;
        $newUsersWeek      = $isAdmin ? User::where('user_type', 2)->where('created_at', '>=', Carbon::now()->startOfWeek())->count() : 0;
        $totalRestaurants  = $isAdmin ? User::where('user_type', 3)->count() : 0;
        $newRestWeek       = $isAdmin ? User::where('user_type', 3)->where('created_at', '>=', Carbon::now()->startOfWeek())->count() : 0;

        $activeRestaurants = 0;
        if ($isAdmin) {
            $restTable = $this->modelTable(Restaurant::class);
            if ($restTable) {
                $activeRestaurants = $this->safeCol($restTable, 'active')
                    ? Restaurant::where('active', 1)->count()
                    : Restaurant::count();
            }
        }

        // ═══════════════════ ITEMS ═══════════════════
        $itemsQ = Item::query();
        if ($isRestaurant) $itemsQ->where('restaurant_id', $restId);
        $totalItems  = (clone $itemsQ)->count();
        $itemTable   = $this->modelTable(Item::class);
        $activeItems = ($itemTable && $this->safeCol($itemTable, 'active'))
            ? (clone $itemsQ)->where('active', 1)->count()
            : $totalItems;

        // ═══════════════════ RATINGS ═══════════════════
        $totalRatings        = 0;
        $avgRating           = 0;
        $rating5             = 0;
        $rating4             = 0;
        $rating3             = 0;
        $ratingBelow3        = 0;
        $topRatedRestaurants = collect();

        $rateTable = $this->modelTable(Rate::class);
        if ($rateTable) {
            $ratesQ = Rate::query();
            if ($isRestaurant && $this->safeCol($rateTable, 'restaurant_id')) {
                $ratesQ->where('restaurant_id', $restId);
            }
            $totalRatings = (clone $ratesQ)->count();
            $avgRating    = (clone $ratesQ)->avg('rating') ?? 0;
            if ($this->safeCol($rateTable, 'rating')) {
                $rating5      = (clone $ratesQ)->where('rating', 5)->count();
                $rating4      = (clone $ratesQ)->whereBetween('rating', [4, 4.99])->count();
                $rating3      = (clone $ratesQ)->whereBetween('rating', [3, 3.99])->count();
                $ratingBelow3 = (clone $ratesQ)->where('rating', '<', 3)->count();
            }
            if ($isAdmin && $this->safeCol($rateTable, 'restaurant_id')) {
                $topRatedRestaurants = Rate::select('restaurant_id', DB::raw('avg(rating) as avg_rate'), DB::raw('count(*) as cnt'))
                    ->with('restaurant')
                    ->groupBy('restaurant_id')
                    ->orderByDesc('avg_rate')
                    ->take(5)
                    ->get();
            }
        }

        // ═══════════════════ COUPONS, FAVORITES, ADS ═══════════════════
        $totalCoupons  = 0;
        $activeCoupons = 0;
        $couponTable   = $this->modelTable(Coupon::class);
        if ($couponTable) {
            $totalCoupons  = Coupon::count();
            $activeCoupons = $this->safeCol($couponTable, 'active')
                ? Coupon::where('active', 1)->count()
                : $totalCoupons;
        }

        $totalFavorites = 0;
        $favTable = $this->modelTable(Favorite::class);
        if ($favTable) {
            $totalFavorites = ($isRestaurant && $this->safeCol($favTable, 'restaurant_id'))
                ? Favorite::where('restaurant_id', $restId)->count()
                : Favorite::count();
        }

        $totalAds  = 0;
        $activeAds = 0;
        $adTable   = $this->modelTable(AllAd::class);
        if ($adTable) {
            $totalAds  = AllAd::count();
            $activeAds = $this->safeCol($adTable, 'status')
                ? AllAd::where('status', 1)->count()
                : $totalAds;
        }

        // ═══════════════════ RESTAURANT-SPECIFIC ═══════════════════
        $restVisits    = 0;
        $restFavorites = 0;
        $restCartItems = 0;
        if ($isRestaurant) {
            $rest          = Restaurant::find($restId);
            $restTable2    = $this->modelTable(Restaurant::class);
            $restVisits    = ($rest && $restTable2 && $this->safeCol($restTable2, 'visits')) ? ($rest->visits ?? 0) : 0;
            $restFavorites = ($favTable && $this->safeCol($favTable, 'restaurant_id'))
                ? Favorite::where('restaurant_id', $restId)->count() : 0;
            $cartTable = $this->modelTable(CartItem::class);
            $restCartItems = $cartTable
                ? CartItem::whereHas('item', fn($q) => $q->where('restaurant_id', $restId))->count() : 0;
        }

        // ═══════════════════ FINANCE (admin) ═══════════════════
        $totalIncome    = 0;
        $incomeMonth    = 0;
        $totalExpense   = 0;
        $expenseMonth   = 0;
        $netProfit      = 0;
        $netProfitMonth = 0;
        if ($isAdmin) {
            $incomeTable = $this->modelTable(Income::class);
            if ($incomeTable) {
                $totalIncome = Income::sum('amount');
                $incomeMonth = Income::where('created_at', '>=', Carbon::now()->startOfMonth())->sum('amount');
            } else {
                $totalIncome = $revenueTotal;
                $incomeMonth = $revenueMonth;
            }
            $expenseTable = $this->modelTable(Expense::class);
            if ($expenseTable) {
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
            $subTable2 = $this->modelTable(SubscriptionUser::class);
            if ($subTable2) {
                $activeSubs    = SubscriptionUser::where('status', 1)->count();
                $expiredSubs   = SubscriptionUser::where('status', '!=', 1)->count();
                $subsThisMonth = SubscriptionUser::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
            }
        }

        // ═══════════════════ SUPPORT TICKETS (admin) ═══════════════════
        $totalTickets  = 0;
        $openTickets   = 0;
        $closedTickets = 0;
        $latestTickets = collect();
        if ($isAdmin) {
            $ticketTable = $this->modelTable(Ticket::class);
            if ($ticketTable) {
                $totalTickets  = Ticket::count();
                $openTickets   = $this->safeCol($ticketTable, 'ticket_status_id') ? Ticket::where('ticket_status_id', 1)->count() : 0;
                $closedTickets = $this->safeCol($ticketTable, 'ticket_status_id') ? Ticket::where('ticket_status_id', '!=', 1)->count() : 0;
                $latestTickets = Ticket::with(['user', 'status'])->latest()->take(8)->get();
            }
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
            $contactTable = $this->modelTable(\App\Models\Contact::class);
            if ($contactTable) {
                $totalContacts = \App\Models\Contact::count();
            }

            $partnerTable = $this->modelTable(Partner::class);
            if ($partnerTable) {
                $totalPartners = Partner::count();
            }

            $reportTable = $this->modelTable(Report::class);
            if ($reportTable) {
                $totalReports   = Report::count();
                $pendingReports = $this->safeCol($reportTable, 'status') ? Report::where('status', 0)->count() : 0;
            }

            $qaTable = $this->modelTable(QaTopic::class);
            if ($qaTable) {
                $totalQa = QaTopic::count();
                $openQa  = $this->safeCol($qaTable, 'status') ? QaTopic::where('status', 'open')->count() : 0;
            }

            $pointsTable = $this->modelTable(UserPoint::class);
            if ($pointsTable) {
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
