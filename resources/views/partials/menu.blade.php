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
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="{{route('home_loop')}}" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link" href="{{ $status == true ? route("admin.home") : '#' }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/user-statuses*") ? "menu-open" : "" }} {{ request()->is("admin/restaurants*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? route("admin.permissions.index") : '#' }}"
                                       class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? route("admin.roles.index") : '#' }}"
                                       class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? route("admin.users.index") : '#' }}"
                                       class="nav-link {{ request()->is("admin/users")  ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-check">

                                        </i>
                                        <p>
                                            {{ trans('cruds.Admin') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? url("admin/users/10/type") : '#' }}"
                                       class="nav-link {{ request()->is("admin/users/10/type") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-clock">

                                        </i>
                                        <p>
                                            {{ trans('cruds.employees.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? url("admin/users/2/type") : '#' }}"
                                       class="nav-link {{ request()->is("admin/users/2/type") || request()->is("admin/users/2/type") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('restaurant_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.restaurants.index") }}"
                                       class="nav-link {{ request()->is("admin/restaurants") || request()->is("admin/restaurants/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-utensils">

                                        </i>
                                        <p>
                                            {{ trans('cruds.restaurant.title') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url("admin/restaurants_register?type=4") }}"
                                       class="nav-link {{ request()->is("admin/restaurants_register") || request()->is("admin/restaurants_register/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-utensils">

                                        </i>
                                        <p>
                                            {{ trans('cruds.restaurant_register') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_status_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.user-statuses.index") }}"
                                       class="nav-link {{ request()->is("admin/user-statuses") || request()->is("admin/user-statuses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-exchange-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.userStatus.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('loopuser_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.loopusers.index") }}"
                                       class="nav-link {{ request()->is("admin/loopusers") || request()->is("admin/loopusers/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-bullhorn">

                                        </i>
                                        <p>
                                            {{ trans('cruds.loopuser.title') }}
                                        </p>
                                    </a>
                                </li>

                                    <li class="nav-item">
                                    <a href="{{ url("admin/loopusers?type=1") }}"
                                       class="nav-link {{ request()->is("admin/loopusers?type=1") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-bullhorn">

                                        </i>
                                        <p>
                                            {{ trans('cruds.loopuserRegister') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('employees_access')
                    <li class="nav-item">
                        <a href="{{ $status == true ? route("admin.employees.index") : '#' }}"
                           class="nav-link {{ request()->is("admin/employees") || request()->is("admin/employees/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-user-alt">

                            </i>
                            <p>
                                {{ trans('cruds.employees.title') }}
                            </p>
                        </a>
                    </li>
                @endcan

                @can('place_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/countries*") ? "menu-open" : "" }} {{ request()->is("admin/cities*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-globe-asia">

                            </i>
                            <p>
                                {{ trans('cruds.place.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('country_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.countries.index") }}"
                                       class="nav-link {{ request()->is("admin/countries") || request()->is("admin/countries/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-flag">

                                        </i>
                                        <p>
                                            {{ trans('cruds.country.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('city_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.cities.index") }}"
                                       class="nav-link {{ request()->is("admin/cities") || request()->is("admin/cities/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-flag">

                                        </i>
                                        <p>
                                            {{ trans('cruds.city.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('restaurants_management_access')
                    <li class="nav-item has-treeview  {{ request()->is("admin/categories*") ? "menu-open" : "" }} {{ request()->is("admin/items*") ? "menu-open" : "" }} {{ request()->is("admin/sitting-areas*") ? "menu-open" : "" }} {{ request()->is("admin/extras*") ? "menu-open" : "" }} {{ request()->is("admin/otherbranches*") ? "menu-open" : "" }} {{ request()->is("admin/payment-methods*") ? "menu-open" : "" }} {{ request()->is("admin/tables*") ? "menu-open" : "" }} {{ request()->is("admin/table-statuses*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-utensils">

                            </i>
                            <p>
                                {{ trans('cruds.restaurantsManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('category_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? route("admin.categories.index") : '#' }}"
                                       class="nav-link {{ request()->is("admin/categories") || request()->is("admin/categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-bars">

                                        </i>
                                        <p>
                                            {{ trans('cruds.category.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('item_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? route("admin.items.index") : '#' }}"
                                       class="nav-link {{ request()->is("admin/items") || request()->is("admin/items/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-italic">

                                        </i>
                                        <p>
                                            {{ trans('cruds.item.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('sitting_area_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? route("admin.sitting-areas.index") : '#' }}"
                                       class="nav-link {{ request()->is("admin/sitting-areas") || request()->is("admin/sitting-areas/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-chart-area">

                                        </i>
                                        <p>
                                            {{ trans('cruds.sittingArea.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('otherbranch_access')
                                @if (\Illuminate\Support\Facades\Auth::user()['restaurant_id'] == null)
                                    <li class="nav-item">
                                        <a href="{{ $status == true ? route("admin.otherbranches.index") : '#' }}"
                                           class="nav-link {{ request()->is("admin/otherbranches") || request()->is("admin/otherbranches/*") ? "active" : "" }}">
                                            <i class="fa-fw nav-icon fab fa-buromobelexperte">

                                            </i>
                                            <p>
                                                {{ trans('cruds.otherbranch.title') }}
                                            </p>
                                        </a>
                                    </li>
                                @endif

                            @endcan
                            @can('payment_method_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? route("admin.payment-methods.index") : '#' }}"
                                       class="nav-link {{ request()->is("admin/payment-methods") || request()->is("admin/payment-methods/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-money-bill-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.paymentMethod.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('table_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? route("admin.tables.index") : '#' }}"
                                       class="nav-link {{ request()->is("admin/tables") || request()->is("admin/tables/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-table">

                                        </i>
                                        <p>
                                            {{ trans('cruds.table.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('table_status_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.table-statuses.index") }}"
                                       class="nav-link {{ request()->is("admin/table-statuses") || request()->is("admin/table-statuses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-check">

                                        </i>
                                        <p>
                                            {{ trans('cruds.tableStatus.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('delivery_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/deliveries*") ? "menu-open" : "" }} {{ request()->is("admin/delivery-companies*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-car">

                            </i>
                            <p>
                                {{ trans('cruds.deliveryManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('delivery_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.deliveries.index") }}"
                                       class="nav-link {{ request()->is("admin/deliveries") || request()->is("admin/deliveries/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-car">

                                        </i>
                                        <p>
                                            {{ trans('cruds.delivery.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('delivery_company_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.delivery-companies.index") }}"
                                       class="nav-link {{ request()->is("admin/delivery-companies") || request()->is("admin/delivery-companies/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-truck">

                                        </i>
                                        <p>
                                            {{ trans('cruds.deliveryCompany.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('order_mangement_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/order-types*") ? "menu-open" : "" }} {{ request()->is("admin/order-statuses*") ? "menu-open" : "" }} {{ request()->is("admin/orders*") ? "menu-open" : "" }} {{ request()->is("admin/cansel-reasons*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fab fa-first-order">

                            </i>
                            <p>
                                {{ trans('cruds.orderMangement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('order_type_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? route("admin.order-types.index") : '#' }}"
                                       class="nav-link {{ request()->is("admin/order-types") || request()->is("admin/order-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-align-justify">

                                        </i>
                                        <p>
                                            {{ trans('cruds.orderType.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('order_status_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.order-statuses.index") }}"
                                       class="nav-link {{ request()->is("admin/order-statuses") || request()->is("admin/order-statuses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-align-justify">

                                        </i>
                                        <p>
                                            {{ trans('cruds.orderStatus.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('order_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? route("admin.orders.index") : '#' }}"
                                       class="nav-link {{ request()->is("admin/orders") || request()->is("admin/orders/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fab fa-jedi-order">

                                        </i>
                                        <p>
                                            {{ trans('cruds.order.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('cansel_reason_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.cansel-reasons.index") }}"
                                       class="nav-link {{ request()->is("admin/cansel-reasons") || request()->is("admin/cansel-reasons/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-ban">

                                        </i>
                                        <p>
                                            {{ trans('cruds.canselReason.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('ad_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/slide-shows*") ? "menu-open" : "" }} {{ request()->is("admin/ads-categories*") ? "menu-open" : "" }} {{ request()->is("admin/all-ads*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fab fa-adversal">

                            </i>
                            <p>
                                {{ trans('cruds.ad.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('slide_show_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.slide-shows.index") }}"
                                       class="nav-link {{ request()->is("admin/slide-shows") || request()->is("admin/slide-shows/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-eye">

                                        </i>
                                        <p>
                                            {{ trans('cruds.slideShow.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ads_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ads-categories.index") }}"
                                       class="nav-link {{ request()->is("admin/ads-categories") || request()->is("admin/ads-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-align-justify">

                                        </i>
                                        <p>
                                            {{ trans('cruds.adsCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('all_ad_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.all-ads.index") }}"
                                       class="nav-link {{ request()->is("admin/all-ads") || request()->is("admin/all-ads/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fab fa-adversal">

                                        </i>
                                        <p>
                                            {{ trans('cruds.allAd.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('subscription_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/subscription-packages*") ? "menu-open" : "" }} {{ request()->is("admin/subscription-vips*") ? "menu-open" : "" }} {{ request()->is("admin/subscription-users*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-check-circle">

                            </i>
                            <p>
                                {{ trans('cruds.subscription.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('subscription_package_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.subscription-packages.index") }}"
                                       class="nav-link {{ request()->is("admin/subscription-packages") || request()->is("admin/subscription-packages/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cubes">

                                        </i>
                                        <p>
                                            {{ trans('cruds.subscriptionPackage.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('subscription_vip_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.subscription-vips.index") }}"
                                       class="nav-link {{ request()->is("admin/subscription-vips") || request()->is("admin/subscription-vips/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-hands-helping">

                                        </i>
                                        <p>
                                            {{ trans('cruds.subscriptionVip.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('subscription_user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.subscription-users.index") }}"
                                       class="nav-link {{ request()->is("admin/subscription-users") || request()->is("admin/subscription-users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fab fa-cc-paypal">

                                        </i>
                                        <p>
                                            {{ trans('cruds.subscriptionUser.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('ticketmanagement_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/reportings*") ? "menu-open" : "" }} {{ request()->is("admin/ticket-statuses*") ? "menu-open" : "" }} {{ request()->is("admin/tickets*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-ticket-alt">

                            </i>
                            <p>
                                {{ trans('cruds.ticketmanagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('reporting_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.reportings.index") }}"
                                       class="nav-link {{ request()->is("admin/reportings") || request()->is("admin/reportings/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-invoice">

                                        </i>
                                        <p>
                                            {{ trans('cruds.reporting.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ticket_status_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ticket-statuses.index") }}"
                                       class="nav-link {{ request()->is("admin/ticket-statuses") || request()->is("admin/ticket-statuses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-check">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ticketStatus.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ticket_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.tickets.index") }}"
                                       class="nav-link {{ request()->is("admin/tickets") || request()->is("admin/tickets/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-ticket-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ticket.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('point_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/point-types*") ? "menu-open" : "" }} {{ request()->is("admin/points*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon far fa-hand-pointer">

                            </i>
                            <p>
                                {{ trans('cruds.pointManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('point_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.point-types.index") }}"
                                       class="nav-link {{ request()->is("admin/point-types") || request()->is("admin/point-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-exchange-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.pointType.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('point_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.points.index") }}"
                                       class="nav-link {{ request()->is("admin/points") || request()->is("admin/points/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-hand-point-down">

                                        </i>
                                        <p>
                                            {{ trans('cruds.point.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('faq_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.faqs.index") }}"
                           class="nav-link {{ request()->is("admin/faqs") || request()->is("admin/faqs/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-question">

                            </i>
                            <p>
                                {{ trans('cruds.faq.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('currency_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.currencies.index") }}"
                           class="nav-link {{ request()->is("admin/currencies") || request()->is("admin/currencies/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-file-invoice-dollar">

                            </i>
                            <p>
                                {{ trans('cruds.currency.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('coupon_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.coupons.index") }}"
                           class="nav-link {{ request()->is("admin/coupons") || request()->is("admin/coupons/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-gift">

                            </i>
                            <p>
                                {{ trans('cruds.coupon.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('report_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/reports*") ? "menu-open" : "" }} {{ request()->is("admin/reports/1*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-money-bill">

                            </i>
                            <p>
                                {{ trans('cruds.expenseManagementRestaurant.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('report_access')
                                <li class="nav-item">
                                    <a href="{{ $status == true ? route("admin.reports.index") : '#' }}"
                                       class="nav-link {{ request()->is("admin/reports")  ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-chart-line">

                                        </i>
                                        <p>
                                            {{ trans('cruds.expenseReportRestaurant.title') }}
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ $status == true ? url("admin/reports/1") : '#' }}"
                                       class="nav-link {{ request()->is("admin/reports/1") || request()->is("admin/reports/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-chart-line">

                                        </i>
                                        <p>
                                            {{ trans('cruds.expenseReportRestaurant.reports.product') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('onbordering_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.onborderings.index") }}"
                           class="nav-link {{ request()->is("admin/onborderings") || request()->is("admin/onborderings/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-puzzle-piece">

                            </i>
                            <p>
                                {{ trans('cruds.onbordering.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('car_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/carbrands*") ? "menu-open" : "" }} {{ request()->is("admin/type-of-cars*") ? "menu-open" : "" }} {{ request()->is("admin/car-colors*") ? "menu-open" : "" }} {{ request()->is("admin/car-lists*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-car">

                            </i>
                            <p>
                                {{ trans('cruds.car.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('carbrand_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.carbrands.index") }}"
                                       class="nav-link {{ request()->is("admin/carbrands") || request()->is("admin/carbrands/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-braille">

                                        </i>
                                        <p>
                                            {{ trans('cruds.carbrand.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('type_of_car_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.type-of-cars.index") }}"
                                       class="nav-link {{ request()->is("admin/type-of-cars") || request()->is("admin/type-of-cars/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-braille">

                                        </i>
                                        <p>
                                            {{ trans('cruds.typeOfCar.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('car_color_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.car-colors.index") }}"
                                       class="nav-link {{ request()->is("admin/car-colors") || request()->is("admin/car-colors/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-braille">

                                        </i>
                                        <p>
                                            {{ trans('cruds.carColor.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('car_list_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.car-lists.index") }}"
                                       class="nav-link {{ request()->is("admin/car-lists") || request()->is("admin/car-lists/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-car">

                                        </i>
                                        <p>
                                            {{ trans('cruds.carList.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('sms_history_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.sms-histories.index") }}"
                           class="nav-link {{ request()->is("admin/sms-histories") || request()->is("admin/sms-histories/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.smsHistory.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('rate_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.rates.index") }}"
                           class="nav-link {{ request()->is("admin/rates") || request()->is("admin/rates/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-star">

                            </i>
                            <p>
                                {{ trans('cruds.rate.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('loop_bank_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.loop-banks.index") }}"
                           class="nav-link {{ request()->is("admin/loop-banks") || request()->is("admin/loop-banks/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-university">

                            </i>
                            <p>
                                {{ trans('cruds.loopBank.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('referral_subscription_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.referral-subscriptions.index") }}"
                           class="nav-link {{ request()->is("admin/referral-subscriptions") || request()->is("admin/referral-subscriptions/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-check-circle">

                            </i>
                            <p>
                                {{ trans('cruds.referralSubscription.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('expense_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/expense-categories*") ? "menu-open" : "" }} {{ request()->is("admin/income-categories*") ? "menu-open" : "" }} {{ request()->is("admin/expenses*") ? "menu-open" : "" }} {{ request()->is("admin/incomes*") ? "menu-open" : "" }} {{ request()->is("admin/expense-reports*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-money-bill">

                            </i>
                            <p>
                                {{ trans('cruds.expenseManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route("admin.expense-categories.index") }}" class="nav-link {{ request()->is("admin/expense-categories") || request()->is("admin/expense-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list">

                                        </i>
                                        <p>
                                            {{ trans('cruds.expenseCategory.title') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route("admin.income-categories.index") }}" class="nav-link {{ request()->is("admin/income-categories") || request()->is("admin/income-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list">

                                        </i>
                                        <p>
                                            {{ trans('cruds.incomeCategory.title') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route("admin.expenses.index") }}" class="nav-link {{ request()->is("admin/expenses") || request()->is("admin/expenses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-arrow-circle-right">

                                        </i>
                                        <p>
                                            {{ trans('cruds.expense.title') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route("admin.incomes.index") }}" class="nav-link {{ request()->is("admin/incomes") || request()->is("admin/incomes/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-arrow-circle-right">

                                        </i>
                                        <p>
                                            {{ trans('cruds.income.title') }}
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route("admin.expense-reports.index") }}" class="nav-link {{ request()->is("admin/expense-reports") || request()->is("admin/expense-reports/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-chart-line">

                                        </i>
                                        <p>
                                            {{ trans('cruds.expenseReport.title') }}
                                        </p>
                                    </a>
                                </li>

                        </ul>
                    </li>
                @endcan
                @can('setting_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.settings.index") }}"
                           class="nav-link {{ request()->is("admin/settings") || request()->is("admin/settings/*") ? "active" : "" }}">
                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.setting.title') }}
                        </a>
                    </li>
                @endcan
                @can('website_seting_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/sliders*") ? "menu-open" : "" }} {{ request()->is("admin/top-restaurants*") ? "menu-open" : "" }} {{ request()->is("admin/category-top-restaurants*") ? "menu-open" : "" }} {{ request()->is("admin/venture-companies*") ? "menu-open" : "" }} {{ request()->is("admin/become-partners*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.websiteSeting.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('slider_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.sliders.index") }}"
                                       class="nav-link {{ request()->is("admin/sliders") || request()->is("admin/sliders/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-chalkboard">

                                        </i>
                                        <p>
                                            {{ trans('cruds.slider.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('top_restaurant_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.top-restaurants.index") }}"
                                       class="nav-link {{ request()->is("admin/top-restaurants") || request()->is("admin/top-restaurants/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-vials">

                                        </i>
                                        <p>
                                            {{ trans('cruds.topRestaurant.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('category_top_restaurant_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.category-top-restaurants.index") }}"
                                       class="nav-link {{ request()->is("admin/category-top-restaurants") || request()->is("admin/category-top-restaurants/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-align-justify">

                                        </i>
                                        <p>
                                            {{ trans('cruds.categoryTopRestaurant.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('venture_company_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.venture-companies.index") }}"
                                       class="nav-link {{ request()->is("admin/venture-companies") || request()->is("admin/venture-companies/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-hotel">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ventureCompany.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('become_partner_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.become-partners.index") }}"
                                       class="nav-link {{ request()->is("admin/become-partners") || request()->is("admin/become-partners/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-hands-helping">

                                        </i>
                                        <p>
                                            {{ trans('cruds.becomePartner.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('user_alert_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.user-alerts.index") }}"
                           class="nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-bell">

                            </i>
                            <p>
                                {{ trans('cruds.userAlert.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('systemCalendar')
                    <li class="nav-item">
                        <a href="{{ $status == true ? route("admin.systemCalendar") : '#' }}"
                           class="nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                            <i class="fas fa-fw fa-calendar nav-icon">

                            </i>
                            <p>
                                {{ trans('global.systemCalendar') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @php($unread = \App\Models\QaTopic::unreadCount())
                <li class="nav-item">
                    <a href="{{ route("admin.messenger.index") }}"
                       class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "active" : "" }} nav-link">
                        <i class="fa-fw fa fa-envelope nav-icon">

                        </i>
                        <p>{{ trans('global.messages') }}</p>
                        @if($unread > 0)
                            <strong>( {{ $unread }} )</strong>
                        @endif

                    </a>
                </li>
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}"
                               href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-user nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.my_profile') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                        <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
