@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.city.title')"
        icon="fas fa-city"
        color="teal"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.city.title')],
        ]"
    />

    @php
        $total   = $cities->count();
        $active  = $cities->where('status',1)->count();
        $inactive= $cities->where('status',0)->count();
        $countriesCount = $cities->groupBy('country_id')->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-city"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.city.title') }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#94a3b8,#cbd5e1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-pause-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $inactive }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.inactive') ?? 'Inactive' }}</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#0d9488,#0f766e);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(13,148,136,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-globe"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $countriesCount }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">{{ trans('cruds.country.title') ?? 'Countries' }}</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.city.title_singular').' '.trans('global.list')"
        icon="fas fa-city"
        color="teal"
        datatableClass="datatable-City"
        :count="$cities->count()"
        :createRoute="can('city_create') ? route('admin.cities.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.city.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.city.fields.name_en') }}</th>
                <th>{{ trans('cruds.city.fields.name_ar') }}</th>
                <th>{{ trans('cruds.city.fields.country') ?? 'Country' }}</th>
                <th>{{ trans('cruds.city.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($cities as $city)
            <tr data-entry-id="{{ $city->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#ccfbf1,#99f6e4);display:flex;align-items:center;justify-content:center;color:#0f766e;font-size:13px;flex-shrink:0;"><i class="fas fa-city"></i></div>
                        <span style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $city->name_en ?? '' }}</span>
                    </span>
                </td>
                <td style="color:#64748b;font-size:0.83rem;">{{ $city->name_ar ?? '' }}</td>
                <td><span style="font-size:0.82rem;color:#475569;"><i class="fas fa-globe" style="color:#94a3b8;margin-left:4px;font-size:0.75rem;"></i>{{ optional($city->country)->name_en ?? '—' }}</span></td>
                <td>
                    @if($city->status == 1)
                        <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>{{ trans('global.active') ?? 'Active' }}</span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>{{ trans('global.inactive') ?? 'Inactive' }}</span>
                    @endif
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('city_show')<x-admin-action-btn href="{{ route('admin.cities.show',$city->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('city_edit')<x-admin-action-btn href="{{ route('admin.cities.edit',$city->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('city_delete')<x-admin-action-btn href="{{ route('admin.cities.destroy',$city->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    @can('city_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.cities.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-City:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
