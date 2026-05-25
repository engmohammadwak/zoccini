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

    @php
        $total    = $orders->count();
        $pending  = $orders->whereIn('status',['pending','new',0,1])->count();
        $completed= $orders->whereIn('status',['completed','delivered',4,5])->count();
        $cancelled= $orders->whereIn('status',['cancelled','canceled',6,7])->count();
        $revenue  = $orders->whereIn('status',['completed','delivered',4,5])->sum('total_price') ?? 0;
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-shopping-bag"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.order.title') }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-clock"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $pending }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Pending</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check-double"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $completed }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Completed</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-times-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $cancelled }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Cancelled</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(59,130,246,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-dollar-sign"></i></div>
            <div><div style="font-size:1rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($revenue,2) }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Revenue</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.order.title_singular').' '.trans('global.list')"
        icon="fas fa-shopping-bag"
        color="blue"
        datatableClass="datatable-Order"
        :count="$orders->count()"
        :createRoute="can('order_create') ? route('admin.orders.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.order.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>#</th>
                <th>{{ trans('cruds.order.fields.user') ?? 'Customer' }}</th>
                <th>{{ trans('cruds.order.fields.restaurant') ?? 'Restaurant' }}</th>
                <th>{{ trans('cruds.order.fields.total_price') ?? 'Total' }}</th>
                <th>{{ trans('cruds.order.fields.status') }}</th>
                <th>{{ trans('cruds.order.fields.created_at') ?? 'Date' }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($orders as $order)
            @php
                $statusMap = [
                    'pending'   => ['bg'=>'#fef9c3','color'=>'#854d0e','icon'=>'fa-clock'],
                    'new'       => ['bg'=>'#dbeafe','color'=>'#1e40af','icon'=>'fa-bell'],
                    'accepted'  => ['bg'=>'#e0e7ff','color'=>'#3730a3','icon'=>'fa-thumbs-up'],
                    'preparing' => ['bg'=>'#fce7f3','color'=>'#9d174d','icon'=>'fa-utensils'],
                    'on_way'    => ['bg'=>'#e0f2fe','color'=>'#0c4a6e','icon'=>'fa-motorcycle'],
                    'delivered' => ['bg'=>'#dcfce7','color'=>'#166534','icon'=>'fa-check-double'],
                    'completed' => ['bg'=>'#dcfce7','color'=>'#166534','icon'=>'fa-check-circle'],
                    'cancelled' => ['bg'=>'#fee2e2','color'=>'#991b1b','icon'=>'fa-times-circle'],
                    'canceled'  => ['bg'=>'#fee2e2','color'=>'#991b1b','icon'=>'fa-times-circle'],
                ];
                $s  = $order->status ?? 'pending';
                $sm = $statusMap[$s] ?? ['bg'=>'#f1f5f9','color'=>'#475569','icon'=>'fa-circle'];
            @endphp
            <tr data-entry-id="{{ $order->id }}">
                <td></td>
                <td><span style="font-weight:700;color:#3b82f6;font-size:0.88rem;">#{{ $order->id }}</span></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        <x-admin-avatar :name="optional($order->user)->name ?? 'U'" color="blue" />
                        <span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($order->user)->name ?? '—' }}</span>
                    </span>
                </td>
                <td style="font-size:0.82rem;color:#475569;">{{ optional($order->restaurant)->name_en ?? optional($order->restaurant)->name ?? '—' }}</td>
                <td><span style="background:#dcfce7;color:#166534;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">{{ number_format($order->total_price ?? 0, 2) }}</span></td>
                <td>
                    <span style="background:{{ $sm['bg'] }};color:{{ $sm['color'] }};padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;">
                        <i class="fas {{ $sm['icon'] }}" style="font-size:0.7rem;"></i>
                        {{ ucfirst(str_replace('_',' ',$s)) }}
                    </span>
                </td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($order->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('order_show')<x-admin-action-btn href="{{ route('admin.orders.show',$order->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('order_edit')<x-admin-action-btn href="{{ route('admin.orders.edit',$order->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('order_delete')<x-admin-action-btn href="{{ route('admin.orders.destroy',$order->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
