@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.restaurant.title')"
        icon="fas fa-store"
        color="rose"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.restaurant.title')],
        ]"
    />

    @php
        $total    = $restaurants->count();
        $active   = $restaurants->where('status',1)->count();
        $featured = $restaurants->where('is_featured',1)->count();
        $open     = $restaurants->where('is_open',1)->count();
    @endphp

    {{-- KPI Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:14px;margin-bottom:24px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#f43f5e,#fb7185);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(244,63,94,.3);"><i class="fas fa-store"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('cruds.restaurant.title') }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(16,185,129,.3);"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(245,158,11,.3);"><i class="fas fa-star"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $featured }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.featured') ?? 'Featured' }}</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#f43f5e,#e11d48);border-radius:14px;padding:18px;box-shadow:0 4px 18px rgba(244,63,94,.35);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;"><i class="fas fa-door-open"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:#fff;line-height:1;">{{ $open }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,.75);margin-top:3px;font-weight:600;">{{ trans('global.open_now') ?? 'Open Now' }}</div></div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);flex-wrap:wrap;gap:10px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(244,63,94,.1);display:flex;align-items:center;justify-content:center;color:#f43f5e;font-size:15px;"><i class="fas fa-store"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.restaurant.title') }}</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @can('restaurant_create')
            <a href="{{ route('admin.restaurants.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(39,186,77,.3);transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                {{ trans('global.add') }} {{ trans('cruds.restaurant.title_singular') }}
            </a>
            @endcan
        </div>

        {{-- Table --}}
        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-Restaurant" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.restaurant.fields.name_en') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.restaurant.fields.name_ar') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.restaurant.fields.city') ?? 'City' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.restaurant.fields.rating') ?? 'Rating' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.restaurant.fields.status') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($restaurants as $restaurant)
                <tr data-entry-id="{{ $restaurant->id }}">
                    <td></td>
                    {{-- Name EN + logo --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            @if($restaurant->logo)
                                <img src="{{ asset('storage/'.$restaurant->logo) }}" style="width:38px;height:38px;border-radius:10px;object-fit:cover;border:1px solid var(--z-border);" alt="" loading="lazy" />
                            @else
                                <div style="width:38px;height:38px;border-radius:10px;background:rgba(244,63,94,.1);display:flex;align-items:center;justify-content:center;color:#f43f5e;font-size:15px;flex-shrink:0;"><i class="fas fa-store"></i></div>
                            @endif
                            <div>
                                <div style="font-weight:700;color:var(--z-text);font-size:0.85rem;">{{ $restaurant->name_en ?? '' }}</div>
                                @if($restaurant->is_featured)
                                <span style="background:rgba(245,158,11,.12);color:#b45309;padding:1px 7px;border-radius:5px;font-size:0.68rem;font-weight:700;"><i class="fas fa-star" style="font-size:0.6rem;margin-right:2px;"></i>Featured</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    {{-- Name AR --}}
                    <td style="font-size:0.83rem;color:var(--z-text-muted);">{{ $restaurant->name_ar ?? '' }}</td>
                    {{-- City --}}
                    <td>
                        <span style="font-size:0.82rem;color:var(--z-text-muted);display:inline-flex;align-items:center;gap:5px;">
                            <i class="fas fa-map-marker-alt" style="color:#f43f5e;font-size:0.7rem;"></i>
                            {{ optional($restaurant->city)->name_en ?? '—' }}
                        </span>
                    </td>
                    {{-- Rating --}}
                    <td>
                        @if($restaurant->rating)
                        <span style="display:inline-flex;align-items:center;gap:4px;">
                            <i class="fas fa-star" style="color:#f59e0b;font-size:0.75rem;"></i>
                            <span style="font-weight:700;color:var(--z-text);font-size:0.83rem;">{{ number_format($restaurant->rating,1) }}</span>
                        </span>
                        @else<span style="color:var(--z-text-faint);font-size:0.8rem;">—</span>@endif
                    </td>
                    {{-- Status --}}
                    <td>
                        @if($restaurant->status == 1)
                        <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>{{ trans('global.active') ?? 'Active' }}
                        </span>
                        @else
                        <span style="background:rgba(148,163,184,.12);color:var(--z-text-muted);padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                        </span>
                        @endif
                    </td>
                    {{-- Actions --}}
                    <td>
                        <div style="display:flex;gap:5px;flex-wrap:nowrap;">
                            @can('restaurant_show')
                            <a href="{{ route('admin.restaurants.show',$restaurant->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('restaurant_edit')
                            <a href="{{ route('admin.restaurants.edit',$restaurant->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('restaurant_delete')
                            <form action="{{ route('admin.restaurants.destroy',$restaurant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
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
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
    @can('restaurant_delete')
    dtButtons.push({
        text: '{{ trans('global.datatables.delete') }}',
        url:  '{{ route('admin.restaurants.massDestroy') }}',
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
    $('.datatable-Restaurant:not(.ajaxTable)').DataTable({ buttons: dtButtons });
});
</script>
@endsection
