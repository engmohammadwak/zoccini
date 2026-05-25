@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.order.title')"
        icon="fas fa-shopping-bag"
        color="blue"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.order.title')],
        ]"
    />

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
                <td><span style="background:#dbeafe;color:#1d4ed8;padding:3px 10px;border-radius:7px;font-weight:700;font-size:0.8rem;">#{{ $order->id }}</span></td>
                <td>{{ optional($order->user)->name ?? '' }}</td>
                <td>{{ optional($order->restaurant)->name_en ?? '' }}</td>
                <td><strong style="color:#059669;">{{ number_format($order->total ?? 0, 2) }}</strong></td>
                <td>
                    @php
                        $statusColors = ['pending'=>'warning','processing'=>'info','completed'=>'success','cancelled'=>'danger'];
                        $sc = $statusColors[$order->status ?? ''] ?? 'info';
                    @endphp
                    <x-admin-status-badge :label="$order->status ?? ''" :type="$sc" />
                </td>
                <td style="color:#7a80a0;font-size:0.82rem;"><i class="far fa-clock" style="margin-left:4px;"></i>{{ optional($order->created_at)->translatedFormat('d/m/Y H:i') ?? '' }}</td>
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
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Order:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
