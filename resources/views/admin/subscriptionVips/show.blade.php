@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.subscriptionVip.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscription-vips.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.id') }}
                        </th>
                        <td>
                            {{ $subscriptionVip->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.user') }}
                        </th>
                        <td>
                            {{ $subscriptionVip->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.start_day') }}
                        </th>
                        <td>
                            {{ $subscriptionVip->start_day }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.end_day') }}
                        </th>
                        <td>
                            {{ $subscriptionVip->end_day }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\SubscriptionVip::STATUS_SELECT[$subscriptionVip->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.price') }}
                        </th>
                        <td>
                            {{ $subscriptionVip->price }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscription-vips.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection