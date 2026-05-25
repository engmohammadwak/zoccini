@php
    $user = \Illuminate\Support\Facades\Auth::id();
    $status = true;
if (\Illuminate\Support\Facades\Auth::user()['user_type'] == 3)
    {
         $restaurant = \App\Models\Restaurant::where('restaurant_id' , $user)->first();
    if ($restaurant && $restaurant->plan){
        if ($restaurant->plan->have_map == 1)
            {
               $status = false;
            }
    }
    }

@endphp

<style>
/* =============================
   SIDEBAR — Modern Redesign
============================= */
.main-sidebar {
    background: linear-gradient(180deg, #1a1f2e 0%, #141824 100%) !important;
    box-shadow: 4px 0 20px rgba(0,0,0,0.3) !important;
    border-right: none !important;
}

.main-sidebar .brand-link {
    background: rgba(255,255,255,0.04) !important;
    border-bottom: 1px solid rgba(255,255,255,0.06) !important;
    padding: 14px 16px !important;
    display: flex !important;
    align-items: center !important;
    gap: 10px;
    transition: background 0.2s;
}
.main-sidebar .brand-link:hover {
    background: rgba(255,255,255,0.07) !important;
}
.brand-logo-icon {
    width: 34px;
    height: 34px;
    background: linear-gradient(135deg, #4f7cff 0%, #7c4fff 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #fff;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(79,124,255,0.4);
}
.brand-text {
    color: #fff !important;
    font-size: 1rem !important;
    font-weight: 700 !important;
    letter-spacing: 0.3px;
}

/* Sidebar user panel */
.sidebar .user-panel {
    background: rgba(255,255,255,0.03);
    border-bottom: 1px solid rgba(255,255,255,0.06);
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.sidebar .user-panel .user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4f7cff, #7c4fff);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: #fff;
    font-weight: 700;
    flex-shrink: 0;
}
.sidebar .user-panel .user-name {
    color: #e0e4f0;
    font-size: 0.82rem;
    font-weight: 600;
    line-height: 1.2;
}
.sidebar .user-panel .user-role {
    color: rgba(255,255,255,0.35);
    font-size: 0.72rem;
}

/* Nav section labels */
.nav-section-label {
    color: rgba(255,255,255,0.25) !important;
    font-size: 0.65rem !important;
    font-weight: 700 !important;
    letter-spacing: 1.2px !important;
    text-transform: uppercase !important;
    padding: 14px 18px 4px !important;
    display: block;
}

/* Nav items */
.nav-sidebar > .nav-item > .nav-link,
.nav-sidebar .nav-treeview .nav-item .nav-link {
    color: rgba(210,218,240,0.75) !important;
    border-radius: 8px !important;
    margin: 1px 8px !important;
    padding: 8px 12px !important;
    font-size: 0.83rem !important;
    font-weight: 500 !important;
    transition: all 0.18s ease !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.nav-sidebar > .nav-item > .nav-link:hover,
.nav-sidebar .nav-treeview .nav-item .nav-link:hover {
    background: rgba(79,124,255,0.12) !important;
    color: #fff !important;
}
.nav-sidebar > .nav-item > .nav-link.active,
.nav-sidebar .nav-treeview .nav-item .nav-link.active {
    background: linear-gradient(135deg, rgba(79,124,255,0.25), rgba(124,79,255,0.18)) !important;
    color: #fff !important;
    box-shadow: 0 2px 8px rgba(79,124,255,0.2) !important;
}
.nav-sidebar > .nav-item > .nav-link.active .nav-icon,
.nav-sidebar .nav-treeview .nav-item .nav-link.active .nav-icon {
    color: #6b9fff !important;
}

/* Nav icons */
.nav-sidebar .nav-icon {
    width: 18px !important;
    font-size: 0.8rem !important;
    margin: 0 !important;
    text-align: center !important;
    color: rgba(255,255,255,0.4) !important;
    transition: color 0.18s !important;
    flex-shrink: 0;
}
.nav-sidebar .nav-link:hover .nav-icon {
    color: rgba(255,255,255,0.75) !important;
}

/* Treeview parent links */
.nav-sidebar .nav-dropdown-toggle {
    position: relative;
}
.nav-sidebar .nav-link p {
    flex: 1;
    margin: 0 !important;
    font-size: 0.83rem !important;
    line-height: 1.3 !important;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.nav-sidebar .nav-link p .right {
    font-size: 0.7rem !important;
    opacity: 0.5;
    transition: transform 0.2s, opacity 0.2s !important;
}
.nav-sidebar .menu-open > .nav-link p .right {
    transform: rotate(-90deg);
    opacity: 0.8;
}

/* Treeview sub-items */
.nav-treeview {
    background: rgba(0,0,0,0.15) !important;
    border-radius: 8px !important;
    margin: 2px 8px !important;
    padding: 4px 0 !important;
}
.nav-treeview .nav-item .nav-link {
    padding: 6px 10px 6px 28px !important;
    font-size: 0.8rem !important;
    margin: 1px 4px !important;
    color: rgba(200,210,235,0.6) !important;
}
.nav-treeview .nav-item .nav-link:hover {
    color: #c8d2eb !important;
    background: rgba(255,255,255,0.06) !important;
}
.nav-treeview .nav-item .nav-link.active {
    color: #a0bcff !important;
    background: rgba(79,124,255,0.15) !important;
    box-shadow: none !important;
}

/* Sidebar scrollbar */
.sidebar {
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.1) transparent;
}
.sidebar::-webkit-scrollbar { width: 4px; }
.sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

/* Logout link */
.nav-logout-link .nav-link {
    color: rgba(255,120,120,0.7) !important;
    margin-top: 4px !important;
    border-top: 1px solid rgba(255,255,255,0.06) !important;
    border-radius: 0 0 8px 8px !important;
}
.nav-logout-link .nav-link:hover {
    color: #ff8080 !important;
    background: rgba(255,80,80,0.1) !important;
}

/* Sidebar footer */
.sidebar-version {
    padding: 10px 18px;
    font-size: 0.68rem;
    color: rgba(255,255,255,0.18);
    border-top: 1px solid rgba(255,255,255,0.05);
    text-align: center;
}
</style>

<aside class="main-sidebar elevation-0">
    <!-- Brand Logo -->
    <a href="{{route('home_loop')}}" class="brand-link">
        <div class="brand-logo-icon">
            <i class="fas fa-utensils"></i>
        </div>
        <span class="brand-text">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- User Panel -->
        <div class="user-panel">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="user-name">{{ Auth::user()->name ?? '' }}</div>
                <div class="user-role">{{ Auth::user()->email ?? '' }}</div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <span class="nav-section-label">{{ trans('global.dashboard') }}</span>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin') || request()->is('admin/home') ? 'active' : '' }}"
                       href="{{ $status == true ? route('admin.home') : '#' }}">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>{{ trans('global.dashboard') }}</p>
                    </a>
                </li>

                {{-- User Management --}}
                @can('user_management_access')
                <span class="nav-section-label">{{ trans('cruds.userManagement.title') }}</span>
                <li class="nav-item has-treeview
                    {{ request()->is('admin/permissions*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/roles*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/users*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/user-statuses*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/restaurants*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-users nav-icon"></i>
                        <p>{{ trans('cruds.userManagement.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('permission_access')
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.permissions.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/permissions*') ? 'active' : '' }}">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>{{ trans('cruds.permission.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('role_access')
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.roles.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/roles*') ? 'active' : '' }}">
                                <i class="fas fa-briefcase nav-icon"></i>
                                <p>{{ trans('cruds.role.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('user_access')
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.users.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                                <i class="fas fa-user-check nav-icon"></i>
                                <p>{{ trans('cruds.Admin') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ $status == true ? url('admin/users/10/type') : '#' }}"
                               class="nav-link {{ request()->is('admin/users/10/type') ? 'active' : '' }}">
                                <i class="fas fa-user-clock nav-icon"></i>
                                <p>{{ trans('cruds.employees.title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ $status == true ? url('admin/users/2/type') : '#' }}"
                               class="nav-link {{ request()->is('admin/users/2/type') ? 'active' : '' }}">
                                <i class="fas fa-user nav-icon"></i>
                                <p>{{ trans('cruds.user.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('restaurant_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.restaurants.index') }}"
                               class="nav-link {{ request()->is('admin/restaurants*') ? 'active' : '' }}">
                                <i class="fas fa-utensils nav-icon"></i>
                                <p>{{ trans('cruds.restaurant.title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/restaurants_register?type=4') }}"
                               class="nav-link {{ request()->is('admin/restaurants_register*') ? 'active' : '' }}">
                                <i class="fas fa-store nav-icon"></i>
                                <p>{{ trans('cruds.restaurant_register') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('user_status_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.user-statuses.index') }}"
                               class="nav-link {{ request()->is('admin/user-statuses*') ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt nav-icon"></i>
                                <p>{{ trans('cruds.userStatus.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('loopuser_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.loopusers.index') }}"
                               class="nav-link {{ request()->is('admin/loopusers') ? 'active' : '' }}">
                                <i class="fas fa-bullhorn nav-icon"></i>
                                <p>{{ trans('cruds.loopuser.title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/loopusers?type=1') }}"
                               class="nav-link">
                                <i class="fas fa-bullhorn nav-icon"></i>
                                <p>{{ trans('cruds.loopuserRegister') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- Employees --}}
                @can('employees_access')
                <li class="nav-item">
                    <a href="{{ $status == true ? route('admin.employees.index') : '#' }}"
                       class="nav-link {{ request()->is('admin/employees*') ? 'active' : '' }}">
                        <i class="fas fa-user-alt nav-icon"></i>
                        <p>{{ trans('cruds.employees.title') }}</p>
                    </a>
                </li>
                @endcan

                {{-- Places --}}
                @can('place_access')
                <span class="nav-section-label">{{ trans('cruds.place.title') }}</span>
                <li class="nav-item has-treeview
                    {{ request()->is('admin/countries*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/cities*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-globe-asia nav-icon"></i>
                        <p>{{ trans('cruds.place.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('country_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.countries.index') }}"
                               class="nav-link {{ request()->is('admin/countries*') ? 'active' : '' }}">
                                <i class="fas fa-flag nav-icon"></i>
                                <p>{{ trans('cruds.country.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('city_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.cities.index') }}"
                               class="nav-link {{ request()->is('admin/cities*') ? 'active' : '' }}">
                                <i class="far fa-flag nav-icon"></i>
                                <p>{{ trans('cruds.city.title') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- Restaurants Management --}}
                @can('restaurants_management_access')
                <span class="nav-section-label">{{ trans('cruds.restaurantsManagement.title') }}</span>
                <li class="nav-item has-treeview
                    {{ request()->is('admin/categories*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/items*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/sitting-areas*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/extras*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/otherbranches*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/payment-methods*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/tables*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/table-statuses*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-utensils nav-icon"></i>
                        <p>{{ trans('cruds.restaurantsManagement.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('category_access')
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.categories.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>{{ trans('cruds.category.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('item_access')
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.items.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/items*') ? 'active' : '' }}">
                                <i class="fas fa-hamburger nav-icon"></i>
                                <p>{{ trans('cruds.item.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('sitting_area_access')
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.sitting-areas.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/sitting-areas*') ? 'active' : '' }}">
                                <i class="fas fa-chair nav-icon"></i>
                                <p>{{ trans('cruds.sittingArea.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('otherbranch_access')
                        @if (\Illuminate\Support\Facades\Auth::user()['restaurant_id'] == null)
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.otherbranches.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/otherbranches*') ? 'active' : '' }}">
                                <i class="fas fa-code-branch nav-icon"></i>
                                <p>{{ trans('cruds.otherbranch.title') }}</p>
                            </a>
                        </li>
                        @endif
                        @endcan
                        @can('payment_method_access')
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.payment-methods.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/payment-methods*') ? 'active' : '' }}">
                                <i class="fas fa-credit-card nav-icon"></i>
                                <p>{{ trans('cruds.paymentMethod.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('table_access')
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.tables.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/tables*') ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>{{ trans('cruds.table.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('table_status_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.table-statuses.index') }}"
                               class="nav-link {{ request()->is('admin/table-statuses*') ? 'active' : '' }}">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>{{ trans('cruds.tableStatus.title') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- Delivery --}}
                @can('delivery_management_access')
                <span class="nav-section-label">{{ trans('cruds.deliveryManagement.title') }}</span>
                <li class="nav-item has-treeview
                    {{ request()->is('admin/deliveries*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/delivery-companies*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-motorcycle nav-icon"></i>
                        <p>{{ trans('cruds.deliveryManagement.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('delivery_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.deliveries.index') }}"
                               class="nav-link {{ request()->is('admin/deliveries*') ? 'active' : '' }}">
                                <i class="fas fa-user-ninja nav-icon"></i>
                                <p>{{ trans('cruds.delivery.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('delivery_company_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.delivery-companies.index') }}"
                               class="nav-link {{ request()->is('admin/delivery-companies*') ? 'active' : '' }}">
                                <i class="fas fa-truck nav-icon"></i>
                                <p>{{ trans('cruds.deliveryCompany.title') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- Orders --}}
                @can('order_mangement_access')
                <span class="nav-section-label">{{ trans('cruds.orderMangement.title') }}</span>
                <li class="nav-item has-treeview
                    {{ request()->is('admin/order-types*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/order-statuses*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/orders*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/cansel-reasons*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-shopping-bag nav-icon"></i>
                        <p>{{ trans('cruds.orderMangement.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('order_type_access')
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.order-types.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/order-types*') ? 'active' : '' }}">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>{{ trans('cruds.orderType.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('order_status_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.order-statuses.index') }}"
                               class="nav-link {{ request()->is('admin/order-statuses*') ? 'active' : '' }}">
                                <i class="fas fa-stream nav-icon"></i>
                                <p>{{ trans('cruds.orderStatus.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('order_access')
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.orders.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                                <i class="fas fa-receipt nav-icon"></i>
                                <p>{{ trans('cruds.order.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('cansel_reason_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.cansel-reasons.index') }}"
                               class="nav-link {{ request()->is('admin/cansel-reasons*') ? 'active' : '' }}">
                                <i class="fas fa-ban nav-icon"></i>
                                <p>{{ trans('cruds.canselReason.title') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- Ads --}}
                @can('ad_access')
                <span class="nav-section-label">{{ trans('cruds.ad.title') }}</span>
                <li class="nav-item has-treeview
                    {{ request()->is('admin/slide-shows*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/ads-categories*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/all-ads*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-ad nav-icon"></i>
                        <p>{{ trans('cruds.ad.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('slide_show_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.slide-shows.index') }}"
                               class="nav-link {{ request()->is('admin/slide-shows*') ? 'active' : '' }}">
                                <i class="fas fa-images nav-icon"></i>
                                <p>{{ trans('cruds.slideShow.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('ads_category_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.ads-categories.index') }}"
                               class="nav-link {{ request()->is('admin/ads-categories*') ? 'active' : '' }}">
                                <i class="fas fa-tags nav-icon"></i>
                                <p>{{ trans('cruds.adsCategory.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('all_ad_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.all-ads.index') }}"
                               class="nav-link {{ request()->is('admin/all-ads*') ? 'active' : '' }}">
                                <i class="fas fa-bullseye nav-icon"></i>
                                <p>{{ trans('cruds.allAd.title') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- Subscriptions --}}
                @can('subscription_access')
                <span class="nav-section-label">{{ trans('cruds.subscription.title') }}</span>
                <li class="nav-item has-treeview
                    {{ request()->is('admin/subscription-packages*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/subscription-vips*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/subscription-users*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-crown nav-icon"></i>
                        <p>{{ trans('cruds.subscription.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('subscription_package_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.subscription-packages.index') }}"
                               class="nav-link {{ request()->is('admin/subscription-packages*') ? 'active' : '' }}">
                                <i class="fas fa-box nav-icon"></i>
                                <p>{{ trans('cruds.subscriptionPackage.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('subscription_vip_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.subscription-vips.index') }}"
                               class="nav-link {{ request()->is('admin/subscription-vips*') ? 'active' : '' }}">
                                <i class="fas fa-star nav-icon"></i>
                                <p>{{ trans('cruds.subscriptionVip.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('subscription_user_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.subscription-users.index') }}"
                               class="nav-link {{ request()->is('admin/subscription-users*') ? 'active' : '' }}">
                                <i class="fas fa-user-tag nav-icon"></i>
                                <p>{{ trans('cruds.subscriptionUser.title') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- Tickets --}}
                @can('ticketmanagement_access')
                <li class="nav-item has-treeview
                    {{ request()->is('admin/reportings*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/ticket-statuses*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/tickets*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-headset nav-icon"></i>
                        <p>{{ trans('cruds.ticketmanagement.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('reporting_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.reportings.index') }}"
                               class="nav-link {{ request()->is('admin/reportings*') ? 'active' : '' }}">
                                <i class="fas fa-flag nav-icon"></i>
                                <p>{{ trans('cruds.reporting.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('ticket_status_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.ticket-statuses.index') }}"
                               class="nav-link {{ request()->is('admin/ticket-statuses*') ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>{{ trans('cruds.ticketStatus.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('ticket_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.tickets.index') }}"
                               class="nav-link {{ request()->is('admin/tickets*') ? 'active' : '' }}">
                                <i class="fas fa-ticket-alt nav-icon"></i>
                                <p>{{ trans('cruds.ticket.title') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- Points --}}
                @can('point_management_access')
                <li class="nav-item has-treeview
                    {{ request()->is('admin/point-types*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/points*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-coins nav-icon"></i>
                        <p>{{ trans('cruds.pointManagement.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('point_type_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.point-types.index') }}"
                               class="nav-link {{ request()->is('admin/point-types*') ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt nav-icon"></i>
                                <p>{{ trans('cruds.pointType.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('point_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.points.index') }}"
                               class="nav-link {{ request()->is('admin/points*') ? 'active' : '' }}">
                                <i class="fas fa-hand-holding-usd nav-icon"></i>
                                <p>{{ trans('cruds.point.title') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- Finance --}}
                @can('expense_management_access')
                <span class="nav-section-label">{{ trans('cruds.expenseManagement.title') }}</span>
                <li class="nav-item has-treeview
                    {{ request()->is('admin/expense-categories*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/income-categories*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/expenses*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/incomes*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/expense-reports*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-wallet nav-icon"></i>
                        <p>{{ trans('cruds.expenseManagement.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.expense-categories.index') }}"
                               class="nav-link {{ request()->is('admin/expense-categories*') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>{{ trans('cruds.expenseCategory.title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.income-categories.index') }}"
                               class="nav-link {{ request()->is('admin/income-categories*') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>{{ trans('cruds.incomeCategory.title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.expenses.index') }}"
                               class="nav-link {{ request()->is('admin/expenses*') ? 'active' : '' }}">
                                <i class="fas fa-arrow-circle-down nav-icon"></i>
                                <p>{{ trans('cruds.expense.title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.incomes.index') }}"
                               class="nav-link {{ request()->is('admin/incomes*') ? 'active' : '' }}">
                                <i class="fas fa-arrow-circle-up nav-icon"></i>
                                <p>{{ trans('cruds.income.title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.expense-reports.index') }}"
                               class="nav-link {{ request()->is('admin/expense-reports*') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar nav-icon"></i>
                                <p>{{ trans('cruds.expenseReport.title') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                {{-- Reports --}}
                @can('report_management_access')
                <li class="nav-item has-treeview
                    {{ request()->is('admin/reports*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <p>{{ trans('cruds.expenseManagementRestaurant.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('report_access')
                        <li class="nav-item">
                            <a href="{{ $status == true ? route('admin.reports.index') : '#' }}"
                               class="nav-link {{ request()->is('admin/reports') ? 'active' : '' }}">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>{{ trans('cruds.expenseReportRestaurant.title') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ $status == true ? url('admin/reports/1') : '#' }}"
                               class="nav-link {{ request()->is('admin/reports/1') ? 'active' : '' }}">
                                <i class="fas fa-box-open nav-icon"></i>
                                <p>{{ trans('cruds.expenseReportRestaurant.reports.product') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- Other --}}
                <span class="nav-section-label">{{ trans('global.other') ?? 'Other' }}</span>

                @can('faq_access')
                <li class="nav-item">
                    <a href="{{ route('admin.faqs.index') }}"
                       class="nav-link {{ request()->is('admin/faqs*') ? 'active' : '' }}">
                        <i class="fas fa-question-circle nav-icon"></i>
                        <p>{{ trans('cruds.faq.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('currency_access')
                <li class="nav-item">
                    <a href="{{ route('admin.currencies.index') }}"
                       class="nav-link {{ request()->is('admin/currencies*') ? 'active' : '' }}">
                        <i class="fas fa-dollar-sign nav-icon"></i>
                        <p>{{ trans('cruds.currency.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('coupon_access')
                <li class="nav-item">
                    <a href="{{ route('admin.coupons.index') }}"
                       class="nav-link {{ request()->is('admin/coupons*') ? 'active' : '' }}">
                        <i class="fas fa-percentage nav-icon"></i>
                        <p>{{ trans('cruds.coupon.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('rate_access')
                <li class="nav-item">
                    <a href="{{ route('admin.rates.index') }}"
                       class="nav-link {{ request()->is('admin/rates*') ? 'active' : '' }}">
                        <i class="fas fa-star-half-alt nav-icon"></i>
                        <p>{{ trans('cruds.rate.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('loop_bank_access')
                <li class="nav-item">
                    <a href="{{ route('admin.loop-banks.index') }}"
                       class="nav-link {{ request()->is('admin/loop-banks*') ? 'active' : '' }}">
                        <i class="fas fa-university nav-icon"></i>
                        <p>{{ trans('cruds.loopBank.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('referral_subscription_access')
                <li class="nav-item">
                    <a href="{{ route('admin.referral-subscriptions.index') }}"
                       class="nav-link {{ request()->is('admin/referral-subscriptions*') ? 'active' : '' }}">
                        <i class="fas fa-user-friends nav-icon"></i>
                        <p>{{ trans('cruds.referralSubscription.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('onbordering_access')
                <li class="nav-item">
                    <a href="{{ route('admin.onborderings.index') }}"
                       class="nav-link {{ request()->is('admin/onborderings*') ? 'active' : '' }}">
                        <i class="fas fa-door-open nav-icon"></i>
                        <p>{{ trans('cruds.onbordering.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('car_access')
                <li class="nav-item has-treeview
                    {{ request()->is('admin/carbrands*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/type-of-cars*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/car-colors*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/car-lists*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-car nav-icon"></i>
                        <p>{{ trans('cruds.car.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('carbrand_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.carbrands.index') }}"
                               class="nav-link {{ request()->is('admin/carbrands*') ? 'active' : '' }}">
                                <i class="fas fa-trademark nav-icon"></i>
                                <p>{{ trans('cruds.carbrand.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('type_of_car_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.type-of-cars.index') }}"
                               class="nav-link {{ request()->is('admin/type-of-cars*') ? 'active' : '' }}">
                                <i class="fas fa-car-side nav-icon"></i>
                                <p>{{ trans('cruds.typeOfCar.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('car_color_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.car-colors.index') }}"
                               class="nav-link {{ request()->is('admin/car-colors*') ? 'active' : '' }}">
                                <i class="fas fa-palette nav-icon"></i>
                                <p>{{ trans('cruds.carColor.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('car_list_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.car-lists.index') }}"
                               class="nav-link {{ request()->is('admin/car-lists*') ? 'active' : '' }}">
                                <i class="fas fa-list-ol nav-icon"></i>
                                <p>{{ trans('cruds.carList.title') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('sms_history_access')
                <li class="nav-item">
                    <a href="{{ route('admin.sms-histories.index') }}"
                       class="nav-link {{ request()->is('admin/sms-histories*') ? 'active' : '' }}">
                        <i class="fas fa-sms nav-icon"></i>
                        <p>{{ trans('cruds.smsHistory.title') }}</p>
                    </a>
                </li>
                @endcan

                {{-- Settings --}}
                <span class="nav-section-label">{{ trans('cruds.setting.title') }}</span>

                @can('setting_access')
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}"
                       class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog nav-icon"></i>
                        <p>{{ trans('cruds.setting.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('website_seting_access')
                <li class="nav-item has-treeview
                    {{ request()->is('admin/sliders*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/top-restaurants*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/category-top-restaurants*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/venture-companies*') ? 'menu-open' : '' }}
                    {{ request()->is('admin/become-partners*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-sliders-h nav-icon"></i>
                        <p>{{ trans('cruds.websiteSeting.title') }}<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('slider_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.sliders.index') }}"
                               class="nav-link {{ request()->is('admin/sliders*') ? 'active' : '' }}">
                                <i class="fas fa-images nav-icon"></i>
                                <p>{{ trans('cruds.slider.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('top_restaurant_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.top-restaurants.index') }}"
                               class="nav-link {{ request()->is('admin/top-restaurants*') ? 'active' : '' }}">
                                <i class="fas fa-award nav-icon"></i>
                                <p>{{ trans('cruds.topRestaurant.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('category_top_restaurant_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.category-top-restaurants.index') }}"
                               class="nav-link {{ request()->is('admin/category-top-restaurants*') ? 'active' : '' }}">
                                <i class="fas fa-th-list nav-icon"></i>
                                <p>{{ trans('cruds.categoryTopRestaurant.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('venture_company_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.venture-companies.index') }}"
                               class="nav-link {{ request()->is('admin/venture-companies*') ? 'active' : '' }}">
                                <i class="fas fa-building nav-icon"></i>
                                <p>{{ trans('cruds.ventureCompany.title') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('become_partner_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.become-partners.index') }}"
                               class="nav-link {{ request()->is('admin/become-partners*') ? 'active' : '' }}">
                                <i class="fas fa-handshake nav-icon"></i>
                                <p>{{ trans('cruds.becomePartner.title') }}</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('user_alert_access')
                <li class="nav-item">
                    <a href="{{ route('admin.user-alerts.index') }}"
                       class="nav-link {{ request()->is('admin/user-alerts*') ? 'active' : '' }}">
                        <i class="fas fa-bell nav-icon"></i>
                        <p>{{ trans('cruds.userAlert.title') }}</p>
                    </a>
                </li>
                @endcan

                @can('systemCalendar')
                <li class="nav-item">
                    <a href="{{ $status == true ? route('admin.systemCalendar') : '#' }}"
                       class="nav-link {{ request()->is('admin/system-calendar*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <p>{{ trans('global.systemCalendar') }}</p>
                    </a>
                </li>
                @endcan

                {{-- Messages --}}
                @php($unread = \App\Models\QaTopic::unreadCount())
                <li class="nav-item">
                    <a href="{{ route('admin.messenger.index') }}"
                       class="nav-link {{ request()->is('admin/messenger*') ? 'active' : '' }}">
                        <i class="fas fa-comments nav-icon"></i>
                        <p>
                            {{ trans('global.messages') }}
                            @if($unread > 0)
                                <span class="badge badge-pill ml-auto" style="background:rgba(79,124,255,0.9);color:#fff;font-size:0.65rem;padding:2px 6px;">{{ $unread }}</span>
                            @endif
                        </p>
                    </a>
                </li>

                {{-- Profile / Logout --}}
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('profile/password*') ? 'active' : '' }}"
                           href="{{ route('profile.password.edit') }}">
                            <i class="fas fa-user-circle nav-icon"></i>
                            <p>{{ trans('global.my_profile') }}</p>
                        </a>
                    </li>
                    @endcan
                @endif

                <li class="nav-item nav-logout-link">
                    <a href="#" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>{{ trans('global.logout') }}</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

    <div class="sidebar-version">v1.0 &mdash; {{ trans('panel.site_title') }}</div>
</aside>
