@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('global.reports') ?? 'Reports'"
        icon="fas fa-chart-bar"
        color="blue"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('global.reports') ?? 'Reports'],
        ]"
    />

    {{-- ===== Quick Links Grid ===== --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;margin-bottom:28px;">

        {{-- Orders Report --}}
        <a href="{{ route('admin.orders.index') }}" style="text-decoration:none;">
        <div style="background:#fff;border-radius:16px;padding:20px;box-shadow:0 2px 12px rgba(0,0,0,0.07);border-right:4px solid #3b82f6;transition:transform 0.18s,box-shadow 0.18s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(59,130,246,0.15)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 12px rgba(0,0,0,0.07)'">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
                <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#3b82f6,#6366f1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ trans('cruds.order.title') }}</span>
            </div>
            <div style="font-size:0.78rem;color:#94a3b8;">عرض وتحليل جميع الطلبات</div>
            <div style="margin-top:10px;color:#3b82f6;font-size:0.78rem;font-weight:600;">عرض التقرير →</div>
        </div>
        </a>

        {{-- Restaurants Report --}}
        <a href="{{ route('admin.restaurants.index') }}" style="text-decoration:none;">
        <div style="background:#fff;border-radius:16px;padding:20px;box-shadow:0 2px 12px rgba(0,0,0,0.07);border-right:4px solid #f43f5e;transition:transform 0.18s,box-shadow 0.18s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(244,63,94,0.15)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 12px rgba(0,0,0,0.07)'">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
                <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#f43f5e,#fb7185);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;">
                    <i class="fas fa-utensils"></i>
                </div>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ trans('cruds.restaurant.title') }}</span>
            </div>
            <div style="font-size:0.78rem;color:#94a3b8;">إحصائيات المطاعم والنشاط</div>
            <div style="margin-top:10px;color:#f43f5e;font-size:0.78rem;font-weight:600;">عرض التقرير →</div>
        </div>
        </a>

        {{-- Users Report --}}
        <a href="{{ route('admin.users.index') }}" style="text-decoration:none;">
        <div style="background:#fff;border-radius:16px;padding:20px;box-shadow:0 2px 12px rgba(0,0,0,0.07);border-right:4px solid #6366f1;transition:transform 0.18s,box-shadow 0.18s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(99,102,241,0.15)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 12px rgba(0,0,0,0.07)'">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
                <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;">
                    <i class="fas fa-users"></i>
                </div>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ trans('cruds.user.title') }}</span>
            </div>
            <div style="font-size:0.78rem;color:#94a3b8;">تقرير المستخدمين والنشاط</div>
            <div style="margin-top:10px;color:#6366f1;font-size:0.78rem;font-weight:600;">عرض التقرير →</div>
        </div>
        </a>

        {{-- Deliveries Report --}}
        <a href="{{ route('admin.deliveries.index') }}" style="text-decoration:none;">
        <div style="background:#fff;border-radius:16px;padding:20px;box-shadow:0 2px 12px rgba(0,0,0,0.07);border-right:4px solid #f97316;transition:transform 0.18s,box-shadow 0.18s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(249,115,22,0.15)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 12px rgba(0,0,0,0.07)'">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
                <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#f97316,#fb923c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ trans('cruds.delivery.title') }}</span>
            </div>
            <div style="font-size:0.78rem;color:#94a3b8;">تقرير سائقي التوصيل</div>
            <div style="margin-top:10px;color:#f97316;font-size:0.78rem;font-weight:600;">عرض التقرير →</div>
        </div>
        </a>

        {{-- Coupons Report --}}
        <a href="{{ route('admin.coupons.index') }}" style="text-decoration:none;">
        <div style="background:#fff;border-radius:16px;padding:20px;box-shadow:0 2px 12px rgba(0,0,0,0.07);border-right:4px solid #22c55e;transition:transform 0.18s,box-shadow 0.18s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(34,197,94,0.15)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 12px rgba(0,0,0,0.07)'">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
                <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#22c55e,#4ade80);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;">
                    <i class="fas fa-tag"></i>
                </div>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ trans('cruds.coupon.title') }}</span>
            </div>
            <div style="font-size:0.78rem;color:#94a3b8;">تقرير الكوبونات والخصومات</div>
            <div style="margin-top:10px;color:#22c55e;font-size:0.78rem;font-weight:600;">عرض التقرير →</div>
        </div>
        </a>

        {{-- Subscriptions Report --}}
        <a href="{{ route('admin.subscription-packages.index') }}" style="text-decoration:none;">
        <div style="background:#fff;border-radius:16px;padding:20px;box-shadow:0 2px 12px rgba(0,0,0,0.07);border-right:4px solid #9333ea;transition:transform 0.18s,box-shadow 0.18s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(147,51,234,0.15)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 12px rgba(0,0,0,0.07)'">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
                <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#9333ea,#a855f7);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;">
                    <i class="fas fa-box-open"></i>
                </div>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">Subscriptions</span>
            </div>
            <div style="font-size:0.78rem;color:#94a3b8;">باقات الاشتراكات والباقات</div>
            <div style="margin-top:10px;color:#9333ea;font-size:0.78rem;font-weight:600;">عرض التقرير →</div>
        </div>
        </a>

    </div>

</div>
@endsection
