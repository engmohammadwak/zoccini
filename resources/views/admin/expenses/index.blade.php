@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.expense.title')"
        icon="fas fa-file-invoice-dollar"
        color="red"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.expense.title')],
        ]"
    />

    @php
        $total     = $expenses->count();
        $totalAmt  = $expenses->sum('amount') ?? 0;
        $thisMonth = $expenses->filter(fn($e)=> optional($e->created_at)->isCurrentMonth())->sum('amount') ?? 0;
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-file-invoice-dollar"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Records</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-calendar-alt"></i></div>
            <div><div style="font-size:1rem;font-weight:800;color:#1e293b;line-height:1;">{{ number_format($thisMonth,2) }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">This Month</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#ef4444,#dc2626);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(239,68,68,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-money-bill-wave"></i></div>
            <div><div style="font-size:1rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($totalAmt,2) }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Total Amount</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.expense.title')"
        icon="fas fa-file-invoice-dollar"
        color="red"
        datatableClass="datatable-Expense"
        :count="$expenses->count()"
        :createRoute="can('expense_create') ? route('admin.expenses.create') : null"
        :createLabel="trans('global.add').' Expense'"
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
            @foreach($expenses as $expense)
            <tr data-entry-id="{{ $expense->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $expense->title ?? $expense->description ?? '—' }}</td>
                <td>
                    @if($expense->category ?? $expense->expenseCategory ?? null)
                    <span style="background:#fee2e2;color:#991b1b;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">{{ optional($expense->expenseCategory ?? $expense->category)->name_en ?? optional($expense->expenseCategory ?? $expense->category)->name ?? '—' }}</span>
                    @endif
                </td>
                <td><span style="background:#fee2e2;color:#991b1b;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">{{ number_format($expense->amount ?? 0,2) }}</span></td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($expense->date ?? $expense->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('expense_show')<x-admin-action-btn href="{{ route('admin.expenses.show',$expense->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('expense_edit')<x-admin-action-btn href="{{ route('admin.expenses.edit',$expense->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('expense_delete')<x-admin-action-btn href="{{ route('admin.expenses.destroy',$expense->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    $('.datatable-Expense:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)});
});
</script>
@endsection
