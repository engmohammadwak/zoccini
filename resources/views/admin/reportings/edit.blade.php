@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-edit me-2 text-warning"></i>
                {{ trans('global.edit') }} {{ trans('cruds.reporting.title_singular') ?? 'Report' }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.reportings.index') }}">{{ trans('cruds.reporting.title') ?? 'Reports' }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('global.edit') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3" style="max-width:700px">
        <div class="card-body p-4">
            <form action="{{ route('admin.reportings.update', $reporting->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ trans('cruds.reporting.fields.user') ?? 'User' }}</label>
                    <select name="user_id" class="form-select">
                        <option value="">-- {{ trans('global.select') }} --</option>
                        @foreach($users ?? [] as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $reporting->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ trans('cruds.reporting.fields.type') ?? 'Type' }}</label>
                    <input type="text" name="type" class="form-control" value="{{ old('type', $reporting->type) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ trans('cruds.reporting.fields.description') ?? 'Description' }}</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $reporting->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ trans('cruds.reporting.fields.status') ?? 'Status' }}</label>
                    <select name="status" class="form-select">
                        <option value="pending" {{ old('status', $reporting->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="resolved" {{ old('status', $reporting->status) == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-warning px-4"><i class="fas fa-save me-1"></i> {{ trans('global.save') }}</button>
                    <a href="{{ route('admin.reportings.index') }}" class="btn btn-outline-secondary px-4">{{ trans('global.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
