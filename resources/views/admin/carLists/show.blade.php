@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header title="Show Car" icon="fas fa-car" color="blue"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Car Lists','url'=>route('admin.car-lists.index')],['label'=>trans('global.show')]]" />

    <div style="max-width:720px;">
        {{-- Hero --}}
        <div style="background:#fff;border-radius:18px;box-shadow:0 2px 14px rgba(0,0,0,0.07);padding:28px;margin-bottom:18px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
            @if($carList->image ?? null)
                <img src="{{ asset('storage/'.$carList->image) }}" style="width:110px;height:76px;object-fit:cover;border-radius:12px;flex-shrink:0;" alt="" />
            @else
                <div style="width:90px;height:68px;border-radius:14px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:32px;flex-shrink:0;"><i class="fas fa-car"></i></div>
            @endif
            <div style="flex:1;">
                <div style="font-size:1.35rem;font-weight:800;color:#1e293b;">{{ $carList->model ?? $carList->name ?? '—' }}</div>
                <div style="font-size:0.9rem;color:#64748b;margin-top:4px;">{{ optional($carList->carbrand ?? $carList->brand)->name_en ?? '' }}</div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:10px;">
                    @if($carList->plate_number ?? $carList->plate ?? null)
                    <span style="background:#eff6ff;color:#1d4ed8;padding:4px 12px;border-radius:8px;font-weight:700;font-size:0.8rem;font-family:monospace;letter-spacing:1px;">
                        {{ $carList->plate_number ?? $carList->plate }}
                    </span>
                    @endif
                    @php $clr = $carList->carColor ?? $carList->color_rel ?? null; @endphp
                    @if(optional($clr)->color ?? null)
                    <span style="display:inline-flex;align-items:center;gap:6px;background:#f8fafc;padding:4px 12px;border-radius:8px;">
                        <span style="width:12px;height:12px;border-radius:3px;background:{{ optional($clr)->color }};display:inline-block;border:1px solid rgba(0,0,0,0.1);"></span>
                        <span style="font-size:0.8rem;color:#475569;font-weight:600;">{{ optional($clr)->name_en ?? '' }}</span>
                    </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Car Info --}}
        <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:18px;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-car" style="color:#3b82f6;"></i>
                <span style="font-weight:700;color:#1e293b;font-size:0.9rem;">Car Information</span>
            </div>
            <div style="padding:6px 0;">
                @php
                    $clrObj  = $carList->carColor ?? $carList->color_rel ?? null;
                    $brandObj = $carList->carbrand ?? $carList->brand ?? null;
                    $typeObj  = $carList->typeOfCar ?? $carList->type ?? null;
                    $rows = [
                        ['fas fa-hashtag','ID',$carList->id,false],
                        ['fas fa-car','Model',$carList->model ?? $carList->name ?? '—',false],
                        ['fas fa-trademark','Brand',optional($brandObj)->name_en ?? '—',false],
                        ['fas fa-paint-roller','Color',optional($clrObj)->name_en ?? '—',false],
                        ['fas fa-car-side','Type',optional($typeObj)->name_en ?? '—',false],
                        ['fas fa-id-card','Plate',$carList->plate_number ?? $carList->plate ?? '—',false],
                    ];
                @endphp
                @foreach($rows as [$icon,$label,$val,$rtl])
                <div style="display:flex;align-items:center;gap:12px;padding:11px 20px;border-bottom:1px solid #f8fafc;">
                    <div style="width:28px;text-align:center;color:#94a3b8;font-size:0.8rem;"><i class="{{ $icon }}"></i></div>
                    <div style="width:120px;font-size:0.8rem;color:#64748b;font-weight:500;">{{ $label }}</div>
                    <div style="flex:1;font-size:0.85rem;color:#1e293b;font-weight:600;">{{ $val }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <a href="{{ route('admin.car-lists.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#f1f5f9;color:#475569;border-radius:10px;font-size:0.83rem;font-weight:600;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
        </a>
    </div>
</div>
@endsection
