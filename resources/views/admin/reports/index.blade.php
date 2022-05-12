@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col">
            <h3 class="page-title">{{ trans('cruds.expenseReportRestaurant.reports.title') }}</h3>

            <form method="get">
                <div class="row">
                    <div class="col-3 form-group">
                        <label class="control-label" for="y">{{ trans('global.year') }}</label>
                        <select name="y" id="y" class="form-control">
                            @foreach(array_combine(range(date("Y"), 1900), range(date("Y"), 1900)) as $year)
                                <option value="{{ $year }}"
                                        @if($year===old('y', Request::get('y', date('Y')))) selected @endif>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 form-group">
                        <label class="control-label" for="m">{{ trans('global.month') }}</label>
                        <select name="m" for="m" class="form-control">
                            @foreach(cal_info(0)['months'] as $month)
                                <option value="{{ $month }}"
                                        @if($month===old('m', Request::get('m', date('F')))) selected @endif>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="control-label">&nbsp;</label><br>
                        <button class="btn btn-primary" type="submit">{{ trans('global.filterDate') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.expenseReportRestaurant.reports.sales') }}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ trans('cruds.expenseReportRestaurant.reports.total') }}</th>
                            <td>{{ number_format($total, 2) }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.expenseReportRestaurant.reports.count') }}</th>
                            <td>{{$count }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.expenseReportRestaurant.reports.avg') }}</th>
                            <td>{{ number_format($avg, 2) }}</td>
                        </tr>
                    </table>
{{--                    <div class="{{ $chart_order->options['column_class'] }}">--}}
{{--                        <h3>{!! $chart_order->options['chart_title'] !!}</h3>--}}
{{--                        {!! $chart_order->renderHtml() !!}--}}
{{--                    </div>--}}

{{--                    <div class="{{ $chart_avg->options['column_class'] }}">--}}
{{--                        <h3>{!! $chart_avg->options['chart_title'] !!}</h3>--}}
{{--                        {!! $chart_avg->renderHtml() !!}--}}
{{--                    </div>--}}
                </div>
                <div class="col">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.id') }}
                            </th>
                            @if (\Illuminate\Support\Facades\Auth::user()['user_type'] != 3)
                                <th>
                                    {{ trans('cruds.order.fields.restaurants') }}
                                </th>
                            @endif
                            <th>
                                {{ trans('cruds.order.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.order.fields.final_price') }}
                            </th>
                            <th>
                                {{ trans('cruds.order.fields.created_at') }}
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $key => $order)
                            <tr data-entry-id="{{ $order->id }}">
                                <td>
                                    {{ $order->id ?? '' }}
                                </td>

                                @if (\Illuminate\Support\Facades\Auth::user()['user_type'] != 3)
                                    <td>
                                        {{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? optional($order->restaurants)->name_ar : optional($order->restaurants)->name_en ?? '' }}
                                    </td>
                                @endif

                                <td>
                                    {{ $order->user->name ?? '' }}
                                </td>
                                <td>
                                    {{ $order->final_price ?? '' }}
                                </td>
                                <td>
                                    {{ $order->created_at->translatedFormat('d/m/Y  h:i A') ?? '' }}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
    <script>
        $('.date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('panel.date_format_js') }}"
        })
    </script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>--}}

{{--    {!! $chart_order->renderJs() !!}{!! $chart_avg->renderJs() !!}--}}

@stop
