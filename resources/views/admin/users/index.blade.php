@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.user.title')"
        icon="fas fa-users"
        color="blue"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.user.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.user.title_singular').' '.trans('global.list')"
        icon="fas fa-users"
        color="blue"
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
                <th>{{ trans('cruds.user.fields.roles') }}</th>
                <th>{{ trans('cruds.user.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($users as $user)
            <tr data-entry-id="{{ $user->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        <x-admin-avatar :name="$user->name" color="blue" />
                        {{ $user->name ?? '' }}
                    </span>
                </td>
                <td>{{ $user->email ?? '' }}</td>
                <td>{{ $user->phone ?? '' }}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span style="background:#dbeafe;color:#1d4ed8;padding:2px 8px;border-radius:6px;font-size:0.78rem;margin-right:3px;">{{ $role->title }}</span>
                    @endforeach
                </td>
                <td>
                    <x-admin-status-badge
                        :label="$user->status == 1 ? (trans('global.active') ?? 'Active') : (trans('global.inactive') ?? 'Inactive')"
                        :type="$user->status == 1 ? 'success' : 'danger'"
                    />
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('user_show')
                    <x-admin-action-btn href="{{ route('admin.users.show',$user->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('user_edit')
                    <x-admin-action-btn href="{{ route('admin.users.edit',$user->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('user_delete')
                    <x-admin-action-btn href="{{ route('admin.users.destroy',$user->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
                    @endcan
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
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-User:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
