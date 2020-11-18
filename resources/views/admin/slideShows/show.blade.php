@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.slideShow.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.slide-shows.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.slideShow.fields.id') }}
                        </th>
                        <td>
                            {{ $slideShow->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.slideShow.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\SlideShow::TYPE_SELECT[$slideShow->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.slideShow.fields.resource') }}
                        </th>
                        <td>
                            @if ($slideShow->type == 'image')
                                @if($slideShow->image)
                                    <a href="{{ url('local/public/img/slidshow/' . $slideShow->image) }}"
                                       target="_blank">
                                        <img src="{{ url('local/public/img/slidshow/' . $slideShow->image) }}"
                                             width="50px" height="50px">
                                    </a>
                                @endif
                            @else
                                @if($slideShow->video_url)
                                    <a href="{{ $slideShow->video_url }}" target="_blank">
                                        {{$slideShow->video_url}}
                                    </a>
                                @endif

                            @endif

                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.slideShow.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\SlideShow::STATUS_RADIO[$slideShow->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.slide-shows.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection