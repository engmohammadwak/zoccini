@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.permission.title')"
        icon="fas fa-key"
        color="slate"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.permission.title')],
        ]"
    />

    @php
        $total  = $permissions->count();
        $groups = $permissions->groupBy(fn($p) => explode('_',$p->title)[0])->count();

        $moduleAr = [
            'ad'                 => 'الإعلانات',
            'address'            => 'العناوين',
            'ads'                => 'الإعلانات',
            'adscategory'        => 'تصنيفات الإعلانات',
            'allad'              => 'كل الإعلانات',
            'becomePartner'      => 'طلب شراكة',
            'becomepartner'      => 'طلب شراكة',
            'cancelreason'       => 'أسباب الإلغاء',
            'cancel'             => 'الإلغاء',
            'carbrand'           => 'ماركات السيارات',
            'carcolor'           => 'ألوان السيارات',
            'carlist'            => 'قائمة السيارات',
            'cart'               => 'سلة التسوق',
            'category'           => 'الفئات',
            'categorytoprestaurant' => 'تصنيف المطاعم المميزة',
            'city'               => 'المدن',
            'contact'            => 'التواصل',
            'country'            => 'الدول',
            'coupon'             => 'الكوبونات',
            'currency'           => 'العملات',
            'delivery'           => 'التوصيل',
            'deliverycompany'    => 'شركات التوصيل',
            'expense'            => 'المصاريف',
            'expensecategory'    => 'تصنيفات المصاريف',
            'extra'              => 'الإضافات',
            'faq'                => 'الأسئلة الشائعة',
            'favorite'           => 'المفضلة',
            'image'              => 'الصور',
            'income'             => 'الإيرادات',
            'incomecategory'     => 'تصنيفات الإيرادات',
            'item'               => 'المنتجات',
            'loopbank'           => 'البنك',
            'loopuser'           => 'مستخدمو النظام',
            'notification'       => 'الإشعارات',
            'offeruser'          => 'عروض المستخدمين',
            'onbordering'        => 'التأهيل',
            'order'              => 'الطلبات',
            'orderstatus'        => 'حالات الطلبات',
            'ordertype'          => 'أنواع الطلبات',
            'otherbranch'        => 'الفروع الأخرى',
            'paymentmethod'      => 'طرق الدفع',
            'permission'         => 'الصلاحيات',
            'point'              => 'النقاط',
            'pointtype'          => 'أنواع النقاط',
            'qa'                 => 'الأسئلة والأجوبة',
            'qamessage'          => 'رسائل الأسئلة',
            'qatopic'            => 'مواضيع الأسئلة',
            'queue'              => 'قائمة الانتظار',
            'rate'               => 'التقييمات',
            'referralsubscription' => 'اشتراكات الإحالة',
            'reporting'          => 'التقارير',
            'restaurant'         => 'المطاعم',
            'role'               => 'الأدوار',
            'savecreditcard'     => 'بطاقات الائتمان',
            'setting'            => 'الإعدادات',
            'sittingarea'        => 'مناطق الجلوس',
            'slideshow'          => 'عروض الشرائح',
            'slider'             => 'السلايدر',
            'smshistory'         => 'سجل الرسائل',
            'subscriptionpackage'=> 'باقات الاشتراك',
            'subscriptionuser'   => 'اشتراكات المستخدمين',
            'subscriptionvip'    => 'اشتراكات VIP',
            'table'              => 'الطاولات',
            'tablestatus'        => 'حالات الطاولات',
            'ticket'             => 'التذاكر',
            'ticketmessage'      => 'رسائل التذاكر',
            'ticketstatus'       => 'حالات التذاكر',
            'toprestaurant'      => 'المطاعم المميزة',
            'typeofcar'          => 'أنواع السيارات',
            'user'               => 'المستخدمون',
            'useralert'          => 'تنبيهات المستخدمين',
            'userstatus'         => 'حالات المستخدمين',
            'venturecompany'     => 'شركات المشاريع',
        ];

        $actionAr = [
            'access'  => 'الوصول',
            'create'  => 'إضافة',
            'edit'    => 'تعديل',
            'delete'  => 'حذف',
            'show'    => 'عرض',
            'view'    => 'عرض',
            'index'   => 'قائمة',
            'store'   => 'حفظ',
            'update'  => 'تحديث',
            'destroy' => 'حذف',
            'export'  => 'تصدير',
            'import'  => 'استيراد',
            'approve' => 'موافقة',
            'reject'  => 'رفض',
            'manage'  => 'إدارة',
        ];

        $translateTitle = function(string $title) use ($moduleAr, $actionAr): string {
            $parts  = explode('_', $title);
            $action = strtolower(array_pop($parts));
            $module = strtolower(implode('', $parts));
            $moduleLabel = $moduleAr[$module] ?? ucwords(str_replace('_', ' ', $module));
            $actionLabel = $actionAr[$action] ?? ucfirst($action);
            return $moduleLabel . ' — ' . $actionLabel;
        };
    @endphp

    {{-- KPI Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:16px 18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#475569,#64748b);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-key"></i></div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div>
                <div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:2px;font-weight:600;">{{ trans('cruds.permission.title') }}</div>
            </div>
        </div>
        <div style="background:linear-gradient(135deg,#475569,#334155);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(71,85,105,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-layer-group"></i></div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $groups }}</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;font-weight:600;">{{ trans('global.groups') ?? 'Groups' }}</div>
            </div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(71,85,105,.1);display:flex;align-items:center;justify-content:center;color:#64748b;font-size:15px;"><i class="fas fa-key"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.permission.title') }}</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') ?? 'entries' }}</div>
                </div>
            </div>
            @can('permission_create')
            <a href="{{ route('admin.permissions.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(39,186,77,.3);transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                {{ trans('global.add') }} {{ trans('cruds.permission.title_singular') }}
            </a>
            @endcan
        </div>

        {{-- Table --}}
        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-Permission" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.permission.fields.title') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">الاسم بالعربي</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                @php
                    $arabicName = $translateTitle($permission->title);
                    $parts   = explode('_', $permission->title);
                    $action  = strtolower(array_pop($parts));
                    $actionColors = [
                        'access'  => ['bg'=>'rgba(100,116,139,.15)','color'=>'#64748b'],
                        'create'  => ['bg'=>'rgba(22,163,74,.15)', 'color'=>'#16a34a'],
                        'edit'    => ['bg'=>'rgba(217,119,6,.15)',  'color'=>'#d97706'],
                        'update'  => ['bg'=>'rgba(217,119,6,.15)',  'color'=>'#d97706'],
                        'delete'  => ['bg'=>'rgba(220,38,38,.15)',  'color'=>'#dc2626'],
                        'destroy' => ['bg'=>'rgba(220,38,38,.15)',  'color'=>'#dc2626'],
                        'show'    => ['bg'=>'rgba(37,99,235,.15)',  'color'=>'#2563eb'],
                        'view'    => ['bg'=>'rgba(37,99,235,.15)',  'color'=>'#2563eb'],
                        'index'   => ['bg'=>'rgba(124,58,237,.15)', 'color'=>'#7c3aed'],
                        'export'  => ['bg'=>'rgba(14,116,144,.15)', 'color'=>'#0e7490'],
                        'import'  => ['bg'=>'rgba(14,116,144,.15)', 'color'=>'#0e7490'],
                    ];
                    $badge = $actionColors[$action] ?? ['bg'=>'rgba(71,85,105,.15)','color'=>'#475569'];
                @endphp
                <tr data-entry-id="{{ $permission->id }}">
                    <td></td>
                    <td>
                        <span style="display:inline-flex;align-items:center;gap:6px;flex-wrap:wrap;">
                            <span style="background:var(--z-surface-offset, #f1f5f9);color:var(--z-text-muted);padding:3px 10px;border-radius:7px;font-weight:700;font-size:0.82rem;font-family:monospace;letter-spacing:0.3px;">{{ $permission->title }}</span>
                            <span style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};padding:2px 8px;border-radius:6px;font-size:0.72rem;font-weight:600;text-transform:uppercase;">{{ $action }}</span>
                        </span>
                    </td>
                    <td>
                        <span style="font-size:0.87rem;color:var(--z-text);font-weight:500;">{{ $arabicName }}</span>
                    </td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            @can('permission_show')
                            <a href="{{ route('admin.permissions.show',$permission->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('permission_edit')
                            <a href="{{ route('admin.permissions.edit',$permission->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('permission_delete')
                            <form action="{{ route('admin.permissions.destroy',$permission->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
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
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:50});
    $('.datatable-Permission:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)});
});
</script>
@endsection
