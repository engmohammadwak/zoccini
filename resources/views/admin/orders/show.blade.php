@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.order.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.id') }}
                        </th>
                        <td>
                            {{ $order->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.restaurants') }}
                        </th>
                        <td>
                            {{ $order->restaurants->name_en ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.user') }}
                        </th>
                        <td>
                            {{ $order->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.type') }}
                        </th>
                        <td>
                            {{ $order->type->name_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.sitting_area') }}
                        </th>
                        <td>
                            {{ $order->sitting_area->name_en ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.number_people') }}
                        </th>
                        <td>
                            {{ $order->number_people }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.schedule_request') }}
                        </th>
                        <td>
                            {{ App\Models\Order::SCHEDULE_REQUEST_SELECT[$order->schedule_request] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.schedule_date') }}
                        </th>
                        <td>
                            {{ $order->schedule_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.car_number_yes') }}
                        </th>
                        <td>
                            {{ App\Models\Order::CAR_NUMBER_YES_SELECT[$order->car_number_yes] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.car_number') }}
                        </th>
                        <td>
                            {{ $order->car_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.delivery') }}
                        </th>
                        <td>
                            {{ App\Models\Order::DELIVERY_SELECT[$order->delivery] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.delivery_company') }}
                        </th>
                        <td>
                            {{ $order->delivery_company->name_en ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.status') }}
                        </th>
                        <td>
                            {{ $order->status->name_en ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.item') }}
                        </th>
                        <td>
                            @foreach($order->items as $key => $item)
                                <span class="label label-info">{{ $item->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.cansel_reason') }}
                        </th>
                        <td>
                            {{ $order->cansel_reason->name_en ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.cansel_reason_message') }}
                        </th>
                        <td>
                            {{ $order->cansel_reason_message }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection