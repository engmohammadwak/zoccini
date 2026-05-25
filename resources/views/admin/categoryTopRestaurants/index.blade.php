@extends('layouts.admin')
@section('content')
<div style="padding:24px;">
    <x-admin-page-header title="Category Top Restaurants" icon="fas fa-utensils" color="orange"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Category Top Restaurants']]" />
    @php $total=$categoryTopRestaurants->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-utensils"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Records</div></div>
        </div>
    </div>
    <x-admin-table title="Category Top Restaurants" icon="fas fa-utensils" color="orange" datatableClass="datatable-CategoryTopRestaurant" :count="$categoryTopRestaurants->count()" createPermission="category_top_restaurant_create" :createRoute="route('admin.category-top-restaurants.create')" :createLabel="trans('global.add').' Record'">
        <x-slot name="thead"><tr><th width="10"></th><th>Category</th><th>Restaurant</th><th>Sort</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($categoryTopRestaurants as $rec)
            <tr data-entry-id="{{ $rec->id }}">
                <td></td>
                <td style="font-size:0.85rem;color:#1e293b;font-weight:600;">{{ optional($rec->category)->name_en ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($rec->restaurant)->name_en ?? optional($rec->restaurant)->name ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ $rec->sort ?? $rec->order ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('category_top_restaurant_show')<x-admin-action-btn href="{{ route('admin.category-top-restaurants.show',$rec->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('category_top_restaurant_edit')<x-admin-action-btn href="{{ route('admin.category-top-restaurants.edit',$rec->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('category_top_restaurant_delete')<x-admin-action-btn href="{{ route('admin.category-top-restaurants.destroy',$rec->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-CategoryTopRestaurant:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
