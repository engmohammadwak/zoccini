@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.item.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.item.fields.id') }}
                        </th>
                        <td>
                            {{ $item->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.item.fields.name') }}
                        </th>
                        <td>
                            {{ $item->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.item.fields.name_ar') }}
                        </th>
                        <td>
                            {{ $item->name_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.item.fields.description') }}
                        </th>
                        <td>
                            {{ $item->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.item.fields.description_ar') }}
                        </th>
                        <td>
                            {{ $item->description_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.item.fields.photo') }}
                        </th>
                        <td>
                            @foreach($item->photo as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.item.fields.price') }}
                        </th>
                        <td>
                            {{ $item->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.item.fields.restaurant') }}
                        </th>
                        <td>
                            {{ $item->restaurant->mins ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.item.fields.category') }}
                        </th>
                        <td>
                            {{ $item->category->name_en ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection