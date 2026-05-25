@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Top Restaurants" icon="fas fa-trophy" color="gold"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Top Restaurants']]" />
    @php $total=$topRestaurants->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#d97706,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-trophy"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Top Entries</div></div>
        </div>
    </div>
    <x-admin-table title="Top Restaurants" icon="fas fa-trophy" color="gold" datatableClass="datatable-TopRestaurant" :count="$topRestaurants->count()" :createRoute="can('top_restaurant_create') ? route('admin.top-restaurants.create') : null" :createLabel="trans('global.add').' Entry'">
        <x-slot name="thead"><tr><th width="10"></th><th>Restaurant</th><th>Sort</th><th>City</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($topRestaurants as $item)
            <tr data-entry-id="{{ $item->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:9px;">
                        @if(optional($item->restaurant)->logo ?? null)<img src="{{ asset('storage/'.optional($item->restaurant)->logo) }}" style="width:32px;height:32px;border-radius:8px;object-fit:cover;" alt="" loading="lazy">@else<div style="width:32px;height:32px;border-radius:8px;background:#fef9c3;display:flex;align-items:center;justify-content:center;color:#d97706;"><i class="fas fa-utensils" style="font-size:12px;"></i></div>@endif
                        <span style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ optional($item->restaurant)->name_en ?? '—' }}</span>
                    </span>
                </td>
                <td><span style="background:#fef9c3;color:#854d0e;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">{{ $item->sort ?? $item->order ?? '—' }}</span></td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($item->city)->name_en ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('top_restaurant_show')<x-admin-action-btn href="{{ route('admin.top-restaurants.show',$item->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('top_restaurant_edit')<x-admin-action-btn href="{{ route('admin.top-restaurants.edit',$item->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('top_restaurant_delete')<x-admin-action-btn href="{{ route('admin.top-restaurants.destroy',$item->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-TopRestaurant:not(.ajaxTable)').DataTable({order:[[2,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
