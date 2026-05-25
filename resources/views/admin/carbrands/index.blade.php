@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header title="Car Brands" icon="fas fa-trademark" color="gray"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Car Brands']]" />

    @php
        $total = $carbrands->count();
    @endphp

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#475569,#64748b);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-trademark"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Brands</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#475569,#334155);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(71,85,105,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-car"></i></div>
            <div><div style="font-size:1rem;font-weight:700;color:#fff;line-height:1;">Manage</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.7);margin-top:2px;">Car Brands</div></div>
        </div>
    </div>

    <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;">
        <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#475569,#64748b);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;"><i class="fas fa-trademark"></i></div>
                <div>
                    <div style="font-weight:700;color:#1e293b;font-size:0.92rem;">Car Brands List</div>
                    <div style="font-size:0.72rem;color:#94a3b8;">{{ $total }} brands</div>
                </div>
            </div>
            @can('carbrand_create')
            <a href="{{ route('admin.carbrands.create') }}" style="background:linear-gradient(135deg,#475569,#334155);color:#fff;padding:8px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 2px 8px rgba(71,85,105,0.3);">
                <i class="fas fa-plus"></i> {{ trans('global.add') }} Brand
            </a>
            @endcan
        </div>
        <div style="padding:16px;">
            <table class="table datatable-Carbrand" style="width:100%;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th width="10"></th>
                        <th>Logo</th>
                        <th>Name EN</th>
                        <th>Name AR</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carbrands as $brand)
                    <tr data-entry-id="{{ $brand->id }}">
                        <td></td>
                        <td>
                            @if($brand->logo ?? $brand->image ?? null)
                                <img src="{{ asset('storage/'.($brand->logo ?? $brand->image)) }}" style="width:44px;height:34px;object-fit:contain;border-radius:7px;border:1px solid #f1f5f9;background:#fafafa;" alt="" loading="lazy">
                            @else
                                <div style="width:44px;height:34px;border-radius:7px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:#94a3b8;"><i class="fas fa-car"></i></div>
                            @endif
                        </td>
                        <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $brand->name_en ?? $brand->name ?? '—' }}</td>
                        <td style="font-size:0.83rem;color:#475569;direction:rtl;">{{ $brand->name_ar ?? '—' }}</td>
                        <td>
                            <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                @can('carbrand_show')<x-admin-action-btn href="{{ route('admin.carbrands.show',$brand->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                                @can('carbrand_edit')<x-admin-action-btn href="{{ route('admin.carbrands.edit',$brand->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                                @can('carbrand_delete')<x-admin-action-btn href="{{ route('admin.carbrands.destroy',$brand->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
<script>$(function(){ $('.datatable-Carbrand:not(.ajaxTable)').DataTable({order:[[2,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
