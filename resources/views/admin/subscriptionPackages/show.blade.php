@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.subscriptionPackage.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscription-packages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.id') }}
                        </th>
                        <td>
                            {{ $subscriptionPackage->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.name') }}
                        </th>
                        <td>
                            {{ $subscriptionPackage->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.name_en') }}
                        </th>
                        <td>
                            {{ $subscriptionPackage->name_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.description') }}
                        </th>
                        <td>
                            {{ $subscriptionPackage->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.description_en') }}
                        </th>
                        <td>
                            {{ $subscriptionPackage->description_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.price') }}
                        </th>
                        <td>
                            {{ $subscriptionPackage->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.duration') }}
                        </th>
                        <td>
                            {{ $subscriptionPackage->duration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.number_branches') }}
                        </th>
                        <td>
                            {{ $subscriptionPackage->number_branches }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.offer') }}
                        </th>
                        <td>
                            {{ $subscriptionPackage->offer }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.have_map') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $subscriptionPackage->have_map ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.currency') }}
                        </th>
                        <td>
                            {{ $subscriptionPackage->currency->name_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionPackage.fields.referral_price') }}
                        </th>
                        <td>
                            {{ $subscriptionPackage->referral_price }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscription-packages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
