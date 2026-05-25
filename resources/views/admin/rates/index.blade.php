@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="{{ trans('cruds.rate.title') }}" icon="fas fa-star" color="gold" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.rate.title')]]" />
    <x-admin-table :title="trans('cruds.rate.title_singular').' '.trans('global.list')" icon="fas fa-star" color="gold" datatableClass="datatable-Rate" :count="$rates->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Restaurant</th><th>Rate</th><th>Comment</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($rates as $rate)
            <tr data-entry-id="{{ $rate->id }}">
                <td></td>
                <td>{{ optional($rate->user)->name ?? '' }}</td>
                <td>{{ optional($rate->restaurant)->name_en ?? '' }}</td>
                <td>
                    @for($i=1;$i<=5;$i++)
                        <i class="fas fa-star" style="color:{{ $i<=$rate->rate ? '#f59e0b' : '#d1d5db' }};font-size:0.75rem;"></i>
                    @endfor
                    <strong style="margin-right:4px;">{{ $rate->rate }}/5</strong>
                </td>
                <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $rate->comment ?? '' }}</td>
                <td style="color:#7a80a0;font-size:0.82rem;">{{ optional($rate->created_at)->format('d/m/Y') ?? '' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('rate_show')<x-admin-action-btn href="{{ route('admin.rates.show',$rate->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('rate_delete')<x-admin-action-btn href="{{ route('admin.rates.destroy',$rate->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-Rate:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
