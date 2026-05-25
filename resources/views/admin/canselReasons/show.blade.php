@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#ef4444,#dc2626);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(239,68,68,.3);">
                <i class="fas fa-ban"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;line-height:1.2;">{{ trans('global.show') }} {{ trans('cruds.canselReason.title_singular') }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <a href="{{ route('admin.cansel-reasons.index') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('cruds.canselReason.title') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <span>#{{ $canselReason->id }}</span>
                </nav>
            </div>
        </div>
        <div style="display:flex;gap:8px;">
            @can('cansel_reason_edit')
            <a href="{{ route('admin.cansel-reasons.edit',$canselReason->id) }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(245,158,11,.12);color:#b45309;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;"
               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.12)'">
                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
            </a>
            @endcan
            <a href="{{ route('admin.cansel-reasons.index') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--z-surface-2);color:var(--z-text-muted);border:1px solid var(--z-border);border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>

    {{-- Details Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:24px;box-shadow:var(--z-card-shadow);max-width:560px;">
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--z-border);">
            <div style="width:56px;height:56px;border-radius:13px;background:linear-gradient(135deg,#ef4444,#dc2626);display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:#fff;flex-shrink:0;box-shadow:0 4px 14px rgba(239,68,68,.3);"><i class="fas fa-ban"></i></div>
            <div>
                <div style="font-size:1rem;font-weight:800;color:var(--z-text);">{{ $canselReason->reason_en ?? $canselReason->name_en ?? '#'.$canselReason->id }}</div>
                @if($canselReason->reason_ar ?? $canselReason->name_ar)
                <div style="font-size:0.85rem;color:var(--z-text-muted);direction:rtl;">{{ $canselReason->reason_ar ?? $canselReason->name_ar }}</div>
                @endif
            </div>
        </div>

        @php $rows = [
            ['icon'=>'fa-hashtag','color'=>'#94a3b8','label'=>trans('cruds.canselReason.fields.id') ?? 'ID','val'=>'#'.$canselReason->id],
            ['icon'=>'fa-globe','color'=>'#ef4444','label'=>trans('cruds.canselReason.fields.reason_en') ?? 'Reason EN','val'=>$canselReason->reason_en ?? $canselReason->name_en],
            ['icon'=>'fa-language','color'=>'#f87171','label'=>trans('cruds.canselReason.fields.reason_ar') ?? 'Reason AR','val'=>$canselReason->reason_ar ?? $canselReason->name_ar,'rtl'=>true],
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
