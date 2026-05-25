@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header :title="trans('cruds.point.title')" icon="fas fa-coins" color="gold" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.point.title')]]" />
    <x-admin-table :title="trans('cruds.point.title_singular').' '.trans('global.list')" icon="fas fa-coins" color="gold" datatableClass="datatable-Point" :count="$points->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Points</th><th>Type</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($points as $point)
            <tr data-entry-id="{{ $point->id }}">
                <td></td>
                <td>{{ optional($point->user)->name ?? '' }}</td>
                <td><strong style="color:#d97706;">{{ $point->points ?? '' }}</strong></td>
                <td>{{ optional($point->type)->name ?? '' }}</td>
                <td style="color:#7a80a0;font-size:0.82rem;">{{ optional($point->created_at)->format('d/m/Y') ?? '' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('point_show')<x-admin-action-btn href="{{ route('admin.points.show',$point->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('point_delete')<x-admin-action-btn href="{{ route('admin.points.destroy',$point->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-Point:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
