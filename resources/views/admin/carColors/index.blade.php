@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header title="Car Colors" icon="fas fa-palette" color="pink"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Car Colors']]" />

    @php $total = $carColors->count(); @endphp

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ec4899,#f472b6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-palette"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Colors</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#ec4899,#be185d);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(236,72,153,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-paint-brush"></i></div>
            <div><div style="font-size:1rem;font-weight:700;color:#fff;line-height:1;">Manage</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.7);margin-top:2px;">Car Colors</div></div>
        </div>
    </div>

    <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;">
        <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#ec4899,#f472b6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;"><i class="fas fa-palette"></i></div>
                <div>
                    <div style="font-weight:700;color:#1e293b;font-size:0.92rem;">Car Colors List</div>
                    <div style="font-size:0.72rem;color:#94a3b8;">{{ $total }} colors</div>
                </div>
            </div>
            @can('car_color_create')
            <a href="{{ route('admin.car-colors.create') }}" style="background:linear-gradient(135deg,#ec4899,#be185d);color:#fff;padding:8px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 2px 8px rgba(236,72,153,0.3);">
                <i class="fas fa-plus"></i> {{ trans('global.add') }} Color
            </a>
            @endcan
        </div>
        <div style="padding:16px;">
            <table class="table datatable-CarColor" style="width:100%;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th width="10"></th>
                        <th>Name EN</th>
                        <th>Name AR</th>
                        <th>Color</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carColors as $color)
                    <tr data-entry-id="{{ $color->id }}">
                        <td></td>
                        <td>
                            <span style="display:flex;align-items:center;gap:8px;">
                                @if($color->color ?? $color->hex ?? null)
                                    <span style="width:22px;height:22px;border-radius:6px;background:{{ $color->color ?? $color->hex }};display:inline-block;border:2px solid rgba(0,0,0,0.08);flex-shrink:0;"></span>
                                @endif
                                <span style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $color->name_en ?? $color->name ?? '—' }}</span>
                            </span>
                        </td>
                        <td style="font-size:0.83rem;color:#475569;direction:rtl;">{{ $color->name_ar ?? '—' }}</td>
                        <td>
                            @if($color->color ?? $color->hex ?? null)
                            <span style="display:inline-flex;align-items:center;gap:7px;">
                                <span style="width:18px;height:18px;border-radius:4px;background:{{ $color->color ?? $color->hex }};display:inline-block;border:1px solid rgba(0,0,0,0.1);"></span>
                                <span style="font-size:0.78rem;font-family:monospace;color:#475569;">{{ $color->color ?? $color->hex }}</span>
                            </span>
                            @else
                            <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                @can('car_color_show')<x-admin-action-btn href="{{ route('admin.car-colors.show',$color->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                                @can('car_color_edit')<x-admin-action-btn href="{{ route('admin.car-colors.edit',$color->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                                @can('car_color_delete')<x-admin-action-btn href="{{ route('admin.car-colors.destroy',$color->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
<script>$(function(){ $('.datatable-CarColor:not(.ajaxTable)').DataTable({order:[[1,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
