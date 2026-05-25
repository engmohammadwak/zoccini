@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.delivery.title')"
        icon="fas fa-motorcycle"
        color="cyan"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.delivery.title')],
        ]"
    />

    @php
        $total    = $deliveries->count();
        $active   = $deliveries->where('status',1)->count();
        $online   = $deliveries->where('is_online',1)->count();
        $busy     = $deliveries->where('is_busy',1)->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#06b6d4,#22d3ee);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-motorcycle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.delivery.title') }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-signal"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $online }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Online</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#06b6d4,#0891b2);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(6,182,212,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-hourglass-half"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $busy }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Busy</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.delivery.title_singular').' '.trans('global.list')"
        icon="fas fa-motorcycle"
        color="cyan"
        datatableClass="datatable-Delivery"
        :count="$deliveries->count()"
        :createRoute="can('delivery_create') ? route('admin.deliveries.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.delivery.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.delivery.fields.name') }}</th>
                <th>{{ trans('cruds.delivery.fields.phone') ?? 'Phone' }}</th>
                <th>{{ trans('cruds.delivery.fields.city') ?? 'City' }}</th>
                <th>Online</th>
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
                        @if($delivery->avatar)
                            <img src="{{ asset('storage/'.$delivery->avatar) }}" style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid #e2e8f0;" alt="" loading="lazy" />
                        @else
                            <x-admin-avatar :name="$delivery->name ?? 'D'" color="cyan" />
                        @endif
                        <span style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $delivery->name ?? optional($delivery->user)->name ?? '' }}</span>
                    </span>
                </td>
                <td>
                    @php $phone = $delivery->phone ?? optional($delivery->user)->phone ?? ''; @endphp
                    @if($phone)<span style="display:inline-flex;align-items:center;gap:5px;font-size:0.82rem;color:#475569;"><i class="fas fa-phone" style="color:#94a3b8;font-size:0.7rem;"></i>{{ $phone }}</span>@endif
                </td>
                <td style="font-size:0.82rem;color:#475569;">{{ optional($delivery->city)->name_en ?? '—' }}</td>
                <td>
                    @if($delivery->is_online ?? 0)
                        <span style="background:#dcfce7;color:#166534;padding:3px 10px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>Online</span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 10px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>Offline</span>
                    @endif
                </td>
                <td>
                    @if($delivery->status == 1)
                        <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>{{ trans('global.active') ?? 'Active' }}</span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>{{ trans('global.inactive') ?? 'Inactive' }}</span>
                    @endif
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('delivery_show')<x-admin-action-btn href="{{ route('admin.deliveries.show',$delivery->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('delivery_edit')<x-admin-action-btn href="{{ route('admin.deliveries.edit',$delivery->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('delivery_delete')<x-admin-action-btn href="{{ route('admin.deliveries.destroy',$delivery->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
