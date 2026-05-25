@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#6366f1,#4f46e5);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(99,102,241,.3);">
                <i class="fas fa-globe"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;line-height:1.2;">{{ trans('global.show') }} {{ trans('cruds.country.title_singular') }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <a href="{{ route('admin.countries.index') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('cruds.country.title') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <span>{{ $country->name_en ?? '#'.$country->id }}</span>
                </nav>
            </div>
        </div>
        <div style="display:flex;gap:8px;">
            @can('country_edit')
            <a href="{{ route('admin.countries.edit',$country->id) }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(245,158,11,.12);color:#b45309;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;"
               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.12)'">
                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
            </a>
            @endcan
            <a href="{{ route('admin.countries.index') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--z-surface-2);color:var(--z-text-muted);border:1px solid var(--z-border);border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>

    {{-- Hero --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:24px;box-shadow:var(--z-card-shadow);margin-bottom:20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        @if($country->flag)
            <img src="{{ asset('storage/'.$country->flag) }}" style="width:80px;height:56px;border-radius:10px;object-fit:cover;border:2px solid var(--z-border);flex-shrink:0;" alt="" />
        @else
            <div style="width:80px;height:80px;border-radius:14px;background:linear-gradient(135deg,#6366f1,#4f46e5);display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fff;flex-shrink:0;box-shadow:0 4px 14px rgba(99,102,241,.3);"><i class="fas fa-globe"></i></div>
        @endif
        <div style="flex:1;min-width:200px;">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:6px;">
                <h2 style="font-size:1.25rem;font-weight:800;color:var(--z-text);margin:0;">{{ $country->name_en }}</h2>
                @if($country->name_ar)
                <span style="font-size:1rem;color:var(--z-text-muted);font-weight:600;direction:rtl;">{{ $country->name_ar }}</span>
                @endif
                @if($country->code)
                <span style="background:rgba(99,102,241,.1);color:#3730a3;padding:4px 10px;border-radius:8px;font-weight:700;font-size:0.78rem;font-family:monospace;letter-spacing:1px;">{{ strtoupper($country->code) }}</span>
                @endif
                @if($country->status == 1)
                <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 12px;border-radius:999px;font-weight:700;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>{{ trans('global.active') ?? 'Active' }}
                </span>
                @else
                <span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 12px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Details --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);max-width:520px;">
        <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
            <div style="width:32px;height:32px;border-radius:9px;background:rgba(99,102,241,.1);display:flex;align-items:center;justify-content:center;color:#6366f1;font-size:14px;"><i class="fas fa-info-circle"></i></div>
            <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('global.details') ?? 'Details' }}</span>
        </div>
        @php $rows = [
            ['icon'=>'fa-hashtag','color'=>'#94a3b8','label'=>trans('cruds.country.fields.id'),'val'=>'#'.$country->id],
            ['icon'=>'fa-globe','color'=>'#6366f1','label'=>trans('cruds.country.fields.name_en'),'val'=>$country->name_en],
            ['icon'=>'fa-language','color'=>'#818cf8','label'=>trans('cruds.country.fields.name_ar'),'val'=>$country->name_ar,'rtl'=>true],
            ['icon'=>'fa-code','color'=>'#4f46e5','label'=>trans('cruds.country.fields.code') ?? 'Code','val'=>$country->code ? strtoupper($country->code) : null],
        ]; @endphp
        @foreach($rows as $row)
        @if($row['val'])
        <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:12px;">
            <i class="fas {{ $row['icon'] }}" style="color:{{ $row['color'] }};width:14px;margin-top:2px;flex-shrink:0;"></i>
            <div>
                <div style="font-size:0.7rem;color:var(--z-text-faint);font-weight:600;">{{ $row['label'] }}</div>
                <div style="font-size:0.85rem;color:var(--z-text);font-weight:600;{{ ($row['rtl'] ?? false) ? 'direction:rtl;' : '' }}">{{ $row['val'] }}</div>
            </div>
        </div>
        @endif
        @endforeach
    </div>

</div>
@endsection
