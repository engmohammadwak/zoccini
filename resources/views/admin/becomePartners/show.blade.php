@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#0d9488,#0f766e);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(13,148,136,.3);">
                <i class="fas fa-handshake"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;">Partner Request</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <a href="{{ route('admin.become-partners.index') }}" style="color:var(--z-primary);text-decoration:none;">Become Partners</a>
                    <span style="margin:0 5px;">›</span>
                    <span>{{ $becomePartner->name ?? '#'.$becomePartner->id }}</span>
                </nav>
            </div>
        </div>
        <a href="{{ route('admin.become-partners.index') }}"
           style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--z-surface-2);color:var(--z-text-muted);border:1px solid var(--z-border);border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
        </a>
    </div>

    {{-- Hero --}}
    @php
        $st = $becomePartner->status ?? 'pending';
        $statusMap = [
            'pending'  => ['bg'=>'rgba(245,158,11,.12)','color'=>'#b45309','dot'=>'#f59e0b','label'=>'Pending'],
            'approved' => ['bg'=>'rgba(34,197,94,.12)', 'color'=>'#15803d','dot'=>'#22c55e','label'=>'Approved'],
            'rejected' => ['bg'=>'rgba(239,68,68,.12)', 'color'=>'#dc2626','dot'=>'#ef4444','label'=>'Rejected'],
        ];
        $sm = $statusMap[$st] ?? ['bg'=>'rgba(148,163,184,.12)','color'=>'#64748b','dot'=>'#94a3b8','label'=>ucfirst($st)];
    @endphp
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:24px;box-shadow:var(--z-card-shadow);margin-bottom:20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;font-size:1.6rem;font-weight:800;color:#fff;flex-shrink:0;box-shadow:0 4px 14px rgba(13,148,136,.3);">
            {{ strtoupper(substr($becomePartner->name ?? $becomePartner->owner_name ?? 'P', 0, 1)) }}
        </div>
        <div style="flex:1;min-width:200px;">
            <h2 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0 0 6px;">{{ $becomePartner->name ?? $becomePartner->owner_name ?? '—' }}</h2>
            <div style="display:flex;align-items:center;flex-wrap:wrap;gap:8px;">
                <span style="background:{{ $sm['bg'] }};color:{{ $sm['color'] }};padding:4px 12px;border-radius:8px;font-weight:700;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:{{ $sm['dot'] }};display:inline-block;"></span>{{ $sm['label'] }}
                </span>
                @if($becomePartner->restaurant_name)
                <span style="background:rgba(13,148,136,.08);color:#0f766e;padding:4px 12px;border-radius:8px;font-size:0.78rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;">
                    <i class="fas fa-store" style="font-size:0.65rem;"></i>{{ $becomePartner->restaurant_name }}
                </span>
                @endif
                @if($becomePartner->created_at)
                <span style="background:var(--z-surface-2);color:var(--z-text-faint);padding:4px 12px;border-radius:8px;font-size:0.78rem;font-weight:600;border:1px solid var(--z-border);">
                    <i class="fas fa-calendar-alt" style="font-size:0.65rem;margin-right:4px;"></i>{{ $becomePartner->created_at->format('d/m/Y') }}
                </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Details Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:16px;">

        {{-- Contact Info --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(13,148,136,.1);display:flex;align-items:center;justify-content:center;color:#0d9488;font-size:14px;"><i class="fas fa-address-card"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Contact Info</span>
            </div>
            @php $contactRows = [
                ['icon'=>'fa-user','color'=>'#0d9488','label'=>'Name','val'=>$becomePartner->name ?? $becomePartner->owner_name],
                ['icon'=>'fa-phone','color'=>'#14b8a6','label'=>'Phone','val'=>$becomePartner->phone],
                ['icon'=>'fa-envelope','color'=>'#0f766e','label'=>'Email','val'=>$becomePartner->email],
                ['icon'=>'fa-map-marker-alt','color'=>'#64748b','label'=>'City','val'=>$becomePartner->city],
                ['icon'=>'fa-map-pin','color'=>'#94a3b8','label'=>'Address','val'=>$becomePartner->address],
            ]; @endphp
            @foreach($contactRows as $row)
            @if($row['val'])
            <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:12px;">
                <i class="fas {{ $row['icon'] }}" style="color:{{ $row['color'] }};width:14px;margin-top:2px;flex-shrink:0;"></i>
                <div>
                    <div style="font-size:0.7rem;color:var(--z-text-faint);font-weight:600;">{{ $row['label'] }}</div>
                    <div style="font-size:0.85rem;color:var(--z-text);font-weight:600;">{{ $row['val'] }}</div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        {{-- Business Info --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(13,148,136,.1);display:flex;align-items:center;justify-content:center;color:#0d9488;font-size:14px;"><i class="fas fa-store"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Business Info</span>
            </div>
            @php $bizRows = [
                ['icon'=>'fa-store','color'=>'#0d9488','label'=>'Restaurant Name','val'=>$becomePartner->restaurant_name],
                ['icon'=>'fa-tag','color'=>'#14b8a6','label'=>'Business Type','val'=>$becomePartner->business_type],
                ['icon'=>'fa-calendar-alt','color'=>'#64748b','label'=>'Years in Business','val'=>$becomePartner->years_in_business],
                ['icon'=>'fa-comment-alt','color'=>'#94a3b8','label'=>'Message','val'=>$becomePartner->message ?? $becomePartner->notes],
            ]; @endphp
            @foreach($bizRows as $row)
            @if($row['val'])
            <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:12px;">
                <i class="fas {{ $row['icon'] }}" style="color:{{ $row['color'] }};width:14px;margin-top:2px;flex-shrink:0;"></i>
                <div>
                    <div style="font-size:0.7rem;color:var(--z-text-faint);font-weight:600;">{{ $row['label'] }}</div>
                    <div style="font-size:0.85rem;color:var(--z-text);font-weight:600;">{{ $row['val'] }}</div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

    </div>

</div>
@endsection
