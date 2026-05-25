@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Type Of Cars" icon="fas fa-car-side" color="indigo"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Type Of Cars']]" />
    @php $total=$typeOfCars->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-car-side"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Types</div></div>
        </div>
    </div>
    <x-admin-table title="Type Of Cars" icon="fas fa-car-side" color="indigo" datatableClass="datatable-TypeOfCar" :count="$typeOfCars->count()" :createRoute="can('type_of_car_create') ? route('admin.type-of-cars.create') : null" :createLabel="trans('global.add').' Type'">
        <x-slot name="thead"><tr><th width="10"></th><th>Icon</th><th>Name EN</th><th>Name AR</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($typeOfCars as $type)
            <tr data-entry-id="{{ $type->id }}">
                <td></td>
                <td>@if($type->icon ?? $type->image ?? null)<img src="{{ asset('storage/'.($type->icon ?? $type->image)) }}" style="width:40px;height:40px;object-fit:contain;border-radius:8px;" alt="" loading="lazy">@else<div style="width:40px;height:40px;border-radius:8px;background:#eef2ff;display:flex;align-items:center;justify-content:center;color:#6366f1;"><i class="fas fa-car-side"></i></div>@endif</td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $type->name_en ?? $type->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $type->name_ar ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('type_of_car_show')<x-admin-action-btn href="{{ route('admin.type-of-cars.show',$type->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('type_of_car_edit')<x-admin-action-btn href="{{ route('admin.type-of-cars.edit',$type->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('type_of_car_delete')<x-admin-action-btn href="{{ route('admin.type-of-cars.destroy',$type->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-TypeOfCar:not(.ajaxTable)').DataTable({order:[[2,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
