@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.income.title')"
        icon="fas fa-hand-holding-usd"
        color="green"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.income.title')],
        ]"
    />

    @php
        $total     = $incomes->count();
        $totalAmt  = $incomes->sum('amount') ?? 0;
        $thisMonth = $incomes->filter(fn($e)=> optional($e->created_at)->isCurrentMonth())->sum('amount') ?? 0;
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-hand-holding-usd"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Records</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-calendar-alt"></i></div>
            <div><div style="font-size:1rem;font-weight:800;color:#1e293b;line-height:1;">{{ number_format($thisMonth,2) }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">This Month</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#10b981,#059669);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(16,185,129,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-money-bill-wave"></i></div>
            <div><div style="font-size:1rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($totalAmt,2) }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Total Income</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.income.title')"
        icon="fas fa-hand-holding-usd"
        color="green"
        datatableClass="datatable-Income"
        :count="$incomes->count()"
        :createRoute="can('income_create') ? route('admin.incomes.create') : null"
        :createLabel="trans('global.add').' Income'"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>Title</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Date</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($incomes as $income)
            <tr data-entry-id="{{ $income->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $income->title ?? $income->description ?? '—' }}</td>
                <td>
                    @if($income->incomeCategory ?? $income->category ?? null)
                    <span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">{{ optional($income->incomeCategory ?? $income->category)->name_en ?? optional($income->incomeCategory ?? $income->category)->name ?? '—' }}</span>
                    @endif
                </td>
                <td><span style="background:#dcfce7;color:#166534;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">{{ number_format($income->amount ?? 0,2) }}</span></td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($income->date ?? $income->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('income_show')<x-admin-action-btn href="{{ route('admin.incomes.show',$income->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('income_edit')<x-admin-action-btn href="{{ route('admin.incomes.edit',$income->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('income_delete')<x-admin-action-btn href="{{ route('admin.incomes.destroy',$income->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    $('.datatable-Income:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)});
});
</script>
@endsection
