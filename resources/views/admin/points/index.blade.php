@extends('layouts.admin')
@section('content')
<div style="min-height:100vh;padding:24px;">

    <x-admin-page-header title="{{ trans('cruds.point.title') }}" icon="fas fa-coins" color="green"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.point.title')]]" />
    @php $total=$points->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#22c55e,#16a34a);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-coins"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.point.title') }}</div></div>
        </div>
    </div>
    <x-admin-table
        title="{{ trans('cruds.point.title') }}" icon="fas fa-coins" color="green"
        datatableClass="datatable-Point"
        :count="$points->count()"
        createPermission="point_create"
        :createRoute="route('admin.points.create')"
    >
        <x-slot name="thead"><tr><th width="10"></th><th>{{ trans('cruds.point.fields.user') }}</th><th>{{ trans('cruds.point.fields.point_type') }}</th><th>{{ trans('cruds.point.fields.points') }}</th><th>{{ trans('cruds.point.fields.created_at') ?? 'Date' }}</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($points as $point)
            <tr data-entry-id="{{ $point->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ optional($point->user)->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($point->pointType)->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $point->points ?? $point->amount ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ $point->created_at ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('point_show')<x-admin-action-btn href="{{ route('admin.points.show',$point->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('point_edit')<x-admin-action-btn href="{{ route('admin.points.edit',$point->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('point_delete')<x-admin-action-btn href="{{ route('admin.points.destroy',$point->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
$(document).ready(function(){$('.datatable-Point').DataTable({pageLength:25,order:[[4,'desc']]});});
</script>
@stop
