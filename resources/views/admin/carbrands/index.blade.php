@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Car Brands" icon="fas fa-trademark" color="gray"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Car Brands']]" />
    @php $total=$carbrands->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#475569,#64748b);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-trademark"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Brands</div></div>
        </div>
    </div>
    <x-admin-table title="Car Brands" icon="fas fa-trademark" color="gray" datatableClass="datatable-Carbrand" :count="$carbrands->count()" :createRoute="can('carbrand_create') ? route('admin.carbrands.create') : null" :createLabel="trans('global.add').' Brand'">
        <x-slot name="thead"><tr><th width="10"></th><th>Logo</th><th>Name EN</th><th>Name AR</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($carbrands as $brand)
            <tr data-entry-id="{{ $brand->id }}">
                <td></td>
                <td>@if($brand->logo ?? $brand->image ?? null)<img src="{{ asset('storage/'.($brand->logo ?? $brand->image)) }}" style="width:42px;height:32px;object-fit:contain;border-radius:6px;border:1px solid #f1f5f9;" alt="" loading="lazy">@else<div style="width:42px;height:32px;border-radius:6px;background:#f8fafc;display:flex;align-items:center;justify-content:center;color:#94a3b8;"><i class="fas fa-car"></i></div>@endif</td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $brand->name_en ?? $brand->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $brand->name_ar ?? '—' }}</td>
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
<script>$(function(){ $('.datatable-Carbrand:not(.ajaxTable)').DataTable({order:[[2,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
