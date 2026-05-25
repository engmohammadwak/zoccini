@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Points" icon="fas fa-star" color="gold"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Points']]" />
    @php $total=$points->count(); $totalPts=$points->sum('points') ?? 0; @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#d97706,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-star"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Records</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#d97706,#b45309);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(217,119,6,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-gem"></i></div>
            <div><div style="font-size:1.2rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($totalPts) }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Total Points</div></div>
        </div>
    </div>
    <x-admin-table title="Points" icon="fas fa-star" color="gold" datatableClass="datatable-Point" :count="$points->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Points</th><th>Type</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($points as $point)
            <tr data-entry-id="{{ $point->id }}">
                <td></td>
                <td><span style="display:flex;align-items:center;gap:8px;"><x-admin-avatar :name="optional($point->user)->name ?? 'U'" color="gold" /><span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($point->user)->name ?? '—' }}</span></span></td>
                <td><span style="background:#fef9c3;color:#854d0e;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">{{ number_format($point->points ?? 0) }}</span></td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($point->pointType)->name_en ?? $point->type ?? '—' }}</td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($point->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('point_show')<x-admin-action-btn href="{{ route('admin.points.show',$point->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('point_delete')<x-admin-action-btn href="{{ route('admin.points.destroy',$point->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25}); $('.datatable-Point:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
