@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    <x-admin-page-header
        title="Ads Categories"
        icon="fas fa-layer-group"
        color="purple"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => 'Ads Categories'],
        ]"
    />

    @php
        $total   = $adsCategories->count();
        $active  = $adsCategories->where('status', 1)->count();
    @endphp

    {{-- KPI Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#8b5cf6,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-layer-group"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Categories</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Active</div></div>
        </div>
    </div>

    <x-admin-table
        title="Ads Categories"
        icon="fas fa-layer-group"
        color="purple"
        datatableClass="datatable-AdsCategory"
        :count="$adsCategories->count()"
        createPermission="ads_category_create"
        :createRoute="route('admin.ads-categories.create')"
        :createLabel="trans('global.add').' Category'">

        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>Name EN</th>
                <th>Name AR</th>
                <th>Icon</th>
                <th>Sort</th>
                <th>Status</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach($adsCategories as $cat)
            <tr data-entry-id="{{ $cat->id }}">
                <td></td>
                <td style="font-weight:700;color:#1e293b;font-size:0.85rem;">{{ $cat->name_en ?? $cat->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $cat->name_ar ?? '—' }}</td>
                <td>
                    @if($cat->icon ?? null)
                        <i class="{{ $cat->icon }}" style="font-size:1.1rem;color:#8b5cf6;"></i>
                    @elseif($cat->image ?? null)
                        <img src="{{ asset('storage/'.$cat->image) }}" style="width:36px;height:36px;border-radius:8px;object-fit:cover;" alt="" loading="lazy">
                    @else
                        <span style="color:#cbd5e1;">—</span>
                    @endif
                </td>
                <td style="font-size:0.82rem;color:#64748b;">{{ $cat->sort ?? $cat->order ?? '—' }}</td>
                <td>
                    @if(($cat->status ?? 1) == 1)
                    <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Active</span>
                    @else
                    <span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Inactive</span>
                    @endif
                </td>
                <td style="display:flex;gap:5px;">
                    @can('ads_category_show')<x-admin-action-btn href="{{ route('admin.ads-categories.show',$cat->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('ads_category_edit')<x-admin-action-btn href="{{ route('admin.ads-categories.edit',$cat->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('ads_category_delete')<x-admin-action-btn href="{{ route('admin.ads-categories.destroy',$cat->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>

    </x-admin-table>

</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-AdsCategory:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
