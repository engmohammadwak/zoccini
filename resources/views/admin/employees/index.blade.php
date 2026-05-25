@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.employee.title')"
        icon="fas fa-user-tie"
        color="indigo"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.employee.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.employee.title_singular').' '.trans('global.list')"
        icon="fas fa-user-tie"
        color="indigo"
        datatableClass="datatable-Employee"
        :count="$employees->count()"
        :createRoute="route('admin.employees.create')"
        :createLabel="trans('global.add').' '.trans('cruds.employee.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.employee.fields.name') }}</th>
                <th>{{ trans('cruds.employee.fields.phone') }}</th>
                <th>{{ trans('cruds.employee.fields.email') }}</th>
                <th>{{ trans('cruds.employee.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($employees as $employee)
            <tr data-entry-id="{{ $employee->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        <x-admin-avatar :name="$employee->name" color="indigo" />
                        {{ $employee->name ?? '' }}
                    </span>
                </td>
                <td>{{ $employee->phone ?? '' }}</td>
                <td>{{ $employee->email ?? '' }}</td>
                <td>
                    <x-admin-status-badge
                        :label="$employee->status == 1 ? (trans('global.active') ?? 'Active') : (trans('global.inactive') ?? 'Inactive')"
                        :type="$employee->status == 1 ? 'success' : 'danger'"
                    />
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('employee_show')
                    <x-admin-action-btn href="{{ route('admin.employees.show',$employee->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('employee_edit')
                    <x-admin-action-btn href="{{ route('admin.employees.edit',$employee->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('employee_delete')
                    <x-admin-action-btn href="{{ route('admin.employees.destroy',$employee->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('employee_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.employees.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Employee:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
