@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rate.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.rates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.id') }}
                        </th>
                        <td>
                            {{ $rate->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.user') }}
                        </th>
                        <td>
                            {{ $rate->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.restaurant') }}
                        </th>
                        <td>
                            {{ $rate->restaurant->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.rating') }}
                        </th>
                        <td>
                            {{ $rate->rating }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.rate_1') }}
                        </th>
                        <td>
                            {{ $rate->rate_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.rate_2') }}
                        </th>
                        <td>
                            {{ $rate->rate_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.rate_3') }}
                        </th>
                        <td>
                            {{ $rate->rate_3 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.rate_4') }}
                        </th>
                        <td>
                            {{ $rate->rate_4 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.comment') }}
                        </th>
                        <td>
                            {{ $rate->comment }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.rates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection