@extends('layouts.admin')
@section('content')
<div style="padding:24px;min-height:100vh;">

    {{-- Page Header --}}
    <x-admin-page-header
        :title="$title ?? trans('global.messenger') ?? 'Messages'"
        icon="fas fa-comments"
        color="blue"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('global.messenger') ?? 'Messages'],
        ]"
    />

    {{-- KPI Row --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:16px 18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#4f7cff,#7c4fff);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-envelope"></i></div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $topics->count() }}</div>
                <div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:2px;">{{ trans('global.total') ?? 'Total' }}</div>
            </div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:16px 18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-inbox"></i></div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $unreads['inbox'] ?? 0 }}</div>
                <div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:2px;">{{ trans('global.inbox') ?? 'Inbox Unread' }}</div>
            </div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:16px 18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-paper-plane"></i></div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $unreads['outbox'] ?? 0 }}</div>
                <div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:2px;">{{ trans('global.outbox') ?? 'Outbox Unread' }}</div>
            </div>
        </div>
    </div>

    {{-- Nav Tabs --}}
    <div style="display:flex;gap:8px;margin-bottom:18px;flex-wrap:wrap;align-items:center;">
        <a href="{{ route('admin.messenger.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:9px;font-size:0.82rem;font-weight:600;text-decoration:none;
                  background:{{ request()->routeIs('admin.messenger.index') ? 'var(--z-primary)' : 'var(--z-surface-2)' }};
                  color:{{ request()->routeIs('admin.messenger.index') ? '#fff' : 'var(--z-text-muted)' }};">
            <i class="fas fa-list"></i> {{ trans('global.all_messages') ?? 'All' }}
        </a>
        <a href="{{ route('admin.messenger.showInbox') }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:9px;font-size:0.82rem;font-weight:600;text-decoration:none;
                  background:{{ request()->routeIs('admin.messenger.showInbox') ? 'var(--z-primary)' : 'var(--z-surface-2)' }};
                  color:{{ request()->routeIs('admin.messenger.showInbox') ? '#fff' : 'var(--z-text-muted)' }};">
            <i class="fas fa-inbox"></i> {{ trans('global.inbox') ?? 'Inbox' }}
            @if(($unreads['inbox'] ?? 0) > 0)<span style="background:#ef4444;color:#fff;border-radius:999px;padding:1px 7px;font-size:0.7rem;margin-inline-start:4px;">{{ $unreads['inbox'] }}</span>@endif
        </a>
        <a href="{{ route('admin.messenger.showOutbox') }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:9px;font-size:0.82rem;font-weight:600;text-decoration:none;
                  background:{{ request()->routeIs('admin.messenger.showOutbox') ? 'var(--z-primary)' : 'var(--z-surface-2)' }};
                  color:{{ request()->routeIs('admin.messenger.showOutbox') ? '#fff' : 'var(--z-text-muted)' }};">
            <i class="fas fa-paper-plane"></i> {{ trans('global.outbox') ?? 'Outbox' }}
        </a>
        <a href="{{ route('admin.messenger.createTopic') }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:9px;font-size:0.82rem;font-weight:600;text-decoration:none;background:linear-gradient(135deg,#4f7cff,#7c4fff);color:#fff;margin-inline-start:auto;">
            <i class="fas fa-plus"></i> {{ trans('global.newMessage') ?? 'New Message' }}
        </a>
    </div>

    {{-- Table Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);display:flex;align-items:center;gap:10px;">
            <div style="width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,#4f7cff,#7c4fff);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.85rem;"><i class="fas fa-comments"></i></div>
            <div style="font-size:.9rem;font-weight:700;color:var(--z-text);">{{ $title ?? trans('global.messenger') }}</div>
            <span style="background:var(--z-surface-offset);color:var(--z-text-muted);border-radius:999px;padding:2px 9px;font-size:.73rem;font-weight:700;margin-inline-start:2px;">{{ $topics->count() }}</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="table datatable-Messenger" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:.75rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.5px;">{{ trans('global.subject') ?? 'Subject' }}</th>
                        <th style="font-size:.75rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.5px;">{{ trans('global.from') ?? 'From' }}</th>
                        <th style="font-size:.75rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.5px;">{{ trans('global.to') ?? 'To' }}</th>
                        <th style="font-size:.75rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.5px;">{{ trans('global.date') ?? 'Date' }}</th>
                        <th style="font-size:.75rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.5px;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topics as $topic)
                    <tr data-entry-id="{{ $topic->id }}">
                        <td></td>
                        <td style="font-weight:600;color:var(--z-text);font-size:.85rem;">{{ $topic->subject ?? '—' }}</td>
                        <td style="font-size:.83rem;color:var(--z-text-muted);">{{ optional($topic->creator)->name ?? '—' }}</td>
                        <td style="font-size:.83rem;color:var(--z-text-muted);">{{ optional($topic->receiver)->name ?? '—' }}</td>
                        <td style="font-size:.82rem;color:var(--z-text-faint);">{{ $topic->created_at ? $topic->created_at->diffForHumans() : '—' }}</td>
                        <td style="display:flex;gap:5px;">
                            <x-admin-action-btn href="{{ route('admin.messenger.showMessages', $topic->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                            <x-admin-action-btn href="{{ route('admin.messenger.showReply', $topic->id) }}" icon="fas fa-reply" :label="trans('global.reply') ?? 'Reply'" color="orange" />
                            @can('messenger_delete')
                            <x-admin-action-btn href="{{ route('admin.messenger.destroyTopic', $topic->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:48px 20px;color:var(--z-text-faint);">
                            <i class="fas fa-comments" style="font-size:2.5rem;display:block;margin-bottom:12px;opacity:.3;"></i>
                            {{ trans('global.no_data') ?? 'No messages found' }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
@section('scripts')
@parent
<script>
$(document).ready(function(){
    $('.datatable-Messenger').DataTable({
        pageLength: 25,
        order: [[4, 'desc']],
        columnDefs: [{ orderable: false, targets: [0, 5] }]
    });
});
</script>
@stop
