@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.item.title')"
        icon="fas fa-hamburger"
        color="orange"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.item.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.item.title_singular').' '.trans('global.list')"
        icon="fas fa-hamburger"
        color="orange"
        datatableClass="datatable-Item"
        :count="$items->count()"
        :createRoute="can('item_create') ? route('admin.items.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.item.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.item.fields.name_en') }}</th>
                <th>{{ trans('cruds.item.fields.name_ar') }}</th>
                <th>{{ trans('cruds.item.fields.price') }}</th>
                <th>{{ trans('cruds.item.fields.category') }}</th>
                <th>{{ trans('cruds.item.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($items as $item)
            <tr data-entry-id="{{ $item->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        @if($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" style="width:36px;height:36px;border-radius:8px;object-fit:cover;" alt="" loading="lazy" />
                        @else
                            <x-admin-avatar :name="$item->name_en" color="orange" />
                        @endif
                        {{ $item->name_en ?? '' }}
                    </span>
                </td>
                <td>{{ $item->name_ar ?? '' }}</td>
                <td><strong style="color:#d97706;">{{ number_format($item->price ?? 0, 2) }}</strong></td>
                <td>{{ optional($item->category)->name_en ?? '' }}</td>
                <td>
                    <x-admin-status-badge
                        :label="$item->status == 1 ? (trans('global.active') ?? 'Active') : (trans('global.inactive') ?? 'Inactive')"
                        :type="$item->status == 1 ? 'success' : 'danger'"
                    />
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('item_show')
                    <x-admin-action-btn href="{{ route('admin.items.show',$item->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('item_edit')
                    <x-admin-action-btn href="{{ route('admin.items.edit',$item->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('item_delete')
                    <x-admin-action-btn href="{{ route('admin.items.destroy',$item->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('item_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.items.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Item:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
