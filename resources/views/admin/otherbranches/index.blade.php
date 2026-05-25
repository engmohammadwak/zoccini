@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Other Branches" icon="fas fa-code-branch" color="violet"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Other Branches']]" />
    @php $total=$otherbranches->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-code-branch"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Branches</div></div>
        </div>
    </div>
    <x-admin-table title="Other Branches" icon="fas fa-code-branch" color="violet" datatableClass="datatable-Otherbranch" :count="$otherbranches->count()" :createRoute="\Illuminate\Support\Facades\Gate::allows('otherbranch_create') ? route('admin.otherbranches.create') : null" :createLabel="trans('global.add').' Branch'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Restaurant</th><th>City</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($otherbranches as $branch)
            <tr data-entry-id="{{ $branch->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $branch->branch_name_en ?? $branch->name_en ?? $branch->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $branch->branch_name_ar ?? $branch->name_ar ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($branch->restaurants)->name_en ?? optional($branch->restaurants)->name ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($branch->city)->name_en ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('otherbranch_show')<x-admin-action-btn href="{{ route('admin.otherbranches.show',$branch->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('otherbranch_edit')<x-admin-action-btn href="{{ route('admin.otherbranches.edit',$branch->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('otherbranch_delete')<x-admin-action-btn href="{{ route('admin.otherbranches.destroy',$branch->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-Otherbranch:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
