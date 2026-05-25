@extends('layouts.admin')
@section('content')
<div style="padding:24px;">
    <x-admin-page-header title="All Ads" icon="fas fa-ad" color="orange"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'All Ads']]" />
    @php $total=$allAds->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-ad"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Ads</div></div>
        </div>
    </div>
    <x-admin-table title="All Ads" icon="fas fa-ad" color="orange" datatableClass="datatable-AllAd" :count="$allAds->count()" createPermission="all_ad_create" :createRoute="route('admin.all-ads.create')" :createLabel="trans('global.add').' Ad'">
        <x-slot name="thead"><tr><th width="10"></th><th>Title</th><th>Category</th><th>User</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($allAds as $ad)
            <tr data-entry-id="{{ $ad->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $ad->title ?? $ad->title_en ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;">{{ optional($ad->category)->name_en ?? optional($ad->adsCategory)->name_en ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;">{{ optional($ad->user)->name ?? '—' }}</td>
                <td>@if(($ad->status??1)==1)<span style="background:rgba(16,185,129,.12);color:#065f46;padding:3px 10px;border-radius:999px;font-size:0.75rem;font-weight:600;">Active</span>@else<span style="background:rgba(148,163,184,.12);color:#475569;padding:3px 10px;border-radius:999px;font-size:0.75rem;font-weight:600;">Inactive</span>@endif</td>
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
