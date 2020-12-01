@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.allAd.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.all-ads.update", [$allAd->id]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="restaurant_id">{{ trans('cruds.allAd.fields.restaurant') }}</label>
                    <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}"
                            name="restaurant_id" id="restaurant_id" required>
                        @foreach($restaurants as $id => $restaurant)
                            <option value="{{ $id }}" {{ (old('restaurant_id') ? old('restaurant_id') : $allAd->restaurant->id ?? '') == $id ? 'selected' : '' }}>{{ $restaurant }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('restaurant'))
                        <span class="text-danger">{{ $errors->first('restaurant') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.allAd.fields.restaurant_helper') }}</span>
                </div>
                <input type="hidden" name="category_id" value="{{$allAd->category_id}}">
@if ($allAd->category->id == 1)


                    <div class="form-group">
                        <label for="description_ar">{{ trans('cruds.allAd.fields.description_ar') }}</label>
                        <textarea class="form-control ckeditor {{ $errors->has('description_ar') ? 'is-invalid' : '' }}"
                                  name="description_ar"
                                  id="description_ar">{!! old('description_ar', $allAd->description_ar) !!}</textarea>
                        @if($errors->has('description_ar'))
                            <span class="text-danger">{{ $errors->first('description_ar') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.description_ar_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="description_en">{{ trans('cruds.allAd.fields.description_en') }}</label>
                        <textarea class="form-control ckeditor {{ $errors->has('description_en') ? 'is-invalid' : '' }}"
                                  name="description_en"
                                  id="description_en">{!! old('description_en', $allAd->description_en) !!}</textarea>
                        @if($errors->has('description_en'))
                            <span class="text-danger">{{ $errors->first('description_en') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.description_en_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="number_requests">{{ trans('cruds.allAd.fields.number_requests') }}</label>
                        <input class="form-control {{ $errors->has('number_requests') ? 'is-invalid' : '' }}" type="text"
                               name="number_requests" id="number_requests"
                               value="{{ old('number_requests', $allAd->number_requests) }}">
                        @if($errors->has('number_requests'))
                            <span class="text-danger">{{ $errors->first('number_requests') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.number_requests_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="voucher_number">{{ trans('cruds.allAd.fields.voucher_number') }}</label>
                        <input class="form-control {{ $errors->has('voucher_number') ? 'is-invalid' : '' }}" type="text"
                               name="voucher_number" id="voucher_number"
                               value="{{ old('voucher_number', $allAd->voucher_number) }}">
                        @if($errors->has('voucher_number'))
                            <span class="text-danger">{{ $errors->first('voucher_number') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.voucher_number_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="image">{{ trans('cruds.allAd.fields.image') }}</label>
                        <br>

                        @if($allAd->image)
                            <a href="{{ url('local/public/img/ads/' . $allAd->image) }}" target="_blank">
                                <img src="{{ url('local/public/img/ads/' . $allAd->image) }}" width="50px" height="50px">
                            </a>
                        @endif

                        <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">

                    @if($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.image_helper') }}</span>
                    </div>
{{--                    <div class="form-group">--}}
{{--                        <label for="winner_id">{{ trans('cruds.allAd.fields.winner') }}</label>--}}
{{--                        <select class="form-control select2 {{ $errors->has('winner') ? 'is-invalid' : '' }}"--}}
{{--                                name="winner_id" id="winner_id">--}}
{{--                            @foreach($winners as $id => $winner)--}}
{{--                                <option value="{{ $id }}" {{ (old('winner_id') ? old('winner_id') : $allAd->winner->id ?? '') == $id ? 'selected' : '' }}>{{ $winner }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        @if($errors->has('winner'))--}}
{{--                            <span class="text-danger">{{ $errors->first('winner') }}</span>--}}
{{--                        @endif--}}
{{--                        <span class="help-block">{{ trans('cruds.allAd.fields.winner_helper') }}</span>--}}
{{--                    </div>--}}
                    <div class="form-group">
                        <label for="withdraw_day">{{ trans('cruds.allAd.fields.withdraw_day') }}</label>
                        <input class="form-control date {{ $errors->has('withdraw_day') ? 'is-invalid' : '' }}" type="text"
                               name="withdraw_day" id="withdraw_day"
                               value="{{ old('withdraw_day', $allAd->withdraw_day) }}">
                        @if($errors->has('withdraw_day'))
                            <span class="text-danger">{{ $errors->first('withdraw_day') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.withdraw_day_helper') }}</span>
                    </div>
    @else
                    <div class="form-group">
                        <label for="discount">{{ trans('cruds.allAd.fields.discount') }}</label>
                        <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="text"
                               name="discount" id="discount" value="{{ old('discount', $allAd->discount) }}">
                        @if($errors->has('discount'))
                            <span class="text-danger">{{ $errors->first('discount') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.discount_helper') }}</span>
                    </div>

@endif
                <div class="form-group">
                    <label>{{ trans('cruds.slideShow.fields.status') }}</label>
                    @foreach(App\Models\AllAd::STATUS_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', $allAd->status) == (string) $key ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.slideShow.fields.status_helper') }}</span>
                </div>

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
                                        xhr.open('POST', '/admin/all-ads/ckmedia', true);
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
                                        data.append('crud_id', '{{ $allAd->id ?? 0 }}');
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
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }
        });
    </script>

    <script>
        Dropzone.options.imageDropzone = {
            url: '{{ route('admin.all-ads.storeMedia') }}',
            maxFilesize: 10, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 10,
                width: 4096,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="image"]').remove()
                $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="image"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                        @if(isset($allAd) && $allAd->image)
                var file = {!! json_encode($allAd->image) !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection