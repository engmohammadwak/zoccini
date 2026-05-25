@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('global.show').' '.trans('cruds.country.title_singular')"
        icon="fas fa-globe"
        color="indigo"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.country.title'), 'url' => route('admin.countries.index')],
            ['label' => trans('global.show')],
        ]"
    />

    <div style="max-width:720px;">

        {{-- Hero Card --}}
        <div style="background:#fff;border-radius:18px;box-shadow:0 2px 14px rgba(0,0,0,0.07);padding:28px;margin-bottom:18px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
            <div style="flex-shrink:0;">
                @if($country->flag)
                    <img src="{{ asset('storage/'.$country->flag) }}" style="width:72px;height:52px;border-radius:10px;object-fit:cover;box-shadow:0 2px 8px rgba(0,0,0,0.12);" alt="" />
                @else
                    <div style="width:72px;height:72px;border-radius:16px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:28px;">
                        <i class="fas fa-globe"></i>
                    </div>
                @endif
            </div>
            <div style="flex:1;min-width:200px;">
                <div style="font-size:1.35rem;font-weight:800;color:#1e293b;line-height:1.2;">{{ $country->name_en ?? $country->name ?? '—' }}</div>
                @if($country->name_ar)
                <div style="font-size:0.95rem;color:#64748b;margin-top:4px;direction:rtl;">{{ $country->name_ar }}</div>
                @endif
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:10px;">
                    @if($country->code)
                    <span style="background:#e0e7ff;color:#3730a3;padding:4px 12px;border-radius:8px;font-weight:700;font-size:0.8rem;font-family:monospace;letter-spacing:1px;">{{ strtoupper($country->code) }}</span>
                    @endif
                    @if($country->status == 1)
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
                <i class="fas fa-info-circle" style="color:#6366f1;"></i>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ trans('global.country_details') ?? 'Country Details' }}</span>
            </div>
            <div style="padding:6px 0;">
                @php
                    $rows = [
                        ['icon'=>'fas fa-hashtag','label'=>trans('cruds.country.fields.id'),'value'=>$country->id],
                        ['icon'=>'fas fa-font','label'=>trans('cruds.country.fields.name_en') ?? 'Name EN','value'=>$country->name_en ?? $country->name ?? '—'],
                        ['icon'=>'fas fa-language','label'=>trans('cruds.country.fields.name_ar'),'value'=>$country->name_ar ?? '—','rtl'=>true],
                        ['icon'=>'fas fa-code','label'=>trans('cruds.country.fields.short_code') ?? 'Short Code','value'=>$country->short_code ?? $country->code ?? '—','mono'=>true],
                    ];
                @endphp
                @foreach($rows as $row)
                <div style="display:flex;align-items:center;gap:12px;padding:11px 20px;border-bottom:1px solid #f8fafc;">
                    <div style="width:28px;text-align:center;color:#94a3b8;font-size:0.8rem;"><i class="{{ $row['icon'] }}"></i></div>
                    <div style="width:140px;font-size:0.8rem;color:#64748b;font-weight:500;">{{ $row['label'] }}</div>
                    <div style="flex:1;font-size:0.85rem;color:#1e293b;font-weight:600;{{ isset($row['rtl']) ? 'direction:rtl;text-align:right;' : '' }}{{ isset($row['mono']) ? 'font-family:monospace;' : '' }}">{{ $row['value'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Currency Card --}}
        @if(optional($country->currency)->name_ar || optional($country->currency)->name_en)
        <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:18px;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-coins" style="color:#f59e0b;"></i>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ trans('cruds.country.fields.currency') ?? 'Currency' }}</span>
            </div>
            <div style="padding:16px 20px;display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#fef3c7,#fde68a);display:flex;align-items:center;justify-content:center;color:#d97706;font-size:16px;">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div>
                    <div style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ optional($country->currency)->name_en ?? '' }}</div>
                    <div style="font-size:0.78rem;color:#64748b;direction:rtl;">{{ optional($country->currency)->name_ar ?? '' }}</div>
                </div>
            </div>
        </div>
        @endif

        {{-- Back Button --}}
        <a href="{{ route('admin.countries.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#f1f5f9;color:#475569;border-radius:10px;font-size:0.83rem;font-weight:600;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
        </a>
    </div>

</div>
@endsection
