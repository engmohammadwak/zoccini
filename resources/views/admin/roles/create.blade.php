@extends('layouts.admin')
@section('content')
<style>
/* ===== PAGE HEADER ===== */
.role-header {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
    color: #fff;
    border-radius: 14px;
    padding: 26px 30px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 6px 28px rgba(15,52,96,.22);
}
.role-header i { font-size: 32px; opacity: .88; }
.role-header h4 { margin: 0; font-size: 20px; font-weight: 700; }
.role-header p  { margin: 3px 0 0; opacity: .65; font-size: 13px; }

/* ===== QUICK BAR ===== */
.quick-bar {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 18px;
    background: #fffde7;
    border: 1px solid #ffe082;
    border-radius: 10px;
    margin-bottom: 18px;
    font-size: 13px; color: #7c5c00;
    flex-wrap: wrap;
}
.qbtn {
    border: none; padding: 5px 14px; border-radius: 6px;
    font-size: 12px; font-weight: 700; cursor: pointer;
    display: inline-flex; align-items: center; gap: 5px;
    transition: background .15s;
}
.qbtn-all  { background:#ffc107; color:#000; }
.qbtn-all:hover  { background:#e0a800; }
.qbtn-none { background:#e0e0e0; color:#333; }
.qbtn-none:hover { background:#bdbdbd; }
.sel-counter {
    margin-left: auto;
    background: #fff3cd; border: 1px solid #ffe082;
    border-radius: 20px; padding: 3px 13px;
    font-weight: 700; color: #7c5c00; font-size: 12px;
}

/* ===== CATEGORY CARD ===== */
.cat-card {
    border: 1px solid #d8dde8;
    border-radius: 12px; overflow: hidden;
    margin-bottom: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    background: #fff;
}
.cat-head {
    background: linear-gradient(90deg,#eef1f8,#e6eaf5);
    border-bottom: 1px solid #d8dde8;
    padding: 12px 18px;
    display: flex; align-items: center; justify-content: space-between;
    cursor: pointer; user-select: none;
}
.cat-head:hover { background: linear-gradient(90deg,#e2e8f4,#dae0f0); }
.cat-title {
    display: flex; align-items: center; gap: 9px;
    font-weight: 700; font-size: 14px; color: #1a1a2e;
}
.cat-badge {
    background: #0f3460; color: #fff;
    border-radius: 20px; padding: 2px 10px;
    font-size: 11px; font-weight: 600;
}
.cat-actions { display: flex; gap: 7px; align-items: center; }
.cbtn {
    font-size: 11.5px; padding: 3px 10px; border-radius: 6px;
    border: 1px solid #c8cedc; background: #fff; color: #444;
    cursor: pointer; transition: all .15s;
    display: inline-flex; align-items: center; gap: 4px;
}
.cbtn:hover { background: #0f3460; color: #fff; border-color: #0f3460; }
.cbtn.red:hover { background: #dc3545; color: #fff; border-color: #dc3545; }
.cat-arrow { color: #aab0c0; font-size: 13px; transition: transform .25s; }

/* ===== PERMISSION TABLE ===== */
.perm-table { width: 100%; border-collapse: collapse; background: #fff; }
.perm-table thead th {
    background: #f4f6fb;
    padding: 9px 16px;
    font-size: 11.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px;
    color: #6b7494;
    border-bottom: 2px solid #dde1ed;
    text-align: {{ app()->getLocale()=='ar' ? 'right' : 'left' }};
}
.perm-table thead th:first-child { width: 44px; text-align: center !important; }

.perm-table tbody tr {
    border-bottom: 1px solid #edf0f7;
    transition: background .12s;
    background: #fff;
}
.perm-table tbody tr:last-child { border-bottom: none; }
.perm-table tbody tr:hover { background: #f0f4ff; }
.perm-table tbody tr:has(.perm-cb:checked) { background: #eef2ff; }
.perm-table tbody tr:has(.perm-cb:checked) .perm-name {
    color: #0f3460; font-weight: 600;
}

.perm-table td {
    padding: 10px 16px;
    vertical-align: middle;
    color: #2c3150;
    text-align: {{ app()->getLocale()=='ar' ? 'right' : 'left' }};
}
.perm-table td:first-child { text-align: center !important; width: 44px; }

.perm-cb { width: 17px; height: 17px; cursor: pointer; accent-color: #0f3460; }

.perm-name {
    font-size: 13.5px;
    color: #2c3150;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    {{ app()->getLocale()=='ar' ? 'justify-content:flex-end; flex-direction:row-reverse;' : '' }}
}
.perm-dot {
    width: 7px; height: 7px;
    background: #c0c8de;
    border-radius: 50%; flex-shrink: 0;
    transition: background .15s;
}
.perm-table tbody tr:has(.perm-cb:checked) .perm-dot { background: #0f3460; }

/* ===== FORM ACTIONS ===== */
.form-actions {
    background: #f4f6fb; border-radius: 12px; padding: 16px 22px;
    display: flex; align-items: center; justify-content: space-between;
    border: 1px solid #dde1ed; margin-top: 6px;
}
.btn-save {
    background: linear-gradient(135deg,#0f3460,#16213e);
    color: #fff; border: none; padding: 10px 30px; border-radius: 8px;
    font-size: 14px; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; gap: 7px;
    transition: opacity .2s, transform .1s;
}
.btn-save:hover { opacity: .88; transform: translateY(-1px); }
.btn-back {
    color: #6c757d; text-decoration: none;
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13.5px; padding: 9px 16px; border-radius: 8px;
    border: 1px solid #dee2e6; background: #fff; transition: all .15s;
}
.btn-back:hover { background: #f0f2f8; color: #1a1a2e; text-decoration: none; }
</style>

<div class="card" style="border:none;box-shadow:none;background:transparent;">

    {{-- Header --}}
    <div class="role-header">
        <i class="fas fa-shield-alt"></i>
        <div>
            <h4>{{ trans('global.create') }} {{ trans('cruds.role.title_singular') }}</h4>
            <p>{{ app()->getLocale()=='ar' ? 'تحديد اسم الدور واختيار الصلاحيات المرتبطة به' : 'Define role name and assign permissions' }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.roles.store') }}">
        @csrf

        {{-- Role Info --}}
        <div class="card" style="border-radius:12px;border:1px solid #dde1ed;margin-bottom:20px;">
            <div class="card-header" style="background:#f4f6fb;border-bottom:1px solid #dde1ed;border-radius:12px 12px 0 0;font-weight:700;color:#1a1a2e;">
                <i class="fas fa-id-badge me-2 text-primary"></i>
                {{ app()->getLocale()=='ar' ? 'معلومات الدور' : 'Role Information' }}
            </div>
            <div class="card-body" style="padding:20px 24px;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="title">
                            {{ trans('cruds.role.fields.title') }} <span class="text-danger">*</span>
                        </label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                               type="text" name="title" id="title"
                               value="{{ old('title') }}" required
                               placeholder="{{ app()->getLocale()=='ar' ? 'مثال: مدير_المحتوى' : 'e.g. content_manager' }}">
                        @if($errors->has('title'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Select Bar --}}
        <div class="quick-bar">
            <i class="fas fa-bolt"></i>
            <span style="font-weight:600;">{{ app()->getLocale()=='ar' ? 'تحديد سريع:' : 'Quick select:' }}</span>
            <button type="button" class="qbtn qbtn-all" onclick="toggleAll(true)">
                <i class="fas fa-check-double"></i>
                {{ app()->getLocale()=='ar' ? 'تحديد الكل' : 'Select All' }}
            </button>
            <button type="button" class="qbtn qbtn-none" onclick="toggleAll(false)">
                <i class="fas fa-times"></i>
                {{ app()->getLocale()=='ar' ? 'إلغاء الكل' : 'Deselect All' }}
            </button>
            <span class="sel-counter" id="selCount">0 {{ app()->getLocale()=='ar' ? 'محددة' : 'selected' }}</span>
        </div>

        {{-- Permissions --}}
        @php
        $categoryNames = [
            1  => ['ar'=>'إدارة المستخدمين',      'en'=>'User Management'],
            2  => ['ar'=>'شرائح العرض',            'en'=>'Slide Shows'],
            3  => ['ar'=>'المطاعم',                'en'=>'Restaurants'],
            4  => ['ar'=>'التوصيل',                'en'=>'Delivery'],
            5  => ['ar'=>'الطلبات',                'en'=>'Orders'],
            6  => ['ar'=>'الدفع والاشتراكات',      'en'=>'Payments & Subscriptions'],
            7  => ['ar'=>'المواقع الجغرافية',      'en'=>'Locations'],
            8  => ['ar'=>'الإعلانات',              'en'=>'Advertisements'],
            9  => ['ar'=>'الدعم والتذاكر',         'en'=>'Support & Tickets'],
            10 => ['ar'=>'النقاط',                 'en'=>'Points'],
            11 => ['ar'=>'السيارات',               'en'=>'Cars'],
            12 => ['ar'=>'الإشعارات',              'en'=>'Notifications'],
            13 => ['ar'=>'أخرى',                   'en'=>'Other'],
        ];
        $locale = app()->getLocale();
        @endphp

        @if(count($result) === 0)
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ $locale=='ar' ? 'لا توجد صلاحيات في قاعدة البيانات.' : 'No permissions found in database.' }}
            </div>
        @endif

        @foreach($result as $data)
        @php
            $catId   = 'cat_' . $loop->index;
            $catNum  = $data['category_id'];
            $catName = isset($categoryNames[$catNum])
                       ? $categoryNames[$catNum][$locale]
                       : ($locale=='ar' ? $data['link_name'] : $data['link_name']);
        @endphp
        <div class="cat-card">

            <div class="cat-head" onclick="toggleCat('{{ $catId }}')">
                <div class="cat-title">
                    <i class="fas fa-layer-group" style="color:#0f3460;"></i>
                    <span>{{ $catName }}</span>
                    <span class="cat-badge">{{ $data['permissions']->count() }}</span>
                </div>
                <div class="cat-actions">
                    <button type="button" class="cbtn"
                        onclick="event.stopPropagation();selectCat('{{ $catId }}',true)">
                        <i class="fas fa-check-square"></i>
                        {{ $locale=='ar' ? 'الكل' : 'All' }}
                    </button>
                    <button type="button" class="cbtn red"
                        onclick="event.stopPropagation();selectCat('{{ $catId }}',false)">
                        <i class="fas fa-minus-square"></i>
                        {{ $locale=='ar' ? 'إلغاء' : 'None' }}
                    </button>
                    <i class="fas fa-chevron-down cat-arrow" id="arr_{{ $catId }}"></i>
                </div>
            </div>

            <div id="body_{{ $catId }}">
                <table class="perm-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ $locale=='ar' ? 'الصلاحية' : 'Permission' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['permissions'] as $perm)
                        <tr>
                            <td>
                                <input type="checkbox"
                                    name="perm[]"
                                    value="{{ $perm->id }}"
                                    class="perm-cb perm-of-{{ $catId }}"
                                    id="p{{ $perm->id }}"
                                    {{ in_array($perm->id, old('perm',[])) ? 'checked' : '' }}
                                    onchange="recount()">
                            </td>
                            <td>
                                <label for="p{{ $perm->id }}" style="cursor:pointer;margin:0;width:100%;display:block;">
                                    <span class="perm-name">
                                        <span class="perm-dot"></span>
                                        {{ $locale=='ar' ? $perm->name_ar : $perm->name_en }}
                                    </span>
                                </label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        @endforeach

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
function toggleCat(id){
    const body = document.getElementById('body_'+id);
    const arr  = document.getElementById('arr_'+id);
    const hidden = body.style.display === 'none';
    body.style.display = hidden ? '' : 'none';
    arr.style.transform = hidden ? 'rotate(0deg)' : 'rotate(-90deg)';
}
function selectCat(id, state){
    document.querySelectorAll('.perm-of-'+id).forEach(c => c.checked = state);
    recount();
}
function toggleAll(state){
    document.querySelectorAll('.perm-cb').forEach(c => c.checked = state);
    recount();
}
function recount(){
    const n = document.querySelectorAll('.perm-cb:checked').length;
    const label = document.documentElement.lang === 'ar' ? ' محددة' : ' selected';
    document.getElementById('selCount').textContent = n + label;
}
</script>
@endsection
