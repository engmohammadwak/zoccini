@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.role.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.roles.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Title (internal/system name) --}}
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.role.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title"
                           id="title" value="{{ old('title', '') }}" required>
                    @if($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.role.fields.title_helper') }}</span>
                </div>

                {{-- Title Arabic --}}
                <div class="form-group">
                    <label for="title_ar">الاسم بالعربية</label>
                    <input class="form-control {{ $errors->has('title_ar') ? 'is-invalid' : '' }}" type="text"
                           name="title_ar" id="title_ar" value="{{ old('title_ar', '') }}" dir="rtl"
                           placeholder="أدخل اسم الدور بالعربية">
                    @if($errors->has('title_ar'))
                        <span class="text-danger">{{ $errors->first('title_ar') }}</span>
                    @endif
                </div>

                {{-- Title English --}}
                <div class="form-group">
                    <label for="title_en">Name in English</label>
                    <input class="form-control {{ $errors->has('title_en') ? 'is-invalid' : '' }}" type="text"
                           name="title_en" id="title_en" value="{{ old('title_en', '') }}"
                           placeholder="Enter role name in English">
                    @if($errors->has('title_en'))
                        <span class="text-danger">{{ $errors->first('title_en') }}</span>
                    @endif
                </div>

                {{-- Permissions --}}
                <div class="form-group">
                    <label for="permissions">{{ trans('cruds.role.fields.permissions') }}</label>
                    <div class="row">
                        @foreach($result as $datas)
                            <div class="col-md-6">
                                <hr>
                                <h4>{{ $datas['link_name'] }}</h4>
                                <hr>
                                @php
                                    $permission = \App\Models\Permission::where('category', $datas['permissions']['category'])->orderByDesc('id')->get();
                                @endphp
                                @foreach($permission as $data)
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-2 col-md-6 control-label">
                                                {{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? $data['name_ar'] : $data['name_en'] }}
                                            </label>
                                            <div class="col-sm-10 col-md-6">
                                                <label class="control-label">
                                                    <input type="checkbox" name="perm[]" value="{{ $data['id'] }}"
                                                           class="flat-red"> &nbsp;{{ trans('cruds.checked') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
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
