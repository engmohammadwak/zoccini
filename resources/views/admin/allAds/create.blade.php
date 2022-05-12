@extends('layouts.admin')
@section('content')
<style>
    @import 'https://fonts.googleapis.com/css?family=Share+Tech+Mono';

    body {
        background:antiquewhite;
    }

    #header {
        text-align: center;
        font-family: 'Share Tech Mono', monospace;
    }

    #calc {
        text-align: center;
        width: 380px;
        display: block;
        border-radius:8px;
        border: 1px solid;
        bordel-color: #abc6c2;
        padding:8px;
        margin-top:20px;
        margin-left:auto;
        margin-right:auto;
        background: #224662;
    }

    #display {
        background: #bcbcbc;
        padding: 8px;
        margin:16px 12px 10px 16px;
        text-align: center;
        font-family: 'Share Tech Mono', monospace;
        border-radius:8px;
    }

    #result p{
        font-size:1.8em;
    }

    #result,
    #previous {
        text-align: right;

    }

    #keyboard {
        display: inline-block;
        text-align: center;
        margin-bottom:8px;
    }

    .row {
        margin-top: 4px;
    }

    .last-row {
        float:left;
        margin-top: -11.5%;
    }

    button {
        width: 62px;
        margin: 2px;
    }

    .invisible {
        width:0;
    }

    .btn-zero {
        width: 134px;
    }

    .btn-result {
        float:right;
        margin-left:4px;
        height: 74px;
    }


