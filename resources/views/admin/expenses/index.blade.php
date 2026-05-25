@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.expense.title')"
        icon="fas fa-minus-circle"
        color="red"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.expense.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.expense.title_singular').' '.trans('global.list')"
        icon="fas fa-minus-circle"
        color="red"
        datatableClass="datatable-Expense"
        :count="$expenses->count()"
        :createRoute="route('admin.expenses.create')"
        :createLabel="trans('global.add').' '.trans('cruds.expense.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.expense.fields.title') }}</th>
                <th>{{ trans('cruds.expense.fields.amount') }}</th>
                <th>{{ trans('cruds.expense.fields.category') }}</th>
                <th>{{ trans('cruds.expense.fields.date') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($expenses as $expense)
            <tr data-entry-id="{{ $expense->id }}">
                <td></td>
                <td>{{ $expense->title ?? '' }}</td>
                <td><strong style="color:#b91c1c;">{{ number_format($expense->amount ?? 0, 2) }}</strong></td>
                <td>{{ optional($expense->category)->name ?? '' }}</td>
                <td style="color:#7a80a0;font-size:0.82rem;">{{ $expense->date ?? '' }}</td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('expense_show')
                    <x-admin-action-btn href="{{ route('admin.expenses.show',$expense->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('expense_edit')
                    <x-admin-action-btn href="{{ route('admin.expenses.edit',$expense->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('expense_delete')
                    <x-admin-action-btn href="{{ route('admin.expenses.destroy',$expense->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
                    @endcan
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
    let dtButtons=$.extend(true,[],$.fn.dataTable.defaults.buttons);
    @can('expense_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.expenses.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Expense:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
