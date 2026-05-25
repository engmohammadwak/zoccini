@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.coupon.title')"
        icon="fas fa-ticket-alt"
        color="orange"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.coupon.title')],
        ]"
    />

    @php
        $total    = $coupons->count();
        $active   = $coupons->where('status',1)->count();
        $expired  = $coupons->filter(fn($c)=> $c->expire_date && $c->expire_date < now())->count();
        $usedTotal= $coupons->sum('used_count') ?? 0;
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f97316,#fb923c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-ticket-alt"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.coupon.title') }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-clock"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $expired }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Expired</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#f97316,#ea580c);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(249,115,22,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-chart-bar"></i></div>
            <div><div style="font-size:1.2rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($usedTotal) }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Total Uses</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.coupon.title_singular').' '.trans('global.list')"
        icon="fas fa-ticket-alt"
        color="orange"
        datatableClass="datatable-Coupon"
        :count="$coupons->count()"
        :createRoute="can('coupon_create') ? route('admin.coupons.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.coupon.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.coupon.fields.code') }}</th>
                <th>{{ trans('cruds.coupon.fields.discount') }}</th>
                <th>{{ trans('cruds.coupon.fields.type') ?? 'Type' }}</th>
                <th>{{ trans('cruds.coupon.fields.expire_date') ?? 'Expires' }}</th>
                <th>{{ trans('cruds.coupon.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($coupons as $coupon)
            @php $isExpired = $coupon->expire_date && $coupon->expire_date < now(); @endphp
            <tr data-entry-id="{{ $coupon->id }}">
                <td></td>
                <td>
                    <span style="background:linear-gradient(135deg,#fff7ed,#fed7aa);color:#c2410c;padding:4px 12px;border-radius:8px;font-weight:700;font-size:0.82rem;font-family:monospace;letter-spacing:1px;border:1px dashed #fdba74;">
                        {{ $coupon->code ?? '' }}
                    </span>
                </td>
                <td>
                    <span style="background:#dcfce7;color:#166534;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">
                        {{ $coupon->discount ?? '' }}{{ ($coupon->type ?? '') == 'percentage' ? '%' : '' }}
                    </span>
                </td>
                <td>
                    @php $t = $coupon->type ?? 'fixed'; @endphp
                    <span style="background:{{ $t=='percentage'?'#dbeafe':'#f0fdf4' }};color:{{ $t=='percentage'?'#1e40af':'#166534' }};padding:3px 10px;border-radius:7px;font-size:0.78rem;font-weight:600;">
                        <i class="fas {{ $t=='percentage'?'fa-percent':'fa-tag' }}"></i> {{ ucfirst($t) }}
                    </span>
                </td>
                <td>
                    @if($coupon->expire_date)
                    <span style="font-size:0.82rem;color:{{ $isExpired?'#ef4444':'#475569' }};{{ $isExpired?'font-weight:600;':'' }}">
                        <i class="far fa-calendar-alt" style="margin-left:4px;color:{{ $isExpired?'#f87171':'#cbd5e1' }};"></i>
                        {{ \Carbon\Carbon::parse($coupon->expire_date)->format('d/m/Y') }}
                        @if($isExpired)<span style="background:#fee2e2;color:#991b1b;padding:1px 7px;border-radius:6px;font-size:0.72rem;margin-right:4px;">Expired</span>@endif
                    </span>
                    @else<span style="color:#94a3b8;font-size:0.8rem;">—</span>@endif
                </td>
                <td>
                    @if($coupon->status == 1)
                        <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>{{ trans('global.active') ?? 'Active' }}</span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>{{ trans('global.inactive') ?? 'Inactive' }}</span>
                    @endif
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('coupon_show')<x-admin-action-btn href="{{ route('admin.coupons.show',$coupon->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('coupon_edit')<x-admin-action-btn href="{{ route('admin.coupons.edit',$coupon->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('coupon_delete')<x-admin-action-btn href="{{ route('admin.coupons.destroy',$coupon->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
