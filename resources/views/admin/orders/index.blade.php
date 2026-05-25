@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.order.title')"
        icon="fas fa-shopping-bag"
        color="blue"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.order.title')],
        ]"
    />

    {{-- ===== Stats Cards ===== --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:22px;">
        @php
            $allCount      = $orders->count();
            $pendingCount  = $orders->where('status','pending')->count();
            $completedCount= $orders->where('status','completed')->count();
            $cancelledCount= $orders->where('status','cancelled')->count();
            $totalRevenue  = $orders->where('status','completed')->sum('total');
        @endphp

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#6366f1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-list"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $allCount }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.order.title') }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $pendingCount }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.pending') ?? 'Pending' }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $completedCount }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.completed') ?? 'Completed' }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $cancelledCount }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.cancelled') ?? 'Cancelled' }}</div>
            </div>
        </div>

        <div style="background:linear-gradient(135deg,#1d4ed8,#4f46e5);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(79,70,229,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <div style="font-size:1.2rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($totalRevenue,2) }}</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.7);margin-top:2px;">{{ trans('global.total_revenue') ?? 'Revenue' }}</div>
            </div>
        </div>
    </div>

    {{-- ===== Table ===== --}}
    <x-admin-table
        :title="trans('cruds.order.title_singular').' '.trans('global.list')"
        icon="fas fa-shopping-bag"
        color="blue"
        datatableClass="datatable-Order"
        :count="$orders->count()"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.order.fields.id') }}</th>
                <th>{{ trans('cruds.order.fields.user') }}</th>
                <th>{{ trans('cruds.order.fields.restaurant') }}</th>
                <th>{{ trans('cruds.order.fields.total') }}</th>
                <th>{{ trans('cruds.order.fields.status') }}</th>
                <th>{{ trans('cruds.order.fields.created_at') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($orders as $order)
            <tr data-entry-id="{{ $order->id }}">
                <td></td>
                <td>
                    <span style="background:linear-gradient(135deg,#dbeafe,#e0e7ff);color:#3730a3;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.8rem;">
                        #{{ $order->id }}
                    </span>
                </td>
                <td>
                    <span style="display:flex;align-items:center;gap:7px;">
                        <x-admin-avatar :name="optional($order->user)->name ?? 'U'" color="blue" />
                        <span style="font-size:0.83rem;font-weight:500;color:#334155;">{{ optional($order->user)->name ?? '' }}</span>
                    </span>
                </td>
                <td>
                    <span style="font-size:0.83rem;color:#475569;">
                        <i class="fas fa-utensils" style="color:#94a3b8;margin-left:4px;font-size:0.75rem;"></i>
                        {{ optional($order->restaurant)->name_en ?? '' }}
                    </span>
                </td>
                <td>
                    <span style="background:#dcfce7;color:#166534;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">
                        {{ number_format($order->total ?? 0, 2) }}
                    </span>
                </td>
                <td>
                    @php
                        $statusMap = [
                            'pending'    => ['bg'=>'#fef9c3','color'=>'#854d0e','icon'=>'fa-clock'],
                            'processing' => ['bg'=>'#dbeafe','color'=>'#1e40af','icon'=>'fa-spinner'],
                            'completed'  => ['bg'=>'#dcfce7','color'=>'#166534','icon'=>'fa-check-circle'],
                            'cancelled'  => ['bg'=>'#fee2e2','color'=>'#991b1b','icon'=>'fa-times-circle'],
                        ];
                        $sm = $statusMap[$order->status ?? ''] ?? ['bg'=>'#f1f5f9','color'=>'#64748b','icon'=>'fa-circle'];
                    @endphp
                    <span style="background:{{ $sm['bg'] }};color:{{ $sm['color'] }};padding:3px 10px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;">
                        <i class="fas {{ $sm['icon'] }}"></i>
                        {{ $order->status ?? '' }}
                    </span>
                </td>
                <td style="color:#94a3b8;font-size:0.8rem;white-space:nowrap;">
                    <i class="far fa-calendar-alt" style="margin-left:4px;color:#cbd5e1;"></i>
                    {{ optional($order->created_at)->translatedFormat('d/m/Y') ?? '' }}
                    <span style="display:block;font-size:0.72rem;color:#cbd5e1;">{{ optional($order->created_at)->format('H:i') ?? '' }}</span>
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('order_show')
                    <x-admin-action-btn href="{{ route('admin.orders.show',$order->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('order_edit')
                    <x-admin-action-btn href="{{ route('admin.orders.edit',$order->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('order_delete')
                    <x-admin-action-btn href="{{ route('admin.orders.destroy',$order->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
                    @endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>

</div>
@endsection
@section('scripts')
@parent
<script>
$(function(){
    let dtButtons=$.extend(true,[],$.fn.dataTable.defaults.buttons);
    @can('order_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.orders.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Order:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
