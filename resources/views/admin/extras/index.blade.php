@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Extras" icon="fas fa-plus-circle" color="cyan"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Extras']]" />
    @php $total=$extras->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#06b6d4,#22d3ee);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-plus-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Extras</div></div>
        </div>
    </div>
    <x-admin-table title="Extras" icon="fas fa-plus-circle" color="cyan" datatableClass="datatable-Extra" :count="$extras->count()" :createRoute="can('extra_create') ? route('admin.extras.create') : null" :createLabel="trans('global.add').' Extra'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Price</th><th>Restaurant</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($extras as $extra)
            <tr data-entry-id="{{ $extra->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $extra->name_en ?? $extra->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $extra->name_ar ?? '—' }}</td>
                <td><span style="background:#cffafe;color:#164e63;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.82rem;">{{ number_format($extra->price ?? 0,2) }}</span></td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($extra->restaurant)->name_en ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('extra_show')<x-admin-action-btn href="{{ route('admin.extras.show',$extra->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('extra_edit')<x-admin-action-btn href="{{ route('admin.extras.edit',$extra->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('extra_delete')<x-admin-action-btn href="{{ route('admin.extras.destroy',$extra->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-Extra:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
