@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="min-height:100vh;padding:24px;">

    <x-admin-page-header
        title="Car Colors"
        icon="fas fa-palette"
        color="pink"
        :breadcrumbs="[
            ['label'=>trans('global.dashboard'),'url'=>route('admin.home')],
            ['label'=>'Car Colors'],
        ]"
    />

    @php $total = $carColors->count(); @endphp

    {{-- KPI --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:14px;margin-bottom:24px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#ec4899,#f472b6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(236,72,153,.3);"><i class="fas fa-palette"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">Car Colors</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#ec4899,#be185d);border-radius:14px;padding:18px;box-shadow:0 4px 18px rgba(236,72,153,.35);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;"><i class="fas fa-paint-brush"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:#fff;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,.75);margin-top:3px;font-weight:600;">Total</div></div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(236,72,153,.12);display:flex;align-items:center;justify-content:center;color:#ec4899;font-size:15px;"><i class="fas fa-palette"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">Car Colors List</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @can('car_color_create')
            <a href="{{ route('admin.car-colors.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(39,186,77,.3);transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i> {{ trans('global.add') }} Color
            </a>
            @endcan
        </div>
        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-CarColor" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Name EN</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Name AR</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Hex</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($carColors as $color)
                <tr data-entry-id="{{ $color->id }}">
                    <td></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            @if($color->color ?? $color->hex ?? null)
                                <span style="width:28px;height:28px;border-radius:7px;background:{{ $color->color ?? $color->hex }};display:inline-block;border:2px solid var(--z-border);flex-shrink:0;"></span>
                            @else
                                <div style="width:28px;height:28px;border-radius:7px;background:rgba(236,72,153,.15);display:flex;align-items:center;justify-content:center;color:#ec4899;font-size:12px;"><i class="fas fa-palette"></i></div>
                            @endif
                            <span style="font-weight:700;color:var(--z-text);font-size:0.85rem;">{{ $color->name_en ?? $color->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td style="font-size:0.83rem;color:var(--z-text-muted);direction:rtl;">{{ $color->name_ar ?? '—' }}</td>
                    <td>
                        @if($color->color ?? $color->hex ?? null)
                        <span style="display:inline-flex;align-items:center;gap:6px;">
                            <span style="width:16px;height:16px;border-radius:4px;background:{{ $color->color ?? $color->hex }};display:inline-block;border:1px solid rgba(0,0,0,.1);"></span>
                            <span style="font-size:0.78rem;font-family:monospace;color:var(--z-text-muted);">{{ $color->color ?? $color->hex }}</span>
                        </span>
                        @else
                        <span style="color:var(--z-text-faint);">—</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            @can('car_color_show')
                            <a href="{{ route('admin.car-colors.show',$color->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('car_color_edit')
                            <a href="{{ route('admin.car-colors.edit',$color->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('car_color_delete')
                            <form action="{{ route('admin.car-colors.destroy',$color->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
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
<script>$(function(){ $('.datatable-CarColor:not(.ajaxTable)').DataTable({order:[[1,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
