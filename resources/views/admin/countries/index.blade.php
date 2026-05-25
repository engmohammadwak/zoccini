@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.country.title')"
        icon="fas fa-globe"
        color="indigo"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.country.title')],
        ]"
    />

    @php
        $total   = $countries->count();
        $active  = $countries->where('status',1)->count();
        $inactive= $countries->where('status',0)->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-globe"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.country.title') }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#94a3b8,#cbd5e1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-pause-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $inactive }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.inactive') ?? 'Inactive' }}</div></div>
        </div>
        @if($total > 0)
        <div style="background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(99,102,241,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-chart-pie"></i></div>
            <div><div style="font-size:1.2rem;font-weight:800;color:#fff;line-height:1;">{{ round(($active/$total)*100) }}%</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">{{ trans('global.active_rate') ?? 'Active Rate' }}</div></div>
        </div>
        @endif
    </div>

    <x-admin-table
        :title="trans('cruds.country.title_singular').' '.trans('global.list')"
        icon="fas fa-globe"
        color="indigo"
        datatableClass="datatable-Country"
        :count="$countries->count()"
        :createRoute="can('country_create') ? route('admin.countries.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.country.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.country.fields.name_en') }}</th>
                <th>{{ trans('cruds.country.fields.name_ar') }}</th>
                <th>{{ trans('cruds.country.fields.code') ?? 'Code' }}</th>
                <th>{{ trans('cruds.country.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($countries as $country)
            <tr data-entry-id="{{ $country->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        @if($country->flag)
                            <img src="{{ asset('storage/'.$country->flag) }}" style="width:28px;height:20px;border-radius:4px;object-fit:cover;" alt="" loading="lazy" />
                        @else
                            <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#e0e7ff,#c7d2fe);display:flex;align-items:center;justify-content:center;color:#4f46e5;font-size:13px;flex-shrink:0;"><i class="fas fa-globe"></i></div>
                        @endif
                        <span style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $country->name_en ?? '' }}</span>
                    </span>
                </td>
                <td style="color:#64748b;font-size:0.83rem;">{{ $country->name_ar ?? '' }}</td>
                <td>
                    @if($country->code)
                    <span style="background:#e0e7ff;color:#3730a3;padding:3px 10px;border-radius:7px;font-weight:700;font-size:0.78rem;font-family:monospace;">{{ strtoupper($country->code) }}</span>
                    @endif
                </td>
                <td>
                    @if($country->status == 1)
                        <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>{{ trans('global.active') ?? 'Active' }}</span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>{{ trans('global.inactive') ?? 'Inactive' }}</span>
                    @endif
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('country_show')<x-admin-action-btn href="{{ route('admin.countries.show',$country->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('country_edit')<x-admin-action-btn href="{{ route('admin.countries.edit',$country->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('country_delete')<x-admin-action-btn href="{{ route('admin.countries.destroy',$country->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    @can('country_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.countries.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Country:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
