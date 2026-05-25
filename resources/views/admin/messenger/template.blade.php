@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom py-3 fw-semibold">
            <i class="fas fa-file-alt me-2 text-secondary"></i>
            {{ trans('global.template') ?? 'Template' }}
        </div>
        <div class="card-body p-4">
            @yield('messenger_content')
        </div>
    </div>
</div>

@endsection
