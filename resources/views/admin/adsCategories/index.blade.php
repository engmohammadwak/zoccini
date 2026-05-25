@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Ads Categories" icon="fas fa-th-large" color="violet"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Ads Categories']]" />
    @php $total=$adsCategories->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-th-large"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Categories</div></div>
        </div>
    </div>
    <x-admin-table title="Ads Categories" icon="fas fa-th-large" color="violet" datatableClass="datatable-AdsCategory" :count="$adsCategories->count()" :createRoute="can('ads_category_create') ? route('admin.ads-categories.create') : null" :createLabel="trans('global.add').' Category'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($adsCategories as $cat)
            <tr data-entry-id="{{ $cat->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $cat->name_en ?? $cat->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $cat->name_ar ?? '—' }}</td>
                <td>@if($cat->status ?? 1)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Active</span>@else<span style="background:#f1f5f9;color:#64748b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">Inactive</span>@endif</td>
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
