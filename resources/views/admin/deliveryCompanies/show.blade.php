@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.deliveryCompany.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.delivery-companies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryCompany.fields.id') }}
                        </th>
                        <td>
                            {{ $deliveryCompany->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryCompany.fields.name_ar') }}
                        </th>
                        <td>
                            {{ $deliveryCompany->name_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryCompany.fields.name_en') }}
                        </th>
                        <td>
                            {{ $deliveryCompany->name_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryCompany.fields.rate') }}
                        </th>
                        <td>
                            {{ $deliveryCompany->rate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryCompany.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\DeliveryCompany::STATUS_SELECT[$deliveryCompany->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.delivery-companies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection