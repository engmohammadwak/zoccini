@extends('layouts.admin')
@section('content')
<div style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Slide Shows" icon="fas fa-film" color="purple"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Slide Shows']]" />
    @php $total=$slideShows->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#9333ea,#c084fc);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-film"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Slides</div></div>
        </div>
    </div>
    <x-admin-table title="Slide Shows" icon="fas fa-film" color="purple" datatableClass="datatable-SlideShow" :count="$slideShows->count()" createPermission="slide_show_create" :createRoute="route('admin.slide-shows.create')" :createLabel="trans('global.add').' Slide'">
        <x-slot name="thead"><tr><th width="10"></th><th>Image</th><th>Title EN</th><th>Title AR</th><th>Sort</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($slideShows as $slide)
            <tr data-entry-id="{{ $slide->id }}">
                <td></td>
                <td>@if($slide->image ?? null)<img src="{{ asset('storage/'.$slide->image) }}" style="width:64px;height:36px;object-fit:cover;border-radius:7px;" alt="" loading="lazy">@else<div style="width:64px;height:36px;border-radius:7px;background:#faf5ff;display:flex;align-items:center;justify-content:center;color:#9333ea;"><i class="fas fa-image"></i></div>@endif</td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $slide->title_en ?? $slide->title ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $slide->title_ar ?? '—' }}</td>
                <td><span style="background:#faf5ff;color:#7e22ce;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.82rem;">{{ $slide->sort ?? $slide->order ?? '—' }}</span></td>
                <td>@if($slide->status ?? 1)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Active</span>@else<span style="background:#f1f5f9;color:#64748b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">Inactive</span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('slide_show_show')<x-admin-action-btn href="{{ route('admin.slide-shows.show',$slide->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('slide_show_edit')<x-admin-action-btn href="{{ route('admin.slide-shows.edit',$slide->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('slide_show_delete')<x-admin-action-btn href="{{ route('admin.slide-shows.destroy',$slide->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-SlideShow:not(.ajaxTable)').DataTable({order:[[4,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
