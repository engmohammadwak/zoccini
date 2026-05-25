@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    <x-admin-page-header
        title="Become Partners"
        icon="fas fa-handshake"
        color="teal"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => 'Become Partners'],
        ]"
    />

    @php
        $total   = $becomePartners->count();
        $pending = $becomePartners->where('status','pending')->count();
        $approved = $becomePartners->where('status','approved')->count();
    @endphp

    {{-- KPI Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#14b8a6,#2dd4bf);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-handshake"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Total</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-clock"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $pending }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Pending</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-check"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $approved }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Approved</div></div>
        </div>
    </div>

    <x-admin-table
        title="Become Partners"
        icon="fas fa-handshake"
        color="teal"
        datatableClass="datatable-BecomePartner"
        :count="$becomePartners->count()"
        createPermission="become_partner_create"
        :createRoute="route('admin.become-partners.create')"
        :createLabel="trans('global.add').' Partner'">

        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
                <th>Date</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach($becomePartners as $partner)
            <tr data-entry-id="{{ $partner->id }}">
                <td></td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <x-admin-avatar :name="$partner->name ?? 'P'" color="teal" />
                        <span style="font-weight:700;color:#1e293b;font-size:0.85rem;">{{ $partner->name ?? '—' }}</span>
                    </div>
                </td>
                <td style="font-size:0.82rem;color:#475569;">{{ $partner->phone ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;">{{ $partner->email ?? '—' }}</td>
                <td>
                    @php $status = $partner->status ?? 'pending'; @endphp
                    @if($status === 'approved')
                    <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Approved</span>
                    @elseif($status === 'rejected')
                    <span style="background:rgba(239,68,68,.1);color:#dc2626;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Rejected</span>
                    @else
                    <span style="background:rgba(245,158,11,.12);color:#92400e;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Pending</span>
                    @endif
                </td>
                <td style="font-size:0.78rem;color:#94a3b8;">{{ $partner->created_at?->format('Y-m-d') ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('become_partner_show')<x-admin-action-btn href="{{ route('admin.become-partners.show',$partner->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('become_partner_edit')<x-admin-action-btn href="{{ route('admin.become-partners.edit',$partner->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
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
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-BecomePartner:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
