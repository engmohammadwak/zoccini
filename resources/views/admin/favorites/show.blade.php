@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.favorite.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.favorites.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.favorite.fields.id') }}
                        </th>
                        <td>
                            {{ $favorite->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.favorite.fields.user') }}
                        </th>
                        <td>
                            {{ $favorite->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.favorite.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Favorite::TYPE_SELECT[$favorite->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.favorite.fields.item') }}
                        </th>
                        <td>
                            {{ $favorite->item->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.favorite.fields.restaurant') }}
                        </th>
                        <td>
                            {{ $favorite->restaurant->name_en ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.favorites.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection