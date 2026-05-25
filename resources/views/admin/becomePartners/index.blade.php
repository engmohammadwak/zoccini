@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Become Partners" icon="fas fa-handshake" color="teal" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Become Partners']]" />
    <x-admin-table title="Partner Requests" icon="fas fa-handshake" color="teal" datatableClass="datatable-BecomePartner" :count="$becomePartners->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>Name</th><th>Phone</th><th>Email</th><th>Restaurant Name</th><th>Status</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($becomePartners as $partner)
            <tr data-entry-id="{{ $partner->id }}">
                <td></td>
                <td>{{ $partner->name ?? '' }}</td>
                <td>{{ $partner->phone ?? '' }}</td>
                <td>{{ $partner->email ?? '' }}</td>
                <td>{{ $partner->restaurant_name ?? '' }}</td>
                <td><x-admin-status-badge :label="$partner->status ?? 'pending'" :type="$partner->status=='approved'?'success':($partner->status=='rejected'?'danger':'warning')" /></td>
                <td style="color:#7a80a0;font-size:0.82rem;">{{ optional($partner->created_at)->format('d/m/Y') ?? '' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('become_partner_show')<x-admin-action-btn href="{{ route('admin.become-partners.show',$partner->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('become_partner_delete')<x-admin-action-btn href="{{ route('admin.become-partners.destroy',$partner->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-BecomePartner:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
