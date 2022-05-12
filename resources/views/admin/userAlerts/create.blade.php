@extends('layouts.admin')
@section('content')
<style>
    .select2-container--default .select2-search--inline .select2-search__field {
        background: transparent;
        border: none;
        outline: 0;
        box-shadow: none;
        -webkit-appearance: textfield;
        width: 1500px !important;
    }
</style>
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.userAlert.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.user-alerts.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="status_id">{{ trans('cruds.user_type') }}</label>
                    <select id="user_type" onchange="check()"
                            class="form-control select2 {{ $errors->has('user_type') ? 'is-invalid' : '' }}"
                            name="user_type" id="user_type">
                        <option value="user">{{trans('cruds.user.title')}}</option>
                        <option value="admin">{{trans('cruds.admin')}}</option>
                        <option value="restaurant">{{trans('cruds.restaurant.title')}}</option>
                        <option value="one">{{trans('cruds.one')}}</option>
                    </select>
                    @if($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label class="required" for="alert_text">{{ trans('cruds.userAlert.fields.alert_text') }}</label>
                    <input class="form-control {{ $errors->has('alert_text') ? 'is-invalid' : '' }}" type="text"
                           name="alert_text" id="alert_text" value="{{ old('alert_text', '') }}" required>
                    @if($errors->has('alert_text'))
                        <span class="text-danger">{{ $errors->first('alert_text') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.userAlert.fields.alert_text_helper') }}</span>
                </div>
                <div id="link" style="display: none" class="form-group">
                    <label for="alert_link">{{ trans('cruds.userAlert.fields.alert_link') }}</label>
                    <input class="form-control {{ $errors->has('alert_link') ? 'is-invalid' : '' }}" type="text"
                           name="alert_link" id="alert_link" value="{{ old('alert_link', '') }}">
                    @if($errors->has('alert_link'))
                        <span class="text-danger">{{ $errors->first('alert_link') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.userAlert.fields.alert_link_helper') }}</span>
                </div>
                <div id="body" class="form-group">

                    <label for="alert_link">{{ trans('cruds.userAlert.fields.alert_body') }}</label>
                    <textarea class="form-control {{ $errors->has('alert_body') ? 'is-invalid' : '' }}" type="text"
                              name="alert_body" id="alert_body">{{ old('alert_body', '') }}</textarea>
                    @if($errors->has('alert_body'))
                        <span class="text-danger">{{ $errors->first('alert_body') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.userAlert.fields.alert_body_helper') }}</span>
                </div>
                <div id="user" style="display: none" class="form-group">
                    <label for="users">{{ trans('cruds.userAlert.fields.user') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}" name="users[]"
                            id="users" multiple>
                        @foreach($users as  $user)
                            <option
                                value="{{ $user->id }}" {{ in_array($user->id, old('users', [])) ? 'selected' : '' }}>{{ $user->name . ' '. $user->last_name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('users'))
                        <span class="text-danger">{{ $errors->first('users') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.userAlert.fields.user_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function check() {
            var user_type = document.getElementById('user_type').value;
            var link = document.getElementById('link');
            var body = document.getElementById('body');
            var user = document.getElementById('user');

            if (user_type == "all") {
                body.style.display = "block";
            } else if (user_type == 'user') {
                body.style.display = "block";
                link.style.display = "none";
                user.style.display = "none";
            } else if (user_type == 'admin') {
                link.style.display = "block";
                body.style.display = "none";
                user.style.display = "none";
            } else if (user_type == 'restaurant') {
                link.style.display = "block";
                body.style.display = "none";
                user.style.display = "none";
            } else if (user_type == 'one') {
                user.style.display = "block";
                link.style.display = "none";
                body.style.display = "block";
            }


        }
    </script>

@endsection
