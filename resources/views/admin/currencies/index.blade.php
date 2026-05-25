@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header :title="trans('cruds.currency.title')" icon="fas fa-dollar-sign" color="green" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.currency.title')]]" />
    <x-admin-table :title="trans('cruds.currency.title_singular').' '.trans('global.list')" icon="fas fa-dollar-sign" color="green" datatableClass="datatable-Currency" :count="$currencies->count()" :createRoute="route('admin.currencies.create')" :createLabel="trans('global.add').' '.trans('cruds.currency.title_singular')">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Code</th><th>Symbol</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($currencies as $currency)
            <tr data-entry-id="{{ $currency->id }}">
                <td></td>
                <td>{{ $currency->name_en ?? '' }}</td>
                <td>{{ $currency->name_ar ?? '' }}</td>
                <td><code style="background:#f0fdf4;padding:3px 8px;border-radius:5px;">{{ $currency->code ?? '' }}</code></td>
                <td><strong>{{ $currency->symbol ?? '' }}</strong></td>
                <td><x-admin-status-badge :label="$currency->status==1?'Active':'Inactive'" :type="$currency->status==1?'success':'danger'" /></td>
                <td style="display:flex;gap:5px;">
                    @can('currency_show')<x-admin-action-btn href="{{ route('admin.currencies.show',$currency->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('currency_edit')<x-admin-action-btn href="{{ route('admin.currencies.edit',$currency->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('currency_delete')<x-admin-action-btn href="{{ route('admin.currencies.destroy',$currency->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-Currency:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
