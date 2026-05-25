@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.role.title')"
        icon="fas fa-shield-alt"
        color="red"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.role.title')],
        ]"
    />

    @php
        $totalR = $roles->count();
    @endphp

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $totalR }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.role.title') }}</div>
            </div>
        </div>

        <div style="background:linear-gradient(135deg,#ef4444,#dc2626);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(239,68,68,0.28);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-key"></i>
            </div>
            <div>
                <div style="font-size:1.1rem;font-weight:800;color:#fff;line-height:1;">{{ trans('cruds.permission.title') }}</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">
                    <a href="{{ route('admin.permissions.index') }}" style="color:rgba(255,255,255,0.9);text-decoration:none;">{{ trans('global.view') }} →</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Roles Cards Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;margin-bottom:24px;">
        @foreach($roles as $role)
        @php
            $colors = [
                ['from'=>'#ef4444','to'=>'#f87171'],
                ['from'=>'#f97316','to'=>'#fb923c'],
                ['from'=>'#8b5cf6','to'=>'#a78bfa'],
                ['from'=>'#0ea5e9','to'=>'#38bdf8'],
                ['from'=>'#10b981','to'=>'#34d399'],
                ['from'=>'#6366f1','to'=>'#818cf8'],
            ];
            $c = $colors[$loop->index % 6];
        @endphp
        <div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.07);transition:transform 0.2s,box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.07)'">
            <div style="background:linear-gradient(135deg,{{ $c['from'] }},{{ $c['to'] }});padding:18px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <div style="color:#fff;font-size:1rem;font-weight:800;">{{ $role->title }}</div>
                        <div style="color:rgba(255,255,255,0.7);font-size:0.72rem;">{{ $role->permissions ? $role->permissions->count() : 0 }} {{ trans('global.permissions') ?? 'permissions' }}</div>
                    </div>
                </div>
            </div>
            <div style="padding:14px 16px;display:flex;gap:6px;flex-wrap:wrap;">
                @can('role_show')
                <a href="{{ route('admin.roles.show',$role->id) }}" style="flex:1;text-align:center;background:#f1f5f9;color:#475569;padding:6px;border-radius:8px;font-size:0.78rem;font-weight:600;text-decoration:none;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                    <i class="fas fa-eye"></i> {{ trans('global.view') }}
                </a>
                @endcan
                @can('role_edit')
                <a href="{{ route('admin.roles.edit',$role->id) }}" style="flex:1;text-align:center;background:#fff7ed;color:#c2410c;padding:6px;border-radius:8px;font-size:0.78rem;font-weight:600;text-decoration:none;" onmouseover="this.style.background='#ffedd5'" onmouseout="this.style.background='#fff7ed'">
                    <i class="fas fa-edit"></i> {{ trans('global.edit') }}
                </a>
                @endcan
                @can('role_delete')
                <form action="{{ route('admin.roles.destroy',$role->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('{{ trans('global.areYouSure') }}')" style="background:#fff1f2;color:#be123c;padding:6px 10px;border-radius:8px;font-size:0.78rem;font-weight:600;border:none;cursor:pointer;" onmouseover="this.style.background='#ffe4e6'" onmouseout="this.style.background='#fff1f2'">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                @endcan
            </div>
        </div>
        @endforeach
    </div>

    {{-- Table --}}
    <x-admin-table
        :title="trans('cruds.role.title_singular').' '.trans('global.list')"
        icon="fas fa-shield-alt"
        color="red"
        datatableClass="datatable-Role"
        :count="$roles->count()"
        :createRoute="route('admin.roles.create')"
        :createLabel="trans('global.add').' '.trans('cruds.role.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.role.fields.title') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($roles as $role)
            <tr data-entry-id="{{ $role->id }}">
                <td></td>
                <td>
                    <span style="font-weight:700;color:#1e293b;font-size:0.85rem;display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-shield-alt" style="color:#fca5a5;"></i>
                        {{ $role->title }}
                    </span>
                </td>
                <td style="display:flex;gap:5px;">
                    @can('role_show')<x-admin-action-btn href="{{ route('admin.roles.show',$role->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('role_edit')<x-admin-action-btn href="{{ route('admin.roles.edit',$role->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('role_delete')<x-admin-action-btn href="{{ route('admin.roles.destroy',$role->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25});
    $('.datatable-Role:not(.ajaxTable)').DataTable({buttons:[]});
});
</script>
@endsection
