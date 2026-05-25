@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#f43f5e,#fb7185);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(244,63,94,.3);">
                <i class="fas fa-store"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;line-height:1.2;">{{ trans('global.show') }} {{ trans('cruds.restaurant.title') }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <a href="{{ route('admin.restaurants.index') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('cruds.restaurant.title') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <span>{{ $restaurant->name_en }}</span>
                </nav>
            </div>
        </div>
        <div style="display:flex;gap:8px;">
            @can('restaurant_edit')
            <a href="{{ route('admin.restaurants.edit',$restaurant->id) }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(245,158,11,.12);color:#b45309;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;transition:background .18s;"
               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.12)'">
                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
            </a>
            @endcan
            <a href="{{ route('admin.restaurants.index') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--z-surface-2);color:var(--z-text-muted);border:1px solid var(--z-border);border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>

    {{-- Hero Card: Logo + Main Info --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:22px 24px;box-shadow:var(--z-card-shadow);margin-bottom:20px;display:flex;align-items:flex-start;gap:20px;flex-wrap:wrap;">
        {{-- Logo --}}
        @if($restaurant->image)
            <img src="{{ $restaurant->image_url }}" style="width:90px;height:90px;border-radius:16px;object-fit:cover;border:1px solid var(--z-border);flex-shrink:0;" alt="" />
        @else
            <div style="width:90px;height:90px;border-radius:16px;background:rgba(244,63,94,.1);display:flex;align-items:center;justify-content:center;color:#f43f5e;font-size:30px;flex-shrink:0;"><i class="fas fa-store"></i></div>
        @endif
        <div style="flex:1;min-width:200px;">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:6px;">
                <h2 style="font-size:1.3rem;font-weight:800;color:var(--z-text);margin:0;">{{ $restaurant->name_en }}</h2>
                <span style="font-size:0.9rem;color:var(--z-text-muted);">/ {{ $restaurant->name_ar }}</span>
                {{-- Status badge --}}
                @if($restaurant->status == 1)
                <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 12px;border-radius:999px;font-weight:700;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>{{ trans('global.active') ?? 'Active' }}
                </span>
                @else
                <span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 12px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                </span>
                @endif
                {{-- Featured --}}
                @if($restaurant->is_featured)
                <span style="background:rgba(245,158,11,.12);color:#b45309;padding:4px 12px;border-radius:999px;font-weight:700;font-size:0.75rem;">
                    <i class="fas fa-star" style="font-size:0.65rem;margin-right:3px;"></i>Featured
                </span>
                @endif
                {{-- Open Now --}}
                @if($restaurant->is_open)
                <span style="background:rgba(59,130,246,.12);color:#1d4ed8;padding:4px 12px;border-radius:999px;font-weight:700;font-size:0.75rem;">
                    <i class="fas fa-door-open" style="font-size:0.65rem;margin-right:3px;"></i>Open
                </span>
                @endif
            </div>
            {{-- Quick stats row --}}
            <div style="display:flex;gap:18px;flex-wrap:wrap;margin-top:10px;">
                @if($restaurant->rating)
                <div style="display:flex;align-items:center;gap:5px;font-size:0.82rem;color:var(--z-text-muted);">
                    <i class="fas fa-star" style="color:#f59e0b;"></i>
                    <span style="font-weight:700;color:var(--z-text);">{{ number_format($restaurant->rating,1) }}</span> Rating
                </div>
                @endif
                @if($restaurant->mins)
                <div style="display:flex;align-items:center;gap:5px;font-size:0.82rem;color:var(--z-text-muted);">
                    <i class="fas fa-clock" style="color:#3b82f6;"></i>
                    <span style="font-weight:700;color:var(--z-text);">{{ $restaurant->mins }}</span> mins
                </div>
                @endif
                @if($restaurant->city)
                <div style="display:flex;align-items:center;gap:5px;font-size:0.82rem;color:var(--z-text-muted);">
                    <i class="fas fa-map-marker-alt" style="color:#f43f5e;"></i>
                    {{ optional($restaurant->city)->name_en ?? optional($restaurant->city)->name_ar }}
                </div>
                @endif
            </div>
            @if($restaurant->description_en || $restaurant->description_ar)
            <p style="font-size:0.83rem;color:var(--z-text-muted);margin-top:10px;max-width:600px;">{{ $restaurant->description_en ?? $restaurant->description_ar }}</p>
            @endif
        </div>
    </div>

    {{-- 2 column: Owner Info + Details --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">

        {{-- Owner --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(59,130,246,.1);display:flex;align-items:center;justify-content:center;color:#3b82f6;font-size:14px;"><i class="fas fa-user-tie"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('global.owner') ?? 'Owner Info' }}</span>
            </div>
            <div style="display:flex;align-items:center;gap:11px;margin-bottom:12px;">
                <div style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:800;color:#fff;">{{ strtoupper(substr(optional($restaurant->restaurant)->name ?? 'R',0,1)) }}</div>
                <div>
                    <div style="font-weight:700;color:var(--z-text);font-size:0.9rem;">{{ optional($restaurant->restaurant)->name }} {{ optional($restaurant->restaurant)->last_name }}</div>
                    <div style="font-size:0.75rem;color:var(--z-text-faint);">{{ optional(optional($restaurant->restaurant)->status)->name_ar }}</div>
                </div>
            </div>
            @if(optional($restaurant->restaurant)->phone)
            <div style="font-size:0.82rem;color:var(--z-text-muted);display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                <i class="fas fa-phone" style="color:var(--z-primary);width:14px;"></i> {{ $restaurant->restaurant->phone }}
            </div>
            @endif
            @if(optional($restaurant->restaurant)->email)
            <div style="font-size:0.82rem;color:var(--z-text-muted);display:flex;align-items:center;gap:8px;">
                <i class="fas fa-envelope" style="color:var(--z-primary);width:14px;"></i> {{ $restaurant->restaurant->email }}
            </div>
            @endif
        </div>

        {{-- Details --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(244,63,94,.1);display:flex;align-items:center;justify-content:center;color:#f43f5e;font-size:14px;"><i class="fas fa-info-circle"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('global.details') ?? 'Details' }}</span>
            </div>
            @php $rows = [
                ['icon'=>'fa-map-marker-alt','color'=>'#f43f5e','label'=>trans('cruds.restaurant.fields.address'),'val'=>$restaurant->address],
                ['icon'=>'fa-city','color'=>'#3b82f6','label'=>trans('cruds.restaurant.fields.country'),'val'=>optional($restaurant->country)->name],
                ['icon'=>'fa-clock','color'=>'#f59e0b','label'=>trans('cruds.restaurant.fields.open_time').' / '.trans('cruds.restaurant.fields.close_time'),'val'=>($restaurant->open_time && $restaurant->close_time) ? $restaurant->open_time.' – '.$restaurant->close_time : null],
                ['icon'=>'fa-hourglass-half','color'=>'#6366f1','label'=>trans('cruds.restaurant.fields.min_waiting').' / '.trans('cruds.restaurant.fields.max_waiting'),'val'=>($restaurant->min_waiting && $restaurant->max_waiting) ? $restaurant->min_waiting.' – '.$restaurant->max_waiting.' min' : null],
                ['icon'=>'fa-users','color'=>'#10b981','label'=>trans('cruds.restaurant.fields.number_of_employees'),'val'=>$restaurant->number_of_employees],
                ['icon'=>'fa-code-branch','color'=>'#8b5cf6','label'=>trans('cruds.restaurant.fields.number_branches'),'val'=>$restaurant->number_branches],
            ]; @endphp
            @foreach($rows as $row)
            @if($row['val'])
            <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:9px;">
                <i class="fas {{ $row['icon'] }}" style="color:{{ $row['color'] }};width:14px;margin-top:2px;flex-shrink:0;"></i>
                <div>
                    <div style="font-size:0.7rem;color:var(--z-text-faint);font-weight:600;">{{ $row['label'] }}</div>
                    <div style="font-size:0.83rem;color:var(--z-text);font-weight:600;">{{ $row['val'] }}</div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    {{-- Tags / Payment Methods / Sitting Areas --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;margin-bottom:20px;">

        {{-- Payment Methods --}}
        @if($restaurant->payment_methods->count())
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:18px 20px;box-shadow:var(--z-card-shadow);">
            <div style="font-size:0.75rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px;"><i class="fas fa-credit-card" style="color:#3b82f6;margin-right:6px;"></i>{{ trans('cruds.restaurant.fields.payment_methods') }}</div>
            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                @foreach($restaurant->payment_methods as $pm)
                <span style="background:rgba(59,130,246,.1);color:#1d4ed8;padding:4px 12px;border-radius:999px;font-size:0.78rem;font-weight:600;">{{ $pm->name_ar }}</span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Sitting Areas --}}
        @if($restaurant->sitting_areas->count())
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:18px 20px;box-shadow:var(--z-card-shadow);">
            <div style="font-size:0.75rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px;"><i class="fas fa-chair" style="color:#8b5cf6;margin-right:6px;"></i>{{ trans('cruds.restaurant.fields.sitting_area') }}</div>
            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                @foreach($restaurant->sitting_areas as $sa)
                <span style="background:rgba(139,92,246,.1);color:#6d28d9;padding:4px 12px;border-radius:999px;font-size:0.78rem;font-weight:600;">{{ $sa->name_ar }}</span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Tag --}}
        @if($restaurant->tag)
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:18px 20px;box-shadow:var(--z-card-shadow);">
            <div style="font-size:0.75rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px;"><i class="fas fa-tag" style="color:#f43f5e;margin-right:6px;"></i>{{ trans('cruds.restaurant.fields.tag') }}</div>
            <span style="background:rgba(244,63,94,.1);color:#be185d;padding:5px 14px;border-radius:999px;font-size:0.82rem;font-weight:600;">{{ $restaurant->tag }}</span>
        </div>
        @endif

    </div>

    {{-- Documents --}}
    @if($restaurant->commercial_registration_image || $restaurant->identity_card_image || $restaurant->company_seal)
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
        <div style="font-size:0.75rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:14px;">
            <i class="fas fa-file-alt" style="color:#64748b;margin-right:6px;"></i>{{ trans('global.documents') ?? 'Documents' }}
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            @if($restaurant->commercial_registration_image)
            <a href="{{ $restaurant->commercial_registration_image_url }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:rgba(59,130,246,.08);color:#1d4ed8;border-radius:10px;font-size:0.8rem;font-weight:600;text-decoration:none;border:1px solid rgba(59,130,246,.2);">
                <i class="fas fa-file-invoice"></i> {{ trans('cruds.restaurant.fields.commercial_registration_image') }}
            </a>
            @endif
            @if($restaurant->identity_card_image)
            <a href="{{ $restaurant->identity_card_image_url }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:rgba(99,102,241,.08);color:#4338ca;border-radius:10px;font-size:0.8rem;font-weight:600;text-decoration:none;border:1px solid rgba(99,102,241,.2);">
                <i class="fas fa-id-card"></i> {{ trans('cruds.restaurant.fields.identity_card_image') }}
            </a>
            @endif
            @if($restaurant->company_seal)
            <a href="{{ $restaurant->company_seal_url }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:rgba(16,185,129,.08);color:#065f46;border-radius:10px;font-size:0.8rem;font-weight:600;text-decoration:none;border:1px solid rgba(16,185,129,.2);">
                <i class="fas fa-stamp"></i> {{ trans('cruds.restaurant.fields.company_seal') }}
            </a>
            @endif
        </div>
    </div>
    @endif

</div>
@endsection
