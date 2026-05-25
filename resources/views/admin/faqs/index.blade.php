@extends('layouts.admin')
@section('content')
<div style="padding:24px;">
    <x-admin-page-header title="FAQs" icon="fas fa-question-circle" color="purple"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'FAQs']]" />
    @php $total=$faqs->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#8b5cf6,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-question-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">FAQs</div></div>
        </div>
    </div>
    <x-admin-table title="FAQs" icon="fas fa-question-circle" color="purple" datatableClass="datatable-Faq" :count="$faqs->count()" createPermission="faq_create" :createRoute="route('admin.faqs.create')" :createLabel="trans('global.add').' FAQ'">
        <x-slot name="thead"><tr><th width="10"></th><th>Question EN</th><th>Question AR</th><th>Sort</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($faqs as $faq)
            <tr data-entry-id="{{ $faq->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $faq->question_en ?? $faq->question ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $faq->question_ar ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ $faq->sort ?? $faq->order ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('faq_show')<x-admin-action-btn href="{{ route('admin.faqs.show',$faq->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('faq_edit')<x-admin-action-btn href="{{ route('admin.faqs.edit',$faq->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('faq_delete')<x-admin-action-btn href="{{ route('admin.faqs.destroy',$faq->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-Faq:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
