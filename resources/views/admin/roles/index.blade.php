@extends('layouts.admin')
@section('content')

@php
/* ============================================================
   خريطة ترجمة الصلاحيات — مشتركة بين index / show / edit
   ============================================================ */
$moduleAr = [
    'ad'=>'الإعلانات','address'=>'العناوين','ads'=>'الإعلانات',
    'adscategory'=>'تصنيفات الإعلانات','allad'=>'كل الإعلانات',
    'becomepartner'=>'طلب شراكة','becomePartner'=>'طلب شراكة',
    'cancelreason'=>'أسباب الإلغاء','cancel'=>'الإلغاء',
    'carbrand'=>'ماركات السيارات','carcolor'=>'ألوان السيارات',
    'carlist'=>'قائمة السيارات','cart'=>'سلة التسوق',
    'category'=>'الفئات','categorytoprestaurant'=>'تصنيف المطاعم المميزة',
    'city'=>'المدن','contact'=>'التواصل','country'=>'الدول',
    'coupon'=>'الكوبونات','currency'=>'العملات',
    'delivery'=>'التوصيل','deliverycompany'=>'شركات التوصيل',
    'expense'=>'المصاريف','expensecategory'=>'تصنيفات المصاريف',
    'extra'=>'الإضافات','faq'=>'الأسئلة الشائعة',
    'favorite'=>'المفضلة','image'=>'الصور',
    'income'=>'الإيرادات','incomecategory'=>'تصنيفات الإيرادات',
    'item'=>'المنتجات','loopbank'=>'البنك','loopuser'=>'مستخدمو النظام',
    'notification'=>'الإشعارات','offeruser'=>'عروض المستخدمين',
    'onbordering'=>'التأهيل','order'=>'الطلبات',
    'orderstatus'=>'حالات الطلبات','ordertype'=>'أنواع الطلبات',
    'otherbranch'=>'الفروع الأخرى','paymentmethod'=>'طرق الدفع',
    'permission'=>'الصلاحيات','point'=>'النقاط','pointtype'=>'أنواع النقاط',
    'qa'=>'الأسئلة والأجوبة','qamessage'=>'رسائل الأسئلة','qatopic'=>'مواضيع الأسئلة',
    'queue'=>'قائمة الانتظار','rate'=>'التقييمات',
    'referralsubscription'=>'اشتراكات الإحالة','reporting'=>'التقارير',
    'restaurant'=>'المطاعم','role'=>'الأدوار',
    'savecreditcard'=>'بطاقات الائتمان','setting'=>'الإعدادات',
    'sittingarea'=>'مناطق الجلوس','slideshow'=>'عروض الشرائح',
    'slider'=>'السلايدر','smshistory'=>'سجل الرسائل',
    'subscriptionpackage'=>'باقات الاشتراك',
    'subscriptionuser'=>'اشتراكات المستخدمين',
    'subscriptionvip'=>'اشتراكات VIP',
    'table'=>'الطاولات','tablestatus'=>'حالات الطاولات',
    'ticket'=>'التذاكر','ticketmessage'=>'رسائل التذاكر',
    'ticketstatus'=>'حالات التذاكر','toprestaurant'=>'المطاعم المميزة',
    'typeofcar'=>'أنواع السيارات','user'=>'المستخدمون',
    'useralert'=>'تنبيهات المستخدمين','userstatus'=>'حالات المستخدمين',
    'venturecompany'=>'شركات المشاريع',
];
$actionAr = [
    'access'=>'الوصول','create'=>'إضافة','edit'=>'تعديل',
    'delete'=>'حذف','destroy'=>'حذف','show'=>'عرض','view'=>'عرض',
    'index'=>'قائمة','store'=>'حفظ','update'=>'تحديث',
    'export'=>'تصدير','import'=>'استيراد','approve'=>'موافقة',
    'reject'=>'رفض','manage'=>'إدارة',
];
$actionColors = [
    'access'=>['bg'=>'rgba(71,85,105,.1)','text'=>'#475569'],
    'create'=>['bg'=>'rgba(22,163,74,.1)','text'=>'#16a34a'],
    'edit'=>['bg'=>'rgba(217,119,6,.1)','text'=>'#b45309'],
    'update'=>['bg'=>'rgba(217,119,6,.1)','text'=>'#b45309'],
    'delete'=>['bg'=>'rgba(220,38,38,.1)','text'=>'#dc2626'],
    'destroy'=>['bg'=>'rgba(220,38,38,.1)','text'=>'#dc2626'],
    'show'=>['bg'=>'rgba(37,99,235,.1)','text'=>'#2563eb'],
    'view'=>['bg'=>'rgba(37,99,235,.1)','text'=>'#2563eb'],
    'index'=>['bg'=>'rgba(124,58,237,.1)','text'=>'#7c3aed'],
    'export'=>['bg'=>'rgba(14,116,144,.1)','text'=>'#0e7490'],
    'import'=>['bg'=>'rgba(14,116,144,.1)','text'=>'#0e7490'],
];
$translatePerm = function(string $title) use ($moduleAr,$actionAr,$actionColors):array {
    $parts  = explode('_',$title);
    $action = strtolower(array_pop($parts));
    $module = strtolower(implode('',$parts));
    return [
        'module' => $moduleAr[$module] ?? ucwords(str_replace('_',' ',$module)),
        'action' => $actionAr[$action]  ?? ucfirst($action),
        'action_en' => ucfirst($action),
        'colors' => $actionColors[$action] ?? ['bg'=>'rgba(71,85,105,.1)','text'=>'#475569'],
    ];
};
$total = $roles->count();
@endphp

