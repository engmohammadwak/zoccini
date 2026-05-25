@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Sitting Areas" icon="fas fa-chair" color="teal"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Sitting Areas']]" />
    @php $total=$sittingAreas->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-chair"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Areas</div></div>
        </div>
    </div>
    <x-admin-table title="Sitting Areas" icon="fas fa-chair" color="teal" datatableClass="datatable-SittingArea" :count="$sittingAreas->count()" :createRoute="can('sitting_area_create') ? route('admin.sitting-areas.create') : null" :createLabel="trans('global.add').' Area'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Restaurant</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($sittingAreas as $area)
            <tr data-entry-id="{{ $area->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $area->name_en ?? $area->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $area->name_ar ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($area->restaurant)->name_en ?? '—' }}</td>
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
<script>$(function(){ $('.datatable-SittingArea:not(.ajaxTable)').DataTable({order:[[1,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
