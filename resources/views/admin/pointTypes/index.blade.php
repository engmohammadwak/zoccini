@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Point Types" icon="fas fa-award" color="gold"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Point Types']]" />
    @php $total=$pointTypes->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#d97706,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-award"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Types</div></div>
        </div>
    </div>
    <x-admin-table title="Point Types" icon="fas fa-award" color="gold" datatableClass="datatable-PointType" :count="$pointTypes->count()" :createRoute="can('point_type_create') ? route('admin.point-types.create') : null" :createLabel="trans('global.add').' Type'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Points</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($pointTypes as $type)
            <tr data-entry-id="{{ $type->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $type->name_en ?? $type->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $type->name_ar ?? '—' }}</td>
                <td><span style="background:#fef9c3;color:#854d0e;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.82rem;">{{ $type->points ?? '—' }}</span></td>
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
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-PointType:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
