@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Favorites" icon="fas fa-heart" color="pink"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Favorites']]" />
    @php $total=$favorites->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ec4899,#f472b6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-heart"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Favorites</div></div>
        </div>
    </div>
    <x-admin-table title="Favorites" icon="fas fa-heart" color="pink" datatableClass="datatable-Favorite" :count="$favorites->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Restaurant</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($favorites as $fav)
            <tr data-entry-id="{{ $fav->id }}">
                <td></td>
                <td><span style="display:flex;align-items:center;gap:8px;"><x-admin-avatar :name="optional($fav->user)->name ?? 'U'" color="pink" /><span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($fav->user)->name ?? '—' }}</span></span></td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($fav->restaurant)->name_en ?? '—' }}</td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($fav->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('favorite_delete')<x-admin-action-btn href="{{ route('admin.favorites.destroy',$fav->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25}); $('.datatable-Favorite:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
