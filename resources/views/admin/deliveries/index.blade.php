@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.delivery.title')"
        icon="fas fa-motorcycle"
        color="orange"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.delivery.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.delivery.title_singular').' '.trans('global.list')"
        icon="fas fa-motorcycle"
        color="orange"
        datatableClass="datatable-Delivery"
        :count="$deliveries->count()"
        :createRoute="route('admin.deliveries.create')"
        :createLabel="trans('global.add').' '.trans('cruds.delivery.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.delivery.fields.name') }}</th>
                <th>{{ trans('cruds.delivery.fields.phone') }}</th>
                <th>{{ trans('cruds.delivery.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($deliveries as $delivery)
            <tr data-entry-id="{{ $delivery->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        <x-admin-avatar :name="$delivery->name" color="orange" />
                        {{ $delivery->name ?? '' }}
                    </span>
                </td>
                <td>{{ $delivery->phone ?? '' }}</td>
                <td>
                    <x-admin-status-badge
                        :label="$delivery->status == 1 ? (trans('global.active') ?? 'Active') : (trans('global.inactive') ?? 'Inactive')"
                        :type="$delivery->status == 1 ? 'success' : 'danger'"
                    />
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('delivery_show')
                    <x-admin-action-btn href="{{ route('admin.deliveries.show',$delivery->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('delivery_edit')
                    <x-admin-action-btn href="{{ route('admin.deliveries.edit',$delivery->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('delivery_delete')
                    <x-admin-action-btn href="{{ route('admin.deliveries.destroy',$delivery->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('delivery_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.deliveries.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Delivery:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
