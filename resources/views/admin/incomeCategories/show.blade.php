@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-eye me-2 text-info"></i>
                {{ trans('global.show') }} {{ trans('cruds.incomeCategory.title_singular') }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.income-categories.index') }}">{{ trans('cruds.incomeCategory.title') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('global.show') }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.income-categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> {{ trans('global.back') }}
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3" style="max-width:600px">
        <div class="card-body p-4">
            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted">{{ trans('cruds.incomeCategory.fields.id') }}</dt>
                <dd class="col-sm-8 fw-semibold">{{ $incomeCategory->id }}</dd>
                <dt class="col-sm-4 text-muted">{{ trans('cruds.incomeCategory.fields.name') }}</dt>
                <dd class="col-sm-8 fw-semibold">{{ $incomeCategory->name }}</dd>
            </dl>
        </div>
    </div>
</div>

@endsection
