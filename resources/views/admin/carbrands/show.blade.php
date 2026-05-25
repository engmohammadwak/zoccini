@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#475569,#334155);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(71,85,105,.3);">
                <i class="fas fa-trademark"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;">{{ trans('global.show') }} Car Brand</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <a href="{{ route('admin.carbrands.index') }}" style="color:var(--z-primary);text-decoration:none;">Car Brands</a>
                    <span style="margin:0 5px;">›</span>
                    <span>{{ $carbrand->name_en ?? '#'.$carbrand->id }}</span>
                </nav>
            </div>
        </div>
        <div style="display:flex;gap:8px;">
            @can('carbrand_edit')
            <a href="{{ route('admin.carbrands.edit',$carbrand->id) }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(245,158,11,.12);color:#b45309;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;"
               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.12)'">
                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
            </a>
            @endcan
            <a href="{{ route('admin.carbrands.index') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--z-surface-2);color:var(--z-text-muted);border:1px solid var(--z-border);border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>

    {{-- Hero --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:24px;box-shadow:var(--z-card-shadow);margin-bottom:20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        @if($carbrand->logo ?? $carbrand->image ?? null)
            <img src="{{ asset('storage/'.($carbrand->logo ?? $carbrand->image)) }}" style="width:90px;height:64px;object-fit:contain;border-radius:12px;border:2px solid var(--z-border);background:var(--z-surface-2);flex-shrink:0;" alt="" />
        @else
            <div style="width:80px;height:80px;border-radius:14px;background:linear-gradient(135deg,#475569,#334155);display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fff;flex-shrink:0;"><i class="fas fa-trademark"></i></div>
        @endif
        <div style="flex:1;min-width:200px;">
            <h2 style="font-size:1.25rem;font-weight:800;color:var(--z-text);margin:0 0 4px;">{{ $carbrand->name_en ?? '—' }}</h2>
            @if($carbrand->name_ar)
            <div style="font-size:0.95rem;color:var(--z-text-muted);direction:rtl;">{{ $carbrand->name_ar }}</div>
            @endif
        </div>
    </div>

    {{-- Details --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);max-width:520px;">
        <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
            <div style="width:32px;height:32px;border-radius:9px;background:rgba(71,85,105,.1);display:flex;align-items:center;justify-content:center;color:#475569;font-size:14px;"><i class="fas fa-info-circle"></i></div>
            <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Details</span>
        </div>
        @php $rows = [
            ['icon'=>'fa-hashtag','color'=>'#94a3b8','label'=>'ID','val'=>'#'.$carbrand->id],
            ['icon'=>'fa-globe','color'=>'#475569','label'=>'Name EN','val'=>$carbrand->name_en ?? $carbrand->name],
            ['icon'=>'fa-language','color'=>'#64748b','label'=>'Name AR','val'=>$carbrand->name_ar,'rtl'=>true],
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
