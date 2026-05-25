@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    <x-admin-page-header
        title="Car Lists"
        icon="fas fa-car"
        color="blue"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => 'Car Lists'],
        ]"
    />

    @php $total = $carLists->count(); @endphp

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-car"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Cars</div></div>
        </div>
    </div>

    <x-admin-table title="Car Lists" icon="fas fa-car" color="blue" datatableClass="datatable-CarList" :count="$carLists->count()" createPermission="car_list_create" :createRoute="route('admin.car-lists.create')" :createLabel="trans('global.add').' Car'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name</th><th>Brand</th><th>Year</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($carLists as $car)
            <tr data-entry-id="{{ $car->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $car->name ?? $car->name_en ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;">{{ optional($car->brand)->name_en ?? optional($car->carbrand)->name_en ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;">{{ $car->year ?? '—' }}</td>
                <td>@if(($car->status??1)==1)<span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Active</span>@else<span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Inactive</span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('car_list_show')<x-admin-action-btn href="{{ route('admin.car-lists.show',$car->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('car_list_edit')<x-admin-action-btn href="{{ route('admin.car-lists.edit',$car->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('car_list_delete')<x-admin-action-btn href="{{ route('admin.car-lists.destroy',$car->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>

</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-CarList:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
