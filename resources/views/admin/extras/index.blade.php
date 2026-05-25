@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header :title="trans('cruds.extra.title')" icon="fas fa-plus-square" color="teal" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.extra.title')]]" />
    <x-admin-table :title="trans('cruds.extra.title_singular').' '.trans('global.list')" icon="fas fa-plus-square" color="teal" datatableClass="datatable-Extra" :count="$extras->count()" :createRoute="can('extra_create')?route('admin.extras.create'):null" :createLabel="trans('global.add').' '.trans('cruds.extra.title_singular')">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Price</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($extras as $extra)
            <tr data-entry-id="{{ $extra->id }}">
                <td></td>
                <td>{{ $extra->name_en ?? '' }}</td>
                <td>{{ $extra->name_ar ?? '' }}</td>
                <td><strong style="color:#0d9488;">{{ number_format($extra->price??0,2) }}</strong></td>
                <td><x-admin-status-badge :label="$extra->status==1?'Active':'Inactive'" :type="$extra->status==1?'success':'danger'" /></td>
                <td style="display:flex;gap:5px;">
                    @can('extra_show')<x-admin-action-btn href="{{ route('admin.extras.show',$extra->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('extra_edit')<x-admin-action-btn href="{{ route('admin.extras.edit',$extra->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('extra_delete')<x-admin-action-btn href="{{ route('admin.extras.destroy',$extra->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){let dtButtons=$.extend(true,[],$.fn.dataTable.defaults.buttons);@can('extra_delete')dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.extras.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});@endcan $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-Extra:not(.ajaxTable)').DataTable({buttons:dtButtons});});</script>
@endsection
