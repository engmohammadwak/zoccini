@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Sitting Areas" icon="fas fa-chair" color="teal" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Sitting Areas']]" />
    <x-admin-table title="Sitting Areas List" icon="fas fa-chair" color="teal" datatableClass="datatable-SittingArea" :count="$sittingAreas->count()" :createRoute="route('admin.sitting-areas.create')" createLabel="Add Sitting Area">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Restaurant</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($sittingAreas as $area)
            <tr data-entry-id="{{ $area->id }}">
                <td></td>
                <td>{{ $area->name_en ?? '' }}</td>
                <td>{{ $area->name_ar ?? '' }}</td>
                <td>{{ optional($area->restaurant)->name_en ?? '' }}</td>
                <td><x-admin-status-badge :label="$area->status==1?'Active':'Inactive'" :type="$area->status==1?'success':'danger'" /></td>
                <td style="display:flex;gap:5px;">
                    @can('sitting_area_show')<x-admin-action-btn href="{{ route('admin.sitting-areas.show',$area->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('sitting_area_edit')<x-admin-action-btn href="{{ route('admin.sitting-areas.edit',$area->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('sitting_area_delete')<x-admin-action-btn href="{{ route('admin.sitting-areas.destroy',$area->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-SittingArea:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
