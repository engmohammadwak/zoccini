@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#d97706,#b45309);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(217,119,6,.3);">
                <i class="fas fa-hamburger"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;line-height:1.2;">{{ trans('global.show') }} {{ trans('cruds.item.title_singular') }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <a href="{{ route('admin.items.index') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('cruds.item.title') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <span>{{ $item->name_en ?? '#'.$item->id }}</span>
                </nav>
            </div>
        </div>
        <div style="display:flex;gap:8px;">
            @can('item_edit')
            <a href="{{ route('admin.items.edit',$item->id) }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(245,158,11,.12);color:#b45309;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;"
               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.12)'">
                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
            </a>
            @endcan
            <a href="{{ route('admin.items.index') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--z-surface-2);color:var(--z-text-muted);border:1px solid var(--z-border);border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>

    {{-- Hero Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:24px;box-shadow:var(--z-card-shadow);margin-bottom:20px;display:flex;align-items:flex-start;gap:22px;flex-wrap:wrap;">
        {{-- Item Image --}}
        @if($item->image)
            <img src="{{ asset('storage/'.$item->image) }}" style="width:110px;height:110px;border-radius:16px;object-fit:cover;border:2px solid var(--z-border);flex-shrink:0;" alt="" />
        @else
            <div style="width:110px;height:110px;border-radius:16px;background:linear-gradient(135deg,#d97706,#b45309);display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:#fff;flex-shrink:0;box-shadow:0 4px 14px rgba(217,119,6,.3);"><i class="fas fa-hamburger"></i></div>
        @endif
        <div style="flex:1;min-width:200px;">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:5px;">
                <h2 style="font-size:1.3rem;font-weight:800;color:var(--z-text);margin:0;">{{ $item->name_en }}</h2>
                @if($item->name_ar)
                <span style="font-size:1rem;color:var(--z-text-muted);font-weight:600;direction:rtl;">{{ $item->name_ar }}</span>
                @endif
                {{-- Status --}}
                @if($item->status == 1)
                <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 12px;border-radius:999px;font-weight:700;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>{{ trans('global.active') ?? 'Active' }}
                </span>
                @else
                <span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 12px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                </span>
                @endif
                {{-- Featured --}}
                @if($item->is_featured ?? 0)
                <span style="background:rgba(245,158,11,.12);color:#92400e;padding:4px 12px;border-radius:999px;font-weight:700;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <i class="fas fa-star" style="font-size:0.65rem;"></i>Featured
                </span>
                @endif
            </div>
            {{-- Price --}}
            <div style="display:inline-flex;align-items:center;gap:8px;margin:8px 0 10px;padding:8px 16px;background:rgba(217,119,6,.08);border-radius:10px;border:1px solid rgba(217,119,6,.15);">
                <i class="fas fa-tag" style="color:#d97706;"></i>
                <span style="font-size:1.2rem;font-weight:800;color:#92400e;font-variant-numeric:tabular-nums;">{{ number_format($item->price ?? 0,2) }}</span>
            </div>
            {{-- Description --}}
            @if($item->description_en)
            <p style="font-size:0.85rem;color:var(--z-text-muted);margin:0;line-height:1.6;">{{ $item->description_en }}</p>
            @endif
            @if($item->description_ar)
            <p style="font-size:0.85rem;color:var(--z-text-muted);margin:6px 0 0;line-height:1.6;direction:rtl;text-align:right;">{{ $item->description_ar }}</p>
            @endif
        </div>
    </div>

    {{-- Info Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;">

        {{-- Details Card --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(217,119,6,.1);display:flex;align-items:center;justify-content:center;color:#d97706;font-size:14px;"><i class="fas fa-info-circle"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('global.details') ?? 'Details' }}</span>
            </div>
            @php $rows = [
                ['icon'=>'fa-hashtag','color'=>'#94a3b8','label'=>trans('cruds.item.fields.id'),'val'=>'#'.$item->id],
                ['icon'=>'fa-globe','color'=>'#d97706','label'=>trans('cruds.item.fields.name'),'val'=>$item->name_en],
                ['icon'=>'fa-language','color'=>'#f59e0b','label'=>trans('cruds.item.fields.name_ar'),'val'=>$item->name_ar,'rtl'=>true],
                ['icon'=>'fa-tag','color'=>'#10b981','label'=>trans('cruds.item.fields.price'),'val'=>number_format($item->price??0,2)],
                ['icon'=>'fa-layer-group','color'=>'#7c3aed','label'=>trans('cruds.item.fields.category')??'Category','val'=>optional($item->category)->name_en],
            ]; @endphp
            @foreach($rows as $row)
            @if($row['val'])
            <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:12px;">
                <i class="fas {{ $row['icon'] }}" style="color:{{ $row['color'] }};width:14px;margin-top:2px;flex-shrink:0;"></i>
                <div>
                    <div style="font-size:0.7rem;color:var(--z-text-faint);font-weight:600;">{{ $row['label'] }}</div>
                    <div style="font-size:0.85rem;color:var(--z-text);font-weight:600;{{ ($row['rtl']??false)?'direction:rtl;':'' }}">{{ $row['val'] }}</div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        {{-- Restaurant Card --}}
        @if(optional($item->restaurant)->name_en)
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(239,68,68,.1);display:flex;align-items:center;justify-content:center;color:#dc2626;font-size:14px;"><i class="fas fa-store"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.item.fields.restaurant') ?? 'Restaurant' }}</span>
            </div>
            <div style="display:flex;align-items:center;gap:11px;">
                @if(optional($item->restaurant)->logo)
                <img src="{{ asset('storage/'.$item->restaurant->logo) }}" style="width:46px;height:46px;border-radius:12px;object-fit:cover;border:1px solid var(--z-border);" alt="" loading="lazy">
                @else
                <div style="width:46px;height:46px;border-radius:12px;background:rgba(239,68,68,.1);display:flex;align-items:center;justify-content:center;color:#dc2626;font-size:18px;"><i class="fas fa-store"></i></div>
                @endif
                <div>
                    <div style="font-weight:700;color:var(--z-text);font-size:0.9rem;">{{ $item->restaurant->name_en }}</div>
                    @if(optional($item->restaurant)->name_ar)
                    <div style="font-size:0.78rem;color:var(--z-text-muted);direction:rtl;">{{ $item->restaurant->name_ar }}</div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Extras / Add-ons Card --}}
        @if($item->extras && $item->extras->count())
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(6,182,212,.1);display:flex;align-items:center;justify-content:center;color:#06b6d4;font-size:14px;"><i class="fas fa-plus-circle"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Extras <span style="background:rgba(6,182,212,.12);color:#0e7490;padding:1px 7px;border-radius:8px;margin-left:4px;">{{ $item->extras->count() }}</span></span>
            </div>
            @foreach($item->extras as $extra)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:6px 0;{{ !$loop->last?'border-bottom:1px solid var(--z-border);':'' }}">
                <div style="font-size:0.83rem;font-weight:600;color:var(--z-text);">{{ $extra->name_en ?? $extra->name ?? '' }}</div>
                @if($extra->price ?? false)
                <span style="background:rgba(217,119,6,.1);color:#92400e;padding:2px 8px;border-radius:7px;font-size:0.78rem;font-weight:700;">+{{ number_format($extra->price,2) }}</span>
                @endif
            </div>
            @endforeach
        </div>
        @endif

    </div>

</div>
@endsection
