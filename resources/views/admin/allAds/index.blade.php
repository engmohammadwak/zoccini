@extends('layouts.admin')
@section('content')
<div style="min-height:100vh;padding:24px;">

    <x-admin-page-header title="{{ trans('cruds.allAd.title') }}" icon="fas fa-ad" color="orange"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.allAd.title')]]" />
    @php $total=$allAds->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f97316,#ea580c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-ad"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.allAd.title') }}</div></div>
        </div>
    </div>
    <x-admin-table
        title="{{ trans('cruds.allAd.title') }}" icon="fas fa-ad" color="orange"
        datatableClass="datatable-AllAd"
        :count="$allAds->count()"
        createPermission="all_ad_create"
        :createRoute="route('admin.all-ads.create')"
    >
        <x-slot name="thead"><tr><th width="10"></th><th>{{ trans('cruds.allAd.fields.title') }}</th><th>{{ trans('cruds.allAd.fields.ads_category') }}</th><th>{{ trans('cruds.allAd.fields.status') }}</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($allAds as $ad)
            <tr data-entry-id="{{ $ad->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $ad->title ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($ad->adsCategory)->name ?? '—' }}</td>
                <td>@if($ad->status ?? 1)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Active</span>@else<span style="background:#f1f5f9;color:#64748b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">Inactive</span>@endif</td>
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
<script>
$(document).ready(function(){$('.datatable-AllAd').DataTable({pageLength:25,order:[[1,'asc']]});});
</script>
@stop
