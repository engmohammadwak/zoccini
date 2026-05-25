@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#06b6d4,#0891b2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(6,182,212,.3);">
                <i class="fas fa-motorcycle"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;line-height:1.2;">{{ trans('global.show') }} {{ trans('cruds.delivery.title_singular') }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <a href="{{ route('admin.deliveries.index') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('cruds.delivery.title') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <span>{{ $delivery->name ?? optional($delivery->user)->name ?? '#'.$delivery->id }}</span>
                </nav>
            </div>
        </div>
        <div style="display:flex;gap:8px;">
            @can('delivery_edit')
            <a href="{{ route('admin.deliveries.edit',$delivery->id) }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(245,158,11,.12);color:#b45309;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;"
               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.12)'">
                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
            </a>
            @endcan
            <a href="{{ route('admin.deliveries.index') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--z-surface-2);color:var(--z-text-muted);border:1px solid var(--z-border);border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>

    @php
        $dName = $delivery->name ?? optional($delivery->user)->name ?? '';
        $phone = $delivery->phone ?? optional($delivery->user)->phone ?? '';
        $email = $delivery->email ?? optional($delivery->user)->email ?? '';
    @endphp

    {{-- Hero Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:24px;box-shadow:var(--z-card-shadow);margin-bottom:20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        @if($delivery->avatar)
            <img src="{{ asset('storage/'.$delivery->avatar) }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid var(--z-border);flex-shrink:0;" alt="" />
        @else
            <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#06b6d4,#0891b2);display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;color:#fff;flex-shrink:0;box-shadow:0 4px 14px rgba(6,182,212,.3);">{{ strtoupper(substr($dName ?: 'D',0,1)) }}</div>
        @endif
        <div style="flex:1;min-width:200px;">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:5px;">
                <h2 style="font-size:1.25rem;font-weight:800;color:var(--z-text);margin:0;">{{ $dName }}</h2>
                {{-- Online badge --}}
                @if($delivery->is_online ?? 0)
                <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 12px;border-radius:999px;font-weight:700;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>Online
                </span>
                @else
                <span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 12px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span>Offline
                </span>
                @endif
                {{-- Busy badge --}}
                @if($delivery->is_busy ?? 0)
                <span style="background:rgba(245,158,11,.12);color:#92400e;padding:4px 12px;border-radius:999px;font-weight:700;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <i class="fas fa-hourglass-half" style="font-size:0.6rem;"></i>Busy
                </span>
                @endif
                {{-- Status --}}
                @if($delivery->status == 1)
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
                @if($email)
                <div style="display:flex;align-items:center;gap:6px;font-size:0.83rem;color:var(--z-text-muted);">
                    <i class="fas fa-envelope" style="color:#06b6d4;"></i> {{ $email }}
                </div>
                @endif
                @if($phone)
                <div style="display:flex;align-items:center;gap:6px;font-size:0.83rem;color:var(--z-text-muted);">
                    <i class="fas fa-phone" style="color:var(--z-primary);"></i> {{ $phone }}
                </div>
                @endif
                @if(optional($delivery->city)->name_en)
                <div style="display:flex;align-items:center;gap:6px;font-size:0.83rem;color:var(--z-text-muted);">
                    <i class="fas fa-map-marker-alt" style="color:#f43f5e;"></i> {{ $delivery->city->name_en }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Info Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;">

        {{-- Account Info --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(6,182,212,.1);display:flex;align-items:center;justify-content:center;color:#06b6d4;font-size:14px;"><i class="fas fa-id-card"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('global.account_info') ?? 'Account Info' }}</span>
            </div>
            @php $rows = [
                ['icon'=>'fa-hashtag','color'=>'#94a3b8','label'=>trans('cruds.delivery.fields.id'),'val'=>'#'.$delivery->id],
                ['icon'=>'fa-user','color'=>'#06b6d4','label'=>trans('cruds.delivery.fields.name'),'val'=>$dName],
                ['icon'=>'fa-envelope','color'=>'#3b82f6','label'=>trans('cruds.delivery.fields.email') ?? 'Email','val'=>$email],
                ['icon'=>'fa-phone','color'=>'#10b981','label'=>trans('cruds.delivery.fields.phone') ?? 'Phone','val'=>$phone],
                ['icon'=>'fa-map-marker-alt','color'=>'#f43f5e','label'=>trans('cruds.delivery.fields.city') ?? 'City','val'=>optional($delivery->city)->name_en],
            ]; @endphp
            @foreach($rows as $row)
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

        {{-- Delivery Company --}}
        @if(optional($delivery->deliveryCompany)->name)
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(245,158,11,.1);display:flex;align-items:center;justify-content:center;color:#b45309;font-size:14px;"><i class="fas fa-building"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.deliveryCompany.title_singular') ?? 'Delivery Company' }}</span>
            </div>
            <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ $delivery->deliveryCompany->name }}</div>
        </div>
        @endif

        {{-- Car Info --}}
        @if($delivery->car_number ?? $delivery->car_color ?? $delivery->car_model)
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(139,92,246,.1);display:flex;align-items:center;justify-content:center;color:#8b5cf6;font-size:14px;"><i class="fas fa-motorcycle"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('global.vehicle_info') ?? 'Vehicle Info' }}</span>
            </div>
            @if($delivery->car_number)<div style="display:flex;align-items:center;gap:9px;margin-bottom:8px;"><i class="fas fa-hashtag" style="color:#8b5cf6;width:14px;"></i><div><div style="font-size:0.7rem;color:var(--z-text-faint);font-weight:600;">Plate</div><div style="font-size:0.85rem;font-weight:600;color:var(--z-text);">{{ $delivery->car_number }}</div></div></div>@endif
            @if($delivery->car_color)<div style="display:flex;align-items:center;gap:9px;margin-bottom:8px;"><i class="fas fa-palette" style="color:#8b5cf6;width:14px;"></i><div><div style="font-size:0.7rem;color:var(--z-text-faint);font-weight:600;">Color</div><div style="font-size:0.85rem;font-weight:600;color:var(--z-text);">{{ $delivery->car_color }}</div></div></div>@endif
            @if($delivery->car_model)<div style="display:flex;align-items:center;gap:9px;"><i class="fas fa-car" style="color:#8b5cf6;width:14px;"></i><div><div style="font-size:0.7rem;color:var(--z-text-faint);font-weight:600;">Model</div><div style="font-size:0.85rem;font-weight:600;color:var(--z-text);">{{ $delivery->car_model }}</div></div></div>@endif
        </div>
        @endif

    </div>

</div>
@endsection
