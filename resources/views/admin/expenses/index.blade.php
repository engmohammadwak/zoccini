@extends('layouts.admin')
@section('content')
<div style="padding:24px;">
    <x-admin-page-header title="Expenses" icon="fas fa-money-bill-wave" color="red"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Expenses']]" />
    @php $total=$expenses->count(); $sum=$expenses->sum('amount'); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-money-bill-wave"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Records</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#dc2626,#ef4444);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-calculator"></i></div>
            <div><div style="font-size:1.1rem;font-weight:800;color:#1e293b;line-height:1;">{{ number_format($sum,2) }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Total Amount</div></div>
        </div>
    </div>
    <x-admin-table title="Expenses" icon="fas fa-money-bill-wave" color="red" datatableClass="datatable-Expense" :count="$expenses->count()" createPermission="expense_create" :createRoute="route('admin.expenses.create')" :createLabel="trans('global.add').' Expense'">
        <x-slot name="thead"><tr><th width="10"></th><th>Title</th><th>Category</th><th>Amount</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($expenses as $expense)
            <tr data-entry-id="{{ $expense->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $expense->title ?? $expense->description ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($expense->category)->name_en ?? optional($expense->expenseCategory)->name_en ?? '—' }}</td>
                <td style="font-size:0.85rem;font-weight:700;color:#dc2626;">{{ number_format($expense->amount ?? 0, 2) }}</td>
                <td style="font-size:0.78rem;color:#94a3b8;">{{ $expense->date ? \Carbon\Carbon::parse($expense->date)->format('Y-m-d') : ($expense->created_at?->format('Y-m-d') ?? '—') }}</td>
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
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25}); $('.datatable-Expense:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
