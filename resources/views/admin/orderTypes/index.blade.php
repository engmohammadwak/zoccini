@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header :title="trans('cruds.orderType.title')" icon="fas fa-list-alt" color="cyan" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.orderType.title')]]" />
    <x-admin-table :title="trans('cruds.orderType.title_singular').' '.trans('global.list')" icon="fas fa-list-alt" color="cyan" datatableClass="datatable-OrderType" :count="$orderTypes->count()" :createRoute="route('admin.order-types.create')" :createLabel="trans('global.add').' '.trans('cruds.orderType.title_singular')">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($orderTypes as $type)
            <tr data-entry-id="{{ $type->id }}">
                <td></td>
                <td>{{ $type->name_en ?? '' }}</td>
                <td>{{ $type->name_ar ?? '' }}</td>
                <td><x-admin-status-badge :label="$type->status==1?'Active':'Inactive'" :type="$type->status==1?'success':'danger'" /></td>
                <td style="display:flex;gap:5px;">
                    @can('order_type_show')<x-admin-action-btn href="{{ route('admin.order-types.show',$type->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('order_type_edit')<x-admin-action-btn href="{{ route('admin.order-types.edit',$type->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('order_type_delete')<x-admin-action-btn href="{{ route('admin.order-types.destroy',$type->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-OrderType:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
