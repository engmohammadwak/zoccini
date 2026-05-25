@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.user.title')"
        icon="fas fa-users"
        color="purple"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.user.title')],
        ]"
    />

    @php
        $total     = $users->count();
        $active    = $users->where('status',1)->count();
        $admins    = $users->where('user_type',1)->count();
        $customers = $users->where('user_type',2)->count();
        $restCount = $users->where('user_type',3)->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#8b5cf6,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-users"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.user.title') }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-user-check"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f43f5e,#fb7185);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-user-shield"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $admins }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Admins</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-user"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $customers }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Customers</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(139,92,246,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-store"></i></div>
            <div><div style="font-size:1.2rem;font-weight:800;color:#fff;line-height:1;">{{ $restCount }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Restaurants</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.user.title_singular').' '.trans('global.list')"
        icon="fas fa-users"
        color="purple"
        datatableClass="datatable-User"
        :count="$users->count()"
        :createRoute="can('user_create') ? route('admin.users.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.user.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.user.fields.name') }}</th>
                <th>{{ trans('cruds.user.fields.email') }}</th>
                <th>{{ trans('cruds.user.fields.phone') }}</th>
                <th>{{ trans('cruds.user.fields.user_type') ?? 'Type' }}</th>
                <th>{{ trans('cruds.user.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($users as $user)
            @php
                $typeMap = [
                    1 => ['label'=>'Admin',      'bg'=>'#fee2e2','color'=>'#991b1b'],
                    2 => ['label'=>'Customer',   'bg'=>'#dbeafe','color'=>'#1e40af'],
                    3 => ['label'=>'Restaurant', 'bg'=>'#fef9c3','color'=>'#854d0e'],
                ];
                $tm = $typeMap[$user->user_type ?? 0] ?? ['label'=>'User','bg'=>'#f1f5f9','color'=>'#475569'];
            @endphp
            <tr data-entry-id="{{ $user->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:9px;">
                        @if($user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid #e2e8f0;" alt="" loading="lazy" />
                        @else
                            <x-admin-avatar :name="$user->name ?? 'U'" color="purple" />
                        @endif
                        <span style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $user->name ?? '' }}</span>
                    </span>
                </td>
                <td style="font-size:0.82rem;color:#475569;">{{ $user->email ?? '' }}</td>
                <td>
                    @if($user->phone)
                    <span style="display:inline-flex;align-items:center;gap:5px;font-size:0.82rem;color:#475569;"><i class="fas fa-phone" style="color:#94a3b8;font-size:0.7rem;"></i>{{ $user->phone }}</span>
                    @endif
                </td>
                <td><span style="background:{{ $tm['bg'] }};color:{{ $tm['color'] }};padding:3px 10px;border-radius:8px;font-weight:600;font-size:0.78rem;">{{ $tm['label'] }}</span></td>
                <td>
                    @if($user->status == 1)
                        <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>{{ trans('global.active') ?? 'Active' }}</span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>{{ trans('global.inactive') ?? 'Inactive' }}</span>
                    @endif
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('user_show')<x-admin-action-btn href="{{ route('admin.users.show',$user->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('user_edit')<x-admin-action-btn href="{{ route('admin.users.edit',$user->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('user_delete')<x-admin-action-btn href="{{ route('admin.users.destroy',$user->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    let dtButtons=$.extend(true,[],$.fn.dataTable.defaults.buttons);
    @can('user_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.users.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-User:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
