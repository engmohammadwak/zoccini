@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#8b5cf6,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(139,92,246,.3);">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;line-height:1.2;">{{ trans('global.show') }} {{ trans('cruds.user.title_singular') }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <a href="{{ route('admin.users.index') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('cruds.user.title') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <span>{{ $user->name }}</span>
                </nav>
            </div>
        </div>
        <div style="display:flex;gap:8px;">
            @can('user_edit')
            <a href="{{ route('admin.users.edit',$user->id) }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(245,158,11,.12);color:#b45309;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;transition:background .18s;"
               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.12)'">
                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
            </a>
            @endcan
            <a href="{{ route('admin.users.index') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--z-surface-2);color:var(--z-text-muted);border:1px solid var(--z-border);border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>

    @php
        $typeConfig = [
            1 => ['label'=>trans('global.admin') ?? 'Admin',      'bg'=>'rgba(244,63,94,.12)','color'=>'#9f1239','icon'=>'fa-user-shield'],
            2 => ['label'=>trans('global.customer') ?? 'Customer','bg'=>'rgba(59,130,246,.12)','color'=>'#1e40af','icon'=>'fa-user'],
            3 => ['label'=>trans('cruds.restaurant.title_singular') ?? 'Restaurant','bg'=>'rgba(245,158,11,.12)','color'=>'#92400e','icon'=>'fa-store'],
        ];
        $tc = $typeConfig[$user->user_type ?? 0] ?? ['label'=>'User','bg'=>'rgba(148,163,184,.12)','color'=>'#475569','icon'=>'fa-user'];
    @endphp

    {{-- Profile Hero Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:24px;box-shadow:var(--z-card-shadow);margin-bottom:20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        {{-- Avatar --}}
        @if($user->image)
            <img src="{{ url('local/public/img/user/'.$user->image) }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid var(--z-border);flex-shrink:0;" alt="" />
        @else
            <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#8b5cf6,#a78bfa);display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;color:#fff;flex-shrink:0;box-shadow:0 4px 14px rgba(139,92,246,.3);">{{ strtoupper(substr($user->name ?? 'U',0,1)) }}</div>
        @endif
        <div style="flex:1;min-width:200px;">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:5px;">
                <h2 style="font-size:1.25rem;font-weight:800;color:var(--z-text);margin:0;">{{ $user->name }} {{ $user->last_name }}</h2>
                {{-- Type badge --}}
                <span style="background:{{ $tc['bg'] }};color:{{ $tc['color'] }};padding:4px 12px;border-radius:999px;font-weight:700;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <i class="fas {{ $tc['icon'] }}" style="font-size:0.65rem;"></i> {{ $tc['label'] }}
                </span>
                {{-- Status badge --}}
                @if($user->status == 1)
                <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 12px;border-radius:999px;font-weight:700;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>{{ trans('global.active') ?? 'Active' }}
                </span>
                @else
                <span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 12px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                </span>
                @endif
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:16px;margin-top:10px;">
                @if($user->email)
                <div style="display:flex;align-items:center;gap:6px;font-size:0.83rem;color:var(--z-text-muted);">
                    <i class="fas fa-envelope" style="color:#8b5cf6;"></i> {{ $user->email }}
                </div>
                @endif
                @if($user->phone)
                <div style="display:flex;align-items:center;gap:6px;font-size:0.83rem;color:var(--z-text-muted);">
                    <i class="fas fa-phone" style="color:var(--z-primary);"></i> {{ $user->phone }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Info Cards Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;">

        {{-- Account Info --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(139,92,246,.1);display:flex;align-items:center;justify-content:center;color:#8b5cf6;font-size:14px;"><i class="fas fa-id-card"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('global.account_info') ?? 'Account Info' }}</span>
            </div>
            @php $infoRows = [
                ['icon'=>'fa-hashtag','color'=>'#94a3b8','label'=>trans('cruds.user.fields.id'),'val'=>'#'.$user->id],
                ['icon'=>'fa-user','color'=>'#8b5cf6','label'=>trans('cruds.user.fields.name'),'val'=>$user->name.' '.($user->last_name ?? '')],
                ['icon'=>'fa-envelope','color'=>'#3b82f6','label'=>trans('cruds.user.fields.email'),'val'=>$user->email],
                ['icon'=>'fa-phone','color'=>'#10b981','label'=>trans('cruds.user.fields.phone'),'val'=>$user->phone],
            ]; @endphp
            @foreach($infoRows as $row)
            @if($row['val'])
            <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:10px;">
                <i class="fas {{ $row['icon'] }}" style="color:{{ $row['color'] }};width:14px;margin-top:2px;flex-shrink:0;"></i>
                <div>
                    <div style="font-size:0.7rem;color:var(--z-text-faint);font-weight:600;">{{ $row['label'] }}</div>
                    <div style="font-size:0.85rem;color:var(--z-text);font-weight:600;">{{ $row['val'] }}</div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        {{-- Roles --}}
        @if($user->roles->count())
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(99,102,241,.1);display:flex;align-items:center;justify-content:center;color:#6366f1;font-size:14px;"><i class="fas fa-shield-alt"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.user.fields.roles') }}</span>
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:7px;">
                @foreach($user->roles as $role)
                <span style="background:rgba(99,102,241,.1);color:#4338ca;padding:5px 14px;border-radius:999px;font-size:0.8rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;">
                    <i class="fas fa-shield-alt" style="font-size:0.65rem;"></i> {{ $role->title }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Status Card --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(16,185,129,.1);display:flex;align-items:center;justify-content:center;color:#10b981;font-size:14px;"><i class="fas fa-toggle-on"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.user.fields.status') }}</span>
            </div>
            <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ optional($user->status)->name_ar ?? ($user->status == 1 ? (trans('global.active') ?? 'Active') : (trans('global.inactive') ?? 'Inactive')) }}</div>
            <div style="margin-top:8px;">
                @if($user->status == 1)
                <span style="background:rgba(16,185,129,.12);color:#065f46;padding:5px 14px;border-radius:999px;font-weight:700;font-size:0.8rem;display:inline-flex;align-items:center;gap:6px;">
                    <span style="width:7px;height:7px;border-radius:50%;background:#10b981;"></span>{{ trans('global.active') ?? 'Active' }}
                </span>
                @else
                <span style="background:rgba(148,163,184,.12);color:#475569;padding:5px 14px;border-radius:999px;font-weight:600;font-size:0.8rem;display:inline-flex;align-items:center;gap:6px;">
                    <span style="width:7px;height:7px;border-radius:50%;background:#94a3b8;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                </span>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
