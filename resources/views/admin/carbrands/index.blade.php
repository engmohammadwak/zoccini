@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    <x-admin-page-header
        title="Car Brands"
        icon="fas fa-car-side"
        color="indigo"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => 'Car Brands'],
        ]"
    />

    @php $total = $carbrands->count(); @endphp

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-car-side"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Brands</div></div>
        </div>
    </div>

    <x-admin-table title="Car Brands" icon="fas fa-car-side" color="indigo" datatableClass="datatable-Carbrand" :count="$carbrands->count()" createPermission="carbrand_create" :createRoute="route('admin.carbrands.create')" :createLabel="trans('global.add').' Brand'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Logo</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($carbrands as $brand)
            <tr data-entry-id="{{ $brand->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $brand->name_en ?? $brand->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $brand->name_ar ?? '—' }}</td>
                <td>@if($brand->logo ?? $brand->image ?? null)<img src="{{ asset('storage/'.($brand->logo ?? $brand->image)) }}" style="width:36px;height:36px;border-radius:8px;object-fit:cover;" alt="" loading="lazy">@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('carbrand_show')<x-admin-action-btn href="{{ route('admin.carbrands.show',$brand->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('carbrand_edit')<x-admin-action-btn href="{{ route('admin.carbrands.edit',$brand->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('carbrand_delete')<x-admin-action-btn href="{{ route('admin.carbrands.destroy',$brand->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>

</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-Carbrand:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
