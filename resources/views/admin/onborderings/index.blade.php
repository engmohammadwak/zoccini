@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Onboarding Screens" icon="fas fa-mobile-alt" color="blue"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Onboarding']]" />
    @php $total=$onborderings->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-mobile-alt"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Screens</div></div>
        </div>
    </div>
    <x-admin-table title="Onboarding Screens" icon="fas fa-mobile-alt" color="blue" datatableClass="datatable-Onbordering" :count="$onborderings->count()" :createRoute="can('onbordering_create') ? route('admin.onborderings.create') : null" :createLabel="trans('global.add').' Screen'">
        <x-slot name="thead"><tr><th width="10"></th><th>Image</th><th>Title EN</th><th>Title AR</th><th>Sort</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($onborderings as $ob)
            <tr data-entry-id="{{ $ob->id }}">
                <td></td>
                <td>@if($ob->image ?? null)<img src="{{ asset('storage/'.$ob->image) }}" style="width:52px;height:36px;object-fit:cover;border-radius:7px;" alt="" loading="lazy">@else<div style="width:52px;height:36px;border-radius:7px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#3b82f6;"><i class="fas fa-image"></i></div>@endif</td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $ob->title_en ?? $ob->title ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $ob->title_ar ?? '—' }}</td>
                <td><span style="background:#eff6ff;color:#1d4ed8;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.82rem;">{{ $ob->sort ?? $ob->order ?? '—' }}</span></td>
                <td style="display:flex;gap:5px;">
                    @can('onbordering_show')<x-admin-action-btn href="{{ route('admin.onborderings.show',$ob->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('onbordering_edit')<x-admin-action-btn href="{{ route('admin.onborderings.edit',$ob->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('onbordering_delete')<x-admin-action-btn href="{{ route('admin.onborderings.destroy',$ob->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-Onbordering:not(.ajaxTable)').DataTable({order:[[4,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
