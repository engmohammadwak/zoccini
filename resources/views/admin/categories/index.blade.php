@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.category.title')"
        icon="fas fa-layer-group"
        color="violet"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.category.title')],
        ]"
    />

    @php
        $total    = $categories->count();
        $active   = $categories->where('status',1)->count();
        $parents  = $categories->whereNull('parent_id')->count();
        $children = $categories->whereNotNull('parent_id')->count();
    @endphp

    {{-- KPI Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:14px;margin-bottom:24px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(124,58,237,.3);"><i class="fas fa-layer-group"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('cruds.category.title') }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(16,185,129,.3);"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(99,102,241,.3);"><i class="fas fa-folder"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $parents }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">Parent</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#7c3aed,#5b21b6);border-radius:14px;padding:18px;box-shadow:0 4px 18px rgba(124,58,237,.35);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;"><i class="fas fa-folder-open"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:#fff;line-height:1;">{{ $children }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,.75);margin-top:3px;font-weight:600;">Sub-categories</div></div>
        </div>
    </div>

    {{-- DataTable Card --}}
    {{-- overflow:visible بدل hidden حتى DataTables dropdowns ما تتقطع --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:visible;">

        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);border-radius:16px 16px 0 0;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(124,58,237,.1);display:flex;align-items:center;justify-content:center;color:#7c3aed;font-size:15px;"><i class="fas fa-layer-group"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.category.title') }}</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @can('category_create')
            <a href="{{ route('admin.categories.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(39,186,77,.3);transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                {{ trans('global.add') }} {{ trans('cruds.category.title_singular') }}
            </a>
            @endcan
        </div>

        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-Category" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.category.fields.name_en') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.category.fields.name_ar') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Parent</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.category.fields.status') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                <tr data-entry-id="{{ $category->id }}">
                    <td></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            @if($category->image)
                                <img src="{{ asset('storage/'.$category->image) }}" style="width:36px;height:36px;border-radius:9px;object-fit:cover;border:1px solid var(--z-border);" alt="" loading="lazy" />
                            @else
                                <div style="width:36px;height:36px;border-radius:9px;background:linear-gradient(135deg,rgba(124,58,237,.12),rgba(167,139,250,.18));display:flex;align-items:center;justify-content:center;color:#7c3aed;font-size:14px;flex-shrink:0;"><i class="fas fa-layer-group"></i></div>
                            @endif
                            <div style="font-weight:700;color:var(--z-text);font-size:0.85rem;">{{ $category->name_en ?? '' }}</div>
                        </div>
                    </td>
                    <td style="font-size:0.83rem;color:var(--z-text-muted);direction:rtl;text-align:right;">{{ $category->name_ar ?? '' }}</td>
                    <td>
                        @if($category->parent_id)
                            <span style="background:rgba(124,58,237,.1);color:#5b21b6;padding:4px 10px;border-radius:8px;font-size:0.78rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;">
                                <i class="fas fa-level-up-alt" style="font-size:0.65rem;"></i>{{ optional($category->parent)->name_en ?? '—' }}
                            </span>
                        @else
                            <span style="background:rgba(148,163,184,.1);color:var(--z-text-muted);padding:4px 10px;border-radius:8px;font-size:0.78rem;font-weight:600;">Root</span>
                        @endif
                    </td>
                    <td>
                        @if($category->status == 1)
                        <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>{{ trans('global.active') ?? 'Active' }}
                        </span>
                        @else
                        <span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                        </span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            @can('category_show')
                            <a href="{{ route('admin.categories.show',$category->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('category_edit')
                            <a href="{{ route('admin.categories.edit',$category->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('category_delete')
                            <form action="{{ route('admin.categories.destroy',$category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
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
    @can('category_delete')
    dtButtons.push({
        text: '{{ trans('global.datatables.delete') }}',
        url:  '{{ route('admin.categories.massDestroy') }}',
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

    $('.datatable-Category:not(.ajaxTable)').DataTable({
        buttons: dtButtons,
        orderCellsTop: true,
        pageLength: 25,
        order: [[1, 'asc']],
        columnDefs: [
            { orderable: false, targets: [0, 5] }
        ]
    });
});
</script>
@endsection
