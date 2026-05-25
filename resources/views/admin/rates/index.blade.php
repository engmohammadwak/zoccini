@extends('layouts.admin')
@section('content')
<div style="min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.rate.title')"
        icon="fas fa-star"
        color="amber"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.rate.title')],
        ]"
    />

    @php
        $total   = $rates->count();
        $avg     = $rates->avg('rate') ?? 0;
        $fiveStar= $rates->where('rate',5)->count();
        $oneStar = $rates->where('rate',1)->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-star"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Total Reviews</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-thumbs-up"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $fiveStar }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">5-Star</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-thumbs-down"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $oneStar }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">1-Star</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(245,158,11,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-chart-line"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($avg,1) }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Avg Rating</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.rate.title')"
        icon="fas fa-star"
        color="amber"
        datatableClass="datatable-Rate"
        :count="$rates->count()"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>User</th>
                <th>Restaurant</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($rates as $rate)
            <tr data-entry-id="{{ $rate->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        <x-admin-avatar :name="optional($rate->user)->name ?? 'U'" color="amber" />
                        <span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($rate->user)->name ?? '—' }}</span>
                    </span>
                </td>
                <td style="font-size:0.82rem;color:#475569;">{{ optional($rate->restaurant)->name_en ?? '—' }}</td>
                <td>
                    <span style="display:inline-flex;align-items:center;gap:3px;">
                        @for($i=1;$i<=5;$i++)
                            <i class="fas fa-star" style="font-size:12px;color:{{ $i <= ($rate->rate ?? 0) ? '#f59e0b' : '#e2e8f0' }};"></i>
                        @endfor
                        <span style="font-weight:700;color:#1e293b;font-size:0.82rem;margin-right:4px;">{{ $rate->rate }}</span>
                    </span>
                </td>
                <td style="font-size:0.82rem;color:#64748b;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $rate->comment ?? '—' }}</td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($rate->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('rate_show')<x-admin-action-btn href="{{ route('admin.rates.show',$rate->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('rate_delete')<x-admin-action-btn href="{{ route('admin.rates.destroy',$rate->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>

</div>
@endsection
@section('scripts')
@parent
<script>
$(function(){
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Rate:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)});
});
</script>
@endsection
