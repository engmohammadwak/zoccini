@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Venture Companies" icon="fas fa-building" color="indigo"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Venture Companies']]" />
    @php $total=$ventureCompanies->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-building"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Companies</div></div>
        </div>
    </div>
    <x-admin-table title="Venture Companies" icon="fas fa-building" color="indigo" datatableClass="datatable-VentureCompany" :count="$ventureCompanies->count()" :createRoute="can('venture_company_create') ? route('admin.venture-companies.create') : null" :createLabel="trans('global.add').' Company'">
        <x-slot name="thead"><tr><th width="10"></th><th>Logo</th><th>Name EN</th><th>Name AR</th><th>Email</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($ventureCompanies as $vc)
            <tr data-entry-id="{{ $vc->id }}">
                <td></td>
                <td>@if($vc->logo ?? $vc->image ?? null)<img src="{{ asset('storage/'.($vc->logo ?? $vc->image)) }}" style="width:42px;height:32px;object-fit:contain;border-radius:6px;border:1px solid #f1f5f9;" alt="" loading="lazy">@else<div style="width:42px;height:32px;border-radius:6px;background:#eef2ff;display:flex;align-items:center;justify-content:center;color:#6366f1;"><i class="fas fa-building"></i></div>@endif</td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $vc->name_en ?? $vc->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $vc->name_ar ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ $vc->email ?? '—' }}</td>
                <td>@if($vc->status ?? 1)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Active</span>@else<span style="background:#f1f5f9;color:#64748b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">Inactive</span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('venture_company_show')<x-admin-action-btn href="{{ route('admin.venture-companies.show',$vc->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('venture_company_edit')<x-admin-action-btn href="{{ route('admin.venture-companies.edit',$vc->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('venture_company_delete')<x-admin-action-btn href="{{ route('admin.venture-companies.destroy',$vc->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-VentureCompany:not(.ajaxTable)').DataTable({order:[[2,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
