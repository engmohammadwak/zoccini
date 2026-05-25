@extends('layouts.admin')
@section('content')
<div style="min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.order.title')"
        icon="fas fa-shopping-bag"
        color="blue"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.order.title')],
        ]"
    />

    @php
        $total     = $orders->count();
        $pending   = $orders->whereIn('status',['pending','new',0,1])->count();
        $completed = $orders->whereIn('status',['completed','delivered',4,5])->count();
        $cancelled = $orders->whereIn('status',['cancelled','canceled',6,7])->count();
        $revenue   = $orders->whereIn('status',['completed','delivered',4,5])->sum('total_price') ?? 0;
    @endphp

    {{-- ── KPI Cards ── --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:14px;margin-bottom:24px;">

        {{-- Total --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(59,130,246,.3);"><i class="fas fa-shopping-bag"></i></div>
            <div>
                <div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div>
                <div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('cruds.order.title') }}</div>
            </div>
        </div>

        {{-- Pending --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(245,158,11,.3);"><i class="fas fa-clock"></i></div>
            <div>
                <div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $pending }}</div>
                <div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.pending') ?? 'Pending' }}</div>
            </div>
        </div>

        {{-- Completed --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(16,185,129,.3);"><i class="fas fa-check-double"></i></div>
            <div>
                <div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $completed }}</div>
                <div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.completed') ?? 'Completed' }}</div>
            </div>
        </div>

        {{-- Cancelled --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(239,68,68,.3);"><i class="fas fa-times-circle"></i></div>
            <div>
                <div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $cancelled }}</div>
                <div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.cancelled') ?? 'Cancelled' }}</div>
            </div>
        </div>

        {{-- Revenue --}}
        <div style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);border-radius:14px;padding:18px;box-shadow:0 4px 18px rgba(59,130,246,.35);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;"><i class="fas fa-dollar-sign"></i></div>
            <div>
                <div style="font-size:1.1rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($revenue,2) }}</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,.75);margin-top:3px;font-weight:600;">{{ trans('global.revenue') ?? 'Revenue' }}</div>
            </div>
        </div>

    </div>

    {{-- ── DataTable Card ── --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">

        {{-- Card Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(59,130,246,.1);display:flex;align-items:center;justify-content:center;color:#3b82f6;font-size:15px;"><i class="fas fa-shopping-bag"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.order.title') }}</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @can('order_create')
            <a href="{{ route('admin.orders.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(39,186,77,.3);transition:background .18s,box-shadow .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                {{ trans('global.add') }} {{ trans('cruds.order.title_singular') }}
            </a>
            @endcan
        </div>

        {{-- Table --}}
        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-Order" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">#</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.order.fields.user') ?? 'Customer' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.order.fields.restaurant') ?? 'Restaurant' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.order.fields.total_price') ?? 'Total' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.order.fields.status') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.order.fields.created_at') ?? 'Date' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
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
                <tr data-entry-id="{{ $order->id }}">
                    <td></td>
                    {{-- ID --}}
                    <td>
                        <span style="font-size:0.82rem;font-weight:800;color:#3b82f6;">#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</span>
                    </td>
                    {{-- Customer --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:#fff;flex-shrink:0;">{{ strtoupper(substr(optional($order->user)->name ?? 'U',0,1)) }}</div>
                            <span style="font-size:0.82rem;font-weight:600;color:var(--z-text);">{{ optional($order->user)->name ?? '—' }}</span>
                        </div>
                    </td>
                    {{-- Restaurant --}}
                    <td>
                        <span style="font-size:0.82rem;color:var(--z-text-muted);">{{ optional($order->restaurant)->name_en ?? optional($order->restaurant)->name ?? '—' }}</span>
                    </td>
                    {{-- Total --}}
                    <td>
                        <span style="background:rgba(16,185,129,.12);color:#065f46;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.82rem;">{{ number_format($order->total_price ?? 0,2) }}</span>
                    </td>
                    {{-- Status --}}
                    <td>
                        <span style="background:{{ $sc['bg'] }};color:{{ $sc['color'] }};padding:4px 12px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;">
                            <i class="fas {{ $sc['icon'] }}" style="font-size:0.65rem;"></i>
                            {{ $sc['label'] }}
                        </span>
                    </td>
                    {{-- Date --}}
                    <td>
                        <div style="font-size:0.8rem;color:var(--z-text-muted);">{{ optional($order->created_at)->format('d/m/Y') }}</div>
                        <div style="font-size:0.7rem;color:var(--z-text-faint);">{{ optional($order->created_at)->format('h:i A') }}</div>
                    </td>
                    {{-- Actions --}}
                    <td>
                        <div style="display:flex;gap:5px;">
                            @can('order_show')
                            <a href="{{ route('admin.orders.show',$order->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endcan
                            @can('order_edit')
                            <a href="{{ route('admin.orders.edit',$order->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('order_delete')
                            <form action="{{ route('admin.orders.destroy',$order->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
                                <button type="submit" title="{{ trans('global.delete') }}"
                                   style="width:32px;height:32px;border-radius:8px;background:rgba(239,68,68,.1);color:#dc2626;border:none;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;transition:background .15s;"
                                   onmouseover="this.style.background='rgba(239,68,68,.22)'" onmouseout="this.style.background='rgba(239,68,68,.1)'">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
@section('scripts')
@parent
<script>
$(function(){
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
    @can('order_delete')
    dtButtons.push({
        text: '{{ trans('global.datatables.delete') }}',
        url:  '{{ route('admin.orders.massDestroy') }}',
        className: 'btn-danger',
        action: function(e,dt,node,config){
            var ids = $.map(dt.rows({selected:true}).nodes(), function(entry){ return $(entry).data('entry-id'); });
            if(ids.length === 0){ alert('{{ trans('global.datatables.zero_selected') }}'); return; }
            if(confirm('{{ trans('global.areYouSure') }}')){
                $.ajax({ headers:{'x-csrf-token':_token}, method:'POST', url:config.url, data:{ids:ids,_method:'DELETE'} }).done(function(){ location.reload(); });
            }
        }
    });
    @endcan
    $.extend(true, $.fn.dataTable.defaults, { orderCellsTop:true, order:[[1,'desc']], pageLength:25 });
    $('.datatable-Order:not(.ajaxTable)').DataTable({ buttons: dtButtons });
});
</script>
@endsection
