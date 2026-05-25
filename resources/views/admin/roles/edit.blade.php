@extends('layouts.admin')
@section('content')
<style>
.role-header {
    background: linear-gradient(135deg,#1b4332,#2d6a4f,#40916c);
    color:#fff; border-radius:14px; padding:26px 30px; margin-bottom:24px;
    display:flex; align-items:center; gap:16px;
    box-shadow:0 6px 28px rgba(27,67,50,.22);
}
.role-header i { font-size:32px; opacity:.88; }
.role-header h4 { margin:0; font-size:20px; font-weight:700; }
.role-header p  { margin:3px 0 0; opacity:.65; font-size:13px; }

.quick-bar {
    display:flex; align-items:center; gap:10px;
    padding:10px 18px;
    background: var(--z-surface-2);
    border:1px solid var(--z-border-strong);
    border-radius:10px; margin-bottom:18px;
    font-size:13px; color: var(--z-text-muted); flex-wrap:wrap;
}
.qbtn {
    border:none; padding:5px 14px; border-radius:6px;
    font-size:12px; font-weight:700; cursor:pointer;
    display:inline-flex; align-items:center; gap:5px;
    transition:background .15s;
}
.qbtn-all  { background:#2d6a4f; color:#fff; }
.qbtn-all:hover  { background:#1b4332; }
.qbtn-none { background: var(--z-surface-3); color: var(--z-text); border:1px solid var(--z-border-strong); }
.qbtn-none:hover { background: var(--z-surface-2); }
.sel-counter {
    margin-left:auto;
    background: var(--z-surface);
    border:1px solid var(--z-border-strong);
    border-radius:20px; padding:3px 13px;
    font-weight:700; color: var(--z-text-muted); font-size:12px;
}

.cat-card {
    border:1px solid var(--z-border-strong); border-radius:12px; overflow:hidden;
    margin-bottom:14px; box-shadow: var(--z-card-shadow);
    background: var(--z-card-bg);
    transition: background var(--z-transition-slow), border-color var(--z-transition-slow);
}
.cat-head {
    background: var(--z-surface-2);
    border-bottom:1px solid var(--z-border);
    padding:12px 18px;
    display:flex; align-items:center; justify-content:space-between;
    cursor:pointer; user-select:none;
    transition: background .15s;
}
.cat-head:hover { background: var(--z-surface-3); }
.cat-title { display:flex; align-items:center; gap:9px; font-weight:700; font-size:14px; color: var(--z-text); }
.cat-badge { background:#2d6a4f; color:#fff; border-radius:20px; padding:2px 10px; font-size:11px; font-weight:600; }
.checked-badge {
    background: var(--z-primary-light);
    color: var(--z-primary);
    border-radius:20px; padding:2px 10px;
    font-size:11px; font-weight:600;
}
.cat-actions { display:flex; gap:7px; align-items:center; }
.cbtn {
    font-size:11.5px; padding:3px 10px; border-radius:6px;
    border:1px solid var(--z-border-strong);
    background: var(--z-surface);
    color: var(--z-text-muted);
    cursor:pointer; transition:all .15s;
    display:inline-flex; align-items:center; gap:4px;
}
.cbtn:hover { background:#2d6a4f; color:#fff; border-color:#2d6a4f; }
.cbtn.red:hover { background:#dc3545; color:#fff; border-color:#dc3545; }
.cat-arrow { color: var(--z-text-faint); font-size:13px; transition:transform .25s; }

.perm-table { width:100%; border-collapse:collapse; background: transparent; }
.perm-table thead th {
    background: var(--z-table-header-bg);
    padding:9px 16px;
    font-size:11.5px; font-weight:700;
    text-transform:uppercase; letter-spacing:.5px;
    color: var(--z-text-muted);
    border-bottom:2px solid var(--z-border-strong);
    text-align: {{ app()->getLocale()=='ar' ? 'right' : 'left' }};
}
.perm-table thead th:first-child { width:44px; text-align:center !important; }
.perm-table tbody tr {
    border-bottom:1px solid var(--z-table-border);
    transition:background .12s;
    background: var(--z-surface);
}
.perm-table tbody tr:last-child { border-bottom:none; }
.perm-table tbody tr:hover { background: var(--z-table-row-hover); }
.perm-table tbody tr:has(.perm-cb:checked) { background: var(--z-primary-light); }
.perm-table tbody tr:has(.perm-cb:checked) .perm-name { color: var(--z-primary); font-weight:600; }
.perm-table td {
    padding:10px 16px; vertical-align:middle;
    color: var(--z-text);
    background: transparent !important;
    text-align: {{ app()->getLocale()=='ar' ? 'right' : 'left' }};
}
.perm-table td:first-child { text-align:center !important; width:44px; }
.perm-cb { width:17px; height:17px; cursor:pointer; accent-color:#2d6a4f; }
.perm-name {
    font-size:13.5px; color: var(--z-text); font-weight:500;
    display:flex; align-items:center; gap:8px;
    {{ app()->getLocale()=='ar' ? 'justify-content:flex-end; flex-direction:row-reverse;' : '' }}
}
.perm-dot {
    width:7px; height:7px;
    background: var(--z-text-faint); border-radius:50%; flex-shrink:0;
    transition:background .15s;
}
.perm-table tbody tr:has(.perm-cb:checked) .perm-dot { background:#2d6a4f; }

.form-actions {
    background: var(--z-surface-2); border-radius:12px; padding:16px 22px;
    display:flex; align-items:center; justify-content:space-between;
    border:1px solid var(--z-border); margin-top:6px;
    transition: background var(--z-transition-slow);
}
.btn-save {
    background:linear-gradient(135deg,#1b4332,#2d6a4f);
    color:#fff; border:none; padding:10px 30px; border-radius:8px;
    font-size:14px; font-weight:600; cursor:pointer;
    display:inline-flex; align-items:center; gap:7px;
    transition:opacity .2s, transform .1s;
}
.btn-save:hover { opacity:.88; transform:translateY(-1px); }
.btn-back {
    color: var(--z-text-muted); text-decoration:none;
    display:inline-flex; align-items:center; gap:6px;
    font-size:13.5px; padding:9px 16px; border-radius:8px;
    border:1px solid var(--z-border-strong);
    background: var(--z-surface);
    transition:all .15s;
}
.btn-back:hover { background: var(--z-surface-2); color: var(--z-text); text-decoration:none; }
</style>

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
$rolePermIds = $role->permissions->pluck('id')->toArray();
@endphp

<div class="card" style="border:none;box-shadow:none;background:transparent;">

    <div class="role-header">
        <i class="fas fa-user-shield"></i>
        <div>
            <h4>{{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}: <strong>{{ $role->title }}</strong></h4>
            <p>{{ $locale=='ar' ? 'تعديل الصلاحيات المرتبطة بهذا الدور' : 'Edit permissions assigned to this role' }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.roles.update', [$role->id]) }}">
        @method('PUT')
        @csrf

        <div class="card" style="border-radius:12px;border:1px solid var(--z-border);margin-bottom:20px;">
            <div class="card-header" style="font-weight:700;">
                <i class="fas fa-id-badge me-2" style="color:#2d6a4f;"></i>
                {{ $locale=='ar' ? 'معلومات الدور' : 'Role Information' }}
            </div>
            <div class="card-body" style="padding:20px 24px;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ trans('cruds.role.fields.title') }} <span class="text-danger">*</span></label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid':'' }}"
                               type="text" name="title" value="{{ old('title',$role->title) }}" required>
                        @if($errors->has('title'))<div class="invalid-feedback">{{ $errors->first('title') }}</div>@endif
                    </div>
                </div>
            </div>
        </div>

        <div class="quick-bar">
            <i class="fas fa-bolt"></i>
            <span style="font-weight:600;">{{ $locale=='ar' ? 'تحديد سريع:' : 'Quick select:' }}</span>
            <button type="button" class="qbtn qbtn-all" onclick="toggleAll(true)">
                <i class="fas fa-check-double"></i> {{ $locale=='ar' ? 'تحديد الكل' : 'Select All' }}
            </button>
            <button type="button" class="qbtn qbtn-none" onclick="toggleAll(false)">
                <i class="fas fa-times"></i> {{ $locale=='ar' ? 'إلغاء الكل' : 'Deselect All' }}
            </button>
            <span class="sel-counter" id="selCount">0 {{ $locale=='ar' ? 'محددة' : 'selected' }}</span>
        </div>

        @foreach($result as $data)
        @php
            $catId   = 'cat_'.$loop->index;
            $catNum  = $data['category_id'];
            $catName = isset($categoryNames[$catNum]) ? $categoryNames[$catNum][$locale] : $data['link_name'];
            $checkedCount = $data['permissions']->whereIn('id',$rolePermIds)->count();
        @endphp
        <div class="cat-card">
            <div class="cat-head" onclick="toggleCat('{{ $catId }}')">
                <div class="cat-title">
                    <i class="fas fa-layer-group" style="color:#2d6a4f;"></i>
                    <span>{{ $catName }}</span>
                    <span class="cat-badge">{{ $data['permissions']->count() }}</span>
                    <span class="checked-badge" id="cbadge_{{ $catId }}"
                          style="display:{{ $checkedCount>0?'inline-flex':'none' }}">
                        {{ $checkedCount }} {{ $locale=='ar'?'محدد':'checked' }}
                    </span>
                </div>
                <div class="cat-actions">
                    <button type="button" class="cbtn" onclick="event.stopPropagation();selectCat('{{ $catId }}',true)">
                        <i class="fas fa-check-square"></i> {{ $locale=='ar'?'الكل':'All' }}
                    </button>
                    <button type="button" class="cbtn red" onclick="event.stopPropagation();selectCat('{{ $catId }}',false)">
                        <i class="fas fa-minus-square"></i> {{ $locale=='ar'?'إلغاء':'None' }}
                    </button>
                    <i class="fas fa-chevron-down cat-arrow" id="arr_{{ $catId }}"></i>
                </div>
            </div>

            <div id="body_{{ $catId }}">
                <table class="perm-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ $locale=='ar'?'الصلاحية':'Permission' }}</th>
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
                                    {{ in_array($perm->id,$rolePermIds) ? 'checked' : '' }}
                                    onchange="recount();updateBadge('{{ $catId }}')">
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
    const body=document.getElementById('body_'+id);
    const arr=document.getElementById('arr_'+id);
    const hidden=body.style.display==='none';
    body.style.display=hidden?'':'none';
    arr.style.transform=hidden?'rotate(0deg)':'rotate(-90deg)';
}
function selectCat(id,state){
    document.querySelectorAll('.perm-of-'+id).forEach(c=>c.checked=state);
    recount(); updateBadge(id);
}
function toggleAll(state){
    document.querySelectorAll('.perm-cb').forEach(c=>c.checked=state);
    recount();
    document.querySelectorAll('[id^="cbadge_"]').forEach(b=>updateBadge(b.id.replace('cbadge_','')));
}
function recount(){
    const n=document.querySelectorAll('.perm-cb:checked').length;
    const lbl=document.documentElement.lang==='ar'?' محددة':' selected';
    document.getElementById('selCount').textContent=n+lbl;
}
function updateBadge(id){
    const n=document.querySelectorAll('.perm-of-'+id+':checked').length;
    const b=document.getElementById('cbadge_'+id);
    const lbl=document.documentElement.lang==='ar'?' محدد':' checked';
    if(b){ b.textContent=n+lbl; b.style.display=n>0?'inline-flex':'none'; }
}
document.addEventListener('DOMContentLoaded',function(){ recount(); });
</script>
@endsection
