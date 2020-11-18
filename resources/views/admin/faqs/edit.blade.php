@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.faq.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.faqs.update", [$faq->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="q_ar">{{ trans('cruds.faq.fields.q_ar') }}</label>
                <input class="form-control {{ $errors->has('q_ar') ? 'is-invalid' : '' }}" type="text" name="q_ar" id="q_ar" value="{{ old('q_ar', $faq->q_ar) }}" required>
                @if($errors->has('q_ar'))
                    <span class="text-danger">{{ $errors->first('q_ar') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.faq.fields.q_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="a_ar">{{ trans('cruds.faq.fields.a_ar') }}</label>
                <input class="form-control {{ $errors->has('a_ar') ? 'is-invalid' : '' }}" type="text" name="a_ar" id="a_ar" value="{{ old('a_ar', $faq->a_ar) }}" required>
                @if($errors->has('a_ar'))
                    <span class="text-danger">{{ $errors->first('a_ar') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.faq.fields.a_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="q_en">{{ trans('cruds.faq.fields.q_en') }}</label>
                <input class="form-control {{ $errors->has('q_en') ? 'is-invalid' : '' }}" type="text" name="q_en" id="q_en" value="{{ old('q_en', $faq->q_en) }}" required>
                @if($errors->has('q_en'))
                    <span class="text-danger">{{ $errors->first('q_en') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.faq.fields.q_en_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="a_en">{{ trans('cruds.faq.fields.a_en') }}</label>
                <input class="form-control {{ $errors->has('a_en') ? 'is-invalid' : '' }}" type="text" name="a_en" id="a_en" value="{{ old('a_en', $faq->a_en) }}" required>
                @if($errors->has('a_en'))
                    <span class="text-danger">{{ $errors->first('a_en') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.faq.fields.a_en_helper') }}</span>
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