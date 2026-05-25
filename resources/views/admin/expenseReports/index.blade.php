@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-chart-bar me-2 text-primary"></i>
                {{ trans('cruds.expenseReport.reports.title') }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('cruds.expenseReport.reports.title') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body p-4">
            <form method="get">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">{{ trans('global.year') }}</label>
                        <select name="y" id="y" class="form-select">
                            @foreach(array_combine(range(date("Y"), 1900), range(date("Y"), 1900)) as $year)
                                <option value="{{ $year }}" @if($year===old('y', Request::get('y', date('Y')))) selected @endif>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">{{ trans('global.month') }}</label>
                        <select name="m" id="m" class="form-select">
                            @foreach(cal_info(0)['months'] as $month)
                                <option value="{{ $month }}" @if($month===old('m', Request::get('m', date('F')))) selected @endif>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="fas fa-filter me-1"></i> {{ trans('global.filterDate') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- KPI Summary Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 p-3" style="background:#e8f5e9">
                        <i class="fas fa-arrow-up fa-lg text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">{{ trans('cruds.expenseReport.reports.income') }}</div>
                        <div class="fw-bold fs-5 text-success">{{ number_format($incomesTotal, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 p-3" style="background:#fdecea">
                        <i class="fas fa-arrow-down fa-lg text-danger"></i>
                    </div>
                    <div>
                        <div class="text-muted small">{{ trans('cruds.expenseReport.reports.expense') }}</div>
                        <div class="fw-bold fs-5 text-danger">{{ number_format($expensesTotal, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 p-3" style="background:#e8eaf6">
                        <i class="fas fa-chart-line fa-lg text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small">{{ trans('cruds.expenseReport.reports.profit') }}</div>
                        <div class="fw-bold fs-5 {{ $profit >= 0 ? 'text-primary' : 'text-danger' }}">{{ number_format($profit, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Breakdown Tables --}}
    <div class="row g-4">
        {{-- Income by Category --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom fw-semibold py-3">
                    <i class="fas fa-list me-2 text-success"></i>
                    {{ trans('cruds.expenseReport.reports.incomeByCategory') }}
                    <span class="badge bg-success ms-2">{{ number_format($incomesTotal, 2) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ trans('global.category') ?? 'Category' }}</th>
                                    <th class="text-end">{{ trans('global.amount') ?? 'Amount' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($incomesSummary as $inc)
                                <tr>
                                    <td>{{ $inc['name'] }}</td>
                                    <td class="text-end fw-semibold text-success">{{ number_format($inc['amount'], 2) }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="text-center text-muted py-3">{{ trans('global.no_data') ?? 'No data' }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Expense by Category --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom fw-semibold py-3">
                    <i class="fas fa-list me-2 text-danger"></i>
                    {{ trans('cruds.expenseReport.reports.expenseByCategory') }}
                    <span class="badge bg-danger ms-2">{{ number_format($expensesTotal, 2) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ trans('global.category') ?? 'Category' }}</th>
                                    <th class="text-end">{{ trans('global.amount') ?? 'Amount' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expensesSummary as $inc)
                                <tr>
                                    <td>{{ $inc['name'] }}</td>
                                    <td class="text-end fw-semibold text-danger">{{ number_format($inc['amount'], 2) }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="text-center text-muted py-3">{{ trans('global.no_data') ?? 'No data' }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
@parent
<script>
    $('.date').datepicker({
        autoclose: true,
        dateFormat: "{{ config('panel.date_format_js') }}"
    });
</script>
@stop
