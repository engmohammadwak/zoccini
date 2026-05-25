@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Cancel Reasons" icon="fas fa-ban" color="red" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Cancel Reasons']]" />
    <x-admin-table title="Cancel Reasons List" icon="fas fa-ban" color="red" datatableClass="datatable-CancelReason" :count="$canselReasons->count()" :createRoute="route('admin.cansel-reasons.create')" createLabel="Add Cancel Reason">
        <x-slot name="thead"><tr><th width="10"></th><th>Reason EN</th><th>Reason AR</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($canselReasons as $reason)
            <tr data-entry-id="{{ $reason->id }}">
                <td></td>
                <td>{{ $reason->reason_en ?? '' }}</td>
                <td>{{ $reason->reason_ar ?? '' }}</td>
                <td><x-admin-status-badge :label="$reason->status==1?'Active':'Inactive'" :type="$reason->status==1?'success':'danger'" /></td>
                <td style="display:flex;gap:5px;">
                    @can('cansel_reason_show')<x-admin-action-btn href="{{ route('admin.cansel-reasons.show',$reason->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('cansel_reason_edit')<x-admin-action-btn href="{{ route('admin.cansel-reasons.edit',$reason->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('cansel_reason_delete')<x-admin-action-btn href="{{ route('admin.cansel-reasons.destroy',$reason->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-CancelReason:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