</style>
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.allAd.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.all-ads.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="restaurant_id">{{ trans('cruds.allAd.fields.restaurant') }}</label>
                    <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}"
                            name="restaurant_id" id="restaurant_id">
                        @foreach($restaurants as $id => $restaurant)
                            <option value="{{ $id }}" {{ old('restaurant_id') == $id ? 'selected' : '' }}>{{ $restaurant }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('restaurant'))
                        <span class="text-danger">{{ $errors->first('restaurant') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.allAd.fields.restaurant_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="category_id">{{ trans('cruds.allAd.fields.category') }}</label>
                    <select onchange="select()"
                            class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}"
                            name="category_id" id="category_id" required>
                        @foreach($categories as $id => $category)
                            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category'))
                        <span class="text-danger">{{ $errors->first('category') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.allAd.fields.category_helper') }}</span>
                </div>


                <div class="form-group" id="deal" style="display:none;">
                    <label class="required" for="discount">{{ trans('cruds.allAd.fields.discount') }}</label>
                    <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="text"
                           name="discount" id="discount" value="{{ old('discount', '') }}">
                    @if($errors->has('discount'))
                        <span class="text-danger">{{ $errors->first('discount') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.allAd.fields.discount_helper') }}</span>
                </div>

                <div id="offers" style="display:none;">
                    <div class="form-group">
                        <label class="required" for="description_ar">{{ trans('cruds.allAd.fields.description_ar') }}</label>
                        <textarea class="form-control ckeditor {{ $errors->has('description_ar') ? 'is-invalid' : '' }}"
                                  name="description_ar" id="description_ar">{!! old('description_ar') !!}</textarea>
                        @if($errors->has('description_ar'))
                            <span class="text-danger">{{ $errors->first('description_ar') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.description_ar_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="description_en">{{ trans('cruds.allAd.fields.description_en') }}</label>
                        <textarea class="form-control ckeditor {{ $errors->has('description_en') ? 'is-invalid' : '' }}"
                                  name="description_en" id="description_en">{!! old('description_en') !!}</textarea>
                        @if($errors->has('description_en'))
                            <span class="text-danger">{{ $errors->first('description_en') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.description_en_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="number_requests">{{ trans('cruds.allAd.fields.number_requests') }}</label>
                        <input class="form-control {{ $errors->has('number_requests') ? 'is-invalid' : '' }}"
                               type="text" name="number_requests" id="number_requests"
                               value="{{ old('number_requests', '') }}">
                        @if($errors->has('number_requests'))
                            <span class="text-danger">{{ $errors->first('number_requests') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.number_requests_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="voucher_number">{{ trans('cruds.allAd.fields.voucher_number') }}</label>
                        <input class="form-control {{ $errors->has('voucher_number') ? 'is-invalid' : '' }}" type="text"
                               name="voucher_number" id="voucher_number" value="{{ old('voucher_number', '') }}">
                        @if($errors->has('voucher_number'))
                            <span class="text-danger">{{ $errors->first('voucher_number') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.voucher_number_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="withdraw_day">{{ trans('cruds.allAd.fields.withdraw_day') }}</label>
                        <input class="form-control date {{ $errors->has('withdraw_day') ? 'is-invalid' : '' }}"
                               type="text" name="withdraw_day" id="withdraw_day" value="{{ old('withdraw_day') }}">
                        @if($errors->has('withdraw_day'))
                            <span class="text-danger">{{ $errors->first('withdraw_day') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.allAd.fields.withdraw_day_helper') }}</span>
                    </div>
                </div>

                <div class="form-group" id="image" style="display:none;">
                    <label class="required" for="image">{{ trans('cruds.allAd.fields.image') }}</label>
                    <input type="file" name="image"
                           class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                    @if($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.allAd.fields.image_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required">{{ trans('cruds.slideShow.fields.status') }}</label>
                    @foreach(App\Models\AllAd::STATUS_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status"
                                   value="{{ $key }}" {{ old('status', '1') === (string) $key ? 'checked' : '' }}>
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


{{--    <div class="container">--}}
{{--        <div id="header">--}}
{{--            <h3>Javascript Calculator</h3></div>--}}
{{--        <div id="calc" class="text-center">--}}
{{--            <div id="display">--}}
{{--                <div id="result"><p>0</p></div>--}}
{{--                <div id="previous"><p>0</p></div>--}}
{{--            </div>--}}
{{--            <div id="keyboard">--}}
{{--                <div class="row">--}}
{{--                    <button class="btn btn-info" value="7">7</button>--}}
{{--                    <button class="btn btn-info" value="8">8</button>--}}
{{--                    <button class="btn btn-info" value="9">9</button>--}}
{{--                    <button class="btn btn-danger" value="ac">AC</button>--}}
{{--                    <button class="btn btn-danger" value="ce">CE</button>--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                    <button class="btn btn-info" value="4">4</button>--}}
{{--                    <button class="btn btn-info" value="5">5</button>--}}
{{--                    <button class="btn btn-info" value="6">6</button>--}}
{{--                    <button class="btn btn-warning" value="/">/</button>--}}
{{--                    <button class="btn btn-warning" value="*">*</button>--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                    <button class="btn btn-info" value="1">1</button>--}}
{{--                    <button class="btn btn-info" value="2">2</button>--}}
{{--                    <button class="btn btn-info" value="3">3</button>--}}
{{--                    <button class="btn btn-warning" value="+">+</button>--}}
{{--                    <button class="btn btn-success btn-result" value="=">=</button>--}}

{{--                </div>--}}
{{--                <div class="row last-row">--}}
{{--                    <button class="btn btn-info btn-zero" value="0">0</button>--}}
{{--                    <!-- <button class="invisible" value=""></button> -->--}}
{{--                    <button class="btn btn-warning" value=".">.</button>--}}
{{--                    <button class="btn btn-warning" value="-">-</button>--}}
{{--                    <!-- <button class="invisible" value=""></button> -->--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}



@endsection

@section('scripts')

    <script>
        function select() {
            var deal = document.getElementById('deal');
            var select = document.getElementById('category_id').value;
            var offers = document.getElementById('offers');
            var image = document.getElementById('image');

            if (select == '1') {
                deal.style.display = 'none';
                offers.style.display = 'block';
                image.style.display = 'block';
            } else if (select == '2') {
                deal.style.display = 'block';
                offers.style.display = 'none';
                image.style.display = 'none';
            } else if (select == '3') {
                deal.style.display = 'none';
                offers.style.display = 'none';
                image.style.display = 'block';
            }
        }
    </script>

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
        $(document).ready(function() {
            var eq = "";
            var curNumber="";
            var result = "";
            var entry = "";
            var reset = false;

            $("button").click(function() {
                entry = $(this).attr("value");

                if (entry === "ac") {
                    entry=0;
                    eq=0;
                    result=0;
                    curNumber=0;
                    $('#result p').html(entry);
                    $('#previous p').html(eq);
                }

                else if (entry === "ce") {
                    if (eq.length > 1) {
                        eq = eq.slice(0, -1);
                        $('#previous p').html(eq);
                    }
                    else {
                        eq = 0;
                        $('#result p').html(0);
                    }

                    $('#previous p').html(eq);

                    if (curNumber.length > 1) {
                        curNumber = curNumber.slice(0, -1);
                        $('#result p').html(curNumber);
                    }
                    else {
                        curNumber = 0;
                        $('#result p').html(0);
                    }

                }

                else if (entry === "=") {
                    result = eval(eq);
                    $('#result p').html(result);
                    eq += "="+result;
                    $('#previous p').html(eq);
                    eq = result;
                    entry = result;
                    curNumber = result;
                    reset = true;
                }

                else if (isNaN(entry)) {   //check if is not a number, and after that, prevents for multiple "." to enter the same number
                    if (entry !== ".") {
                        reset = false;
                        if (curNumber === 0 || eq === 0) {
                            curNumber = 0;
                            eq = entry;
                        }
                        else {
                            curNumber = "";
                            eq += entry;
                        }
                        $('#previous p').html(eq);
                    }
                    else if (curNumber.indexOf(".") === -1) {
                        reset = false;
                        if (curNumber === 0 || eq === 0) {
                            curNumber = 0.;
                            eq = 0.;
                        }
                        else {
                            curNumber += entry;
                            eq += entry;
                        }
                        $('#result p').html(curNumber);
                        $('#previous p').html(eq);
                    }
                }

                else {
                    if (reset) {
                        eq = entry;
                        curNumber = entry;
                        reset = false;
                    }
                    else {
                        eq += entry;
                        curNumber += entry;
                    }
                    $('#previous p').html(eq);
                    $('#result p').html(curNumber);
                }


                if (curNumber.length > 10 || eq.length > 26) {
                    $("#result p").html("0");
                    $("#previous p").html("Too many digits");
                    curNumber ="";
                    eq="";
                    result ="";
                    reset=true;
                }

                if (result.indexOf(".") !== -1) {
                    result = result.truncate()
                }

            });


        });
    </script>
@endsection
