@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.restaurant.title')"
        icon="fas fa-utensils"
        color="red"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.restaurant.title')],
        ]"
    />

    {{-- ===== Stats Cards ===== --}}
    @php
        $totalR   = $restaurants->count();
        $activeR  = $restaurants->where('status',1)->count();
        $inactiveR= $restaurants->where('status',0)->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f43f5e,#fb7185);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-store"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $totalR }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.restaurant.title') }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $activeR }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#94a3b8,#cbd5e1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-pause-circle"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $inactiveR }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.inactive') ?? 'Inactive' }}</div>
            </div>
        </div>

        @if($totalR > 0)
        <div style="background:linear-gradient(135deg,#f43f5e,#e11d48);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(244,63,94,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div>
                <div style="font-size:1.2rem;font-weight:800;color:#fff;line-height:1;">{{ round(($activeR/$totalR)*100) }}%</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">{{ trans('global.active_rate') ?? 'Active Rate' }}</div>
            </div>
        </div>
        @endif
    </div>

    {{-- ===== Table ===== --}}
    <x-admin-table
        :title="trans('cruds.restaurant.title_singular').' '.trans('global.list')"
        icon="fas fa-utensils"
        color="red"
        datatableClass="datatable-Restaurant"
        :count="$restaurants->count()"
        :createRoute="can('restaurant_create') ? route('admin.restaurants.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.restaurant.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.restaurant.fields.name_en') }}</th>
                <th>{{ trans('cruds.restaurant.fields.name_ar') }}</th>
                <th>{{ trans('cruds.restaurant.fields.phone') }}</th>
                <th>{{ trans('cruds.restaurant.fields.status') }}</th>
                <th>{{ trans('cruds.restaurant.fields.city') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($restaurants as $restaurant)
            <tr data-entry-id="{{ $restaurant->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:9px;">
                        @if($restaurant->logo)
                            <img src="{{ asset('storage/'.$restaurant->logo) }}"
                                 style="width:36px;height:36px;border-radius:10px;object-fit:cover;box-shadow:0 2px 8px rgba(0,0,0,0.1);"
                                 alt="" loading="lazy" />
                        @else
                            <x-admin-avatar :name="$restaurant->name_en ?? 'R'" color="red" />
                        @endif
                        <span style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $restaurant->name_en ?? '' }}</span>
                    </span>
                </td>
                <td style="color:#64748b;font-size:0.83rem;">{{ $restaurant->name_ar ?? '' }}</td>
                <td>
                    @if($restaurant->phone)
                    <span style="display:inline-flex;align-items:center;gap:5px;font-size:0.82rem;color:#475569;">
                        <i class="fas fa-phone" style="color:#94a3b8;font-size:0.7rem;"></i>
                        {{ $restaurant->phone }}
                    </span>
                    @endif
                </td>
                <td>
                    @if($restaurant->status == 1)
                        <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>
                            {{ trans('global.active') ?? 'Active' }}
                        </span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>
                            {{ trans('global.inactive') ?? 'Inactive' }}
                        </span>
                    @endif
                </td>
                <td>
                    <span style="font-size:0.82rem;color:#475569;">
                        <i class="fas fa-map-marker-alt" style="color:#fca5a5;margin-left:4px;font-size:0.75rem;"></i>
                        {{ optional($restaurant->city)->name_en ?? '—' }}
                    </span>
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('restaurant_show')
                    <x-admin-action-btn href="{{ route('admin.restaurants.show',$restaurant->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('restaurant_edit')
                    <x-admin-action-btn href="{{ route('admin.restaurants.edit',$restaurant->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('restaurant_delete')
                    <x-admin-action-btn href="{{ route('admin.restaurants.destroy',$restaurant->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('restaurant_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.restaurants.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Restaurant:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