<div style="padding:24px;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#8b5cf6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(124,58,237,.3);">
                <i class="fas fa-user-tag"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;line-height:1.2;">{{ trans('cruds.role.title') }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">&rsaquo;</span>
                    <span>{{ trans('cruds.role.title') }}</span>
                </nav>
            </div>
        </div>
    </div>

    {{-- KPI --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:14px;margin-bottom:24px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#8b5cf6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(124,58,237,.3);"><i class="fas fa-user-tag"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('cruds.role.title') }}</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#7c3aed,#5b21b6);border-radius:14px;padding:18px;box-shadow:0 4px 18px rgba(124,58,237,.35);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;"><i class="fas fa-shield-alt"></i></div>
            <div><div style="font-size:1.55rem;font-weight:800;color:#fff;line-height:1;">{{ $roles->sum(fn($r)=>$r->permissions->count()) }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,.75);margin-top:3px;font-weight:600;">{{ trans('cruds.permission.title') ?? 'Permissions' }}</div></div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;width:100%;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(124,58,237,.1);display:flex;align-items:center;justify-content:center;color:#7c3aed;font-size:15px;"><i class="fas fa-user-tag"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.role.title') }}</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @can('role_create')
            <a href="{{ route('admin.roles.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(39,186,77,.3);transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }}
            </a>
            @endcan
        </div>
        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-Role" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.role.fields.title') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.permission.title') ?? 'Permissions' }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                <tr data-entry-id="{{ $role->id }}">
                    <td></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:9px;">
                            <div style="width:32px;height:32px;border-radius:9px;background:rgba(124,58,237,.1);display:flex;align-items:center;justify-content:center;color:#7c3aed;font-size:13px;flex-shrink:0;"><i class="fas fa-user-tag"></i></div>
                            <span style="font-weight:700;color:var(--z-text);font-size:0.85rem;">{{ $role->title ?? '' }}</span>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;flex-wrap:wrap;gap:5px;max-width:520px;">
                            @foreach($role->permissions->take(6) as $perm)
                            @php $t = $translatePerm($perm->title); @endphp
                            <span title="{{ $perm->title }}" style="display:inline-flex;align-items:center;gap:4px;background:{{ $t['colors']['bg'] }};border:1px solid {{ $t['colors']['text'] }}22;border-radius:7px;padding:3px 9px;">
                                <span style="font-size:0.75rem;font-weight:700;color:{{ $t['colors']['text'] }};">{{ $t['module'] }}</span>
                                <span style="width:1px;height:10px;background:{{ $t['colors']['text'] }}44;flex-shrink:0;"></span>
                                <span style="font-size:0.7rem;color:{{ $t['colors']['text'] }};opacity:.85;">{{ $t['action'] }}</span>
                            </span>
                            @endforeach
                            @if($role->permissions->count() > 6)
                            <span style="background:rgba(148,163,184,.12);color:var(--z-text-muted);padding:3px 9px;border-radius:7px;font-size:0.75rem;font-weight:700;">+{{ $role->permissions->count() - 6 }} أخرى</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            @can('role_show')
                            <a href="{{ route('admin.roles.show',$role->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('role_edit')
                            <a href="{{ route('admin.roles.edit',$role->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('role_delete')
                            <form action="{{ route('admin.roles.destroy',$role->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
                                <button type="submit" title="{{ trans('global.delete') }}"
                                   style="width:32px;height:32px;border-radius:8px;background:rgba(239,68,68,.1);color:#dc2626;border:none;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;transition:background .15s;"
                                   onmouseover="this.style.background='rgba(239,68,68,.22)'" onmouseout="this.style.background='rgba(239,68,68,.1)'"><i class="fas fa-trash"></i></button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
@section('scripts')
@parent
<script>
$(function(){
    let dtButtons=$.extend(true,[],$.fn.dataTable.defaults.buttons);
    @can('role_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.roles.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25});
    $('.datatable-Role:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
