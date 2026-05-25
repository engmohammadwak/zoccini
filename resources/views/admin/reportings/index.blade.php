@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-flag me-2 text-danger"></i>
                {{ trans('cruds.reporting.title_singular') ?? 'Reports' }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('cruds.reporting.title') ?? 'Reports' }}</li>
                </ol>
            </nav>
        </div>
        @can('reporting_create')
        <a href="{{ route('admin.reportings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> {{ trans('global.add') }}
        </a>
        @endcan
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('cruds.reporting.fields.user') ?? 'User' }}</th>
                            <th>{{ trans('cruds.reporting.fields.type') ?? 'Type' }}</th>
                            <th>{{ trans('cruds.reporting.fields.status') ?? 'Status' }}</th>
                            <th>{{ trans('cruds.reporting.fields.created_at') ?? 'Date' }}</th>
                            <th class="text-end">{{ trans('global.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportings ?? [] as $key => $reporting)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reporting->user->name ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $reporting->type ?? '-' }}</span></td>
                            <td>
                                @if(($reporting->status ?? '') == 'pending')
                                    <span class="badge bg-warning text-dark">{{ $reporting->status }}</span>
                                @elseif(($reporting->status ?? '') == 'resolved')
                                    <span class="badge bg-success">{{ $reporting->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $reporting->status ?? '-' }}</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $reporting->created_at ?? '-' }}</td>
                            <td class="text-end">
                                @can('reporting_show')
                                <a href="{{ route('admin.reportings.show', $reporting->id) }}" class="btn btn-sm btn-outline-info me-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan
                                @can('reporting_edit')
                                <a href="{{ route('admin.reportings.edit', $reporting->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('reporting_delete')
                                <form action="{{ route('admin.reportings.destroy', $reporting->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ trans('global.areYouSure') }}')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
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
$(document).ready(function(){ $('#dataTable').DataTable({ pageLength: 25, order: [[4,'desc']] }); });
</script>
@stop
