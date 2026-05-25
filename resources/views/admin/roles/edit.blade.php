@extends('layouts.admin')
@section('content')
<style>
.role-header {
    background: linear-gradient(135deg,#1b4332,#2d6a4f,#40916c);
    color:#fff;
    border-radius:14px;
    padding:26px 30px;
    margin-bottom:24px;
    display:flex;
    align-items:center;
    gap:16px;
    box-shadow:0 6px 28px rgba(27,67,50,.22);
}
.role-header i{font-size:32px;opacity:.88;}
.role-header h4{margin:0;font-size:20px;font-weight:700;}
.role-header p{margin:3px 0 0;opacity:.65;font-size:13px;}

.quick-bar{
    display:flex;align-items:center;gap:10px;
    padding:10px 18px;
    background:#d8f3dc;
    border:1px solid #b7e4c7;
    border-radius:10px;
    margin-bottom:18px;
    font-size:13px;color:#1b4332;
    flex-wrap:wrap;
}
.quick-bar .qbtn{
    border:none;padding:5px 14px;border-radius:6px;
    font-size:12px;font-weight:700;cursor:pointer;
    display:inline-flex;align-items:center;gap:5px;
    transition:background .15s;
}
.qbtn-all{background:#2d6a4f;color:#fff;}
.qbtn-all:hover{background:#1b4332;}
.qbtn-none{background:#e0e0e0;color:#333;}
.qbtn-none:hover{background:#bdbdbd;}
.sel-counter{
    margin-left:auto;
    background:#b7e4c7;
    border:1px solid #95d5b2;
    border-radius:20px;
    padding:3px 13px;
    font-weight:700;color:#1b4332;font-size:12px;
}

.cat-card{border:1px solid #e2e6f0;border-radius:12px;overflow:hidden;margin-bottom:14px;box-shadow:0 2px 8px rgba(0,0,0,.05);}
.cat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.09);}

.cat-head{
    background:linear-gradient(90deg,#f4f6fb,#eceff8);
    border-bottom:1px solid #e2e6f0;
    padding:12px 18px;
    display:flex;align-items:center;justify-content:space-between;
    cursor:pointer;user-select:none;
}
.cat-head:hover{background:linear-gradient(90deg,#e8edf7,#e2e8f4);}
.cat-title{display:flex;align-items:center;gap:9px;font-weight:700;font-size:14px;color:#1a1a2e;}

.cat-badge{background:#2d6a4f;color:#fff;border-radius:20px;padding:2px 10px;font-size:11px;font-weight:600;}
.checked-badge{
    background:#d8f3dc;color:#1b4332;
    border-radius:20px;padding:2px 10px;
    font-size:11px;font-weight:600;
}

.cat-actions{display:flex;gap:7px;align-items:center;}
.cbtn{font-size:11.5px;padding:3px 10px;border-radius:6px;border:1px solid #d0d5e0;background:#fff;color:#555;cursor:pointer;transition:all .15s;display:inline-flex;align-items:center;gap:4px;}
.cbtn:hover{background:#2d6a4f;color:#fff;border-color:#2d6a4f;}
.cbtn.red:hover{background:#dc3545;color:#fff;border-color:#dc3545;}
.cat-arrow{color:#aab0c0;font-size:13px;transition:transform .25s;}

.perm-table{width:100%;border-collapse:collapse;}
.perm-table thead th{
    background:#f8f9fd;padding:8px 14px;
    font-size:11px;font-weight:700;text-transform:uppercase;
    letter-spacing:.5px;color:#8a93ad;
    border-bottom:2px solid #e2e6f0;
}
.perm-table thead th:first-child{width:44px;text-align:center;}
.perm-table thead th:last-child{width:200px;}
.perm-table tbody tr{border-bottom:1px solid #f0f2f7;transition:background .1s;}
.perm-table tbody tr:last-child{border-bottom:none;}
.perm-table tbody tr:hover{background:#f5fff8;}
.perm-table tbody tr:has(.perm-cb:checked){background:#f0fdf4;}
.perm-table tbody tr:has(.perm-cb:checked) .perm-name{color:#1b4332;font-weight:600;}
.perm-table td{padding:9px 14px;vertical-align:middle;}
.perm-table td:first-child{text-align:center;}

.perm-cb{width:16px;height:16px;cursor:pointer;accent-color:#2d6a4f;}
.perm-name{
    font-size:13.5px;color:#2c3150;font-weight:500;
    display:flex;align-items:center;gap:7px;
}
.perm-name::before{
    content:'';width:6px;height:6px;
    background:#c8d0e7;border-radius:50%;flex-shrink:0;
}
.perm-table tbody tr:has(.perm-cb:checked) .perm-name::before{background:#2d6a4f;}

.perm-key{
    font-size:11px;color:#b0b8cc;
    font-family:'Courier New',monospace;
    background:#f4f6fb;padding:2px 7px;
    border-radius:4px;border:1px solid #e2e6f0;
    display:inline-block;
}

.form-actions{
    background:#f8f9fc;border-radius:12px;padding:16px 22px;
    display:flex;align-items:center;justify-content:space-between;
    border:1px solid #e2e6f0;margin-top:6px;
}
.btn-save{
    background:linear-gradient(135deg,#1b4332,#2d6a4f);
    color:#fff;border:none;padding:10px 30px;border-radius:8px;
    font-size:14px;font-weight:600;cursor:pointer;
    display:inline-flex;align-items:center;gap:7px;
    transition:opacity .2s,transform .1s;
}
.btn-save:hover{opacity:.88;transform:translateY(-1px);}
.btn-back{
    color:#6c757d;text-decoration:none;
    display:inline-flex;align-items:center;gap:6px;
    font-size:13.5px;padding:9px 16px;border-radius:8px;
    border:1px solid #dee2e6;background:#fff;transition:all .15s;
}
.btn-back:hover{background:#f0f2f8;color:#1a1a2e;text-decoration:none;}
</style>

<div class="card" style="border:none;box-shadow:none;background:transparent;">

    <div class="role-header">
        <i class="fas fa-user-shield"></i>
        <div>
            <h4>{{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}: <strong>{{ $role->title }}</strong></h4>
            <p>تعديل الصلاحيات المرتبطة بهذا الدور</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.roles.update', [$role->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="card" style="border-radius:12px;border:1px solid #e2e6f0;margin-bottom:20px;">
            <div class="card-header" style="background:#f8f9fc;border-bottom:1px solid #e2e6f0;border-radius:12px 12px 0 0;font-weight:700;color:#1a1a2e;">
                <i class="fas fa-id-badge me-2" style="color:#2d6a4f;"></i> معلومات الدور
            </div>
            <div class="card-body" style="padding:20px 24px;">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">{{ trans('cruds.role.fields.title') }} <span class="text-danger">*</span></label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid':'' }}" type="text" name="title" value="{{ old('title',$role->title) }}" required>
                        @if($errors->has('title'))<div class="invalid-feedback">{{ $errors->first('title') }}</div>@endif
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الاسم بالعربية</label>
                        <input class="form-control" type="text" name="title_ar" value="{{ old('title_ar',$role->title_ar??'') }}" dir="rtl">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Name in English</label>
                        <input class="form-control" type="text" name="title_en" value="{{ old('title_en',$role->title_en??'') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="quick-bar">
            <i class="fas fa-bolt"></i>
            <span style="font-weight:600;">تحديد سريع:</span>
            <button type="button" class="qbtn qbtn-all" onclick="toggleAll(true)"><i class="fas fa-check-double"></i> تحديد الكل</button>
            <button type="button" class="qbtn qbtn-none" onclick="toggleAll(false)"><i class="fas fa-times"></i> إلغاء الكل</button>
            <span class="sel-counter" id="selCount">0 محددة</span>
        </div>

        @php $rolePermIds = $role->permissions->pluck('id')->toArray(); @endphp

        @foreach($result as $data)
        @php
            $catId = 'cat_'.$loop->index;
            $checkedCount = $data['permissions']->whereIn('id',$rolePermIds)->count();
        @endphp
        <div class="cat-card">
            <div class="cat-head" onclick="toggleCat('{{ $catId }}')">
                <div class="cat-title">
                    <i class="fas fa-folder-open" style="color:#2d6a4f;"></i>
                    <span>{{ $data['link_name'] }}</span>
                    <span class="cat-badge">{{ $data['permissions']->count() }}</span>
                    <span class="checked-badge" id="cbadge_{{ $catId }}"
                          style="{{ $checkedCount>0 ? 'display:inline-flex' : 'display:none' }}">
                        {{ $checkedCount }} محدد
                    </span>
                </div>
                <div class="cat-actions">
                    <button type="button" class="cbtn" onclick="event.stopPropagation();selectCat('{{ $catId }}',true)">
                        <i class="fas fa-check-square"></i> تحديد الكل
                    </button>
                    <button type="button" class="cbtn red" onclick="event.stopPropagation();selectCat('{{ $catId }}',false)">
                        <i class="fas fa-minus-square"></i> إلغاء
                    </button>
                    <i class="fas fa-chevron-down cat-arrow" id="arr_{{ $catId }}"></i>
                </div>
            </div>

            <div id="body_{{ $catId }}">
                <table class="perm-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ app()->getLocale()=='ar'?'الصلاحية':'Permission' }}</th>
                            <th>{{ app()->getLocale()=='ar'?'المفتاح':'Key' }}</th>
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
                                <label for="p{{ $perm->id }}" style="cursor:pointer;margin:0;">
                                    <span class="perm-name">{{ app()->getLocale()=='ar'?$perm->name_ar:$perm->name_en }}</span>
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
    recount();
    updateBadge(id);
}
function toggleAll(state){
    document.querySelectorAll('.perm-cb').forEach(c=>c.checked=state);
    recount();
    document.querySelectorAll('[id^="cbadge_"]').forEach(b=>{
        const id=b.id.replace('cbadge_','');
        updateBadge(id);
    });
}
function recount(){
    const n=document.querySelectorAll('.perm-cb:checked').length;
    document.getElementById('selCount').textContent=n+' محددة';
}
function updateBadge(id){
    const n=document.querySelectorAll('.perm-of-'+id+':checked').length;
    const b=document.getElementById('cbadge_'+id);
    if(b){ b.textContent=n+' محدد'; b.style.display=n>0?'inline-flex':'none'; }
}
document.addEventListener('DOMContentLoaded',function(){ recount(); });
</script>
@endsection
