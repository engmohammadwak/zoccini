@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header title="Car Lists" icon="fas fa-car" color="blue"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Car Lists']]" />

    @php
        $total  = $carLists->count();
        $brands = $carLists->groupBy(fn($c)=> optional($c->carbrand ?? $c->brand)->id)->count();
    @endphp

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-car"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Cars</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#475569,#64748b);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-trademark"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $brands }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Brands</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(59,130,246,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-id-card"></i></div>
            <div><div style="font-size:1rem;font-weight:700;color:#fff;">Manage</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.7);margin-top:2px;">Car List</div></div>
        </div>
    </div>

    <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;">
        <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;"><i class="fas fa-car"></i></div>
                <div>
                    <div style="font-weight:700;color:#1e293b;font-size:0.92rem;">Car List</div>
                    <div style="font-size:0.72rem;color:#94a3b8;">{{ $total }} cars</div>
                </div>
            </div>
            @can('car_list_create')
            <a href="{{ route('admin.car-lists.create') }}" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:#fff;padding:8px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 2px 8px rgba(59,130,246,0.3);">
                <i class="fas fa-plus"></i> {{ trans('global.add') }} Car
            </a>
            @endcan
        </div>
        <div style="padding:16px;">
            <table class="table datatable-CarList" style="width:100%;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th width="10"></th>
                        <th>Image</th>
                        <th>Model</th>
                        <th>Brand</th>
                        <th>Color</th>
                        <th>Type</th>
                        <th>Plate</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carLists as $car)
                    <tr data-entry-id="{{ $car->id }}">
                        <td></td>
                        <td>
                            @if($car->image ?? null)
                                <img src="{{ asset('storage/'.$car->image) }}" style="width:52px;height:36px;object-fit:cover;border-radius:7px;" alt="" loading="lazy">
                            @else
                                <div style="width:52px;height:36px;border-radius:7px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#3b82f6;"><i class="fas fa-car"></i></div>
                            @endif
                        </td>
                        <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $car->model ?? $car->name ?? '—' }}</td>
                        <td style="font-size:0.83rem;color:#475569;">{{ optional($car->carbrand ?? $car->brand)->name_en ?? '—' }}</td>
                        <td>
                            @php $clr = $car->carColor ?? $car->color_rel ?? null; @endphp
                            @if(optional($clr)->color ?? null)
                                <span style="display:inline-flex;align-items:center;gap:5px;">
                                    <span style="width:14px;height:14px;border-radius:4px;background:{{ optional($clr)->color }};display:inline-block;border:1px solid rgba(0,0,0,0.1);"></span>
                                    <span style="font-size:0.78rem;color:#475569;">{{ optional($clr)->name_en ?? '' }}</span>
                                </span>
                            @else
                                <span style="font-size:0.82rem;color:#94a3b8;">{{ optional($clr)->name_en ?? '—' }}</span>
                            @endif
                        </td>
                        <td style="font-size:0.82rem;color:#64748b;">{{ optional($car->typeOfCar ?? $car->type)->name_en ?? '—' }}</td>
                        <td><span style="font-family:monospace;font-size:0.82rem;color:#1e293b;font-weight:600;background:#f1f5f9;padding:2px 8px;border-radius:5px;">{{ $car->plate_number ?? $car->plate ?? '—' }}</span></td>
                        <td>
                            <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                @can('car_list_show')<x-admin-action-btn href="{{ route('admin.car-lists.show',$car->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                                @can('car_list_edit')<x-admin-action-btn href="{{ route('admin.car-lists.edit',$car->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                                @can('car_list_delete')<x-admin-action-btn href="{{ route('admin.car-lists.destroy',$car->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
<script>$(function(){ $('.datatable-CarList:not(.ajaxTable)').DataTable({order:[[2,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
