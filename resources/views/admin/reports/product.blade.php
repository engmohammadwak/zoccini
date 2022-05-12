@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.expenseReportRestaurant.reports.best_selling_products') }}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ trans('cruds.expenseReportRestaurant.reports.product_name') }}</th>
                            @if (\Illuminate\Support\Facades\Auth::user()['user_type'] != 3)
                                <th>{{ trans('cruds.expenseReportRestaurant.reports.restaurant') }}</th>
                            @endif
                            <th>{{ trans('cruds.expenseReportRestaurant.reports.quantity') }}</th>
                        </tr>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? $item->name_ar : $item->name_en }}</td>
                                @if (\Illuminate\Support\Facades\Auth::user()['user_type'] != 3)
                                    <td>{{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? optional($item->restaurant)->name_ar : optional($item->restaurant)->name_en ?? '' }}</td>
                                @endif
                                <td>{{ $item->sale_count }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>

        </div>
    </div>



@endsection
