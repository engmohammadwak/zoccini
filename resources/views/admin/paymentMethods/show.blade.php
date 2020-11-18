@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.paymentMethod.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payment-methods.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.paymentMethod.fields.id') }}
                        </th>
                        <td>
                            {{ $paymentMethod->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.paymentMethod.fields.name_ar') }}
                        </th>
                        <td>
                            {{ $paymentMethod->name_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.paymentMethod.fields.name_en') }}
                        </th>
                        <td>
                            {{ $paymentMethod->name_en }}
                        </td>
                    </tr>
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.paymentMethod.fields.logo') }}--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            @if($paymentMethod->logo)--}}
{{--                                <a href="{{ $paymentMethod->logo->getUrl() }}" target="_blank" style="display: inline-block">--}}
{{--                                    <img src="{{ $paymentMethod->logo->getUrl('thumb') }}">--}}
{{--                                </a>--}}
{{--                            @endif--}}
{{--                        </td>--}}
{{--                    </tr>--}}
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payment-methods.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection