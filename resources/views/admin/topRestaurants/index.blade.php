@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Top Restaurants" icon="fas fa-trophy" color="gold" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Top Restaurants']]" />
    <x-admin-table title="Top Restaurants List" icon="fas fa-trophy" color="gold" datatableClass="datatable-TopRestaurant" :count="$topRestaurants->count()" :createRoute="route('admin.top-restaurants.create')" createLabel="Add Top Restaurant">
        <x-slot name="thead"><tr><th width="10"></th><th>Restaurant</th><th>Order</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($topRestaurants as $top)
            <tr data-entry-id="{{ $top->id }}">
                <td></td>
                <td>{{ optional($top->restaurant)->name_en ?? '' }}</td>
                <td>{{ $top->order ?? '' }}</td>
                <td><x-admin-status-badge :label="$top->status==1?'Active':'Inactive'" :type="$top->status==1?'success':'danger'" /></td>
                <td style="display:flex;gap:5px;">
                    @can('top_restaurant_show')<x-admin-action-btn href="{{ route('admin.top-restaurants.show',$top->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('top_restaurant_edit')<x-admin-action-btn href="{{ route('admin.top-restaurants.edit',$top->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('top_restaurant_delete')<x-admin-action-btn href="{{ route('admin.top-restaurants.destroy',$top->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-TopRestaurant:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
