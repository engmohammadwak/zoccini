@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-envelope-open me-2 text-info"></i>
                {{ trans('global.show') }} {{ trans('global.message') ?? 'Message' }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.messenger.index') }}">{{ trans('global.messenger') ?? 'Messages' }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('global.show') }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.messenger.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> {{ trans('global.back') }}
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3" style="max-width:700px">
        <div class="card-header bg-white border-bottom py-3">
            <strong>{{ $message->subject ?? '-' }}</strong>
            <span class="text-muted small ms-3">{{ $message->created_at ?? '' }}</span>
        </div>
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                    {{ strtoupper(substr($message->from ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <div class="fw-semibold">{{ $message->from ?? '-' }}</div>
                    <div class="text-muted small">{{ trans('global.from') ?? 'From' }}</div>
                </div>
            </div>
            <hr>
            <p class="mb-0">{{ $message->body ?? $message->message ?? '-' }}</p>
        </div>
        <div class="card-footer bg-white border-top py-3">
            <a href="{{ route('admin.messenger.create') }}?reply={{ $message->id ?? '' }}" class="btn btn-primary">
                <i class="fas fa-reply me-1"></i> {{ trans('global.reply') ?? 'Reply' }}
            </a>
        </div>
    </div>
</div>

@endsection
