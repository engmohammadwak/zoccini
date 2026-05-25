@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    {{-- ── Page Header ── --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(59,130,246,.3);">
                <i class="fas fa-receipt"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;line-height:1.2;">{{ trans('global.show') }} {{ trans('cruds.order.title') }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <a href="{{ route('admin.orders.index') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('cruds.order.title') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <span>#{{ $order->id }}</span>
                </nav>
            </div>
        </div>
        <div style="display:flex;gap:8px;">
            @can('order_edit')
            <a href="{{ route('admin.orders.edit',$order->id) }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(245,158,11,.12);color:#b45309;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;transition:background .18s;"
               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.12)'">
                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
            </a>
            @endcan
            <a href="{{ route('admin.orders.index') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--z-surface-2);color:var(--z-text-muted);border:1px solid var(--z-border);border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;transition:background .18s;"
               onmouseover="this.style.background='var(--z-surface-3)'" onmouseout="this.style.background='var(--z-surface-2)'">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') ?? 'Back' }}
            </a>
        </div>
    </div>

    {{-- ── ORDER ID BADGE ── --}}
    @php
        $statusConfig = [
            'pending'   => ['bg'=>'rgba(245,158,11,.12)','color'=>'#b45309','icon'=>'fa-clock','label'=>'Pending'],
            'new'       => ['bg'=>'rgba(59,130,246,.12)','color'=>'#1d4ed8','icon'=>'fa-bell','label'=>'New'],
            'accepted'  => ['bg'=>'rgba(99,102,241,.12)','color'=>'#4338ca','icon'=>'fa-thumbs-up','label'=>'Accepted'],
            'preparing' => ['bg'=>'rgba(236,72,153,.12)','color'=>'#9d174d','icon'=>'fa-utensils','label'=>'Preparing'],
            'on_way'    => ['bg'=>'rgba(14,165,233,.12)','color'=>'#0369a1','icon'=>'fa-motorcycle','label'=>'On Way'],
            'delivered' => ['bg'=>'rgba(16,185,129,.12)','color'=>'#065f46','icon'=>'fa-check-double','label'=>'Delivered'],
            'completed' => ['bg'=>'rgba(16,185,129,.12)','color'=>'#065f46','icon'=>'fa-check-circle','label'=>'Completed'],
            'cancelled' => ['bg'=>'rgba(239,68,68,.12)','color'=>'#991b1b','icon'=>'fa-times-circle','label'=>'Cancelled'],
            'canceled'  => ['bg'=>'rgba(239,68,68,.12)','color'=>'#991b1b','icon'=>'fa-times-circle','label'=>'Cancelled'],
        ];
        $s  = $order->status ?? 'pending';
        $sc = $statusConfig[$s] ?? ['bg'=>'rgba(148,163,184,.12)','color'=>'#475569','icon'=>'fa-circle','label'=>ucfirst($s)];
    @endphp

    {{-- ── Top info strip ── --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 24px;box-shadow:var(--z-card-shadow);margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:22px;box-shadow:0 4px 14px rgba(59,130,246,.35);">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:900;color:var(--z-text);line-height:1;">{{ trans('cruds.order_id') ?? 'Order' }} <span style="color:#3b82f6;">#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</span></div>
                <div style="font-size:0.78rem;color:var(--z-text-faint);margin-top:4px;">
                    <i class="fas fa-calendar-alt" style="margin-right:4px;"></i>
                    {{ optional($order->created_at)->translatedFormat('d/m/Y  h:i A') }}
                </div>
            </div>
        </div>
        <span style="background:{{ $sc['bg'] }};color:{{ $sc['color'] }};padding:8px 20px;border-radius:999px;font-weight:700;font-size:0.85rem;display:inline-flex;align-items:center;gap:7px;">
            <i class="fas {{ $sc['icon'] }}"></i>
            {{ $sc['label'] }}
        </span>
    </div>

    {{-- ── 2-col: From / To ── --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">

        {{-- From: Restaurant --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;color:#b45309;font-size:14px;"><i class="fas fa-utensils"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">From Restaurant</span>
            </div>
            <div style="font-size:0.95rem;font-weight:700;color:var(--z-text);margin-bottom:8px;">{{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? optional($order->restaurants)->name_ar : optional($order->restaurants)->name_en }}</div>
            @if(optional($order->restaurants)->addess)
            <div style="font-size:0.82rem;color:var(--z-text-muted);display:flex;align-items:flex-start;gap:7px;margin-bottom:5px;">
                <i class="fas fa-map-marker-alt" style="color:var(--z-primary);margin-top:2px;flex-shrink:0;"></i>
                {{ $order->restaurants->addess }}
            </div>
            @endif
            @if(optional(optional($order->restaurants)->restaurant)->phone)
            <div style="font-size:0.82rem;color:var(--z-text-muted);display:flex;align-items:center;gap:7px;margin-bottom:5px;">
                <i class="fas fa-phone" style="color:var(--z-primary);flex-shrink:0;"></i>
                {{ optional($order->restaurants->restaurant)->phone }}
            </div>
            @endif
            @if(optional(optional($order->restaurants)->restaurant)->email)
            <div style="font-size:0.82rem;color:var(--z-text-muted);display:flex;align-items:center;gap:7px;">
                <i class="fas fa-envelope" style="color:var(--z-primary);flex-shrink:0;"></i>
                {{ optional($order->restaurants->restaurant)->email }}
            </div>
            @endif
        </div>

        {{-- To: Customer --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(59,130,246,.12);display:flex;align-items:center;justify-content:center;color:#3b82f6;font-size:14px;"><i class="fas fa-user"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">To Customer</span>
            </div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                <div style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:800;color:#fff;">{{ strtoupper(substr(optional($order->user)->name ?? 'U',0,1)) }}</div>
                <div>
                    <div style="font-size:0.95rem;font-weight:700;color:var(--z-text);">{{ optional($order->user)->name }} {{ optional($order->user)->last_name }}</div>
                </div>
            </div>
            @if(optional($order->user)->phone)
            <div style="font-size:0.82rem;color:var(--z-text-muted);display:flex;align-items:center;gap:7px;margin-bottom:5px;">
                <i class="fas fa-phone" style="color:#3b82f6;flex-shrink:0;"></i>
                {{ $order->user->phone }}
            </div>
            @endif
            @if(optional($order->user)->email)
            <div style="font-size:0.82rem;color:var(--z-text-muted);display:flex;align-items:center;gap:7px;">
                <i class="fas fa-envelope" style="color:#3b82f6;flex-shrink:0;"></i>
                {{ $order->user->email }}
            </div>
            @endif
        </div>
    </div>

    {{-- ── Order Items Table ── --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;margin-bottom:20px;">
        <div style="padding:16px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);display:flex;align-items:center;gap:9px;">
            <div style="width:32px;height:32px;border-radius:9px;background:rgba(99,102,241,.12);display:flex;align-items:center;justify-content:center;color:#6366f1;font-size:13px;"><i class="fas fa-list-ul"></i></div>
            <span style="font-size:0.88rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.order.title_singular') ?? 'Order' }} Items</span>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:var(--z-surface-2);">
                        <th style="padding:11px 18px;font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;text-align:left;border-bottom:1px solid var(--z-border);">{{ trans('cruds.qty') ?? 'Qty' }}</th>
                        <th style="padding:11px 18px;font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;text-align:left;border-bottom:1px solid var(--z-border);">{{ trans('cruds.product') ?? 'Product' }}</th>
                        <th style="padding:11px 18px;font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;text-align:left;border-bottom:1px solid var(--z-border);">{{ trans('cruds.price') ?? 'Price' }}</th>
                        <th style="padding:11px 18px;font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;text-align:left;border-bottom:1px solid var(--z-border);">{{ trans('cruds.extra_invoice') ?? 'Extras' }}</th>
                        <th style="padding:11px 18px;font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;text-align:left;border-bottom:1px solid var(--z-border);">{{ trans('cruds.subtotal') ?? 'Subtotal' }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($order->items as $item)
                @php
                    $extra_final = 0;
                    $extras = \Illuminate\Support\Facades\DB::table('extra_order')
                              ->where('order_id',$item->pivot->order_id)
                              ->where('item_id',$item->id)
                              ->get();
                @endphp
                <tr style="border-bottom:1px solid var(--z-border);transition:background .15s;" onmouseover="this.style.background='var(--z-table-row-hover)'" onmouseout="this.style.background='transparent'">
                    <td style="padding:13px 18px;">
                        <span style="background:rgba(99,102,241,.1);color:#6366f1;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.82rem;">{{ $item->pivot->count }}</span>
                    </td>
                    <td style="padding:13px 18px;">
                        <span style="font-size:0.85rem;font-weight:600;color:var(--z-text);">{{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? $item->name_ar : $item->name_en }}</span>
                    </td>
                    <td style="padding:13px 18px;font-size:0.83rem;color:var(--z-text-muted);">{{ $item->pivot->price }}</td>
                    <td style="padding:13px 18px;">
                        @forelse($extras as $ex)
                            @php $extraModel = \App\Models\Extra::find($ex->extra_id); $extra_final += $ex->final_price; @endphp
                            <div style="font-size:0.78rem;color:var(--z-text-muted);margin-bottom:3px;">
                                <span style="font-weight:600;color:var(--z-text);">{{ optional($extraModel)->name }}</span>
                                &times; {{ $ex->count }}
                                <span style="color:var(--z-primary);margin-left:4px;">+{{ $ex->price }}</span>
                            </div>
                        @empty
                            <span style="color:var(--z-text-faint);font-size:0.78rem;">—</span>
                        @endforelse
                    </td>
                    <td style="padding:13px 18px;">
                        <span style="background:rgba(16,185,129,.1);color:#065f46;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">{{ $item->pivot->final_price + $extra_final }}</span>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Totals Card ── --}}
    <div style="display:flex;justify-content:flex-end;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 24px;box-shadow:var(--z-card-shadow);min-width:280px;">
            <div style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid var(--z-border);">{{ trans('cruds.payment_due') ?? 'Payment Summary' }}</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;justify-content:space-between;font-size:0.83rem;">
                    <span style="color:var(--z-text-muted);">{{ trans('cruds.subtotal') ?? 'Subtotal' }}</span>
                    <span style="font-weight:600;color:var(--z-text);">{{ $order->price }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.83rem;">
                    <span style="color:var(--z-text-muted);">{{ trans('cruds.vat') ?? 'VAT' }}</span>
                    <span style="font-weight:600;color:var(--z-text);">{{ $order->vat ?? 0 }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.83rem;">
                    <span style="color:var(--z-text-muted);">{{ trans('cruds.application_services') ?? 'Service Fee' }}</span>
                    <span style="font-weight:600;color:var(--z-text);">{{ $order->Application_services ?? 0 }}</span>
                </div>
                @if(($order->Discount_Application_services ?? 0) > 0)
                <div style="display:flex;justify-content:space-between;font-size:0.83rem;">
                    <span style="color:#10b981;">{{ trans('cruds.discount_Application_services') ?? 'Discount' }}</span>
                    <span style="font-weight:600;color:#10b981;">-{{ $order->Discount_Application_services }}</span>
                </div>
                @endif
                <div style="height:1px;background:var(--z-border);margin:4px 0;"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:0.88rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.total') ?? 'Total' }}</span>
                    <span style="font-size:1.25rem;font-weight:900;color:#3b82f6;">{{ $order->final_price }}</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
