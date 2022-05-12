@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.topRestaurant.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.top-restaurants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.topRestaurant.fields.id') }}
                        </th>
                        <td>
                            {{ $topRestaurant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topRestaurant.fields.title') }}
                        </th>
                        <td>
                            {{ $topRestaurant->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topRestaurant.fields.body') }}
                        </th>
                        <td>
                            {{ $topRestaurant->body }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topRestaurant.fields.category') }}
                        </th>
                        <td>
                            {{ $topRestaurant->category->name ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.topRestaurant.fields.image') }}
                        </th>
                        <td>
                            @if($topRestaurant->image)
                                <a href="{{$topRestaurant->image_url}}" target="_blank" style="display: inline-block">
                                    <img height="50" width="50" src="{{$topRestaurant->image_url}}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.top-restaurants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection