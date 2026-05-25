@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.income.title')"
        icon="fas fa-plus-circle"
        color="green"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.income.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.income.title_singular').' '.trans('global.list')"
        icon="fas fa-plus-circle"
        color="green"
        datatableClass="datatable-Income"
        :count="$incomes->count()"
        :createRoute="route('admin.incomes.create')"
        :createLabel="trans('global.add').' '.trans('cruds.income.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.income.fields.title') }}</th>
                <th>{{ trans('cruds.income.fields.amount') }}</th>
                <th>{{ trans('cruds.income.fields.category') }}</th>
                <th>{{ trans('cruds.income.fields.date') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($incomes as $income)
            <tr data-entry-id="{{ $income->id }}">
                <td></td>
                <td>{{ $income->title ?? '' }}</td>
                <td><strong style="color:#16a34a;">{{ number_format($income->amount ?? 0, 2) }}</strong></td>
                <td>{{ optional($income->category)->name ?? '' }}</td>
                <td style="color:#7a80a0;font-size:0.82rem;">{{ $income->date ?? '' }}</td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('income_show')
                    <x-admin-action-btn href="{{ route('admin.incomes.show',$income->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('income_edit')
                    <x-admin-action-btn href="{{ route('admin.incomes.edit',$income->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('income_delete')
                    <x-admin-action-btn href="{{ route('admin.incomes.destroy',$income->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('income_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.incomes.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Income:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
