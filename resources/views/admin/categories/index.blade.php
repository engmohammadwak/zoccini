@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.category.title')"
        icon="fas fa-tags"
        color="orange"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.category.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.category.title_singular').' '.trans('global.list')"
        icon="fas fa-tags"
        color="orange"
        datatableClass="datatable-Category"
        :count="$categories->count()"
        :createRoute="can('category_create') ? route('admin.categories.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.category.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.category.fields.name_en') }}</th>
                <th>{{ trans('cruds.category.fields.name_ar') }}</th>
                <th>{{ trans('cruds.category.fields.status') }}</th>
                @if(Auth::user()->user_type != 3)
                <th>{{ trans('cruds.category.fields.restaurant') }}</th>
                @endif
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($categories as $category)
            <tr data-entry-id="{{ $category->id }}">
                <td></td>
                <td>{{ $category->name_en ?? '' }}</td>
                <td>{{ $category->name_ar ?? '' }}</td>
                <td>
                    <x-admin-status-badge
                        :label="App\Models\Category::STATUS_SELECT[$category->status] ?? ''"
                        :type="$category->status == 1 ? 'success' : 'danger'"
                    />
                </td>
                @if(Auth::user()->user_type != 3)
                <td>{{ $category->restaurant->name_en ?? '' }}</td>
                @endif
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('category_show')
                    <x-admin-action-btn href="{{ route('admin.categories.show',$category->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('category_edit')
                    <x-admin-action-btn href="{{ route('admin.categories.edit',$category->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('category_delete')
                    <x-admin-action-btn href="{{ route('admin.categories.destroy',$category->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    let dtButtons = $.extend(true,[],$.fn.dataTable.defaults.buttons);
    @can('category_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.categories.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    let table=$('.datatable-Category:not(.ajaxTable)').DataTable({buttons:dtButtons});
    $('a[data-toggle="tab"]').on('shown.bs.tab click',function(){$($.fn.dataTable.tables(true)).DataTable().columns.adjust()});
});
</script>
@endsection
