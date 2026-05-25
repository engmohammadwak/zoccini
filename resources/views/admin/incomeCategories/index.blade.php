@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-tags me-2 text-primary"></i>
                {{ trans('cruds.incomeCategory.title_singular') }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('cruds.incomeCategory.title') }}</li>
                </ol>
            </nav>
        </div>
        @can('income_category_create')
        <a href="{{ route('admin.income-categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> {{ trans('global.add') }} {{ trans('cruds.incomeCategory.title_singular') }}
        </a>
        @endcan
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:40px">#</th>
                            <th>{{ trans('cruds.incomeCategory.fields.name') }}</th>
                            <th class="text-end">{{ trans('global.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomeCategories as $key => $incomeCategory)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $incomeCategory->name }}</td>
                            <td class="text-end">
                                @can('income_category_show')
                                <a href="{{ route('admin.income-categories.show', $incomeCategory->id) }}" class="btn btn-sm btn-outline-info me-1" title="{{ trans('global.view') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan
                                @can('income_category_edit')
                                <a href="{{ route('admin.income-categories.edit', $incomeCategory->id) }}" class="btn btn-sm btn-outline-warning me-1" title="{{ trans('global.edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('income_category_delete')
                                <form action="{{ route('admin.income-categories.destroy', $incomeCategory->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="{{ trans('global.delete') }}"><i class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
@section('scripts')
@parent
<script>
$(document).ready(function(){ $('#dataTable').DataTable({ pageLength: 25, order: [[0,'asc']] }); });
</script>
@stop
