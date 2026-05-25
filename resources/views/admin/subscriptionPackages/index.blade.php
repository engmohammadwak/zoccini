@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Subscription Packages" icon="fas fa-box-open" color="purple" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Subscription Packages']]" />
    <x-admin-table title="Packages List" icon="fas fa-box-open" color="purple" datatableClass="datatable-SubPackage" :count="$subscriptionPackages->count()" :createRoute="route('admin.subscription-packages.create')" createLabel="Add Package">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Price</th><th>Duration</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($subscriptionPackages as $pkg)
            <tr data-entry-id="{{ $pkg->id }}">
                <td></td>
                <td>{{ $pkg->name_en ?? '' }}</td>
                <td>{{ $pkg->name_ar ?? '' }}</td>
                <td><strong style="color:#7c3aed;">{{ number_format($pkg->price??0,2) }}</strong></td>
                <td>{{ $pkg->duration ?? '' }} days</td>
                <td><x-admin-status-badge :label="$pkg->status==1?'Active':'Inactive'" :type="$pkg->status==1?'success':'danger'" /></td>
                <td style="display:flex;gap:5px;">
                    @can('subscription_package_show')<x-admin-action-btn href="{{ route('admin.subscription-packages.show',$pkg->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('subscription_package_edit')<x-admin-action-btn href="{{ route('admin.subscription-packages.edit',$pkg->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('subscription_package_delete')<x-admin-action-btn href="{{ route('admin.subscription-packages.destroy',$pkg->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-SubPackage:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
