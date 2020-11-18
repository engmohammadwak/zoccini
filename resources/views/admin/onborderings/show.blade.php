@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.onbordering.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.onborderings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.onbordering.fields.id') }}
                        </th>
                        <td>
                            {{ $onbordering->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.onbordering.fields.image') }}
                        </th>
                        <td>
                                @if($onbordering->image)
                                    <a href="{{ url('local/public/img/onbording/' . $onbordering->image) }}" target="_blank">
                                        <img src="{{ url('local/public/img/onbording/' . $onbordering->image) }}" width="50px" height="50px">
                                    </a>
                                @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.onbordering.fields.name_ar') }}
                        </th>
                        <td>
                            {{ $onbordering->name_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.onbordering.fields.name_en') }}
                        </th>
                        <td>
                            {{ $onbordering->name_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.onbordering.fields.description_ar') }}
                        </th>
                        <td>
                            {!! $onbordering->description_ar !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.onbordering.fields.description_en') }}
                        </th>
                        <td>
                            {!! $onbordering->description_en !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.onbordering.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Onbordering::STATUS_SELECT[$onbordering->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.onborderings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection