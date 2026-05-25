@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-comments me-2 text-primary"></i>
                {{ trans('global.messenger') ?? 'Messages' }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('global.messenger') ?? 'Messages' }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.messenger.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> {{ trans('global.newMessage') ?? 'New Message' }}
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:40px">#</th>
                            <th>{{ trans('global.from') ?? 'From' }}</th>
                            <th>{{ trans('global.subject') ?? 'Subject' }}</th>
                            <th>{{ trans('global.date') ?? 'Date' }}</th>
                            <th class="text-end">{{ trans('global.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages ?? [] as $key => $message)
                        <tr class="{{ !$message->read_at ? 'fw-bold' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:0.8rem">
                                        {{ strtoupper(substr($message->from ?? 'U', 0, 1)) }}
                                    </div>
                                    <span>{{ $message->from ?? '-' }}</span>
                                </div>
                            </td>
                            <td>{{ $message->subject ?? '-' }}</td>
                            <td class="text-muted small">{{ $message->created_at ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.messenger.show', $message->id) }}" class="btn btn-sm btn-outline-info me-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.messenger.create') }}?reply={{ $message->id }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-reply"></i>
                                </a>
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
$(document).ready(function(){ $('#dataTable').DataTable({ pageLength: 25, order: [[3,'desc']] }); });
</script>
@stop
