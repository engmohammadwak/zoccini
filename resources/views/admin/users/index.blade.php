@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.user.title')"
        icon="fas fa-users"
        color="purple"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.user.title')],
        ]"
    />

    @php
        $total     = $users->count();
        $active    = $users->where('status_id',1)->count();
        $admins    = $users->where('user_type',1)->count();
        $customers = $users->where('user_type',2)->count();
        $restCount = $users->where('user_type',3)->count();
    @endphp

    {{-- KPI Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:14px;margin-bottom:24px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#8b5cf6,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(139,92,246,.3);"><i class="fas fa-users"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('cruds.user.title') }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(16,185,129,.3);"><i class="fas fa-user-check"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#f43f5e,#fb7185);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(244,63,94,.3);"><i class="fas fa-user-shield"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $admins }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.admins') ?? 'Admins' }}</div></div>
        </div>
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(59,130,246,.3);"><i class="fas fa-user"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $customers }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('global.customers') ?? 'Customers' }}</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);border-radius:14px;padding:18px;box-shadow:0 4px 18px rgba(139,92,246,.35);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;"><i class="fas fa-store"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:#fff;line-height:1;">{{ $restCount }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,.75);margin-top:3px;font-weight:600;">{{ trans('cruds.restaurant.title') ?? 'Restaurants' }}</div></div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(139,92,246,.1);display:flex;align-items:center;justify-content:center;color:#8b5cf6;font-size:15px;"><i class="fas fa-users"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.user.title') }}</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @can('user_create')
            <a href="{{ route('admin.users.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(39,186,77,.3);transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
            </a>
            @endcan
        </div>

        {{-- Table --}}
        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-User" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.user.fields.name') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.user.fields.email') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.user.fields.phone') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.user.fields.user_type') ?? 'Type' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.user.fields.status') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                @php
                    $typeConfig = [
                        1 => ['label'=>trans('global.admin') ?? 'Admin',      'bg'=>'rgba(244,63,94,.12)','color'=>'#9f1239','icon'=>'fa-user-shield'],
                        2 => ['label'=>trans('global.customer') ?? 'Customer','bg'=>'rgba(59,130,246,.12)','color'=>'#1e40af','icon'=>'fa-user'],
                        3 => ['label'=>trans('cruds.restaurant.title_singular') ?? 'Restaurant','bg'=>'rgba(245,158,11,.12)','color'=>'#92400e','icon'=>'fa-store'],
                    ];
                    $tc = $typeConfig[$user->user_type ?? 0] ?? ['label'=>'User','bg'=>'rgba(148,163,184,.12)','color'=>'#475569','icon'=>'fa-user'];
                @endphp
                <tr data-entry-id="{{ $user->id }}">
                    <td></td>
                    {{-- Name + Avatar --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            @if($user->avatar ?? null)
                                <img src="{{ asset('storage/'.$user->avatar) }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:1px solid var(--z-border);" alt="" loading="lazy" />
                            @else
                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#8b5cf6,#a78bfa);display:flex;align-items:center;justify-content:center;font-size:0.82rem;font-weight:800;color:#fff;flex-shrink:0;">{{ strtoupper(substr($user->name ?? 'U',0,1)) }}</div>
                            @endif
                            <div>
                                <div style="font-weight:700;color:var(--z-text);font-size:0.85rem;">{{ $user->name ?? '' }} {{ $user->last_name ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    {{-- Email --}}
                    <td style="font-size:0.82rem;color:var(--z-text-muted);">{{ $user->email ?? '' }}</td>
                    {{-- Phone --}}
                    <td>
                        @if($user->phone)
                        <span style="display:inline-flex;align-items:center;gap:5px;font-size:0.82rem;color:var(--z-text-muted);">
                            <i class="fas fa-phone" style="color:var(--z-primary);font-size:0.7rem;"></i>{{ $user->phone }}
                        </span>
                        @else<span style="color:var(--z-text-faint);">&#8212;</span>@endif
                    </td>
                    {{-- Type --}}
                    <td>
                        <span style="background:{{ $tc['bg'] }};color:{{ $tc['color'] }};padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                            <i class="fas {{ $tc['icon'] }}" style="font-size:0.65rem;"></i>
                            {{ $tc['label'] }}
                        </span>
                    </td>
                    {{-- Status (use status_id to avoid UserStatus object comparison) --}}
                    <td>
                        @if(($user->status_id ?? 0) == 1)
                        <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>{{ trans('global.active') ?? 'Active' }}
                        </span>
                        @else
                        <span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                        </span>
                        @endif
                    </td>
                    {{-- Actions --}}
                    <td>
                        <div style="display:flex;gap:5px;">
                            @can('user_show')
                            <a href="{{ route('admin.users.show',$user->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('user_edit')
                            <a href="{{ route('admin.users.edit',$user->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('user_delete')
                            <form action="{{ route('admin.users.destroy',$user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
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
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
    @can('user_delete')
    dtButtons.push({
        text: '{{ trans('global.datatables.delete') }}',
        url:  '{{ route('admin.users.massDestroy') }}',
        className: 'btn-danger',
        action: function(e,dt,node,config){
            var ids = $.map(dt.rows({selected:true}).nodes(), function(entry){ return $(entry).data('entry-id'); });
            if(ids.length===0){ alert('{{ trans('global.datatables.zero_selected') }}'); return; }
            if(confirm('{{ trans('global.areYouSure') }}')){
                $.ajax({ headers:{'x-csrf-token':_token}, method:'POST', url:config.url, data:{ids:ids,_method:'DELETE'} }).done(function(){ location.reload(); });
            }
        }
    });
    @endcan
    $.extend(true, $.fn.dataTable.defaults, { orderCellsTop:true, order:[[1,'asc']], pageLength:25 });
    $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons });
});
</script>
@endsection
