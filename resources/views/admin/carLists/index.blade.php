@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Car Lists" icon="fas fa-car" color="blue"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Car Lists']]" />
    @php $total=$carLists->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-car"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Cars</div></div>
        </div>
    </div>
    <x-admin-table title="Car Lists" icon="fas fa-car" color="blue" datatableClass="datatable-CarList" :count="$carLists->count()" :createRoute="can('car_list_create') ? route('admin.car-lists.create') : null" :createLabel="trans('global.add').' Car'">
        <x-slot name="thead"><tr><th width="10"></th><th>Image</th><th>Model</th><th>Brand</th><th>Color</th><th>Type</th><th>Plate</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($carLists as $car)
            <tr data-entry-id="{{ $car->id }}">
                <td></td>
                <td>@if($car->image ?? null)<img src="{{ asset('storage/'.$car->image) }}" style="width:52px;height:36px;object-fit:cover;border-radius:7px;" alt="" loading="lazy">@else<div style="width:52px;height:36px;border-radius:7px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#3b82f6;"><i class="fas fa-car"></i></div>@endif</td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $car->model ?? $car->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($car->carbrand)->name_en ?? optional($car->brand)->name_en ?? '—' }}</td>
                <td>@if(optional($car->carColor)->color ?? null)<span style="display:inline-flex;align-items:center;gap:5px;"><span style="width:14px;height:14px;border-radius:4px;background:{{ optional($car->carColor)->color }};display:inline-block;border:1px solid rgba(0,0,0,0.1);"></span><span style="font-size:0.78rem;color:#475569;">{{ optional($car->carColor)->name_en ?? '' }}</span></span>@else<span style="font-size:0.82rem;color:#94a3b8;">{{ optional($car->carColor)->name_en ?? '—' }}</span>@endif</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($car->typeOfCar)->name_en ?? '—' }}</td>
                <td><span style="font-family:monospace;font-size:0.82rem;color:#1e293b;font-weight:600;">{{ $car->plate_number ?? $car->plate ?? '—' }}</span></td>
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
<script>$(function(){ $('.datatable-CarList:not(.ajaxTable)').DataTable({order:[[2,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
