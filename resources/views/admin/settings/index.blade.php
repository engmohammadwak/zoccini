@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.setting.title_singular') }}
        </div>

        <div class="card-body">

            <form action="{{url('/admin/settings')}}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @foreach ($settings as $setting)
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {{  \Illuminate\Support\Facades\App::getLocale() == 'ar' ? $setting->slug_ar : $setting->slug_en}}
                            </div>

                            <div class="col-md-9">
                                @if($setting->type ==0)
                                    <input class="form-control" type="text" name="{{$setting->namesetting}}"
                                           value="{{$setting->value}}">
                                @elseif($setting->type ==3)
                                    @if($setting->value !='')
                                        @php
                                            $type = explode(".", $setting->value);
                                        @endphp
                                        @if ( $type[1]== 'mp4')
                                            <video controls autoplay style="width: 199px;">
                                                <source src="{{asset(url('/local/public/img/setting/'.$setting->value))}}" type="video/mp4">
                                                <source src="mov_bbb.ogg" type="video/ogg">
                                                Your browser does not support HTML video.
                                            </video>
                                        @else
                                            <img src="{{asset(url('/local/public/img/setting/'.$setting->value))}}"
                                                 width="150">
                                        @endif

                                    @endif
                                    <input class="form-control" type="file" name="{{$setting->namesetting}}"
                                           value="">
                                @else
                                    <textarea name="{{$setting->namesetting}}" rows="10" cols="80"
                                              class="form-control ckeditor">
                                                {{$setting->value}}
                                                </textarea>
                                @endif
                                @if ($errors->has('setting->namesetting'))
                                    <span class="help-block">
                                             <strong>{{ $errors->first('setting->namesetting') }}</strong>
                                          </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                @endforeach


                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>


        </div>
    </div>



@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
                    return {
                        upload: function () {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function (resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '/admin/settings/ckmedia', true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText = `Couldn't upload file: ${file.name}.`;
                                        xhr.addEventListener('error', function () {
                                            reject(genericErrorText)
                                        });
                                        xhr.addEventListener('abort', function () {
                                            reject()
                                        });
                                        xhr.addEventListener('load', function () {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                            }

                                            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                            resolve({default: response.url});
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function (e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', {{ $setting->id ?? 0 }});
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        fullPage: true,
                        extraPlugins: [SimpleUploadAdapter],
                        allowedContent: true,
                        rtl :true,
                        language: 'ar',


                    }
                );
            }
        });
    </script>
@endsection