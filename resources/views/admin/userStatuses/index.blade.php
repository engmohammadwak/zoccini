@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    <x-admin-page-header
        title="User Statuses"
        icon="fas fa-user-check"
        color="purple"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => 'User Statuses'],
        ]"
    />

    @php $total = $userStatuses->count(); @endphp

    {{-- KPI --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:16px 18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#9333ea,#c084fc);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-user-check"></i></div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div>
                <div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:2px;">Statuses</div>
            </div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);flex-wrap:wrap;gap:10px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(147,51,234,.1);display:flex;align-items:center;justify-content:center;color:#9333ea;font-size:15px;"><i class="fas fa-user-check"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">User Statuses</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @if(auth()->user()->can('user_status_create'))
            <a href="{{ route('admin.user-statuses.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                {{ trans('global.add') }} Status
            </a>
            @endif
        </div>

        {{-- Table --}}
        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-UserStatus" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Name EN</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Name AR</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($userStatuses as $status)
                <tr data-entry-id="{{ $status->id }}">
                    <td></td>
                    <td style="font-weight:600;color:var(--z-text);font-size:0.85rem;">{{ $status->name_en ?? $status->name ?? '—' }}</td>
                    <td style="font-size:0.83rem;color:var(--z-text-muted);">{{ $status->name_ar ?? '—' }}</td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            @can('user_status_show')
                            <a href="{{ route('admin.user-statuses.show',$status->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('user_status_edit')
                            <a href="{{ route('admin.user-statuses.edit',$status->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('user_status_delete')
                            <form action="{{ route('admin.user-statuses.destroy',$status->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
                                <button type="submit" title="{{ trans('global.delete') }}"
                                   style="width:32px;height:32px;border-radius:8px;background:rgba(239,68,68,.1);color:#dc2626;border:none;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;transition:background .15s;"
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
    $.extend(true, $.fn.dataTable.defaults, { orderCellsTop:true, order:[[1,'asc']], pageLength:25 });
    $('.datatable-UserStatus:not(.ajaxTable)').DataTable({ buttons: $.extend(true,[],$.fn.dataTable.defaults.buttons) });
});
</script>
@endsection
