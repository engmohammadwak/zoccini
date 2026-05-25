@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.paymentMethod.title')"
        icon="fas fa-credit-card"
        color="green"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.paymentMethod.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.paymentMethod.title_singular').' '.trans('global.list')"
        icon="fas fa-credit-card"
        color="green"
        datatableClass="datatable-PaymentMethod"
        :count="$paymentMethods->count()"
        :createRoute="route('admin.payment-methods.create')"
        :createLabel="trans('global.add').' '.trans('cruds.paymentMethod.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.paymentMethod.fields.name_en') }}</th>
                <th>{{ trans('cruds.paymentMethod.fields.name_ar') }}</th>
                <th>{{ trans('cruds.paymentMethod.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($paymentMethods as $pm)
            <tr data-entry-id="{{ $pm->id }}">
                <td></td>
                <td>{{ $pm->name_en ?? '' }}</td>
                <td>{{ $pm->name_ar ?? '' }}</td>
                <td>
                    <x-admin-status-badge
                        :label="$pm->status == 1 ? (trans('global.active') ?? 'Active') : (trans('global.inactive') ?? 'Inactive')"
                        :type="$pm->status == 1 ? 'success' : 'danger'"
                    />
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('payment_method_show')
                    <x-admin-action-btn href="{{ route('admin.payment-methods.show',$pm->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('payment_method_edit')
                    <x-admin-action-btn href="{{ route('admin.payment-methods.edit',$pm->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('payment_method_delete')
                    <x-admin-action-btn href="{{ route('admin.payment-methods.destroy',$pm->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('payment_method_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.payment-methods.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-PaymentMethod:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
