@extends('layouts.admin')
@section('content')
<div style="min-height:100vh;padding:24px;">

    <x-admin-page-header title="{{ trans('cruds.pointType.title') }}" icon="fas fa-star" color="orange"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.pointType.title')]]" />
    @php $total=$pointTypes->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f97316,#ea580c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-star"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.pointType.title') }}</div></div>
        </div>
    </div>
    <x-admin-table
        title="{{ trans('cruds.pointType.title') }}" icon="fas fa-star" color="orange"
        datatableClass="datatable-PointType"
        :count="$pointTypes->count()"
        createPermission="point_type_create"
        :createRoute="route('admin.point-types.create')"
    >
        <x-slot name="thead"><tr><th width="10"></th><th>{{ trans('cruds.pointType.fields.name') }}</th><th>{{ trans('cruds.pointType.fields.points') ?? 'Points' }}</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($pointTypes as $type)
            <tr data-entry-id="{{ $type->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $type->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $type->points ?? $type->value ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('point_type_show')<x-admin-action-btn href="{{ route('admin.point-types.show',$type->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('point_type_edit')<x-admin-action-btn href="{{ route('admin.point-types.edit',$type->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('point_type_delete')<x-admin-action-btn href="{{ route('admin.point-types.destroy',$type->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
$(document).ready(function(){$('.datatable-PointType').DataTable({pageLength:25,order:[[1,'asc']]});});
</script>
@stop
