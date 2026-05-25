@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.delivery.title')"
        icon="fas fa-motorcycle"
        color="orange"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.delivery.title')],
        ]"
    />

    {{-- ===== Stats Cards ===== --}}
    @php
        $totalD   = $deliveries->count();
        $activeD  = $deliveries->where('status',1)->count();
        $inactiveD= $deliveries->where('status',0)->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:22px;">

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f97316,#fb923c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-motorcycle"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $totalD }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.delivery.title') }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $activeD }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#94a3b8,#cbd5e1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-pause-circle"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $inactiveD }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.inactive') ?? 'Inactive' }}</div>
            </div>
        </div>

        @if($totalD > 0)
        <div style="background:linear-gradient(135deg,#f97316,#ea580c);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(249,115,22,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div>
                <div style="font-size:1.2rem;font-weight:800;color:#fff;line-height:1;">{{ round(($activeD/$totalD)*100) }}%</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">{{ trans('global.active_rate') ?? 'Active Rate' }}</div>
            </div>
        </div>
        @endif

    </div>

    {{-- ===== Table ===== --}}
    <x-admin-table
        :title="trans('cruds.delivery.title_singular').' '.trans('global.list')"
        icon="fas fa-motorcycle"
        color="orange"
        datatableClass="datatable-Delivery"
        :count="$deliveries->count()"
        :createRoute="route('admin.deliveries.create')"
        :createLabel="trans('global.add').' '.trans('cruds.delivery.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.delivery.fields.name') }}</th>
                <th>{{ trans('cruds.delivery.fields.phone') }}</th>
                <th>{{ trans('cruds.delivery.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($deliveries as $delivery)
            <tr data-entry-id="{{ $delivery->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:9px;">
                        <x-admin-avatar :name="$delivery->name ?? 'D'" color="orange" />
                        <span style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $delivery->name ?? '' }}</span>
                    </span>
                </td>
                <td>
                    @if($delivery->phone)
                    <span style="font-size:0.82rem;color:#475569;display:inline-flex;align-items:center;gap:5px;">
                        <i class="fas fa-phone" style="color:#fed7aa;font-size:0.7rem;"></i>
                        {{ $delivery->phone }}
                    </span>
                    @endif
                </td>
                <td>
                    @if($delivery->status == 1)
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
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('delivery_show')
                    <x-admin-action-btn href="{{ route('admin.deliveries.show',$delivery->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('delivery_edit')
                    <x-admin-action-btn href="{{ route('admin.deliveries.edit',$delivery->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('delivery_delete')
                    <x-admin-action-btn href="{{ route('admin.deliveries.destroy',$delivery->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('delivery_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.deliveries.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Delivery:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
