@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

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

        /* ---- خريطة ترجمة أسماء الوحدات ---- */
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

        /* ---- خريطة ترجمة أسماء العمليات ---- */
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

        /* ---- دالة ترجمة العنوان ---- */
        $translateTitle = function(string $title) use ($moduleAr, $actionAr): string {
            $parts  = explode('_', $title);
            // العملية هي آخر جزء
            $action = strtolower(array_pop($parts));
            // الوحدة هي ما تبقى
            $module = strtolower(implode('', $parts));

            $moduleLabel = $moduleAr[$module] ?? ucwords(str_replace('_', ' ', $module));
            $actionLabel = $actionAr[$action] ?? ucfirst($action);

            return $moduleLabel . ' — ' . $actionLabel;
        };
    @endphp

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#475569,#64748b);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-key"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Total</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#475569,#334155);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(71,85,105,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-layer-group"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $groups }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Groups</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.permission.title')"
        icon="fas fa-key"
        color="slate"
        datatableClass="datatable-Permission"
        :count="$permissions->count()"
        :createRoute="auth()->user()->can('permission_create') ? route('admin.permissions.create') : null"
        :createLabel="trans('global.add').' Permission'"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.permission.fields.title') }} (EN)</th>
                <th>الاسم بالعربي</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($permissions as $permission)
            @php
                $arabicName = $translateTitle($permission->title);
                // استخراج القسم لعرض badge اللون
                $parts   = explode('_', $permission->title);
                $action  = strtolower(array_pop($parts));
                $actionColors = [
                    'access'  => '#64748b',
                    'create'  => '#16a34a',
                    'edit'    => '#d97706',
                    'update'  => '#d97706',
                    'delete'  => '#dc2626',
                    'destroy' => '#dc2626',
                    'show'    => '#2563eb',
                    'view'    => '#2563eb',
                    'index'   => '#7c3aed',
                    'export'  => '#0e7490',
                    'import'  => '#0e7490',
                ];
                $badgeColor = $actionColors[$action] ?? '#475569';
            @endphp
            <tr data-entry-id="{{ $permission->id }}">
                <td></td>
                <td>
                    <span style="display:inline-flex;align-items:center;gap:6px;">
                        <span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:7px;font-weight:700;font-size:0.82rem;font-family:monospace;letter-spacing:0.3px;">{{ $permission->title }}</span>
                        <span style="background:{{ $badgeColor }}1a;color:{{ $badgeColor }};padding:2px 8px;border-radius:6px;font-size:0.72rem;font-weight:600;text-transform:uppercase;">{{ $action }}</span>
                    </span>
                </td>
                <td>
                    <span style="font-size:0.87rem;color:#1e293b;font-weight:500;">{{ $arabicName }}</span>
                </td>
                <td style="display:flex;gap:5px;">
                    @can('permission_show')<x-admin-action-btn href="{{ route('admin.permissions.show',$permission->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('permission_edit')<x-admin-action-btn href="{{ route('admin.permissions.edit',$permission->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('permission_delete')<x-admin-action-btn href="{{ route('admin.permissions.destroy',$permission->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>

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
