@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-edit me-2 text-warning"></i>
                {{ trans('global.edit') }} {{ trans('cruds.incomeCategory.title_singular') }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.income-categories.index') }}">{{ trans('cruds.incomeCategory.title') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('global.edit') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3" style="max-width:600px">
        <div class="card-body p-4">
            <form action="{{ route('admin.income-categories.update', $incomeCategory->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ trans('cruds.incomeCategory.fields.name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $incomeCategory->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-warning px-4"><i class="fas fa-save me-1"></i> {{ trans('global.save') }}</button>
                    <a href="{{ route('admin.income-categories.index') }}" class="btn btn-outline-secondary px-4">{{ trans('global.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
