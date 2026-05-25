@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.category.title')"
        icon="fas fa-th-large"
        color="teal"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.category.title')],
        ]"
    />

    @php
        $totalCat   = $categories->count();
        $activeCat  = $categories->where('status',1)->count();
        $inactiveCat= $categories->where('status',0)->count();
    @endphp

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-th-large"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $totalCat }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.category.title') }}</div>
            </div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $activeCat }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div>
            </div>
        </div>
        <div style="background:linear-gradient(135deg,#0d9488,#0f766e);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(13,148,136,0.28);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-ban"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $inactiveCat }}</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">{{ trans('global.inactive') ?? 'Inactive' }}</div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <x-admin-table
        :title="trans('cruds.category.title_singular').' '.trans('global.list')"
        icon="fas fa-th-large"
        color="teal"
        datatableClass="datatable-Category"
        :count="$categories->count()"
        :createRoute="route('admin.categories.create')"
        :createLabel="trans('global.add').' '.trans('cruds.category.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.category.fields.name') }}</th>
                <th>{{ trans('cruds.category.fields.name_ar') ?? 'Name AR' }}</th>
                <th>{{ trans('cruds.category.fields.image') ?? 'Image' }}</th>
                <th>{{ trans('cruds.category.fields.status') ?? 'Status' }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($categories as $cat)
            <tr data-entry-id="{{ $cat->id }}">
                <td></td>
                <td style="font-weight:700;color:#1e293b;font-size:0.85rem;">{{ $cat->name ?? $cat->name_en ?? '' }}</td>
                <td style="color:#64748b;font-size:0.85rem;">{{ $cat->name_ar ?? '' }}</td>
                <td>
                    @if($cat->image)
                        <img src="{{ asset('storage/'.$cat->image) }}" alt="" width="40" height="40" loading="lazy" style="border-radius:10px;object-fit:cover;border:2px solid #e2e8f0;">
                    @else
                        <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;">
                            <i class="fas fa-th-large"></i>
                        </div>
                    @endif
                </td>
                <td>
                    @if(isset($cat->status))
                        @if($cat->status == 1)
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
                    @can('category_show')<x-admin-action-btn href="{{ route('admin.categories.show',$cat->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('category_edit')<x-admin-action-btn href="{{ route('admin.categories.edit',$cat->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('category_delete')<x-admin-action-btn href="{{ route('admin.categories.destroy',$cat->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    $('.datatable-Category:not(.ajaxTable)').DataTable({buttons:[]});
});
</script>
@endsection
