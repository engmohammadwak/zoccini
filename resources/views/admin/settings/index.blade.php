@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-cog me-2 text-primary"></i>
                {{ trans('global.edit') }} {{ trans('cruds.setting.title_singular') }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('cruds.setting.title_singular') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <form action="{{ url('/admin/settings') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @foreach ($settings as $setting)
                <div class="row align-items-center mb-4 pb-3 border-bottom">
                    {{-- Label --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-dark mb-0">
                            {{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? $setting->slug_ar : $setting->slug_en }}
                        </label>
                    </div>

                    {{-- Field --}}
                    <div class="col-md-9">
                        @if($setting->type == 0)
                            {{-- Text Input --}}
                            <input class="form-control" type="text"
                                   name="{{ $setting->namesetting }}"
                                   value="{{ $setting->value }}">

                        @elseif($setting->type == 3)
                            {{-- File / Image / Video --}}
                            @if($setting->value != '')
                                @php $type = explode('.', $setting->value); @endphp
                                @if(isset($type[1]) && $type[1] == 'mp4')
                                    <video controls style="max-width:200px;border-radius:8px;" class="mb-2">
                                        <source src="{{ asset('/local/public/img/setting/'.$setting->value) }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ asset('/local/public/img/setting/'.$setting->value) }}"
                                         width="120" class="rounded-2 border mb-2">
                                @endif
                            @endif
                            <input class="form-control" type="file" name="{{ $setting->namesetting }}">

                        @else
                            {{-- CKEditor Textarea --}}
                            <textarea name="{{ $setting->namesetting }}" rows="8"
                                      class="form-control ckeditor">{{ $setting->value }}</textarea>
                        @endif

                        @if ($errors->has($setting->namesetting))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first($setting->namesetting) }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach

                {{-- Save Button --}}
                <div class="d-flex justify-content-end pt-2">
                    <button class="btn btn-primary px-5" type="submit">
                        <i class="fas fa-save me-1"></i> {{ trans('global.save') }}
                    </button>
                </div>

            </form>
        </div>
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
                        return loader.file.then(function (file) {
                            return new Promise(function (resolve, reject) {
                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', '/admin/settings/ckmedia', true);
                                xhr.setRequestHeader('x-csrf-token', window._token);
                                xhr.setRequestHeader('Accept', 'application/json');
                                xhr.responseType = 'json';
                                var genericErrorText = `Couldn't upload file: ${file.name}.`;
                                xhr.addEventListener('error', function () { reject(genericErrorText); });
                                xhr.addEventListener('abort', function () { reject(); });
                                xhr.addEventListener('load', function () {
                                    var response = xhr.response;
                                    if (!response || xhr.status !== 201) {
                                        return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                    }
                                    $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');
                                    resolve({ default: response.url });
                                });
                                if (xhr.upload) {
                                    xhr.upload.addEventListener('progress', function (e) {
                                        if (e.lengthComputable) { loader.uploadTotal = e.total; loader.uploaded = e.loaded; }
                                    });
                                }
                                var data = new FormData();
                                data.append('upload', file);
                                xhr.send(data);
                            });
                        });
                    }
                };
            };
        }

        var allEditors = document.querySelectorAll('.ckeditor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(allEditors[i], {
                fullPage: true,
                extraPlugins: [SimpleUploadAdapter],
                allowedContent: true,
                language: 'ar'
            });
        }
    });
</script>
@endsection
