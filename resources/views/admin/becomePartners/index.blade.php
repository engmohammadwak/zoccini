@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="min-height:100vh;padding:24px;">

    <x-admin-page-header
        title="Become Partners"
        icon="fas fa-handshake"
        color="teal"
        :breadcrumbs="[
            ['label'=>trans('global.dashboard'),'url'=>route('admin.home')],
            ['label'=>'Become Partners'],
        ]"
    />

    @php
        $total    = $becomePartners->count();
        $pending  = $becomePartners->where('status','pending')->count();
        $approved = $becomePartners->where('status','approved')->count();
        $rejected = $becomePartners->where('status','rejected')->count();
    @endphp

    {{-- KPI --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(165px,1fr));gap:14px;margin-bottom:24px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(13,148,136,.3);"><i class="fas fa-handshake"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">Total</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(245,158,11,.3);"><i class="fas fa-clock"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $pending }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">Pending</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#22c55e,#16a34a);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(34,197,94,.3);"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $approved }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">Approved</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#0d9488,#0f766e);border-radius:14px;padding:18px;box-shadow:0 4px 18px rgba(13,148,136,.35);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;"><i class="fas fa-times-circle"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:#fff;line-height:1;">{{ $rejected }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,.75);margin-top:3px;font-weight:600;">Rejected</div></div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(13,148,136,.12);display:flex;align-items:center;justify-content:center;color:#0d9488;font-size:15px;"><i class="fas fa-handshake"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">Partners Requests</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
        </div>
        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-BecomePartner" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Name</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Phone</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Restaurant</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Status</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Date</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($becomePartners as $partner)
                @php
                    $st = $partner->status ?? 'pending';
                    $statusMap = [
                        'pending'  => ['bg'=>'rgba(245,158,11,.12)','color'=>'#b45309','dot'=>'#f59e0b','label'=>'Pending'],
                        'approved' => ['bg'=>'rgba(34,197,94,.12)', 'color'=>'#15803d','dot'=>'#22c55e','label'=>'Approved'],
                        'rejected' => ['bg'=>'rgba(239,68,68,.12)', 'color'=>'#dc2626','dot'=>'#ef4444','label'=>'Rejected'],
                    ];
                    $sm = $statusMap[$st] ?? ['bg'=>'rgba(148,163,184,.12)','color'=>'#64748b','dot'=>'#94a3b8','label'=>ucfirst($st)];
                @endphp
                <tr data-entry-id="{{ $partner->id }}">
                    <td></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.8rem;font-weight:700;flex-shrink:0;">
                                {{ strtoupper(substr($partner->name ?? $partner->owner_name ?? 'P', 0, 1)) }}
                            </div>
                            <span style="font-weight:700;color:var(--z-text);font-size:0.85rem;">{{ $partner->name ?? $partner->owner_name ?? '—' }}</span>
                        </div>
                    </td>
                    <td>
                        @if($partner->phone)
                        <span style="font-size:0.82rem;color:var(--z-text-muted);display:inline-flex;align-items:center;gap:5px;">
                            <i class="fas fa-phone" style="font-size:0.7rem;color:#0d9488;"></i>{{ $partner->phone }}
                        </span>
                        @else
                        <span style="color:var(--z-text-faint);">—</span>
                        @endif
                    </td>
                    <td>
                        @if($partner->restaurant_name)
                        <span style="background:rgba(13,148,136,.08);color:#0f766e;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;">
                            <i class="fas fa-store" style="font-size:0.65rem;"></i>{{ $partner->restaurant_name }}
                        </span>
                        @else
                        <span style="color:var(--z-text-faint);">—</span>
                        @endif
                    </td>
                    <td>
                        <span style="background:{{ $sm['bg'] }};color:{{ $sm['color'] }};padding:4px 10px;border-radius:8px;font-weight:700;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:{{ $sm['dot'] }};display:inline-block;"></span>
                            {{ $sm['label'] }}
                        </span>
                    </td>
                    <td style="font-size:0.8rem;color:var(--z-text-faint);">{{ optional($partner->created_at)->format('d/m/Y') }}</td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            @can('become_partner_show')
                            <a href="{{ route('admin.become-partners.show',$partner->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('become_partner_delete')
                            <form action="{{ route('admin.become-partners.destroy',$partner->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
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
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25}); $('.datatable-BecomePartner:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
