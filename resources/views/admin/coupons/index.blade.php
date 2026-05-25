@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#f97316,#ea580c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(249,115,22,.3);">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;line-height:1.2;">{{ trans('cruds.coupon.title') }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <span>{{ trans('cruds.coupon.title') }}</span>
                </nav>
            </div>
        </div>
    </div>

    @php
        $total    = $coupons->count();
        $active   = $coupons->where('status',1)->count();
        $expired  = $coupons->filter(fn($c)=> $c->expire_date && $c->expire_date < now())->count();
        $usedTotal= $coupons->sum('used_count') ?? 0;
    @endphp

    {{-- KPI Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:14px;margin-bottom:24px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#f97316,#fb923c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(249,115,22,.3);"><i class="fas fa-ticket-alt"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('cruds.coupon.title') }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(16,185,129,.3);"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(239,68,68,.3);"><i class="fas fa-clock"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $expired }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.expired') ?? 'Expired' }}</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#f97316,#ea580c);border-radius:14px;padding:18px;box-shadow:0 4px 18px rgba(249,115,22,.35);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;"><i class="fas fa-chart-bar"></i></div>
            <div><div style="font-size:1.25rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($usedTotal) }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,.75);margin-top:3px;font-weight:600;">{{ trans('global.total_uses') ?? 'Total Uses' }}</div></div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(249,115,22,.1);display:flex;align-items:center;justify-content:center;color:#f97316;font-size:15px;"><i class="fas fa-ticket-alt"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.coupon.title') }}</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @can('coupon_create')
            <a href="{{ route('admin.coupons.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(39,186,77,.3);transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                {{ trans('global.add') }} {{ trans('cruds.coupon.title_singular') }}
            </a>
            @endcan
        </div>

        {{-- Table --}}
        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-Coupon" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.coupon.fields.code') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.coupon.fields.discount') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.coupon.fields.type') ?? 'Type' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.coupon.fields.expire_date') ?? 'Expires' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.coupon.fields.status') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($coupons as $coupon)
                @php $isExpired = $coupon->expire_date && $coupon->expire_date < now(); @endphp
                <tr data-entry-id="{{ $coupon->id }}">
                    <td></td>
                    {{-- Code --}}
                    <td>
                        <span style="background:rgba(249,115,22,.1);color:#c2410c;padding:4px 12px;border-radius:8px;font-weight:800;font-size:0.82rem;font-family:monospace;letter-spacing:1.5px;border:1px dashed rgba(249,115,22,.35);">
                            {{ $coupon->code ?? '' }}
                        </span>
                    </td>
                    {{-- Discount --}}
                    <td>
                        <span style="background:rgba(16,185,129,.12);color:#065f46;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">
                            {{ $coupon->discount ?? '' }}{{ ($coupon->type ?? '') == 'percentage' ? '%' : '' }}
                        </span>
                    </td>
                    {{-- Type --}}
                    <td>
                        @php $t = $coupon->type ?? 'fixed'; @endphp
                        <span style="background:{{ $t=='percentage'?'rgba(59,130,246,.1)':'rgba(16,185,129,.1)' }};color:{{ $t=='percentage'?'#1d4ed8':'#065f46' }};padding:3px 10px;border-radius:7px;font-size:0.78rem;font-weight:600;">
                            <i class="fas {{ $t=='percentage'?'fa-percent':'fa-tag' }}"></i> {{ ucfirst($t) }}
                        </span>
                    </td>
                    {{-- Expires --}}
                    <td>
                        @if($coupon->expire_date)
                        <div style="font-size:0.82rem;color:{{ $isExpired?'#ef4444':'var(--z-text-muted)' }};font-weight:{{ $isExpired?'700':'400' }};">
                            <i class="far fa-calendar-alt" style="margin-left:4px;color:{{ $isExpired?'#f87171':'var(--z-text-faint)' }};"></i>
                            {{ \Carbon\Carbon::parse($coupon->expire_date)->format('d/m/Y') }}
                        </div>
                        @if($isExpired)
                        <span style="background:rgba(239,68,68,.12);color:#991b1b;padding:1px 7px;border-radius:6px;font-size:0.7rem;font-weight:700;">{{ trans('global.expired') ?? 'Expired' }}</span>
                        @endif
                        @else<span style="color:var(--z-text-faint);font-size:0.8rem;">—</span>@endif
                    </td>
                    {{-- Status --}}
                    <td>
                        @if($coupon->status == 1)
                        <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>{{ trans('global.active') ?? 'Active' }}
                        </span>
                        @else
                        <span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                        </span>
                        @endif
                    </td>
                    {{-- Actions --}}
                    <td>
                        <div style="display:flex;gap:5px;">
                            @can('coupon_show')
                            <a href="{{ route('admin.coupons.show',$coupon->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('coupon_edit')
                            <a href="{{ route('admin.coupons.edit',$coupon->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('coupon_delete')
                            <form action="{{ route('admin.coupons.destroy',$coupon->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
                                <button type="submit" title="{{ trans('global.delete') }}"
                                   style="width:32px;height:32px;border-radius:8px;background:rgba(239,68,68,.1);color:#dc2626;border:none;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;transition:background .15s;"
                                   onmouseover="this.style.background='rgba(239,68,68,.22)'" onmouseout="this.style.background='rgba(239,68,68,.1)'"><i class="fas fa-trash"></i></button>
                            </form>
                            @endcan
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
    @can('coupon_delete')
    dtButtons.push({
        text:'{{ trans('global.datatables.delete') }}',
        url:"{{ route('admin.coupons.massDestroy') }}",
        className:'btn-danger',
        action:function(e,dt,node,config){
            var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});
            if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}
            if(confirm('{{ trans('global.areYouSure') }}')){
                $.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()});
            }
        }
    });
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Coupon:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
