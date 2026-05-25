@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Table Statuses" icon="fas fa-border-all" color="indigo" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Table Statuses']]" />
    <x-admin-table title="Table Statuses List" icon="fas fa-border-all" color="indigo" datatableClass="datatable-TableStatus" :count="$tableStatuses->count()" :createRoute="route('admin.table-statuses.create')" createLabel="Add Status">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Color</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($tableStatuses as $status)
            <tr data-entry-id="{{ $status->id }}">
                <td></td>
                <td>{{ $status->name_en ?? '' }}</td>
                <td>{{ $status->name_ar ?? '' }}</td>
                <td>@if($status->color)<span style="display:inline-block;width:18px;height:18px;border-radius:50%;background:{{ $status->color }};vertical-align:middle;margin-left:5px;"></span> {{ $status->color }}@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('table_status_show')<x-admin-action-btn href="{{ route('admin.table-statuses.show',$status->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('table_status_edit')<x-admin-action-btn href="{{ route('admin.table-statuses.edit',$status->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('table_status_delete')<x-admin-action-btn href="{{ route('admin.table-statuses.destroy',$status->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-TableStatus:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
