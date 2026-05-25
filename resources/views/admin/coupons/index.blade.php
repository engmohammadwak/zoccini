@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.coupon.title')"
        icon="fas fa-tag"
        color="green"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.coupon.title')],
        ]"
    />

    {{-- ===== Stats Cards ===== --}}
    @php
        $now      = now();
        $totalC   = $coupons->count();
        $activeC  = $coupons->filter(fn($c) => (!$c->start_date || $c->start_date <= $now) && (!$c->end_date || $c->end_date >= $now))->count();
        $expiredC = $coupons->filter(fn($c) => $c->end_date && $c->end_date < $now)->count();
        $percentC = $coupons->where('type','percent')->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:22px;">

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#22c55e,#4ade80);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-tags"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $totalC }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.coupon.title') }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $activeC }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-calendar-times"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $expiredC }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.expired') ?? 'Expired' }}</div>
            </div>
        </div>

        <div style="background:linear-gradient(135deg,#22c55e,#16a34a);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(34,197,94,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-percent"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $percentC }}</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">{{ trans('global.percent_type') ?? 'Percent Type' }}</div>
            </div>
        </div>

    </div>

    {{-- ===== Table ===== --}}
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
            @php
                $isExpired = $coupon->end_date && $coupon->end_date < $now;
                $isActive  = (!$coupon->start_date || $coupon->start_date <= $now) && (!$coupon->end_date || $coupon->end_date >= $now);
            @endphp
            <tr data-entry-id="{{ $coupon->id }}">
                <td></td>
                <td>
                    <span style="background:linear-gradient(135deg,#dcfce7,#d1fae5);color:#166534;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.8rem;">
                        #{{ $coupon->id }}
                    </span>
                </td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $coupon->name ?? '' }}</td>
                <td>
                    <span style="background:#f8fafc;border:1px solid #e2e8f0;padding:3px 10px;border-radius:7px;font-family:monospace;font-size:0.82rem;font-weight:700;color:#0f172a;letter-spacing:0.5px;">
                        {{ $coupon->code ?? '' }}
                    </span>
                </td>
                <td>
                    <span style="background:#fef9c3;color:#854d0e;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">
                        {{ $coupon->discount ?? '0' }}%
                    </span>
                </td>
                <td>
                    <span style="background:#f1f5f9;color:#475569;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">
                        {{ $coupon->type ?? '' }}
                    </span>
                </td>
                <td style="font-size:0.8rem;color:#64748b;white-space:nowrap;">
                    @if($coupon->start_date)
                        <i class="far fa-calendar-check" style="color:#86efac;margin-left:3px;"></i>
                        {{ \Carbon\Carbon::parse($coupon->start_date)->format('d/m/Y') }}
                    @else
                        <span style="color:#cbd5e1;">—</span>
                    @endif
                </td>
                <td style="font-size:0.8rem;white-space:nowrap;">
                    @if($coupon->end_date)
                        <span style="color:{{ $isExpired ? '#ef4444' : '#64748b' }};">
                            <i class="far fa-calendar-times" style="margin-left:3px;color:{{ $isExpired ? '#fca5a5' : '#fda4af' }};"></i>
                            {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}
                            @if($isExpired)
                                <span style="background:#fee2e2;color:#991b1b;padding:1px 6px;border-radius:5px;font-size:0.7rem;font-weight:600;margin-right:4px;">{{ trans('global.expired') ?? 'Expired' }}</span>
                            @endif
                        </span>
                    @else
                        <span style="background:#dcfce7;color:#166534;padding:2px 8px;border-radius:6px;font-size:0.75rem;font-weight:600;">
                            {{ trans('global.no_expiry') ?? 'No Expiry' }}
                        </span>
                    @endif
                </td>
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
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Coupon:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
