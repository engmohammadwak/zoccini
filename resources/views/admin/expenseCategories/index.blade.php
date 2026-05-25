@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Expense Categories" icon="fas fa-folder-minus" color="red" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Expense Categories']]" />
    <x-admin-table title="Expense Categories List" icon="fas fa-folder-minus" color="red" datatableClass="datatable-ExpenseCategory" :count="$expenseCategories->count()" :createRoute="route('admin.expense-categories.create')" createLabel="Add Category">
        <x-slot name="thead"><tr><th width="10"></th><th>Name</th><th>Description</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($expenseCategories as $cat)
            <tr data-entry-id="{{ $cat->id }}">
                <td></td>
                <td>{{ $cat->name ?? '' }}</td>
                <td>{{ $cat->description ?? '' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('expense_category_show')<x-admin-action-btn href="{{ route('admin.expense-categories.show',$cat->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('expense_category_edit')<x-admin-action-btn href="{{ route('admin.expense-categories.edit',$cat->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('expense_category_delete')<x-admin-action-btn href="{{ route('admin.expense-categories.destroy',$cat->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-ExpenseCategory:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
