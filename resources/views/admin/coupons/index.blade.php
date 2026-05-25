@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.coupon.title')"
        icon="fas fa-tag"
        color="green"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.coupon.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.coupon.title_singular').' '.trans('global.list')"
        icon="fas fa-tag"
        color="green"
        datatableClass="datatable-Coupon"
        :count="$coupons->count()"
        :createRoute="route('admin.coupons.create')"
        :createLabel="trans('global.add').' '.trans('cruds.coupon.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.coupon.fields.id') }}</th>
                <th>{{ trans('cruds.coupon.fields.name') }}</th>
                <th>{{ trans('cruds.coupon.fields.code') }}</th>
                <th>{{ trans('cruds.coupon.fields.discount') }}</th>
                <th>{{ trans('cruds.coupon.fields.type') }}</th>
                <th>{{ trans('cruds.coupon.fields.start_date') }}</th>
                <th>{{ trans('cruds.coupon.fields.end_date') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($coupons as $coupon)
            <tr data-entry-id="{{ $coupon->id }}">
                <td></td>
                <td><span style="background:#dcfce7;color:#16a34a;padding:3px 10px;border-radius:7px;font-weight:700;font-size:0.8rem;">#{{ $coupon->id }}</span></td>
                <td>{{ $coupon->name ?? '' }}</td>
                <td><code style="background:#f0f2fa;padding:3px 8px;border-radius:5px;font-size:0.82rem;">{{ $coupon->code ?? '' }}</code></td>
                <td><strong style="color:#16a34a;">{{ $coupon->discount ?? '' }}%</strong></td>
                <td>{{ $coupon->type ?? '' }}</td>
                <td>{{ $coupon->start_date ?? '' }}</td>
                <td>{{ $coupon->end_date ?? '' }}</td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('coupon_show')
                    <x-admin-action-btn href="{{ route('admin.coupons.show',$coupon->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('coupon_edit')
                    <x-admin-action-btn href="{{ route('admin.coupons.edit',$coupon->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('coupon_delete')
                    <x-admin-action-btn href="{{ route('admin.coupons.destroy',$coupon->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('coupon_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.coupons.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Coupon:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
