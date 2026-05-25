@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header :title="trans('cruds.pointType.title')" icon="fas fa-star-half-alt" color="gold" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.pointType.title')]]" />
    <x-admin-table :title="trans('cruds.pointType.title_singular').' '.trans('global.list')" icon="fas fa-star-half-alt" color="gold" datatableClass="datatable-PointType" :count="$pointTypes->count()" :createRoute="route('admin.point-types.create')" :createLabel="trans('global.add').' '.trans('cruds.pointType.title_singular')">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Points</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($pointTypes as $type)
            <tr data-entry-id="{{ $type->id }}">
                <td></td>
                <td>{{ $type->name_en ?? '' }}</td>
                <td>{{ $type->name_ar ?? '' }}</td>
                <td><strong style="color:#d97706;">{{ $type->points ?? '' }}</strong></td>
                <td><x-admin-status-badge :label="$type->status==1?'Active':'Inactive'" :type="$type->status==1?'success':'danger'" /></td>
                <td style="display:flex;gap:5px;">
                    @can('point_type_show')<x-admin-action-btn href="{{ route('admin.point-types.show',$type->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('point_type_edit')<x-admin-action-btn href="{{ route('admin.point-types.edit',$type->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('point_type_delete')<x-admin-action-btn href="{{ route('admin.point-types.destroy',$type->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-PointType:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
