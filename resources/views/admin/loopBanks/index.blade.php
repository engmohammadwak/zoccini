@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Loop Banks" icon="fas fa-university" color="green"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Loop Banks']]" />
    @php $total=$loopBanks->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-university"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Banks</div></div>
        </div>
    </div>
    <x-admin-table title="Loop Banks" icon="fas fa-university" color="green" datatableClass="datatable-LoopBank" :count="$loopBanks->count()" :createRoute="can('loop_bank_create') ? route('admin.loop-banks.create') : null" :createLabel="trans('global.add').' Bank'">
        <x-slot name="thead"><tr><th width="10"></th><th>Logo</th><th>Name EN</th><th>Name AR</th><th>IBAN / Account</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($loopBanks as $bank)
            <tr data-entry-id="{{ $bank->id }}">
                <td></td>
                <td>@if($bank->logo ?? $bank->image ?? null)<img src="{{ asset('storage/'.($bank->logo ?? $bank->image)) }}" style="width:42px;height:32px;object-fit:contain;border-radius:6px;border:1px solid #f1f5f9;" alt="" loading="lazy">@else<div style="width:42px;height:32px;border-radius:6px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;color:#10b981;"><i class="fas fa-university"></i></div>@endif</td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $bank->name_en ?? $bank->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $bank->name_ar ?? '—' }}</td>
                <td><span style="font-family:monospace;font-size:0.82rem;color:#475569;">{{ $bank->iban ?? $bank->account_number ?? '—' }}</span></td>
                <td style="display:flex;gap:5px;">
                    @can('loop_bank_show')<x-admin-action-btn href="{{ route('admin.loop-banks.show',$bank->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('loop_bank_edit')<x-admin-action-btn href="{{ route('admin.loop-banks.edit',$bank->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('loop_bank_delete')<x-admin-action-btn href="{{ route('admin.loop-banks.destroy',$bank->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-LoopBank:not(.ajaxTable)').DataTable({order:[[2,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
