@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header :title="trans('cruds.table.title')" icon="fas fa-table" color="indigo" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.table.title')]]" />
    <x-admin-table :title="trans('cruds.table.title_singular').' '.trans('global.list')" icon="fas fa-table" color="indigo" datatableClass="datatable-Table" :count="$tables->count()" :createRoute="can('table_create')?route('admin.tables.create'):null" :createLabel="trans('global.add').' '.trans('cruds.table.title_singular')">
        <x-slot name="thead"><tr><th width="10"></th><th>Number</th><th>Capacity</th><th>Restaurant</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($tables as $table)
            <tr data-entry-id="{{ $table->id }}">
                <td></td>
                <td><span style="background:#e0e7ff;color:#4338ca;padding:3px 10px;border-radius:7px;font-weight:700;">{{ $table->number ?? '' }}</span></td>
                <td>{{ $table->capacity ?? '' }} persons</td>
                <td>{{ optional($table->restaurant)->name_en ?? '' }}</td>
                <td><x-admin-status-badge :label="$table->status==1?'Available':'Unavailable'" :type="$table->status==1?'success':'danger'" /></td>
                <td style="display:flex;gap:5px;">
                    @can('table_show')<x-admin-action-btn href="{{ route('admin.tables.show',$table->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('table_edit')<x-admin-action-btn href="{{ route('admin.tables.edit',$table->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('table_delete')<x-admin-action-btn href="{{ route('admin.tables.destroy',$table->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){let dtButtons=$.extend(true,[],$.fn.dataTable.defaults.buttons);@can('table_delete')dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.tables.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});@endcan $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-Table:not(.ajaxTable)').DataTable({buttons:dtButtons});});</script>
@endsection
