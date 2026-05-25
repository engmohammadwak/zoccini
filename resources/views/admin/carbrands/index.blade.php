@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="min-height:100vh;padding:24px;">

    <x-admin-page-header
        title="Car Brands"
        icon="fas fa-trademark"
        color="gray"
        :breadcrumbs="[
            ['label'=>trans('global.dashboard'),'url'=>route('admin.home')],
            ['label'=>'Car Brands'],
        ]"
    />

    @php $total = $carbrands->count(); @endphp

    {{-- KPI --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:14px;margin-bottom:24px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#475569,#64748b);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(71,85,105,.3);"><i class="fas fa-trademark"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">Car Brands</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#475569,#334155);border-radius:14px;padding:18px;box-shadow:0 4px 18px rgba(71,85,105,.35);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;"><i class="fas fa-car"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:#fff;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,.75);margin-top:3px;font-weight:600;">Total</div></div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(71,85,105,.12);display:flex;align-items:center;justify-content:center;color:#475569;font-size:15px;"><i class="fas fa-trademark"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">Car Brands List</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @can('carbrand_create')
            <a href="{{ route('admin.carbrands.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(39,186,77,.3);transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i> {{ trans('global.add') }} Brand
            </a>
            @endcan
        </div>
        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-Carbrand" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Name EN</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Name AR</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($carbrands as $brand)
                <tr data-entry-id="{{ $brand->id }}">
                    <td></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            @if($brand->logo ?? $brand->image ?? null)
                                <img src="{{ asset('storage/'.($brand->logo ?? $brand->image)) }}" style="width:44px;height:32px;object-fit:contain;border-radius:8px;border:1px solid var(--z-border);background:var(--z-surface-2);" alt="" loading="lazy">
                            @else
                                <div style="width:44px;height:32px;border-radius:8px;background:rgba(71,85,105,.1);display:flex;align-items:center;justify-content:center;color:#64748b;font-size:14px;"><i class="fas fa-car"></i></div>
                            @endif
                            <span style="font-weight:700;color:var(--z-text);font-size:0.85rem;">{{ $brand->name_en ?? $brand->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td style="font-size:0.83rem;color:var(--z-text-muted);direction:rtl;">{{ $brand->name_ar ?? '—' }}</td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            @can('carbrand_show')
                            <a href="{{ route('admin.carbrands.show',$brand->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('carbrand_edit')
                            <a href="{{ route('admin.carbrands.edit',$brand->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('carbrand_delete')
                            <form action="{{ route('admin.carbrands.destroy',$brand->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
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
<script>$(function(){ $('.datatable-Carbrand:not(.ajaxTable)').DataTable({order:[[1,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
