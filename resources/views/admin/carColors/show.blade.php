@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header title="Show Car Color" icon="fas fa-palette" color="pink"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Car Colors','url'=>route('admin.car-colors.index')],['label'=>trans('global.show')]]" />

    <div style="max-width:680px;">
        {{-- Hero --}}
        <div style="background:#fff;border-radius:18px;box-shadow:0 2px 14px rgba(0,0,0,0.07);padding:28px;margin-bottom:18px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
            <div style="width:72px;height:72px;border-radius:16px;background:{{ $carColor->color ?? $carColor->hex ?? 'linear-gradient(135deg,#ec4899,#f472b6)' }};border:3px solid rgba(0,0,0,0.08);flex-shrink:0;"></div>
            <div style="flex:1;">
                <div style="font-size:1.35rem;font-weight:800;color:#1e293b;">{{ $carColor->name_en ?? $carColor->name ?? '—' }}</div>
                @if($carColor->name_ar)
                <div style="font-size:0.95rem;color:#64748b;margin-top:4px;direction:rtl;">{{ $carColor->name_ar }}</div>
                @endif
                @if($carColor->color ?? $carColor->hex ?? null)
                <span style="background:#fce7f3;color:#be185d;padding:4px 12px;border-radius:8px;font-size:0.8rem;font-family:monospace;font-weight:700;display:inline-block;margin-top:8px;">{{ $carColor->color ?? $carColor->hex }}</span>
                @endif
            </div>
        </div>

        {{-- Details --}}
        <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:18px;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-info-circle" style="color:#ec4899;"></i>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">Color Details</span>
            </div>
            <div style="padding:6px 0;">
                @foreach([
                    ['fas fa-hashtag','ID',$carColor->id,false],
                    ['fas fa-font','Name EN',$carColor->name_en ?? $carColor->name ?? '—',false],
                    ['fas fa-language','Name AR',$carColor->name_ar ?? '—',true],
                    ['fas fa-fill-drip','Hex Code',$carColor->color ?? $carColor->hex ?? '—',false,'mono'],
                ] as [$icon,$label,$val,$rtl,$mono??''])
                <div style="display:flex;align-items:center;gap:12px;padding:11px 20px;border-bottom:1px solid #f8fafc;">
                    <div style="width:28px;text-align:center;color:#94a3b8;font-size:0.8rem;"><i class="{{ $icon }}"></i></div>
                    <div style="width:120px;font-size:0.8rem;color:#64748b;font-weight:500;">{{ $label }}</div>
                    <div style="flex:1;font-size:0.85rem;color:#1e293b;font-weight:600;{{ $rtl ? 'direction:rtl;text-align:right;' : '' }}{{ $mono ? 'font-family:monospace;' : '' }}">{{ $val }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <a href="{{ route('admin.car-colors.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#f1f5f9;color:#475569;border-radius:10px;font-size:0.83rem;font-weight:600;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
        </a>
    </div>
</div>
@endsection
