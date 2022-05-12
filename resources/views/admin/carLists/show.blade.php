@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.carList.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.car-lists.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.carList.fields.id') }}
                        </th>
                        <td>
                            {{ $carList->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carList.fields.car_brand') }}
                        </th>
                        <td>
                            {{ optional($carList->car_brand)->name_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carList.fields.car_type') }}
                        </th>
                        <td>
                            {{ optional($carList->car_type)->name_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carList.fields.car_color') }}
                        </th>
                        <td>
                            {{ optional($carList->car_color)->name_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carList.fields.pate_number') }}
                        </th>
                        <td>
                            {{ $carList->pate_number }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.car-lists.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
