@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('global.show').' '.trans('cruds.city.title_singular')"
        icon="fas fa-city"
        color="teal"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.city.title'), 'url' => route('admin.cities.index')],
            ['label' => trans('global.show')],
        ]"
    />

    <div style="max-width:720px;">

        {{-- Hero Card --}}
        <div style="background:#fff;border-radius:18px;box-shadow:0 2px 14px rgba(0,0,0,0.07);padding:28px;margin-bottom:18px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
            <div style="width:72px;height:72px;border-radius:16px;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:28px;flex-shrink:0;">
                <i class="fas fa-city"></i>
            </div>
            <div style="flex:1;min-width:200px;">
                <div style="font-size:1.35rem;font-weight:800;color:#1e293b;line-height:1.2;">{{ $city->name_en ?? '—' }}</div>
                @if($city->name_ar)
                <div style="font-size:0.95rem;color:#64748b;margin-top:4px;direction:rtl;">{{ $city->name_ar }}</div>
                @endif
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:10px;">
                    @if($city->status == 1)
                    <span style="background:#dcfce7;color:#166534;padding:4px 12px;border-radius:8px;font-weight:600;font-size:0.8rem;display:inline-flex;align-items:center;gap:5px;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>{{ trans('global.active') ?? 'Active' }}
                    </span>
                    @else
                    <span style="background:#f1f5f9;color:#64748b;padding:4px 12px;border-radius:8px;font-weight:600;font-size:0.8rem;display:inline-flex;align-items:center;gap:5px;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Details Card --}}
        <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:18px;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-info-circle" style="color:#0d9488;"></i>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ trans('global.city_details') ?? 'City Details' }}</span>
            </div>
            <div style="padding:6px 0;">
                @php
                    $rows = [
                        ['icon'=>'fas fa-hashtag','label'=>trans('cruds.city.fields.id'),'value'=>$city->id],
                        ['icon'=>'fas fa-font','label'=>trans('cruds.city.fields.name_en'),'value'=>$city->name_en ?? '—'],
                        ['icon'=>'fas fa-language','label'=>trans('cruds.city.fields.name_ar'),'value'=>$city->name_ar ?? '—','rtl'=>true],
                    ];
                @endphp
                @foreach($rows as $row)
                <div style="display:flex;align-items:center;gap:12px;padding:11px 20px;border-bottom:1px solid #f8fafc;">
                    <div style="width:28px;text-align:center;color:#94a3b8;font-size:0.8rem;"><i class="{{ $row['icon'] }}"></i></div>
                    <div style="width:140px;font-size:0.8rem;color:#64748b;font-weight:500;">{{ $row['label'] }}</div>
                    <div style="flex:1;font-size:0.85rem;color:#1e293b;font-weight:600;{{ isset($row['rtl']) ? 'direction:rtl;text-align:right;' : '' }}">{{ $row['value'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Country Card --}}
        @if(optional($city->country)->id || optional($city->countries)->id)
        @php $countryRel = $city->country ?? $city->countries ?? null; @endphp
        @if($countryRel)
        <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:18px;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-globe" style="color:#6366f1;"></i>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ trans('cruds.city.fields.countries') ?? 'Country' }}</span>
            </div>
            <div style="padding:16px 20px;display:flex;align-items:center;gap:12px;">
                @if($countryRel->flag)
                    <img src="{{ asset('storage/'.$countryRel->flag) }}" style="width:48px;height:34px;border-radius:6px;object-fit:cover;" alt="" />
                @else
                    <div style="width:42px;height:42px;border-radius:10px;background:linear-gradient(135deg,#e0e7ff,#c7d2fe);display:flex;align-items:center;justify-content:center;color:#4f46e5;font-size:16px;">
                        <i class="fas fa-globe"></i>
                    </div>
                @endif
                <div>
                    <div style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ $countryRel->name_en ?? $countryRel->name ?? '—' }}</div>
                    @if($countryRel->name_ar)
                    <div style="font-size:0.78rem;color:#64748b;direction:rtl;">{{ $countryRel->name_ar }}</div>
                    @endif
                    @if($countryRel->code)
                    <span style="background:#e0e7ff;color:#3730a3;padding:2px 8px;border-radius:5px;font-size:0.73rem;font-family:monospace;font-weight:700;letter-spacing:1px;display:inline-block;margin-top:4px;">{{ strtoupper($countryRel->code) }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endif
        @endif

        {{-- Back Button --}}
        <a href="{{ route('admin.cities.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#f1f5f9;color:#475569;border-radius:10px;font-size:0.83rem;font-weight:600;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
        </a>
    </div>

</div>
@endsection
