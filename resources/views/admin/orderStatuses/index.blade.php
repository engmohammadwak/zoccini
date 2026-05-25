@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header :title="trans('cruds.orderStatus.title')" icon="fas fa-tasks" color="blue" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.orderStatus.title')]]" />
    <x-admin-table :title="trans('cruds.orderStatus.title_singular').' '.trans('global.list')" icon="fas fa-tasks" color="blue" datatableClass="datatable-OrderStatus" :count="$orderStatuses->count()" :createRoute="route('admin.order-statuses.create')" :createLabel="trans('global.add').' '.trans('cruds.orderStatus.title_singular')">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Color</th><th>Order</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($orderStatuses as $status)
            <tr data-entry-id="{{ $status->id }}">
                <td></td>
                <td>{{ $status->name_en ?? '' }}</td>
                <td>{{ $status->name_ar ?? '' }}</td>
                <td>@if($status->color)<span style="display:inline-block;width:20px;height:20px;border-radius:50%;background:{{ $status->color }};vertical-align:middle;"></span> {{ $status->color }}@endif</td>
                <td>{{ $status->order ?? '' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('order_status_show')<x-admin-action-btn href="{{ route('admin.order-statuses.show',$status->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('order_status_edit')<x-admin-action-btn href="{{ route('admin.order-statuses.edit',$status->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('order_status_delete')<x-admin-action-btn href="{{ route('admin.order-statuses.destroy',$status->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-OrderStatus:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
