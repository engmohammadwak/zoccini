@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.item.title')"
        icon="fas fa-hamburger"
        color="amber"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.item.title')],
        ]"
    />

    @php
        $total    = $items->count();
        $active   = $items->where('status',1)->count();
        $featured = $items->where('is_featured',1)->count();
        $avgPrice = $items->avg('price') ?? 0;
    @endphp

    {{-- KPI Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:14px;margin-bottom:24px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#d97706,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(217,119,6,.3);"><i class="fas fa-hamburger"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('cruds.item.title') }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(16,185,129,.3);"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#f59e0b,#fcd34d);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(245,158,11,.3);"><i class="fas fa-star"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $featured }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">Featured</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#d97706,#b45309);border-radius:14px;padding:18px;box-shadow:0 4px 18px rgba(217,119,6,.35);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;"><i class="fas fa-tags"></i></div>
            <div><div style="font-size:1.15rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($avgPrice,2) }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,.75);margin-top:3px;font-weight:600;">Avg Price</div></div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">

        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(217,119,6,.1);display:flex;align-items:center;justify-content:center;color:#d97706;font-size:15px;"><i class="fas fa-hamburger"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.item.title') }}</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @can('item_create')
            <a href="{{ route('admin.items.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(39,186,77,.3);transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                {{ trans('global.add') }} {{ trans('cruds.item.title_singular') }}
            </a>
            @endcan
        </div>

        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-Item" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.item.fields.name_en') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.item.fields.restaurant') ?? 'Restaurant' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.item.fields.category') ?? 'Category' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.item.fields.price') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.item.fields.status') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                <tr data-entry-id="{{ $item->id }}">
                    <td></td>
                    {{-- Name + Image --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" style="width:40px;height:40px;border-radius:10px;object-fit:cover;border:1px solid var(--z-border);" alt="" loading="lazy" />
                            @else
                                <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,rgba(217,119,6,.12),rgba(251,191,36,.18));display:flex;align-items:center;justify-content:center;color:#d97706;font-size:16px;flex-shrink:0;"><i class="fas fa-hamburger"></i></div>
                            @endif
                            <div>
                                <div style="font-weight:700;color:var(--z-text);font-size:0.85rem;">{{ $item->name_en ?? '' }}</div>
                                <div style="font-size:0.75rem;color:var(--z-text-faint);">{{ $item->name_ar ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    {{-- Restaurant --}}
                    <td>
                        @php $rest = optional($item->restaurant); @endphp
                        @if($rest->name_en)
                        <div style="display:flex;align-items:center;gap:7px;">
                            @if($rest->logo)
                            <img src="{{ asset('storage/'.$rest->logo) }}" style="width:26px;height:26px;border-radius:7px;object-fit:cover;border:1px solid var(--z-border);" alt="" loading="lazy">
                            @endif
                            <span style="font-size:0.82rem;color:var(--z-text-muted);font-weight:600;">{{ $rest->name_en }}</span>
                        </div>
                        @else<span style="color:var(--z-text-faint);">—</span>@endif
                    </td>
                    {{-- Category --}}
                    <td>
                        @if($item->category)
                        <span style="background:rgba(124,58,237,.1);color:#5b21b6;padding:4px 10px;border-radius:8px;font-size:0.78rem;font-weight:600;">{{ optional($item->category)->name_en ?? '—' }}</span>
                        @else<span style="color:var(--z-text-faint);">—</span>@endif
                    </td>
                    {{-- Price --}}
                    <td>
                        <span style="background:rgba(217,119,6,.1);color:#92400e;padding:4px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;font-variant-numeric:tabular-nums;">
                            {{ number_format($item->price ?? 0,2) }}
                        </span>
                    </td>
                    {{-- Status --}}
                    <td>
                        @if($item->status == 1)
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
                            @can('item_show')
                            <a href="{{ route('admin.items.show',$item->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('item_edit')
                            <a href="{{ route('admin.items.edit',$item->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('item_delete')
                            <form action="{{ route('admin.items.destroy',$item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
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
    @can('item_delete')
    dtButtons.push({
        text: '{{ trans('global.datatables.delete') }}',
        url:  '{{ route('admin.items.massDestroy') }}',
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
    $('.datatable-Item:not(.ajaxTable)').DataTable({ buttons: dtButtons });
});
</script>
@endsection
