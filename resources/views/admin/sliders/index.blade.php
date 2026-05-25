@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.slider.title')"
        icon="fas fa-images"
        color="pink"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.slider.title')],
        ]"
    />

    @php
        $total  = $sliders->count();
        $active = $sliders->where('status',1)->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ec4899,#f472b6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-images"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Total</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#ec4899,#be185d);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(236,72,153,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-eye"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Active</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.slider.title')"
        icon="fas fa-images"
        color="pink"
        datatableClass="datatable-Slider"
        :count="$sliders->count()"
        :createRoute="can('slider_create') ? route('admin.sliders.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.slider.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>Image</th>
                <th>Title</th>
                <th>Link</th>
                <th>Order</th>
                <th>{{ trans('cruds.slider.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($sliders as $slider)
            <tr data-entry-id="{{ $slider->id }}">
                <td></td>
                <td>
                    @if($slider->image)
                        <img src="{{ asset('storage/'.$slider->image) }}" style="width:72px;height:42px;border-radius:8px;object-fit:cover;border:2px solid #f1f5f9;" alt="" loading="lazy" />
                    @else
                        <div style="width:72px;height:42px;border-radius:8px;background:linear-gradient(135deg,#fce7f3,#fbcfe8);display:flex;align-items:center;justify-content:center;color:#ec4899;font-size:18px;"><i class="fas fa-image"></i></div>
                    @endif
                </td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $slider->title_en ?? $slider->title ?? '—' }}</td>
                <td>
                    @if($slider->link ?? $slider->url ?? null)
                    <a href="{{ $slider->link ?? $slider->url }}" target="_blank" style="color:#3b82f6;font-size:0.82rem;"><i class="fas fa-external-link-alt"></i> Link</a>
                    @else<span style="color:#cbd5e1;font-size:0.8rem;">—</span>@endif
                </td>
                <td><span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:7px;font-weight:700;font-size:0.83rem;">{{ $slider->order ?? $slider->sort ?? '—' }}</span></td>
                <td>
                    @if($slider->status == 1)
                        <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>Active</span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>Inactive</span>
                    @endif
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('slider_show')<x-admin-action-btn href="{{ route('admin.sliders.show',$slider->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('slider_edit')<x-admin-action-btn href="{{ route('admin.sliders.edit',$slider->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('slider_delete')<x-admin-action-btn href="{{ route('admin.sliders.destroy',$slider->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Slider:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)});
});
</script>
@endsection
