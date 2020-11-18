@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.subscriptionUser.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscription-users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionUser.fields.id') }}
                        </th>
                        <td>
                            {{ $subscriptionUser->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionUser.fields.user') }}
                        </th>
                        <td>
                            {{ $subscriptionUser->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionUser.fields.package') }}
                        </th>
                        <td>
                            {{ $subscriptionUser->package->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionUser.fields.start_date') }}
                        </th>
                        <td>
                            {{ $subscriptionUser->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionUser.fields.end_day') }}
                        </th>
                        <td>
                            {{ $subscriptionUser->end_day }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionUser.fields.price') }}
                        </th>
                        <td>
                            {{ $subscriptionUser->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subscriptionUser.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\SubscriptionUser::STATUS_SELECT[$subscriptionUser->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscription-users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection