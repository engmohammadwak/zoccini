@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Car Colors" icon="fas fa-palette" color="pink"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Car Colors']]" />
    @php $total=$carColors->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ec4899,#f472b6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-palette"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Colors</div></div>
        </div>
    </div>
    <x-admin-table title="Car Colors" icon="fas fa-palette" color="pink" datatableClass="datatable-CarColor" :count="$carColors->count()" :createRoute="can('car_color_create') ? route('admin.car-colors.create') : null" :createLabel="trans('global.add').' Color'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Color</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($carColors as $color)
            <tr data-entry-id="{{ $color->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $color->name_en ?? $color->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $color->name_ar ?? '—' }}</td>
                <td>@if($color->color ?? $color->hex ?? null)
                    <span style="display:inline-flex;align-items:center;gap:7px;">
                        <span style="width:22px;height:22px;border-radius:6px;background:{{ $color->color ?? $color->hex }};display:inline-block;border:1px solid rgba(0,0,0,0.1);"></span>
                        <span style="font-size:0.78rem;font-family:monospace;color:#475569;">{{ $color->color ?? $color->hex }}</span>
                    </span>
                @endif</td>
                <td style="display:flex;gap:5px;">
                    @can('car_color_show')<x-admin-action-btn href="{{ route('admin.car-colors.show',$color->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('car_color_edit')<x-admin-action-btn href="{{ route('admin.car-colors.edit',$color->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('car_color_delete')<x-admin-action-btn href="{{ route('admin.car-colors.destroy',$color->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-CarColor:not(.ajaxTable)').DataTable({order:[[1,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
