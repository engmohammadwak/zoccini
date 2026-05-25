@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.faq.title')"
        icon="fas fa-question-circle"
        color="cyan"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.faq.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.faq.title_singular').' '.trans('global.list')"
        icon="fas fa-question-circle"
        color="cyan"
        datatableClass="datatable-Faq"
        :count="$faqs->count()"
        :createRoute="route('admin.faqs.create')"
        :createLabel="trans('global.add').' '.trans('cruds.faq.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.faq.fields.question_en') }}</th>
                <th>{{ trans('cruds.faq.fields.question_ar') }}</th>
                <th>{{ trans('cruds.faq.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($faqs as $faq)
            <tr data-entry-id="{{ $faq->id }}">
                <td></td>
                <td style="max-width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $faq->question_en ?? '' }}</td>
                <td style="max-width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $faq->question_ar ?? '' }}</td>
                <td>
                    <x-admin-status-badge
                        :label="$faq->status == 1 ? (trans('global.active') ?? 'Active') : (trans('global.inactive') ?? 'Inactive')"
                        :type="$faq->status == 1 ? 'success' : 'danger'"
                    />
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('faq_show')
                    <x-admin-action-btn href="{{ route('admin.faqs.show',$faq->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('faq_edit')
                    <x-admin-action-btn href="{{ route('admin.faqs.edit',$faq->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('faq_delete')
                    <x-admin-action-btn href="{{ route('admin.faqs.destroy',$faq->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('faq_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.faqs.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Faq:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
