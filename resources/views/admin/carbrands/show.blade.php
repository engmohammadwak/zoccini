@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header title="Show Car Brand" icon="fas fa-trademark" color="gray"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Car Brands','url'=>route('admin.carbrands.index')],['label'=>trans('global.show')]]" />

    <div style="max-width:680px;">
        {{-- Hero --}}
        <div style="background:#fff;border-radius:18px;box-shadow:0 2px 14px rgba(0,0,0,0.07);padding:28px;margin-bottom:18px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
            @if($carbrand->logo ?? $carbrand->image ?? null)
                <img src="{{ asset('storage/'.($carbrand->logo ?? $carbrand->image)) }}" style="width:80px;height:60px;object-fit:contain;border-radius:12px;border:1px solid #f1f5f9;background:#fafafa;flex-shrink:0;" alt="" />
            @else
                <div style="width:72px;height:72px;border-radius:16px;background:linear-gradient(135deg,#475569,#64748b);display:flex;align-items:center;justify-content:center;color:#fff;font-size:28px;flex-shrink:0;"><i class="fas fa-trademark"></i></div>
            @endif
            <div style="flex:1;">
                <div style="font-size:1.35rem;font-weight:800;color:#1e293b;">{{ $carbrand->name_en ?? $carbrand->name ?? '—' }}</div>
                @if($carbrand->name_ar)
                <div style="font-size:0.95rem;color:#64748b;margin-top:4px;direction:rtl;">{{ $carbrand->name_ar }}</div>
                @endif
            </div>
        </div>

        {{-- Details --}}
        <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:18px;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-info-circle" style="color:#475569;"></i>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">Brand Details</span>
            </div>
            <div style="padding:6px 0;">
                @foreach([['fas fa-hashtag','ID',$carbrand->id],['fas fa-font','Name EN',$carbrand->name_en ?? $carbrand->name ?? '—'],['fas fa-language','Name AR',$carbrand->name_ar ?? '—',true]] as [$icon,$label,$val,$rtl??false])
                <div style="display:flex;align-items:center;gap:12px;padding:11px 20px;border-bottom:1px solid #f8fafc;">
                    <div style="width:28px;text-align:center;color:#94a3b8;font-size:0.8rem;"><i class="{{ $icon }}"></i></div>
                    <div style="width:120px;font-size:0.8rem;color:#64748b;font-weight:500;">{{ $label }}</div>
                    <div style="flex:1;font-size:0.85rem;color:#1e293b;font-weight:600;{{ $rtl ? 'direction:rtl;text-align:right;' : '' }}">{{ $val }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <a href="{{ route('admin.carbrands.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#f1f5f9;color:#475569;border-radius:10px;font-size:0.83rem;font-weight:600;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
        </a>
    </div>
</div>
@endsection
