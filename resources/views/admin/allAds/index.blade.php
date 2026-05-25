@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="All Ads" icon="fas fa-ad" color="orange"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'All Ads']]" />
    @php
        $total  = $allAds->count();
        $active = $allAds->where('status',1)->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f97316,#fb923c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-ad"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Total</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#f97316,#ea580c);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(249,115,22,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Active</div></div>
        </div>
    </div>
    <x-admin-table title="All Ads" icon="fas fa-ad" color="orange" datatableClass="datatable-AllAd" :count="$allAds->count()" :createRoute="can('all_ad_create') ? route('admin.all-ads.create') : null" :createLabel="trans('global.add').' Ad'">
        <x-slot name="thead"><tr><th width="10"></th><th>Image</th><th>Title</th><th>Category</th><th>Status</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($allAds as $ad)
            <tr data-entry-id="{{ $ad->id }}">
                <td></td>
                <td>@if($ad->image)<img src="{{ asset('storage/'.$ad->image) }}" style="width:52px;height:36px;border-radius:7px;object-fit:cover;" alt="" loading="lazy">@else<div style="width:52px;height:36px;border-radius:7px;background:#fff7ed;display:flex;align-items:center;justify-content:center;color:#f97316;"><i class="fas fa-image"></i></div>@endif</td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $ad->title_en ?? $ad->title ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($ad->adsCategory)->name_en ?? '—' }}</td>
                <td>@if($ad->status == 1)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Active</span>@else<span style="background:#f1f5f9;color:#64748b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">Inactive</span>@endif</td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($ad->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('all_ad_show')<x-admin-action-btn href="{{ route('admin.all-ads.show',$ad->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('all_ad_edit')<x-admin-action-btn href="{{ route('admin.all-ads.edit',$ad->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('all_ad_delete')<x-admin-action-btn href="{{ route('admin.all-ads.destroy',$ad->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25}); $('.datatable-AllAd:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
