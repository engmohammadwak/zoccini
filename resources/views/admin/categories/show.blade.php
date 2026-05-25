@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#5b21b6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(124,58,237,.3);">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;line-height:1.2;">{{ trans('global.show') }} {{ trans('cruds.category.title_singular') }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <a href="{{ route('admin.categories.index') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('cruds.category.title') }}</a>
                    <span style="margin:0 5px;">›</span>
                    <span>{{ $category->name_en ?? '#'.$category->id }}</span>
                </nav>
            </div>
        </div>
        <div style="display:flex;gap:8px;">
            @can('category_edit')
            <a href="{{ route('admin.categories.edit',$category->id) }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(245,158,11,.12);color:#b45309;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;"
               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.12)'">
                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
            </a>
            @endcan
            <a href="{{ route('admin.categories.index') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--z-surface-2);color:var(--z-text-muted);border:1px solid var(--z-border);border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>

    {{-- Hero Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:24px;box-shadow:var(--z-card-shadow);margin-bottom:20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        @if($category->image)
            <img src="{{ asset('storage/'.$category->image) }}" style="width:80px;height:80px;border-radius:14px;object-fit:cover;border:2px solid var(--z-border);flex-shrink:0;" alt="" />
        @else
            <div style="width:80px;height:80px;border-radius:14px;background:linear-gradient(135deg,#7c3aed,#5b21b6);display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fff;flex-shrink:0;box-shadow:0 4px 14px rgba(124,58,237,.3);"><i class="fas fa-layer-group"></i></div>
        @endif
        <div style="flex:1;min-width:200px;">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:6px;">
                <h2 style="font-size:1.25rem;font-weight:800;color:var(--z-text);margin:0;">{{ $category->name_en }}</h2>
                @if($category->name_ar)
                <span style="font-size:1rem;color:var(--z-text-muted);font-weight:600;direction:rtl;">{{ $category->name_ar }}</span>
                @endif
                {{-- Status badge --}}
                @if($category->status == 1)
                <span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 12px;border-radius:999px;font-weight:700;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span>{{ trans('global.active') ?? 'Active' }}
                </span>
                @else
                <span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 12px;border-radius:999px;font-weight:600;font-size:0.75rem;display:inline-flex;align-items:center;gap:5px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span>{{ trans('global.inactive') ?? 'Inactive' }}
                </span>
                @endif
            </div>
            {{-- Parent breadcrumb --}}
            @if($category->parent_id)
            <div style="display:flex;align-items:center;gap:6px;font-size:0.82rem;color:var(--z-text-muted);">
                <i class="fas fa-level-up-alt" style="color:#7c3aed;"></i>
                <span>Sub-category of:</span>
                <span style="font-weight:700;color:#7c3aed;">{{ optional($category->parent)->name_en ?? '—' }}</span>
            </div>
            @else
            <div style="display:inline-flex;align-items:center;gap:6px;font-size:0.78rem;color:var(--z-text-muted);background:rgba(148,163,184,.1);padding:3px 10px;border-radius:8px;">
                <i class="fas fa-folder" style="color:#6366f1;"></i> Root Category
            </div>
            @endif
        </div>
    </div>

    {{-- Info Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;">

        {{-- Details Card --}}
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(124,58,237,.1);display:flex;align-items:center;justify-content:center;color:#7c3aed;font-size:14px;"><i class="fas fa-info-circle"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('global.details') ?? 'Details' }}</span>
            </div>
            @php $rows = [
                ['icon'=>'fa-hashtag','color'=>'#94a3b8','label'=>trans('cruds.category.fields.id'),'val'=>'#'.$category->id],
                ['icon'=>'fa-globe','color'=>'#7c3aed','label'=>trans('cruds.category.fields.name_en'),'val'=>$category->name_en],
                ['icon'=>'fa-language','color'=>'#6366f1','label'=>trans('cruds.category.fields.name_ar'),'val'=>$category->name_ar,'rtl'=>true],
                ['icon'=>'fa-folder','color'=>'#10b981','label'=>'Parent','val'=>optional($category->parent)->name_en ?? ($category->parent_id ? '#'.$category->parent_id : 'Root')],
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

        {{-- Restaurant Card (if user is not type 3) --}}
        @if(\Illuminate\Support\Facades\Auth::user()['user_type'] != 3 && optional($category->restaurant)->name_en)
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(239,68,68,.1);display:flex;align-items:center;justify-content:center;color:#dc2626;font-size:14px;"><i class="fas fa-store"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.category.fields.restaurant') }}</span>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                @if(optional($category->restaurant)->logo)
                <img src="{{ asset('storage/'.$category->restaurant->logo) }}" style="width:40px;height:40px;border-radius:10px;object-fit:cover;border:1px solid var(--z-border);" alt="" loading="lazy">
                @else
                <div style="width:40px;height:40px;border-radius:10px;background:rgba(239,68,68,.1);display:flex;align-items:center;justify-content:center;color:#dc2626;"><i class="fas fa-store"></i></div>
                @endif
                <div>
                    <div style="font-weight:700;color:var(--z-text);font-size:0.88rem;">{{ $category->restaurant->name_en }}</div>
                    @if(optional($category->restaurant)->name_ar)
                    <div style="font-size:0.78rem;color:var(--z-text-muted);direction:rtl;">{{ $category->restaurant->name_ar }}</div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Sub-categories Card --}}
        @if($category->children && $category->children->count())
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;padding:20px 22px;box-shadow:var(--z-card-shadow);">
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--z-border);">
                <div style="width:32px;height:32px;border-radius:9px;background:rgba(99,102,241,.1);display:flex;align-items:center;justify-content:center;color:#6366f1;font-size:14px;"><i class="fas fa-sitemap"></i></div>
                <span style="font-size:0.78rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">Sub-categories <span style="background:rgba(99,102,241,.12);color:#4f46e5;padding:1px 7px;border-radius:8px;margin-left:4px;">{{ $category->children->count() }}</span></span>
            </div>
            @foreach($category->children as $child)
            <div style="display:flex;align-items:center;gap:9px;padding:7px 0;{{ !$loop->last ? 'border-bottom:1px solid var(--z-border);' : '' }}">
                @if($child->image)
                <img src="{{ asset('storage/'.$child->image) }}" style="width:28px;height:28px;border-radius:7px;object-fit:cover;" alt="" loading="lazy">
                @else
                <div style="width:28px;height:28px;border-radius:7px;background:rgba(124,58,237,.1);display:flex;align-items:center;justify-content:center;color:#7c3aed;font-size:11px;"><i class="fas fa-layer-group"></i></div>
                @endif
                <div style="font-size:0.83rem;font-weight:600;color:var(--z-text);">{{ $child->name_en }}</div>
                @if($child->status==1)<span style="margin-left:auto;background:rgba(16,185,129,.1);color:#065f46;padding:2px 8px;border-radius:6px;font-size:0.7rem;font-weight:700;">Active</span>@endif
            </div>
            @endforeach
        </div>
        @endif

    </div>

</div>
@endsection
