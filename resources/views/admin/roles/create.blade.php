@extends('layouts.admin')
@section('content')

<style>
.perm-header {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    color: #fff;
    border-radius: 14px;
    padding: 28px 32px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 24px rgba(15,52,96,0.18);
}
.perm-header i { font-size: 34px; opacity: 0.9; }
.perm-header h4 { margin: 0; font-size: 22px; font-weight: 700; }
.perm-header p { margin: 4px 0 0; opacity: 0.72; font-size: 14px; }

.category-card {
    border: 1px solid #e4e8f0;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: box-shadow 0.2s;
}
.category-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,0.09); }

.category-header {
    background: linear-gradient(90deg, #f4f6fb 0%, #eef1f8 100%);
    border-bottom: 1px solid #e4e8f0;
    padding: 13px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    user-select: none;
}
.category-header:hover { background: linear-gradient(90deg, #eaeff8, #e2e8f5); }
.category-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 14.5px;
    color: #1a1a2e;
}
.category-badge {
    background: #0f3460;
    color: #fff;
    border-radius: 20px;
    padding: 2px 10px;
    font-size: 11.5px;
    font-weight: 600;
}
.cat-btn {
    font-size: 12px;
    padding: 4px 11px;
    border-radius: 6px;
    border: 1px solid #d0d5e0;
    background: #fff;
    color: #555;
    cursor: pointer;
    transition: all 0.15s;
    display: flex;
    align-items: center;
    gap: 4px;
}
.cat-btn:hover { background: #0f3460; color: #fff; border-color: #0f3460; }
.cat-btn.danger:hover { background: #dc3545; color: #fff; border-color: #dc3545; }

.perm-table { width: 100%; border-collapse: collapse; }
.perm-table thead th {
    background: #f8f9fd;
    padding: 9px 16px;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #7a8099;
    border-bottom: 2px solid #e4e8f0;
    text-align: start;
}
.perm-table tbody tr {
    border-bottom: 1px solid #f0f2f7;
    transition: background 0.12s;
}
.perm-table tbody tr:last-child { border-bottom: none; }
.perm-table tbody tr:hover { background: #f5f7ff; }
.perm-table td { padding: 10px 16px; vertical-align: middle; }
.perm-table td:first-child { width: 46px; text-align: center; }
.perm-table td:last-child { width: 220px; }

.perm-name { font-size: 13.5px; color: #2d3436; font-weight: 500; }
.perm-key {
    font-size: 11.5px;
    color: #b0b8cc;
    font-family: 'Courier New', monospace;
    background: #f4f6fb;
    padding: 2px 7px;
    border-radius: 4px;
    border: 1px solid #e4e8f0;
}
.perm-checkbox {
    width: 17px; height: 17px;
    cursor: pointer;
    accent-color: #0f3460;
}

/* Checked row highlight */
.perm-table tbody tr:has(.perm-checkbox:checked) {
    background: #eef3ff;
}

.select-all-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 20px;
    background: #fffde7;
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
    display: flex;
    align-items: center;
    gap: 5px;
    transition: background 0.15s;
}
.select-all-bar button:hover { background: #e0a800; }
.select-all-bar .btn-clear { background: #e0e0e0; color: #333; }
.select-all-bar .btn-clear:hover { background: #bdbdbd; }

.form-actions {
    background: #f8f9fc;
    border-radius: 12px;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid #e4e8f0;
    margin-top: 8px;
}
.btn-save {
    background: linear-gradient(135deg, #0f3460, #16213e);
    color: #fff;
    border: none;
    padding: 11px 32px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: opacity 0.2s, transform 0.1s;
}
.btn-save:hover { opacity: 0.88; transform: translateY(-1px); }
.btn-back {
    color: #6c757d;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    padding: 10px 18px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    background: #fff;
    transition: all 0.15s;
}
.btn-back:hover { background: #f0f2f8; color: #1a1a2e; text-decoration: none; }

.selected-count {
    font-size: 13px;
    color: #0f3460;
    font-weight: 600;
    background: #e8eeff;
    padding: 6px 14px;
    border-radius: 20px;
    display: none;
}
</style>

<div class="card" style="border:none; box-shadow:none; background:transparent;">

    <div class="perm-header">
        <i class="fas fa-shield-alt"></i>
        <div>
            <h4>{{ trans('global.create') }} {{ trans('cruds.role.title_singular') }}</h4>
            <p>{{ trans('cruds.role.description') ?? 'تحديد الصلاحيات المرتبطة بهذا الدور' }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.roles.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Basic Info --}}
        <div class="card" style="border-radius:12px; border:1px solid #e4e8f0; margin-bottom:20px;">
            <div class="card-header" style="background:#f8f9fc; border-bottom:1px solid #e4e8f0; border-radius:12px 12px 0 0; font-weight:700; color:#1a1a2e;">
                <i class="fas fa-info-circle me-2 text-primary"></i> معلومات الدور
            </div>
            <div class="card-body" style="padding:22px 24px;">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="title">{{ trans('cruds.role.fields.title') }} <span class="text-danger">*</span></label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="role_key_name">
                        @if($errors->has('title'))<div class="invalid-feedback">{{ $errors->first('title') }}</div>@endif
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="title_ar">الاسم بالعربية</label>
                        <input class="form-control" type="text" name="title_ar" id="title_ar" value="{{ old('title_ar') }}" dir="rtl" placeholder="اسم الدور بالعربية">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="title_en">Name in English</label>
                        <input class="form-control" type="text" name="title_en" id="title_en" value="{{ old('title_en') }}" placeholder="Role name in English">
                    </div>
                </div>
            </div>
        </div>

        {{-- Select All Bar --}}
        <div class="select-all-bar">
            <i class="fas fa-bolt"></i>
            <span>تحديد سريع:</span>
            <button type="button" onclick="toggleAll(true)"><i class="fas fa-check-double"></i> تحديد الكل</button>
            <button type="button" class="btn-clear" onclick="toggleAll(false)"><i class="fas fa-times"></i> إلغاء الكل</button>
            <span class="selected-count" id="selectedCount">0 صلاحية محددة</span>
        </div>

        {{-- Permissions by Category --}}
        @foreach($result as $index => $data)
        @php $catId = 'cat_' . $data['category_id']; @endphp
        <div class="category-card">
            <div class="category-header" onclick="toggleCategory('{{ $catId }}')">
                <div class="category-title">
                    <i class="fas fa-layer-group" style="color:#0f3460;"></i>
                    <span>{{ $data['link_name'] }}</span>
                    <span class="category-badge">{{ $data['permissions']->count() }} صلاحية</span>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <button type="button" class="cat-btn" onclick="event.stopPropagation(); toggleCat('{{ $catId }}', true)">
                        <i class="fas fa-check-square"></i> تحديد الكل
                    </button>
                    <button type="button" class="cat-btn danger" onclick="event.stopPropagation(); toggleCat('{{ $catId }}', false)">
                        <i class="fas fa-square"></i> إلغاء الكل
                    </button>
                    <i class="fas fa-chevron-down" id="arrow_{{ $catId }}" style="color:#9aa3b5; transition:transform 0.25s;"></i>
                </div>
            </div>
            <div id="{{ $catId }}">
                <table class="perm-table">
                    <thead>
                        <tr>
                            <th>✓</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'الصلاحية' : 'Permission' }}</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'المفتاح التقني' : 'Key' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['permissions'] as $perm)
                        <tr>
                            <td>
                                <input type="checkbox"
                                       name="perm[]"
                                       value="{{ $perm->id }}"
                                       class="perm-checkbox cat-perm-{{ $catId }}"
                                       id="perm_{{ $perm->id }}"
                                       {{ in_array($perm->id, old('perm', [])) ? 'checked' : '' }}
                                       onchange="updateCount()">
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
    const isHidden = el.style.display === 'none';
    el.style.display = isHidden ? 'block' : 'none';
    if (arrow) arrow.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(-90deg)';
}
function toggleCat(catId, state) {
    document.querySelectorAll('.cat-perm-' + catId).forEach(cb => { cb.checked = state; });
    updateCount();
}
function toggleAll(state) {
    document.querySelectorAll('.perm-checkbox').forEach(cb => { cb.checked = state; });
    updateCount();
}
function updateCount() {
    const count = document.querySelectorAll('.perm-checkbox:checked').length;
    const el = document.getElementById('selectedCount');
    el.textContent = count + ' صلاحية محددة';
    el.style.display = count > 0 ? 'inline-flex' : 'none';
}
</script>

@endsection
