@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.category.title')"
        icon="fas fa-layer-group"
        color="violet"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.category.title')],
        ]"
    />

    @php
        $total    = $categories->count();
        $active   = $categories->where('status',1)->count();
        $parents  = $categories->whereNull('parent_id')->count();
        $children = $categories->whereNotNull('parent_id')->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-layer-group"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.category.title') }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.active') ?? 'Active' }}</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-folder"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $parents }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Parent</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#7c3aed,#5b21b6);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(124,58,237,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-folder-open"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $children }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Sub-categories</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.category.title_singular').' '.trans('global.list')"
        icon="fas fa-layer-group"
        color="violet"
        datatableClass="datatable-Category"
        :count="$categories->count()"
        :createRoute="can('category_create') ? route('admin.categories.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.category.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.category.fields.name_en') }}</th>
                <th>{{ trans('cruds.category.fields.name_ar') }}</th>
                <th>Parent</th>
                <th>{{ trans('cruds.category.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($categories as $category)
            <tr data-entry-id="{{ $category->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:9px;">
                        @if($category->image)
                            <img src="{{ asset('storage/'.$category->image) }}" style="width:34px;height:34px;border-radius:9px;object-fit:cover;" alt="" loading="lazy" />
                        @else
                            <div style="width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,#ede9fe,#ddd6fe);display:flex;align-items:center;justify-content:center;color:#7c3aed;font-size:14px;"><i class="fas fa-layer-group"></i></div>
                        @endif
                        <span style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $category->name_en ?? '' }}</span>
                    </span>
                </td>
                <td style="color:#64748b;font-size:0.83rem;">{{ $category->name_ar ?? '' }}</td>
                <td>
                    @if($category->parent_id)
                        <span style="background:#ede9fe;color:#5b21b6;padding:3px 10px;border-radius:7px;font-size:0.78rem;font-weight:600;"><i class="fas fa-level-up-alt" style="font-size:0.7rem;"></i> {{ optional($category->parent)->name_en ?? '—' }}</span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 10px;border-radius:7px;font-size:0.78rem;">Root</span>
                    @endif
                </td>
                <td>
                    @if($category->status == 1)
                        <span style="background:#dcfce7;color:#166534;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>{{ trans('global.active') ?? 'Active' }}</span>
                    @else
                        <span style="background:#f1f5f9;color:#64748b;padding:3px 11px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block;"></span>{{ trans('global.inactive') ?? 'Inactive' }}</span>
                    @endif
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('category_show')<x-admin-action-btn href="{{ route('admin.categories.show',$category->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('category_edit')<x-admin-action-btn href="{{ route('admin.categories.edit',$category->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('category_delete')<x-admin-action-btn href="{{ route('admin.categories.destroy',$category->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    @can('category_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.categories.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Category:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
