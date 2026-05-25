@extends('layouts.admin')
@section('content')

<style>
.perm-header {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    color: #fff;
    border-radius: 12px;
    padding: 28px 32px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 16px;
}
.perm-header i { font-size: 32px; opacity: 0.9; }
.perm-header h4 { margin: 0; font-size: 22px; font-weight: 700; }
.perm-header p { margin: 4px 0 0; opacity: 0.75; font-size: 14px; }

.category-card {
    border: 1px solid #e8eaf0;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: box-shadow 0.2s;
}
.category-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.1); }

.category-header {
    background: #f8f9fc;
    border-bottom: 1px solid #e8eaf0;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    user-select: none;
}
.category-header:hover { background: #f0f2f8; }
.category-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 15px;
    color: #1a1a2e;
}
.category-badge {
    background: #0f3460;
    color: #fff;
    border-radius: 20px;
    padding: 2px 10px;
    font-size: 12px;
    font-weight: 600;
}
.category-badge-active {
    background: #198754;
    color: #fff;
    border-radius: 20px;
    padding: 2px 10px;
    font-size: 12px;
    font-weight: 600;
}
.cat-check-all {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #6c757d;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid #dee2e6;
    background: #fff;
    cursor: pointer;
    transition: all 0.15s;
}
.cat-check-all:hover { background: #0f3460; color: #fff; border-color: #0f3460; }

.perm-table {
    width: 100%;
    border-collapse: collapse;
}
.perm-table thead th {
    background: #f0f2f8;
    padding: 10px 16px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    border-bottom: 2px solid #e8eaf0;
    text-align: start;
}
.perm-table tbody tr {
    border-bottom: 1px solid #f0f2f5;
    transition: background 0.15s;
}
.perm-table tbody tr:last-child { border-bottom: none; }
.perm-table tbody tr:hover { background: #fafbff; }
.perm-table tbody tr.has-perm { background: #f0fff4; }
.perm-table tbody tr.has-perm:hover { background: #e6ffee; }
.perm-table td { padding: 12px 16px; vertical-align: middle; }
.perm-table td:first-child { width: 48px; text-align: center; }

.perm-name { font-size: 14px; color: #2d3436; font-weight: 500; }
.perm-key { font-size: 12px; color: #b2bec3; font-family: monospace; margin-top: 2px; }
.perm-checkbox { width: 18px; height: 18px; cursor: pointer; accent-color: #0f3460; }

.form-actions {
    background: #f8f9fc;
    border-radius: 12px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid #e8eaf0;
    margin-top: 8px;
}
.btn-save {
    background: linear-gradient(135deg, #0f3460, #16213e);
    color: #fff;
    border: none;
    padding: 12px 32px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: opacity 0.2s;
}
.btn-save:hover { opacity: 0.9; }
.btn-back {
    color: #6c757d;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    padding: 10px 16px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    background: #fff;
    transition: all 0.15s;
}
.btn-back:hover { background: #f0f2f8; color: #1a1a2e; text-decoration: none; }

.select-all-bar {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    background: #fff8e1;
    border-bottom: 1px solid #ffe082;
    font-size: 13px;
    color: #7c5c00;
}
.select-all-bar button {
    background: #ffc107;
    color: #000;
    border: none;
    padding: 4px 14px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
}
.select-all-bar button:hover { background: #e0a800; }

.stats-bar {
    display: flex;
    gap: 16px;
    padding: 14px 20px;
    background: #e8f4fd;
    border-bottom: 1px solid #bee5fb;
    font-size: 13px;
    color: #0c5460;
    flex-wrap: wrap;
}
.stat-item { display: flex; align-items: center; gap: 6px; font-weight: 600; }
</style>

<div class="card" style="border: none; box-shadow: none; background: transparent;">

    {{-- Page Header --}}
    <div class="perm-header">
        <i class="fas fa-user-shield"></i>
        <div>
            <h4>{{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}: {{ app()->getLocale() == 'ar' ? ($role->title_ar ?? $role->title) : ($role->title_en ?? $role->title) }}</h4>
            <p>{{ trans('cruds.role.description') ?? 'تعديل الصلاحيات المرتبطة بهذا الدور' }}</p>
        </div>
    </div>

    {{-- Stats Bar --}}
    @php $totalAssigned = $role->permissions->count(); @endphp
    <div class="stats-bar">
        <div class="stat-item"><i class="fas fa-check-circle text-success"></i> {{ $totalAssigned }} صلاحية محددة</div>
        <div class="stat-item"><i class="fas fa-list text-primary"></i> {{ \App\Models\Permission::count() }} إجمالي الصلاحيات</div>
        <div class="stat-item"><i class="fas fa-layer-group text-warning"></i> {{ count($result) }} مجموعة</div>
    </div>

    <form method="POST" action="{{ route('admin.roles.update', [$role->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        {{-- Basic Info --}}
        <div class="card" style="border-radius: 12px; border: 1px solid #e8eaf0; margin-bottom: 24px; margin-top: 20px;">
            <div class="card-header" style="background: #f8f9fc; border-bottom: 1px solid #e8eaf0; border-radius: 12px 12px 0 0; font-weight: 700; color: #1a1a2e;">
                <i class="fas fa-info-circle me-2 text-primary"></i> {{ trans('cruds.role.fields.title') }}
            </div>
            <div class="card-body" style="padding: 24px;">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="title">{{ trans('cruds.role.fields.title') }} <span class="text-danger">*</span></label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $role->title) }}" required>
                        @if($errors->has('title'))<div class="invalid-feedback">{{ $errors->first('title') }}</div>@endif
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="title_ar">الاسم بالعربية</label>
                        <input class="form-control {{ $errors->has('title_ar') ? 'is-invalid' : '' }}" type="text" name="title_ar" id="title_ar" value="{{ old('title_ar', $role->title_ar) }}" dir="rtl" placeholder="اسم الدور بالعربية">
                        @if($errors->has('title_ar'))<div class="invalid-feedback">{{ $errors->first('title_ar') }}</div>@endif
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="title_en">Name in English</label>
                        <input class="form-control {{ $errors->has('title_en') ? 'is-invalid' : '' }}" type="text" name="title_en" id="title_en" value="{{ old('title_en', $role->title_en) }}" placeholder="Role name in English">
                        @if($errors->has('title_en'))<div class="invalid-feedback">{{ $errors->first('title_en') }}</div>@endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Select All Bar --}}
        <div class="select-all-bar">
            <i class="fas fa-bolt"></i>
            <span>تحديد سريع:</span>
            <button type="button" onclick="toggleAll(true)"><i class="fas fa-check-double me-1"></i>تحديد الكل</button>
            <button type="button" onclick="toggleAll(false)" style="background:#e0e0e0; color:#333;"><i class="fas fa-times me-1"></i>إلغاء الكل</button>
        </div>

        {{-- Permissions by Category --}}
        @foreach($result as $key => $datas)
        @php
            $catPerms = \App\Models\Permission::where('category', $datas['permissions']['category'])->orderBy('id')->get();
            $catId = 'cat_' . $datas['permissions']['category'];
            $assignedInCat = $catPerms->filter(fn($p) => $role->permissions->contains($p->id))->count();
        @endphp
        <div class="category-card">
            <div class="category-header" onclick="toggleCategory('{{ $catId }}')">
                <div class="category-title">
                    <i class="fas fa-layer-group text-primary"></i>
                    <span>{{ $datas['link_name'] }}</span>
                    <span class="category-badge">{{ $catPerms->count() }}</span>
                    @if($assignedInCat > 0)
                    <span class="category-badge-active"><i class="fas fa-check me-1"></i>{{ $assignedInCat }} محددة</span>
                    @endif
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <button type="button" class="cat-check-all" onclick="event.stopPropagation(); toggleCat('{{ $catId }}', true)">
                        <i class="fas fa-check"></i> تحديد المجموعة
                    </button>
                    <button type="button" class="cat-check-all" onclick="event.stopPropagation(); toggleCat('{{ $catId }}', false)" style="border-color:#dc3545; color:#dc3545;">
                        <i class="fas fa-times"></i> إلغاء
                    </button>
                    <i class="fas fa-chevron-down" id="arrow_{{ $catId }}" style="color:#6c757d; transition: transform 0.2s;"></i>
                </div>
            </div>
            <div id="{{ $catId }}">
                <table class="perm-table">
                    <thead>
                        <tr>
                            <th>✓</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'الصلاحية' : 'Permission' }}</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'المفتاح' : 'Key' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($catPerms as $perm)
                        @php $isChecked = $role->permissions->contains($perm->id); @endphp
                        <tr class="{{ $isChecked ? 'has-perm' : '' }}">
                            <td>
                                <input type="checkbox" name="perm[]" value="{{ $perm->id }}"
                                       class="perm-checkbox cat-perm-{{ $catId }}"
                                       id="perm_{{ $perm->id }}"
                                       {{ $isChecked ? 'checked' : '' }}>
                            </td>
                            <td>
                                <label for="perm_{{ $perm->id }}" style="cursor:pointer; margin:0;">
                                    <div class="perm-name">{{ app()->getLocale() == 'ar' ? $perm->name_ar : $perm->name_en }}</div>
                                </label>
                            </td>
                            <td><span class="perm-key">{{ $perm->title }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach

        {{-- Actions --}}
        <div class="form-actions">
            <a href="{{ route('admin.roles.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> {{ trans('global.back_to_list') }}
            </a>
            <button class="btn-save" type="submit">
                <i class="fas fa-save"></i> {{ trans('global.save') }}
            </button>
        </div>

    </form>
</div>

<script>
function toggleCategory(catId) {
    const el = document.getElementById(catId);
    const arrow = document.getElementById('arrow_' + catId);
    if (el.style.display === 'none') {
        el.style.display = 'block';
        if (arrow) arrow.style.transform = 'rotate(0deg)';
    } else {
        el.style.display = 'none';
        if (arrow) arrow.style.transform = 'rotate(-90deg)';
    }
}
function toggleCat(catId, state) {
    document.querySelectorAll('.cat-perm-' + catId).forEach(cb => cb.checked = state);
}
function toggleAll(state) {
    document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = state);
}
</script>

@endsection
