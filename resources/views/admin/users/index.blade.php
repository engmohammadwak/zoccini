@extends('layouts.admin')
@section('content')

<style>
/* ── Users Page ── */
.users-page-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px; margin-bottom: 24px;
}
.users-page-title {
    font-size: 1.35rem; font-weight: 700; color: #1a1f2e;
    display: flex; align-items: center; gap: 10px;
}
.users-page-title .title-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1rem;
    box-shadow: 0 4px 12px rgba(124,58,237,0.35);
}
.users-add-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px;
    background: linear-gradient(135deg, #7c3aed, #a855f7);
    color: #fff !important; border-radius: 9px;
    font-size: 0.85rem; font-weight: 600; text-decoration: none;
    box-shadow: 0 3px 10px rgba(124,58,237,0.3);
    transition: opacity 0.2s, transform 0.15s; border: none;
}
.users-add-btn:hover { opacity: 0.88; transform: translateY(-1px); color: #fff !important; text-decoration: none; }

.users-card {
    background: #fff; border-radius: 14px;
    border: 1px solid #e8ecf4;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06); overflow: hidden;
}
.users-card-header {
    background: linear-gradient(135deg, #faf8ff 0%, #f3eeff 100%);
    border-bottom: 1px solid #e5d9ff;
    padding: 16px 20px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 12px; flex-wrap: wrap;
}
.users-card-header-title {
    font-size: 0.92rem; font-weight: 700; color: #1a1f2e;
    display: flex; align-items: center; gap: 8px;
}
.users-card-header-title i { color: #7c3aed; }
.users-card-body { padding: 20px; }

/* Table */
.users-table-wrap { overflow-x: auto; border-radius: 10px; border: 1px solid #eef0f8; }
.users-table { width: 100%; border-collapse: collapse; font-size: 0.84rem; }
.users-table thead tr:first-child th {
    background: #faf8ff; color: #4a3070;
    font-weight: 700; font-size: 0.78rem;
    text-transform: uppercase; letter-spacing: 0.5px;
    padding: 12px 14px; border-bottom: 2px solid #e5d9ff; white-space: nowrap;
}
.users-table thead tr:nth-child(2) td {
    background: #fdfaff; padding: 8px 10px; border-bottom: 1px solid #e5d9ff;
}
.users-table thead tr:nth-child(2) input,
.users-table thead tr:nth-child(2) select {
    width: 100%; border: 1px solid #d8c8f8; border-radius: 7px;
    padding: 5px 8px; font-size: 0.78rem; color: #4a3070;
    background: #fff; outline: none; transition: border-color 0.2s;
}
.users-table thead tr:nth-child(2) input:focus,
.users-table thead tr:nth-child(2) select:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
}
.users-table tbody tr { border-bottom: 1px solid #f3f0fa; transition: background 0.15s; }
.users-table tbody tr:last-child { border-bottom: none; }
.users-table tbody tr:hover { background: #faf8ff; }
.users-table tbody td { padding: 12px 14px; color: #2d3250; vertical-align: middle; }

/* User cell */
.user-cell { display: flex; align-items: center; gap: 10px; }
.user-avatar-circle {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 0.78rem; font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
.user-full-name { font-weight: 600; color: #1a1f2e; font-size: 0.85rem; line-height: 1.3; }

/* ID badge */
.user-id-badge {
    display: inline-flex; align-items: center; justify-content: center;
    background: #f0e8ff; color: #7c3aed;
    font-weight: 700; font-size: 0.8rem;
    border-radius: 7px; padding: 3px 10px; min-width: 38px;
}

/* Phone */
.user-phone { display: inline-flex; align-items: center; gap: 5px; font-size: 0.82rem; color: #4a5080; }

/* Role badge */
.role-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 9px; border-radius: 20px;
    font-size: 0.72rem; font-weight: 600; margin: 2px;
    background: #ede9fe; color: #5b21b6;
}

/* Status badge */
.status-user-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px;
    font-size: 0.75rem; font-weight: 600; white-space: nowrap;
}
.status-user-badge::before {
    content: ''; width: 6px; height: 6px;
    border-radius: 50%; background: currentColor; opacity: 0.7;
}
.status-active   { background: #d4f5e2; color: #0d6b35; }
.status-inactive { background: #ffe6e6; color: #c42b2b; }
.status-pending-u{ background: #fff8e6; color: #c47f00; }
.status-other-u  { background: #f0f2fa; color: #4a5080; }

/* Action buttons */
.user-actions { display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
.btn-user-view  { display:inline-flex;align-items:center;gap:4px;padding:5px 10px;background:linear-gradient(135deg,#4f7cff,#7c4fff);color:#fff !important;border-radius:7px;font-size:0.75rem;font-weight:600;text-decoration:none;border:none;cursor:pointer;box-shadow:0 2px 6px rgba(79,124,255,0.25);transition:opacity 0.2s,transform 0.15s; }
.btn-user-edit  { display:inline-flex;align-items:center;gap:4px;padding:5px 10px;background:linear-gradient(135deg,#17c3b2,#06b89a);color:#fff !important;border-radius:7px;font-size:0.75rem;font-weight:600;text-decoration:none;border:none;cursor:pointer;box-shadow:0 2px 6px rgba(23,195,178,0.25);transition:opacity 0.2s,transform 0.15s; }
.btn-user-orders{ display:inline-flex;align-items:center;gap:4px;padding:5px 10px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff !important;border-radius:7px;font-size:0.75rem;font-weight:600;text-decoration:none;border:none;cursor:pointer;box-shadow:0 2px 6px rgba(34,197,94,0.25);transition:opacity 0.2s,transform 0.15s; }
.btn-user-delete{ display:inline-flex;align-items:center;gap:4px;padding:5px 10px;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff !important;border-radius:7px;font-size:0.75rem;font-weight:600;text-decoration:none;border:none;cursor:pointer;box-shadow:0 2px 6px rgba(239,68,68,0.25);transition:opacity 0.2s,transform 0.15s; }
.btn-user-view:hover,.btn-user-edit:hover,.btn-user-orders:hover,.btn-user-delete:hover {
    opacity:0.85; transform:translateY(-1px); color:#fff !important; text-decoration:none;
}

/* Avatar gradient palette */
.av-0  { background: linear-gradient(135deg,#4f7cff,#7c4fff); }
.av-1  { background: linear-gradient(135deg,#ff6b35,#f7931e); }
.av-2  { background: linear-gradient(135deg,#17c3b2,#06b89a); }
.av-3  { background: linear-gradient(135deg,#f59e0b,#d97706); }
.av-4  { background: linear-gradient(135deg,#ef4444,#dc2626); }
.av-5  { background: linear-gradient(135deg,#7c3aed,#a855f7); }
.av-6  { background: linear-gradient(135deg,#0ea5e9,#0284c7); }
.av-7  { background: linear-gradient(135deg,#22c55e,#16a34a); }

/* DataTables */
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #d8c8f8 !important; border-radius: 8px !important;
    padding: 6px 12px !important; font-size: 0.83rem !important;
}
.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #7c3aed !important;
    box-shadow: 0 0 0 3px rgba(124,58,237,0.12) !important; outline: none !important;
}
.dataTables_wrapper .dataTables_length select {
    border: 1px solid #d8c8f8 !important; border-radius: 8px !important;
    padding: 4px 8px !important; font-size: 0.83rem !important;
}
.dataTables_wrapper .paginate_button.current,
.dataTables_wrapper .paginate_button.current:hover {
    background: linear-gradient(135deg,#7c3aed,#a855f7) !important;
    color: #fff !important; border: none !important; border-radius: 7px !important;
}
</style>

<div class="content-wrapper" style="background:#f4f6fb; min-height:100vh; padding:24px;">

    {{-- Page Header --}}
    <div class="users-page-header">
        <div class="users-page-title">
            <div class="title-icon"><i class="fas fa-users"></i></div>
            {{ trans('cruds.user.title') }}
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <nav aria-label="breadcrumb" style="font-size:0.8rem;">
                <ol class="breadcrumb mb-0" style="background:transparent;padding:0;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}" style="color:#7c3aed;">{{ trans('global.dashboard') }}</a></li>
                    <li class="breadcrumb-item active" style="color:#7a80a0;">{{ trans('cruds.user.title') }}</li>
                </ol>
            </nav>
            @can('user_create')
                <a class="users-add-btn" href="{{ route('admin.users.create') }}">
                    <i class="fas fa-user-plus"></i>
                    {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                </a>
            @endcan
        </div>
    </div>

    {{-- Main Card --}}
    <div class="users-card">
        <div class="users-card-header">
            <div class="users-card-header-title">
                <i class="fas fa-users"></i>
                {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
                <span style="background:#ede9fe;color:#5b21b6;font-size:0.72rem;font-weight:700;padding:2px 10px;border-radius:20px;margin-inline-start:4px;">
                    {{ $users->count() }}
                </span>
            </div>
            <span style="font-size:0.78rem;color:#a080c0;">
                <i class="fas fa-sync-alt" style="margin-left:4px;"></i>
                {{ now()->translatedFormat('d/m/Y H:i') }}
            </span>
        </div>

        <div class="users-card-body">
            <div class="users-table-wrap">
                <table class="users-table table datatable datatable-User">
                    <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.user.fields.id') }}</th>
                        <th>{{ trans('cruds.user.fields.full_name') }}</th>
                        <th>{{ trans('cruds.user.fields.phone') }}</th>
                        @if(!isset($type))
                            <th>{{ trans('cruds.user.fields.roles') }}</th>
                        @endif
                        <th>{{ trans('cruds.user.fields.status') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        @if(!isset($type))
                            <td>
                                <select class="search">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach($roles as $item)
                                        <option value="{{ $item->title }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </td>
                        @endif
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($user_statuses as $item)
                                    <option value="{{ App::getLocale()=='ar' ? $item->name_ar : $item->name_en }}">
                                        {{ App::getLocale()=='ar' ? $item->name_ar : $item->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        @php
                            $avClass = 'av-' . ($user->id % 8);
                            $initials = strtoupper(mb_substr($user->name ?? 'U', 0, 1));
                            $statusName = $user->status->name_ar ?? '';
                            $statusId = optional($user->status)->id ?? 0;
                            $statusClass = match(true) {
                                $statusId == 1 => 'status-active',
                                $statusId == 2 => 'status-inactive',
                                $statusId == 3 => 'status-pending-u',
                                default        => 'status-other-u',
                            };
                        @endphp
                        <tr data-entry-id="{{ $user->id }}">
                            <td></td>
                            <td><span class="user-id-badge">#{{ $user->id }}</span></td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar-circle {{ $avClass }}">{{ $initials }}</div>
                                    <div>
                                        <div class="user-full-name">{{ $user->name . ' ' . $user->last_name }}</div>
                                        @if($user->email)
                                            <div style="font-size:0.73rem;color:#9aa0c0;">{{ $user->email }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="user-phone">
                                    <i class="fas fa-phone" style="color:#7c3aed;font-size:0.72rem;"></i>
                                    {{ $user->phone ?? '—' }}
                                </span>
                            </td>
                            @if(!isset($type))
                                <td>
                                    @forelse($user->roles as $item)
                                        <span class="role-badge"><i class="fas fa-shield-alt" style="font-size:0.65rem;"></i>{{ $item->title }}</span>
                                    @empty
                                        <span style="color:#bbb;font-size:0.78rem;">—</span>
                                    @endforelse
                                </td>
                            @endif
                            <td>
                                <span class="status-user-badge {{ $statusClass }}">{{ $statusName }}</span>
                            </td>
                            <td>
                                <div class="user-actions">
                                    @can('user_show')
                                        <a class="btn-user-view" href="{{ route('admin.users.show', $user->id) }}">
                                            <i class="fas fa-eye"></i> {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    @can('user_edit')
                                        <a class="btn-user-edit" href="{{ route('admin.users.edit', $user->id) }}">
                                            <i class="fas fa-edit"></i> {{ trans('global.edit') }}
                                        </a>
                                    @endcan
                                    @if($user->user_type == 2)
                                        <a class="btn-user-orders" href="{{ route('admin.users.user_order', $user->id) }}">
                                            <i class="fas fa-shopping-bag"></i> {{ trans('global.order_user') }}
                                        </a>
                                    @endif
                                    @can('user_delete')
                                        @if($user->id != 1)
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                  style="display:inline-block;margin:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-user-delete">
                                                    <i class="fas fa-trash-alt"></i> {{ trans('global.delete') }}
                                                </button>
                                            </form>
                                        @endif
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

</div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            @can('user_delete')
            let deleteButton = {
                text: '{{ trans('global.datatables.delete') }}',
                url: "{{ route('admin.users.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id');
                    });
                    if (ids.length === 0) { alert('{{ trans('global.datatables.zero_selected') }}'); return; }
                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: { 'x-csrf-token': _token },
                            method: 'POST', url: config.url,
                            data: { ids: ids, _method: 'DELETE' }
                        }).done(function () { location.reload(); });
                    }
                }
            };
            dtButtons.push(deleteButton);
            @endcan
            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true, order: [[1, 'desc']], pageLength: 100,
            });
            let table = $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons });
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function () {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index()).search(value, strict).draw();
            });
        });
    </script>
@endsection
