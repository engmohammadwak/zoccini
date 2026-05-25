# Admin Shared Components

هذه المكونات المشتركة تُستخدم في جميع صفحات لوحة التحكم لضمان التصميم الموحّد.

## المكونات المتاحة

### 1. `<x-admin-table>` — الجدول الرئيسي

```blade
<x-admin-table
    :title="trans('cruds.order.title')"
    icon="fas fa-receipt"
    color="blue"
    datatableClass="datatable-Order"
    :count="$orders->count()"
    :createRoute="route('admin.orders.create')"
    :createLabel="trans('global.add')"
>
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </x-slot>
    <x-slot name="tbody">
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->name }}</td>
            <td>
                <x-admin-action-btn
                    href="{{ route('admin.orders.show', $order->id) }}"
                    icon="fas fa-eye"
                    :label="trans('global.view')"
                    color="blue"
                />
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-admin-table>
```

### 2. `<x-admin-page-header>` — رأس الصفحة

```blade
<x-admin-page-header
    :title="trans('cruds.order.title')"
    icon="fas fa-receipt"
    color="blue"
    :breadcrumbs="[
        ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
        ['label' => trans('cruds.order.title')],
    ]"
/>
```

### 3. `<x-admin-status-badge>` — شارة الحالة

```blade
<x-admin-status-badge label="Active" type="success" />
<x-admin-status-badge label="Pending" type="warning" />
<x-admin-status-badge label="Cancelled" type="danger" />
```

**أنواع الحالات:** `success` | `warning` | `danger` | `info` | `primary` | `secondary` | `purple` | `cyan` | `orange` | `pink` | `default`

### 4. `<x-admin-action-btn>` — زر الإجراء

```blade
{{-- عرض --}}
<x-admin-action-btn href="{{ route('admin.orders.show', $id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />

{{-- تعديل --}}
<x-admin-action-btn href="{{ route('admin.orders.edit', $id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />

{{-- حذف --}}
<x-admin-action-btn href="{{ route('admin.orders.destroy', $id) }}" icon="fas fa-trash" method="DELETE" color="red" />
```

**ألوان الأزرار:** `blue` | `green` | `orange` | `red` | `purple` | `cyan` | `pink` | `indigo`

### 5. `<x-admin-avatar>` — أفاتار المستخدم

```blade
{{-- نص فقط --}}
<x-admin-avatar :name="$user->name" color="blue" />

{{-- مع صورة --}}
<x-admin-avatar :name="$user->name" :image="$user->avatar" size="36px" />
```

## ألوان الثيم المتاحة

| اللون | الكود |
|-------|-------|
| أزرق-بنفسجي | `blue` |
| أخضر | `green` |
| برتقالي | `orange` |
| بنفسجي | `purple` |
| أحمر | `red` |
| سماوي | `cyan` |
| نيلي | `indigo` |
| تيل | `teal` |
| وردي | `pink` |
