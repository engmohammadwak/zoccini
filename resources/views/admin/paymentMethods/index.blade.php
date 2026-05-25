@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:19px;box-shadow:0 4px 14px rgba(16,185,129,.3);">
                <i class="fas fa-credit-card"></i>
            </div>
            <div>
                <h1 style="font-size:1.2rem;font-weight:800;color:var(--z-text);margin:0;line-height:1.2;">{{ trans('cruds.paymentMethod.title') }}</h1>
                <nav style="font-size:0.75rem;color:var(--z-text-faint);margin-top:3px;">
                    <a href="{{ route('admin.home') }}" style="color:var(--z-primary);text-decoration:none;">{{ trans('global.dashboard') }}</a>
                    <span style="margin:0 5px;">&rsaquo;</span>
                    <span>{{ trans('cruds.paymentMethod.title') }}</span>
                </nav>
            </div>
        </div>
    </div>

    @php
        $total = $paymentMethods->count();
    @endphp

    {{-- KPI Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:14px;margin-bottom:24px;">
        <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:14px;padding:18px;box-shadow:var(--z-card-shadow);display:flex;align-items:center;gap:13px;">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 4px 12px rgba(16,185,129,.3);"><i class="fas fa-credit-card"></i></div>
            <div>
                <div style="font-size:1.55rem;font-weight:800;color:var(--z-text);line-height:1;">{{ $total }}</div>
                <div style="font-size:0.72rem;color:var(--z-text-faint);margin-top:3px;font-weight:600;">{{ trans('cruds.paymentMethod.title') }}</div>
            </div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div style="background:var(--z-card-bg);border:1px solid var(--z-card-border);border-radius:16px;box-shadow:var(--z-card-shadow);overflow:hidden;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--z-border);background:var(--z-surface-2);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(16,185,129,.1);display:flex;align-items:center;justify-content:center;color:#10b981;font-size:15px;"><i class="fas fa-credit-card"></i></div>
                <div>
                    <div style="font-size:0.9rem;font-weight:700;color:var(--z-text);">{{ trans('cruds.paymentMethod.title') }}</div>
                    <div style="font-size:0.72rem;color:var(--z-text-faint);">{{ $total }} {{ trans('global.entries') }}</div>
                </div>
            </div>
            @can('payment_method_create')
            <a href="{{ route('admin.payment-methods.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:var(--z-primary);color:#fff;border-radius:10px;font-size:0.8rem;font-weight:700;text-decoration:none;box-shadow:0 3px 10px rgba(16,185,129,.3);transition:background .18s;"
               onmouseover="this.style.background='var(--z-primary-hover)'" onmouseout="this.style.background='var(--z-primary)'">
                <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                {{ trans('global.add') }} {{ trans('cruds.paymentMethod.title_singular') }}
            </a>
            @endcan
        </div>
        <div style="padding:16px 22px;overflow-x:auto;">
            <table class="table datatable-PaymentMethod" style="width:100%;">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.paymentMethod.fields.logo') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.paymentMethod.fields.name_en') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">{{ trans('cruds.paymentMethod.fields.name_ar') }}</th>
                        <th style="font-size:0.72rem;font-weight:700;color:var(--z-text-muted);text-transform:uppercase;letter-spacing:.06em;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($paymentMethods as $pm)
                <tr data-entry-id="{{ $pm->id }}">
                    <td></td>
                    <td>
                        @if($pm->logo)
                        <img src="{{ $pm->logo->url }}" style="width:48px;height:36px;object-fit:contain;border-radius:6px;border:1px solid var(--z-border);" alt="" loading="lazy">
                        @else
                        <div style="width:48px;height:36px;border-radius:6px;background:rgba(16,185,129,.08);display:flex;align-items:center;justify-content:center;color:#10b981;"><i class="fas fa-credit-card"></i></div>
                        @endif
                    </td>
                    <td>
                        <span style="font-weight:700;color:var(--z-text);font-size:0.85rem;">{{ $pm->name_en ?? '—' }}</span>
                    </td>
                    <td style="color:var(--z-text-muted);font-size:0.83rem;direction:rtl;">{{ $pm->name_ar ?? '—' }}</td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            @can('payment_method_show')
                            <a href="{{ route('admin.payment-methods.show',$pm->id) }}" title="{{ trans('global.view') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(59,130,246,.1);color:#3b82f6;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(59,130,246,.22)'" onmouseout="this.style.background='rgba(59,130,246,.1)'"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('payment_method_edit')
                            <a href="{{ route('admin.payment-methods.edit',$pm->id) }}" title="{{ trans('global.edit') }}"
                               style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.1);color:#b45309;display:inline-flex;align-items:center;justify-content:center;font-size:0.78rem;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='rgba(245,158,11,.22)'" onmouseout="this.style.background='rgba(245,158,11,.1)'"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('payment_method_delete')
                            <form action="{{ route('admin.payment-methods.destroy',$pm->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">@csrf @method('DELETE')
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
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
    @can('payment_method_delete')
    dtButtons.push({
        text: '{{ trans('global.datatables.delete') }}',
        url: "{{ route('admin.payment-methods.massDestroy') }}",
        className: 'btn-danger',
        action: function(e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).nodes(), function(entry) { return $(entry).data('entry-id'); });
            if (ids.length === 0) { alert('{{ trans('global.datatables.zero_selected') }}'); return; }
            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                    headers: { 'x-csrf-token': _token },
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'DELETE' }
                }).done(function() { location.reload(); });
            }
        }
    });
    @endcan
    $.extend(true, $.fn.dataTable.defaults, { orderCellsTop: true, pageLength: 25 });
    $('.datatable-PaymentMethod:not(.ajaxTable)').DataTable({
        buttons: dtButtons,
        order: [[2, 'asc']],
        columnDefs: [{ orderable: false, targets: [0, 1, 4] }]
    });
});
</script>
@endsection
