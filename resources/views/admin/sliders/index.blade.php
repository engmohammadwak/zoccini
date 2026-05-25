@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.slider.title')"
        icon="fas fa-images"
        color="pink"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.slider.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.slider.title_singular').' '.trans('global.list')"
        icon="fas fa-images"
        color="pink"
        datatableClass="datatable-Slider"
        :count="$sliders->count()"
        :createRoute="route('admin.sliders.create')"
        :createLabel="trans('global.add').' '.trans('cruds.slider.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.slider.fields.title_en') }}</th>
                <th>{{ trans('cruds.slider.fields.title_ar') }}</th>
                <th>{{ trans('cruds.slider.fields.status') }}</th>
                <th>{{ trans('cruds.slider.fields.order') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($sliders as $slider)
            <tr data-entry-id="{{ $slider->id }}">
                <td></td>
                <td>{{ $slider->title_en ?? '' }}</td>
                <td>{{ $slider->title_ar ?? '' }}</td>
                <td>
                    <x-admin-status-badge
                        :label="$slider->status == 1 ? (trans('global.active') ?? 'Active') : (trans('global.inactive') ?? 'Inactive')"
                        :type="$slider->status == 1 ? 'success' : 'danger'"
                    />
                </td>
                <td>{{ $slider->order ?? '' }}</td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('slider_show')
                    <x-admin-action-btn href="{{ route('admin.sliders.show',$slider->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('slider_edit')
                    <x-admin-action-btn href="{{ route('admin.sliders.edit',$slider->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('slider_delete')
                    <x-admin-action-btn href="{{ route('admin.sliders.destroy',$slider->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('slider_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.sliders.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Slider:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
