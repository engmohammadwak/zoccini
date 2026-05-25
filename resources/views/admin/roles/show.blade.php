@extends('layouts.admin')
@section('content')

@php
$moduleAr = [
    'ad'=>'الإعلانات','address'=>'العناوين','ads'=>'الإعلانات',
    'adscategory'=>'تصنيفات الإعلانات','allad'=>'كل الإعلانات',
    'becomepartner'=>'طلب شراكة','cancelreason'=>'أسباب الإلغاء',
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
    'access' =>['bg'=>'rgba(71,85,105,.08)','text'=>'#475569','border'=>'rgba(71,85,105,.2)'],
    'create' =>['bg'=>'rgba(22,163,74,.08)', 'text'=>'#16a34a','border'=>'rgba(22,163,74,.2)'],
    'edit'   =>['bg'=>'rgba(217,119,6,.08)', 'text'=>'#b45309','border'=>'rgba(217,119,6,.2)'],
    'update' =>['bg'=>'rgba(217,119,6,.08)', 'text'=>'#b45309','border'=>'rgba(217,119,6,.2)'],
    'delete' =>['bg'=>'rgba(220,38,38,.08)', 'text'=>'#dc2626','border'=>'rgba(220,38,38,.2)'],
    'destroy'=>['bg'=>'rgba(220,38,38,.08)', 'text'=>'#dc2626','border'=>'rgba(220,38,38,.2)'],
    'show'   =>['bg'=>'rgba(37,99,235,.08)', 'text'=>'#2563eb','border'=>'rgba(37,99,235,.2)'],
    'view'   =>['bg'=>'rgba(37,99,235,.08)', 'text'=>'#2563eb','border'=>'rgba(37,99,235,.2)'],
    'index'  =>['bg'=>'rgba(124,58,237,.08)','text'=>'#7c3aed','border'=>'rgba(124,58,237,.2)'],
    'export' =>['bg'=>'rgba(14,116,144,.08)','text'=>'#0e7490','border'=>'rgba(14,116,144,.2)'],
    'import' =>['bg'=>'rgba(14,116,144,.08)','text'=>'#0e7490','border'=>'rgba(14,116,144,.2)'],
];
$translatePerm = function(string $title) use ($moduleAr,$actionAr,$actionColors):array {
    $parts  = explode('_',$title);
    $action = strtolower(array_pop($parts));
    $module = strtolower(implode('',$parts));
    return [
        'module' => $moduleAr[$module] ?? ucwords(str_replace('_',' ',$module)),
        'action' => $actionAr[$action]  ?? ucfirst($action),
        'colors' => $actionColors[$action] ?? ['bg'=>'rgba(71,85,105,.08)','text'=>'#475569','border'=>'rgba(71,85,105,.2)'],
        'raw'    => $title,
    ];
};

/* تجميع الصلاحيات حسب الوحدة */
$grouped = $role->permissions->groupBy(function($p) use ($moduleAr){
    $parts = explode('_', $p->title);
    array_pop($parts);
    $key = strtolower(implode('', $parts));
    return $moduleAr[$key] ?? ucwords(str_replace('_',' ',$key));
})->sortKeys();
@endphp

<div style="padding:24px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#8b5cf6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(124,58,237,.3);"><i class="fas fa-user-tag"></i></div>
            <div>
                <h1 style="font-size:1.15rem;font-weight:800;color:var(--z-text);margin:0;">{{ $role->title }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">&rsaquo;</span>
                    <a href="{{ route('admin.roles.index') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('cruds.role.title') }}</a>
                    <span style="margin:0 5px;">&rsaquo;</span>
                    <span>{{ $role->title }}</span>
                </nav>
            </div>
        </div>
        <a href="{{ route('admin.roles.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 15px;background:var(--z-surface-2);border:1px solid var(--z-border);color:var(--z-text);border-radius:9px;font-size:0.8rem;font-weight:600;text-decoration:none;">
            <i class="fas fa-arrow-right" style="font-size:0.72rem;"></i>
            {{ trans('global.back_to_list') }}
        </a>
    </div>

    {{-- Info Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);padding:22px;margin-bottom:22px;">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;">
            <div>
                <div style="font-size:0.7rem;font-weight:700;color:var(--z-text-faint);text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px;">{{ trans('cruds.role.fields.id') }}</div>
                <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">#{{ $role->id }}</div>
            </div>
            <div>
                <div style="font-size:0.7rem;font-weight:700;color:var(--z-text-faint);text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px;">{{ trans('cruds.role.fields.title') }}</div>
                <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ $role->title }}</div>
            </div>
            <div>
                <div style="font-size:0.7rem;font-weight:700;color:var(--z-text-faint);text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px;">عدد الصلاحيات</div>
                <span style="background:rgba(124,58,237,.1);color:#7c3aed;padding:3px 12px;border-radius:8px;font-weight:800;font-size:0.9rem;">{{ $role->permissions->count() }}</span>
            </div>
        </div>
    </div>

    {{-- Permissions grouped by module --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">
        <div style="padding:16px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);display:flex;align-items:center;gap:10px;">
            <div style="width:32px;height:32px;border-radius:9px;background:rgba(124,58,237,.1);display:flex;align-items:center;justify-content:center;color:#7c3aed;"><i class="fas fa-shield-alt"></i></div>
            <span style="font-weight:700;color:var(--z-text);font-size:0.9rem;">{{ trans('cruds.permission.title') }}</span>
            <span style="background:rgba(124,58,237,.1);color:#7c3aed;padding:2px 10px;border-radius:6px;font-size:0.78rem;font-weight:700;">{{ $role->permissions->count() }}</span>
        </div>
        <div style="padding:20px 22px;">
            @if($grouped->isEmpty())
                <div style="text-align:center;padding:32px;color:var(--z-text-faint);"><i class="fas fa-lock-open" style="font-size:2rem;margin-bottom:10px;display:block;"></i>لا توجد صلاحيات مُعيّنة</div>
            @else
                <div style="display:flex;flex-direction:column;gap:14px;">
                @foreach($grouped as $moduleName => $perms)
                    <div style="background:var(--z-surface-2);border:1px solid var(--z-border);border-radius:12px;overflow:hidden;">
                        {{-- Module header --}}
                        <div style="padding:10px 16px;background:var(--z-surface-offset);border-bottom:1px solid var(--z-border);display:flex;align-items:center;justify-content:space-between;">
                            <span style="font-weight:700;font-size:0.85rem;color:var(--z-text);">{{ $moduleName }}</span>
                            <span style="background:rgba(124,58,237,.1);color:#7c3aed;padding:1px 8px;border-radius:5px;font-size:0.72rem;font-weight:700;">{{ $perms->count() }}</span>
                        </div>
                        {{-- Permissions --}}
                        <div style="padding:12px 16px;display:flex;flex-wrap:wrap;gap:6px;">
                        @foreach($perms as $perm)
                        @php $t = $translatePerm($perm->title); @endphp
                            <span title="{{ $perm->title }}" style="display:inline-flex;align-items:center;gap:5px;background:{{ $t['colors']['bg'] }};border:1px solid {{ $t['colors']['border'] }};border-radius:8px;padding:4px 10px;">
                                <span style="font-size:0.8rem;font-weight:700;color:{{ $t['colors']['text'] }};">{{ $t['action'] }}</span>
                                <span style="font-size:0.68rem;color:{{ $t['colors']['text'] }};opacity:.65;font-family:monospace;">{{ $perm->title }}</span>
                            </span>
                        @endforeach
                        </div>
                    </div>
                @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
