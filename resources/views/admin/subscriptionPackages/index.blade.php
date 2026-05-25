@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        title="Subscription Packages"
        icon="fas fa-box-open"
        color="purple"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => 'Subscription Packages'],
        ]"
    />

    {{-- ===== Stats Cards ===== --}}
    @php
        $totalP   = $subscriptionPackages->count();
        $activeP  = $subscriptionPackages->where('status',1)->count();
        $inactiveP= $subscriptionPackages->where('status',0)->count();
        $avgPrice = $totalP > 0 ? $subscriptionPackages->avg('price') : 0;
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:22px;">

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#9333ea,#a855f7);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-box-open"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $totalP }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Packages</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-toggle-on"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $activeP }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#94a3b8,#cbd5e1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-toggle-off"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $inactiveP }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.inactive') ?? 'Inactive' }}</div>
            </div>
        </div>

        <div style="background:linear-gradient(135deg,#9333ea,#7c3aed);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(147,51,234,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <div style="font-size:1.1rem;font-weight:800;color:#fff;line-height:1;">{{ number_format($avgPrice,2) }}</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Avg Price</div>
            </div>
        </div>

    </div>

    {{-- ===== Packages Grid ===== --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;margin-bottom:24px;">
        @foreach($subscriptionPackages as $pkg)
        @php
            $gradients = [
                0 => ['from'=>'#6366f1','to'=>'#8b5cf6'],
                1 => ['from'=>'#0ea5e9','to'=>'#6366f1'],
                2 => ['from'=>'#f97316','to'=>'#ef4444'],
                3 => ['from'=>'#10b981','to'=>'#0ea5e9'],
            ];
            $g = $gradients[$loop->index % 4];
        @endphp
        <div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.08);transition:transform 0.2s,box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.08)'">
            {{-- Header --}}
            <div style="background:linear-gradient(135deg,{{ $g['from'] }},{{ $g['to'] }});padding:20px 18px;position:relative;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                    <div>
                        <div style="color:rgba(255,255,255,0.75);font-size:0.72rem;font-weight:600;letter-spacing:1px;text-transform:uppercase;">Package</div>
                        <div style="color:#fff;font-size:1rem;font-weight:800;margin-top:3px;">{{ $pkg->name_en ?? '' }}</div>
                        <div style="color:rgba(255,255,255,0.65);font-size:0.78rem;margin-top:1px;">{{ $pkg->name_ar ?? '' }}</div>
                    </div>
                    <div style="background:rgba(255,255,255,0.15);border-radius:10px;padding:8px 12px;text-align:center;">
                        <div style="color:#fff;font-size:1.4rem;font-weight:900;line-height:1;">{{ number_format($pkg->price??0,0) }}</div>
                        <div style="color:rgba(255,255,255,0.7);font-size:0.65rem;margin-top:1px;">price</div>
                    </div>
                </div>
            </div>
            {{-- Body --}}
            <div style="padding:16px 18px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <span style="font-size:0.8rem;color:#64748b;"><i class="fas fa-calendar-day" style="color:#a5b4fc;margin-left:4px;"></i>{{ $pkg->duration ?? '?' }} days</span>
                    @if($pkg->status == 1)
                        <span style="background:#dcfce7;color:#166534;padding:2px 10px;border-radius:7px;font-size:0.75rem;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
                            <span style="width:5px;height:5px;border-radius:50%;background:#16a34a;display:inline-block;"></span>
                            {{ trans('global.active') ?? 'Active' }}
                        </span>
                    @else
                        <span style="background:#f1f5f9;color:#94a3b8;padding:2px 10px;border-radius:7px;font-size:0.75rem;font-weight:600;">
                            {{ trans('global.inactive') ?? 'Inactive' }}
                        </span>
                    @endif
                </div>
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    @can('subscription_package_show')
                    <a href="{{ route('admin.subscription-packages.show',$pkg->id) }}" style="flex:1;text-align:center;background:#f1f5f9;color:#475569;padding:6px;border-radius:8px;font-size:0.78rem;font-weight:600;text-decoration:none;transition:background 0.15s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                        <i class="fas fa-eye"></i> {{ trans('global.view') }}
                    </a>
                    @endcan
                    @can('subscription_package_edit')
                    <a href="{{ route('admin.subscription-packages.edit',$pkg->id) }}" style="flex:1;text-align:center;background:#fff7ed;color:#c2410c;padding:6px;border-radius:8px;font-size:0.78rem;font-weight:600;text-decoration:none;transition:background 0.15s;" onmouseover="this.style.background='#ffedd5'" onmouseout="this.style.background='#fff7ed'">
                        <i class="fas fa-edit"></i> {{ trans('global.edit') }}
                    </a>
                    @endcan
                    @can('subscription_package_delete')
                    <form action="{{ route('admin.subscription-packages.destroy',$pkg->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('{{ trans('global.areYouSure') }}')" style="background:#fff1f2;color:#be123c;padding:6px 10px;border-radius:8px;font-size:0.78rem;font-weight:600;border:none;cursor:pointer;transition:background 0.15s;" onmouseover="this.style.background='#ffe4e6'" onmouseout="this.style.background='#fff1f2'">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ===== Datatable (hidden, for export) ===== --}}
    <x-admin-table
        title="Packages Table"
        icon="fas fa-box-open"
        color="purple"
        datatableClass="datatable-SubPackage"
        :count="$subscriptionPackages->count()"
        :createRoute="route('admin.subscription-packages.create')"
        createLabel="Add Package"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>Name EN</th>
                <th>Name AR</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Status</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($subscriptionPackages as $pkg)
            <tr data-entry-id="{{ $pkg->id }}">
                <td></td>
                <td>{{ $pkg->name_en ?? '' }}</td>
                <td>{{ $pkg->name_ar ?? '' }}</td>
                <td><strong style="color:#7c3aed;">{{ number_format($pkg->price??0,2) }}</strong></td>
                <td>{{ $pkg->duration ?? '' }} days</td>
                <td>
                    @if($pkg->status==1)
                        <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>
                            {{ trans('global.active') ?? 'Active' }}
                        </span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;">{{ trans('global.inactive') ?? 'Inactive' }}</span>
                    @endif
                </td>
                <td style="display:flex;gap:5px;">
                    @can('subscription_package_show')<x-admin-action-btn href="{{ route('admin.subscription-packages.show',$pkg->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('subscription_package_edit')<x-admin-action-btn href="{{ route('admin.subscription-packages.edit',$pkg->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('subscription_package_delete')<x-admin-action-btn href="{{ route('admin.subscription-packages.destroy',$pkg->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-SubPackage:not(.ajaxTable)').DataTable({buttons:[]});
});
</script>
@endsection
