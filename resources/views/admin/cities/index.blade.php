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
        $total          = $cities->count();
        $active         = $cities->where('status',1)->count();
        $inactive       = $cities->where('status',0)->count();
        $countriesCount = $cities->groupBy('country_id')->count();
    @endphp

    {{-- KPI Cards --}}
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

    {{-- Table Card --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;">
        {{-- Header --}}
        <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;"><i class="fas fa-city"></i></div>
                <div>
                    <div style="font-weight:700;color:#1e293b;font-size:0.92rem;">{{ trans('cruds.city.title_singular') }} {{ trans('global.list') }}</div>
                    <div style="font-size:0.72rem;color:#94a3b8;">{{ $total }} {{ trans('cruds.city.title') }}</div>
                </div>
            </div>
            @can('city_create')
            <a href="{{ route('admin.cities.create') }}" style="background:linear-gradient(135deg,#0d9488,#0f766e);color:#fff;padding:8px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 2px 8px rgba(13,148,136,0.3);">
                <i class="fas fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.city.title_singular') }}
            </a>
            @endcan
        </div>

        {{-- DataTable --}}
        <div style="padding:16px;">
            <table class="table datatable-City" style="width:100%;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th width="10"></th>
                        <th>{{ trans('cruds.city.fields.name_en') }}</th>
                        <th>{{ trans('cruds.city.fields.name_ar') }}</th>
                        <th>{{ trans('cruds.city.fields.country') ?? 'Country' }}</th>
                        <th>{{ trans('cruds.city.fields.status') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cities as $city)
                    <tr data-entry-id="{{ $city->id }}">
                        <td></td>
                        <td>
                            <span style="display:flex;align-items:center;gap:8px;">
                                <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#ccfbf1,#99f6e4);display:flex;align-items:center;justify-content:center;color:#0f766e;font-size:13px;flex-shrink:0;"><i class="fas fa-city"></i></div>
                                <span style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $city->name_en ?? '' }}</span>
                            </span>
                        </td>
                        <td style="color:#64748b;font-size:0.83rem;direction:rtl;">{{ $city->name_ar ?? '' }}</td>
                        <td>
                            @if(optional($city->country)->flag)
                                <span style="display:inline-flex;align-items:center;gap:6px;">
                                    <img src="{{ asset('storage/'.optional($city->country)->flag) }}" style="width:20px;height:15px;border-radius:3px;object-fit:cover;" alt="" loading="lazy" />
                                    <span style="font-size:0.82rem;color:#475569;">{{ optional($city->country)->name_en ?? '—' }}</span>
                                </span>
                            @else
                                <span style="font-size:0.82rem;color:#475569;">
                                    <i class="fas fa-globe" style="color:#94a3b8;margin-inline-end:4px;font-size:0.75rem;"></i>{{ optional($city->country)->name_en ?? '—' }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($city->status == 1)
                                <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>{{ trans('global.active') ?? 'Active' }}
                                </span>
                            @else
                                <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                @can('city_show')<x-admin-action-btn href="{{ route('admin.cities.show',$city->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                                @can('city_edit')<x-admin-action-btn href="{{ route('admin.cities.edit',$city->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                                @can('city_delete')<x-admin-action-btn href="{{ route('admin.cities.destroy',$city->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

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
