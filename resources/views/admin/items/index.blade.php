@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.item.title')"
        icon="fas fa-utensils"
        color="orange"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.item.title')],
        ]"
    />

    @php
        $totalI   = $items->count();
        $activeI  = $items->where('status',1)->count();
        $inactiveI= $items->where('status',0)->count();
        $avgPrice = $totalI > 0 ? $items->avg('price') : 0;
    @endphp

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f97316,#fb923c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-utensils"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $totalI }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.item.title') }}</div>
            </div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $activeI }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div>
            </div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#94a3b8,#cbd5e1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-eye-slash"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $inactiveI }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.inactive') ?? 'Inactive' }}</div>
            </div>
        </div>
        <div style="background:linear-gradient(135deg,#f97316,#ea580c);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(249,115,22,0.28);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-tag"></i>
            </div>
            <div>
                <div style="font-size:1.1rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($avgPrice,2) }}</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Avg Price</div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <x-admin-table
        :title="trans('cruds.item.title_singular').' '.trans('global.list')"
        icon="fas fa-utensils"
        color="orange"
        datatableClass="datatable-Item"
        :count="$items->count()"
        :createRoute="route('admin.items.create')"
        :createLabel="trans('global.add').' '.trans('cruds.item.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.item.fields.image') ?? 'Image' }}</th>
                <th>{{ trans('cruds.item.fields.name') }}</th>
                <th>{{ trans('cruds.item.fields.name_ar') ?? 'Name AR' }}</th>
                <th>{{ trans('cruds.item.fields.price') ?? 'Price' }}</th>
                <th>{{ trans('cruds.item.fields.category') ?? 'Category' }}</th>
                <th>{{ trans('cruds.item.fields.status') ?? 'Status' }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($items as $item)
            <tr data-entry-id="{{ $item->id }}">
                <td></td>
                <td>
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" alt="" width="44" height="44" loading="lazy" style="border-radius:10px;object-fit:cover;border:2px solid #fed7aa;">
                    @else
                        <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,#f97316,#fb923c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;">
                            <i class="fas fa-utensils"></i>
                        </div>
                    @endif
                </td>
                <td style="font-weight:700;color:#1e293b;font-size:0.85rem;">{{ $item->name ?? $item->name_en ?? '' }}</td>
                <td style="color:#64748b;font-size:0.85rem;">{{ $item->name_ar ?? '' }}</td>
                <td>
                    <span style="font-weight:800;color:#f97316;font-size:0.9rem;">
                        {{ number_format($item->price ?? 0, 2) }}
                    </span>
                </td>
                <td>
                    @if(optional($item->category)->name ?? optional($item->category)->name_en ?? false)
                        <span style="background:#f0fdf4;color:#166534;padding:2px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">
                            {{ optional($item->category)->name ?? optional($item->category)->name_en ?? '' }}
                        </span>
                    @endif
                </td>
                <td>
                    @if(isset($item->status))
                        @if($item->status == 1)
                            <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;">
                                <span style="width:5px;height:5px;border-radius:50%;background:#16a34a;"></span>
                                {{ trans('global.active') ?? 'Active' }}
                            </span>
                        @else
                            <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;">{{ trans('global.inactive') ?? 'Inactive' }}</span>
                        @endif
                    @endif
                </td>
                <td style="display:flex;gap:5px;">
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
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25});
    $('.datatable-Item:not(.ajaxTable)').DataTable({buttons:[]});
});
</script>
@endsection
