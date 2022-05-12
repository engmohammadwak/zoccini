@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.restaurant.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.restaurants.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.id') }}
                        </th>
                        <td>
                            {{ $restaurant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <td>
                            {{ $restaurant->restaurant->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.last_name') }}
                        </th>
                        <td>
                            {{ $restaurant->restaurant->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.phone') }}
                        </th>
                        <td>
                            {{ $restaurant->restaurant->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $restaurant->restaurant->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.status') }}
                        </th>
                        <td>
                            {{ $restaurant->restaurant->status->name_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.image') }}
                        </th>
                        <td>
                            @if($restaurant->restaurant->image)
                                <a href="{{ url('local/public/img/user/' . $restaurant->restaurant->image) }}"
                                   target="_blank">
                                    {{ trans('global.view') }}
                                </a>
                            @else
                                <a href="{{ url('local/public/img/setting/' . getSetting('user_image')) }}"
                                   target="_blank">
                                    {{ trans('global.view') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.name_ar') }}
                        </th>
                        <td>
                            {{ $restaurant->name_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.name_en') }}
                        </th>
                        <td>
                            {{ $restaurant->name_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.description_ar') }}
                        </th>
                        <td>
                            {{ $restaurant->description_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.description_en') }}
                        </th>
                        <td>
                            {{ $restaurant->description_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.image') }}
                        </th>
                        <td>
                            @if($restaurant->image)
                                <a href="{{ $restaurant->image_url }}"
                                   target="_blank">
                                    <img src="{{ $restaurant->image_url }}"
                                         width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.mins') }}
                        </th>
                        <td>
                            {{ $restaurant->mins }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.delivery') }}
                        </th>
                        <td>
                            {{ $restaurant->delivery->name_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.payment_methods') }}
                        </th>
                        <td>
                            @foreach($restaurant->payment_methods as $key => $payment_methods)
                                <span class="label label-info">{{ $payment_methods->name_ar }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.tag') }}
                        </th>
                        <td>
                            {{ $restaurant->tag }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.sitting_area') }}
                        </th>
                        <td>
                            @foreach($restaurant->sitting_areas as $key => $sitting_area)
                                <span class="label label-info">{{ $sitting_area->name_ar }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.address') }}
                        </th>
                        <td>
                            {{ $restaurant->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.opening_time') }}
                        </th>
                        <td>
                            {{ $restaurant->opening_time }}
                        </td>
                    </tr>
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.restaurant.fields.description') }}--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            {{ $restaurant->description }}--}}
{{--                        </td>--}}
{{--                    </tr>--}}
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.number_of_employees') }}
                        </th>
                        <td>
                            {{ $restaurant->number_of_employees }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.number_branches') }}
                        </th>
                        <td>
                            {{ $restaurant->number_branches }}
                        </td>
                    </tr>
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.restaurant.fields.subscription_package') }}--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            {{ $restaurant->subscription_package }}--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.restaurant.fields.end_date_subscription') }}--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            {{ $restaurant->end_date_subscription }}--}}
{{--                        </td>--}}
{{--                    </tr>--}}
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.country') }}
                        </th>
                        <td>
                            {{ $restaurant->country->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.city') }}
                        </th>
                        <td>
                            {{ $restaurant->city->name_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.commercial_registration_image') }}
                        </th>
                        <td>
                            @if($restaurant->commercial_registration_image)
                                <a href="{{ $restaurant->commercial_registration_image_url }}"
                                   target="_blank">
                                    {{ trans('global.view') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.identity_card_image') }}
                        </th>
                        <td>
                            @if($restaurant->identity_card_image)
                                <a href="{{ $restaurant->identity_card_image_url }}"
                                   target="_blank">
                                    {{ trans('global.view') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.company_seal') }}
                        </th>
                        <td>
                            @if($restaurant->company_seal)
                                <a href="{{ $restaurant->company_seal_url }}"
                                   target="_blank">
                                    {{ trans('global.view') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.open_time') }}
                        </th>
                        <td>
                            {{ $restaurant->open_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.close_time') }}
                        </th>
                        <td>
                            {{ $restaurant->close_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.min_waiting') }}
                        </th>
                        <td>
                            {{ $restaurant->min_waiting }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.max_waiting') }}
                        </th>
                        <td>
                            {{ $restaurant->max_waiting }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.restaurants.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
