@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="min-height:100vh;padding:24px;">

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
        $total  = $deliveries->count();
        $active = $deliveries->where('status',1)->count();
        $online = $deliveries->where('is_online',1)->count();
        $busy   = $deliveries->where('is_busy',1)->count();
    @endphp

    {{-- KPI Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:14px;margin-bottom:24px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#06b6d4,#22d3ee);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(6,182,212,.3);"><i class="fas fa-motorcycle"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('cruds.delivery.title') }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(16,185,129,.3);"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(59,130,246,.3);"><i class="fas fa-signal"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $online }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">Online</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#06b6d4,#0891b2);border-radius:14px;padding:18px;box-shadow:0 4px 18px rgba(6,182,212,.35);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;"><i class="fas fa-hourglass-half"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:#fff;line-height:1;">{{ $busy }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,.75);margin-top:3px;font-weight:600;">Busy</div></div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">

        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(6,182,212,.1);display:flex;align-items:center;justify-content:center;color:#06b6d4;font-size:15px;"><i class="fas fa-motorcycle"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.delivery.title') }}</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @can('delivery_create')
            <a href="{{ route('admin.deliveries.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(39,186,77,.3);transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                {{ trans('global.add') }} {{ trans('cruds.delivery.title_singular') }}
            </a>
            @endcan
        </div>

        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-Delivery" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.delivery.fields.name') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.delivery.fields.phone') ?? 'Phone' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.delivery.fields.city') ?? 'City' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Online</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.delivery.fields.status') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($deliveries as $delivery)
                <tr data-entry-id="{{ $delivery->id }}">
                    <td></td>
                    {{-- Name + Avatar --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            @if($delivery->avatar)
                                <img src="{{ asset('storage/'.$delivery->avatar) }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:1px solid var(--z-border);" alt="" loading="lazy" />
                            @else
                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#06b6d4,#0891b2);display:flex;align-items:center;justify-content:center;font-size:0.82rem;font-weight:800;color:#fff;flex-shrink:0;">{{ strtoupper(substr($delivery->name ?? optional($delivery->user)->name ?? 'D',0,1)) }}</div>
                            @endif
                            <div style="font-weight:700;color:var(--z-text);font-size:0.85rem;">{{ $delivery->name ?? optional($delivery->user)->name ?? '' }}</div>
                        </div>
                    </td>
                    {{-- Phone --}}
                    <td>
                        @php $phone = $delivery->phone ?? optional($delivery->user)->phone ?? ''; @endphp
                        @if($phone)
                        <span style="display:inline-flex;align-items:center;gap:5px;font-size:0.82rem;color:var(--z-text-muted);">
                            <i class="fas fa-phone" style="color:var(--z-primary);font-size:0.7rem;"></i>{{ $phone }}
                        </span>
                        @else<span style="color:var(--z-text-faint);">—</span>@endif
                    </td>
                    {{-- City --}}
                    <td style="font-size:0.82rem;color:var(--z-text-muted);">{{ optional($delivery->city)->name_en ?? '—' }}</td>
                    {{-- Online --}}
                    <td>
                        @if($delivery->is_online ?? 0)
                        <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>Online
                        </span>
                        @else
                        <span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span>Offline
                        </span>
                        @endif
                    </td>
                    {{-- Status --}}
                    <td>
                        @if($delivery->status == 1)
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
                            @can('delivery_show')
                            <a href="{{ route('admin.deliveries.show',$delivery->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('delivery_edit')
                            <a href="{{ route('admin.deliveries.edit',$delivery->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('delivery_delete')
                            <form action="{{ route('admin.deliveries.destroy',$delivery->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
                                <button type="submit" title="{{ trans('global.delete') }}"
                                   style="width:32px;height:32px;border-radius:8px;background:rgba(239,68,68,.1);color:#dc2626;border:none;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;"
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
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
    @can('delivery_delete')
    dtButtons.push({
        text: '{{ trans('global.datatables.delete') }}',
        url:  '{{ route('admin.deliveries.massDestroy') }}',
        className: 'btn-danger',
        action: function(e,dt,node,config){
            var ids = $.map(dt.rows({selected:true}).nodes(), function(entry){ return $(entry).data('entry-id'); });
            if(ids.length===0){ alert('{{ trans('global.datatables.zero_selected') }}'); return; }
            if(confirm('{{ trans('global.areYouSure') }}')){
                $.ajax({ headers:{'x-csrf-token':_token}, method:'POST', url:config.url, data:{ids:ids,_method:'DELETE'} }).done(function(){ location.reload(); });
            }
        }
    });
    @endcan
    $.extend(true, $.fn.dataTable.defaults, { orderCellsTop:true, order:[[1,'asc']], pageLength:25 });
    $('.datatable-Delivery:not(.ajaxTable)').DataTable({ buttons: dtButtons });
});
</script>
@endsection
