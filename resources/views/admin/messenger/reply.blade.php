@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-reply me-2 text-warning"></i>
                {{ trans('global.reply') ?? 'Reply' }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.messenger.index') }}">{{ trans('global.messenger') ?? 'Messages' }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('global.reply') ?? 'Reply' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3" style="max-width:700px">
        <div class="card-body p-4">
            <form action="{{ route('admin.messenger.store') }}" method="POST">
                @csrf
                <input type="hidden" name="thread_id" value="{{ $thread->id ?? '' }}">
                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ trans('global.message') ?? 'Message' }} <span class="text-danger">*</span></label>
                    <textarea name="message" rows="5" class="form-control" required></textarea>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-warning px-4"><i class="fas fa-reply me-1"></i> {{ trans('global.reply') ?? 'Reply' }}</button>
                    <a href="{{ route('admin.messenger.index') }}" class="btn btn-outline-secondary px-4">{{ trans('global.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
