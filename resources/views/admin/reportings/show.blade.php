@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-flag me-2 text-danger"></i>
                {{ trans('global.show') }} {{ trans('cruds.reporting.title_singular') ?? 'Report' }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.reportings.index') }}">{{ trans('cruds.reporting.title') ?? 'Reports' }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('global.show') }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @can('reporting_edit')
            <a href="{{ route('admin.reportings.edit', $reporting->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> {{ trans('global.edit') }}
            </a>
            @endcan
            <a href="{{ route('admin.reportings.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> {{ trans('global.back') }}
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3" style="max-width:700px">
        <div class="card-body p-4">
            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted">{{ trans('cruds.reporting.fields.id') ?? 'ID' }}</dt>
                <dd class="col-sm-8 fw-semibold">{{ $reporting->id }}</dd>
                <dt class="col-sm-4 text-muted">{{ trans('cruds.reporting.fields.user') ?? 'User' }}</dt>
                <dd class="col-sm-8">{{ $reporting->user->name ?? '-' }}</dd>
                <dt class="col-sm-4 text-muted">{{ trans('cruds.reporting.fields.type') ?? 'Type' }}</dt>
                <dd class="col-sm-8"><span class="badge bg-secondary">{{ $reporting->type ?? '-' }}</span></dd>
                <dt class="col-sm-4 text-muted">{{ trans('cruds.reporting.fields.status') ?? 'Status' }}</dt>
                <dd class="col-sm-8">
                    @if(($reporting->status ?? '') == 'resolved')
                        <span class="badge bg-success">{{ $reporting->status }}</span>
                    @else
                        <span class="badge bg-warning text-dark">{{ $reporting->status ?? '-' }}</span>
                    @endif
                </dd>
                <dt class="col-sm-4 text-muted">{{ trans('cruds.reporting.fields.description') ?? 'Description' }}</dt>
                <dd class="col-sm-8">{{ $reporting->description ?? '-' }}</dd>
                <dt class="col-sm-4 text-muted">{{ trans('cruds.reporting.fields.created_at') ?? 'Date' }}</dt>
                <dd class="col-sm-8 text-muted small">{{ $reporting->created_at ?? '-' }}</dd>
            </dl>
        </div>
    </div>
</div>

@endsection
