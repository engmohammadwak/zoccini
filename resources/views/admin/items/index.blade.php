@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

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
        $total      = $items->count();
        $active     = $items->where('status',1)->count();
        $featured   = $items->where('is_featured',1)->count();
        $avgPrice   = $items->avg('price') ?? 0;
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#d97706,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-hamburger"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.item.title') }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fcd34d);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-star"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $featured }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Featured</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#d97706,#b45309);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(217,119,6,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-tags"></i></div>
            <div><div style="font-size:1rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($avgPrice,2) }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Avg Price</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.item.title_singular').' '.trans('global.list')"
        icon="fas fa-hamburger"
        color="amber"
        datatableClass="datatable-Item"
        :count="$items->count()"
        :createRoute="can('item_create') ? route('admin.items.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.item.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.item.fields.name_en') }}</th>
                <th>{{ trans('cruds.item.fields.restaurant') ?? 'Restaurant' }}</th>
                <th>{{ trans('cruds.item.fields.category') ?? 'Category' }}</th>
                <th>{{ trans('cruds.item.fields.price') }}</th>
                <th>{{ trans('cruds.item.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($items as $item)
            <tr data-entry-id="{{ $item->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:9px;">
                        @if($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" style="width:38px;height:38px;border-radius:10px;object-fit:cover;" alt="" loading="lazy" />
                        @else
                            <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,#fef3c7,#fde68a);display:flex;align-items:center;justify-content:center;color:#d97706;font-size:16px;"><i class="fas fa-hamburger"></i></div>
                        @endif
                        <div>
                            <div style="font-weight:700;color:#1e293b;font-size:0.85rem;">{{ $item->name_en ?? '' }}</div>
                            <div style="font-size:0.75rem;color:#94a3b8;">{{ $item->name_ar ?? '' }}</div>
                        </div>
                    </span>
                </td>
                <td style="font-size:0.82rem;color:#475569;">{{ optional($item->restaurant)->name_en ?? '—' }}</td>
                <td>
                    @if($item->category)
                    <span style="background:#ede9fe;color:#5b21b6;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">{{ optional($item->category)->name_en ?? '—' }}</span>
                    @endif
                </td>
                <td>
                    <span style="background:#fef3c7;color:#92400e;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">
                        {{ number_format($item->price ?? 0,2) }}
                    </span>
                </td>
                <td>
                    @if($item->status == 1)
                        <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>{{ trans('global.active') ?? 'Active' }}</span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>{{ trans('global.inactive') ?? 'Inactive' }}</span>
                    @endif
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('item_show')<x-admin-action-btn href="{{ route('admin.items.show',$item->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('item_edit')<x-admin-action-btn href="{{ route('admin.items.edit',$item->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('item_delete')<x-admin-action-btn href="{{ route('admin.items.destroy',$item->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    @can('item_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.items.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Item:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
