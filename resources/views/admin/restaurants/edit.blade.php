@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.restaurant.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.restaurants.update", [$restaurant->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
{{--            <div class="form-group">--}}
{{--                <label for="restaurant_id">{{ trans('cruds.restaurant.fields.restaurant') }}</label>--}}
{{--                <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}" name="restaurant_id" id="restaurant_id">--}}
{{--                    @foreach($restaurants as $id => $restaurant)--}}
{{--                        <option value="{{ $id }}" {{ (old('restaurant_id') ? old('restaurant_id') : $restaurant->restaurant->id ?? '') == $id ? 'selected' : '' }}>{{ $restaurant }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                @if($errors->has('restaurant'))--}}
{{--                    <span class="text-danger">{{ $errors->first('restaurant') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.restaurant.fields.restaurant_helper') }}</span>--}}
{{--            </div>--}}
            <div class="form-group">
                <label class="required" for="name_ar">{{ trans('cruds.restaurant.fields.name_ar') }}</label>
                <input class="form-control {{ $errors->has('name_ar') ? 'is-invalid' : '' }}" type="text" name="name_ar" id="name_ar" value="{{ old('name_ar', $restaurant->name_ar) }}" required>
                @if($errors->has('name_ar'))
                    <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.name_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name_en">{{ trans('cruds.restaurant.fields.name_en') }}</label>
                <input class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" type="text" name="name_en" id="name_en" value="{{ old('name_en', $restaurant->name_en) }}" required>
                @if($errors->has('name_en'))
                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.name_en_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description_ar">{{ trans('cruds.restaurant.fields.description_ar') }}</label>
                <textarea class="form-control {{ $errors->has('description_ar') ? 'is-invalid' : '' }}" name="description_ar" id="description_ar">{{ old('description_ar', $restaurant->description_ar) }}</textarea>
                @if($errors->has('description_ar'))
                    <span class="text-danger">{{ $errors->first('description_ar') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.description_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description_en">{{ trans('cruds.restaurant.fields.description_en') }}</label>
                <textarea class="form-control {{ $errors->has('description_en') ? 'is-invalid' : '' }}" name="description_en" id="description_en">{{ old('description_en', $restaurant->description_en) }}</textarea>
                @if($errors->has('description_en'))
                    <span class="text-danger">{{ $errors->first('description_en') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.description_en_helper') }}</span>
            </div>
{{--            <div class="form-group">--}}
{{--                <label for="image">{{ trans('cruds.restaurant.fields.image') }}</label>--}}
{{--                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">--}}
{{--                </div>--}}
{{--                @if($errors->has('image'))--}}
{{--                    <span class="text-danger">{{ $errors->first('image') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.restaurant.fields.image_helper') }}</span>--}}
{{--            </div>--}}

            <div class="form-group">
                <label for="delivery_id">{{ trans('cruds.restaurant.fields.delivery') }}</label>
                <select class="form-control select2 {{ $errors->has('delivery') ? 'is-invalid' : '' }}" name="delivery_id" id="delivery_id">
                    @foreach($deliveries as $id => $delivery)
                        <option value="{{ $id }}" {{ (old('delivery_id') ? old('delivery_id') : $restaurant->delivery->id ?? '') == $id ? 'selected' : '' }}>{{ $delivery }}</option>
                    @endforeach
                </select>
                @if($errors->has('delivery'))
                    <span class="text-danger">{{ $errors->first('delivery') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.delivery_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_methods">{{ trans('cruds.restaurant.fields.payment_methods') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('payment_methods') ? 'is-invalid' : '' }}" name="payment_methods[]" id="payment_methods" multiple>
                    @foreach($payment_methods as $id => $payment_methods)
                        <option value="{{ $id }}" {{ (in_array($id, old('payment_methods', [])) || $restaurant->payment_methods->contains($id)) ? 'selected' : '' }}>{{ $payment_methods }}</option>
                    @endforeach
                </select>
                @if($errors->has('payment_methods'))
                    <span class="text-danger">{{ $errors->first('payment_methods') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.payment_methods_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tag">{{ trans('cruds.restaurant.fields.tag') }}</label>
                <input class="form-control {{ $errors->has('tag') ? 'is-invalid' : '' }}" type="text" name="tag" id="tag" value="{{ old('tag', $restaurant->tag) }}">
                @if($errors->has('tag'))
                    <span class="text-danger">{{ $errors->first('tag') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sitting_areas">{{ trans('cruds.restaurant.fields.sitting_area') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('sitting_areas') ? 'is-invalid' : '' }}" name="sitting_areas[]" id="sitting_areas" multiple>
                    @foreach($sitting_areas as $id => $sitting_area)
                        <option value="{{ $id }}" {{ (in_array($id, old('sitting_areas', [])) || $restaurant->sitting_areas->contains($id)) ? 'selected' : '' }}>{{ $sitting_area }}</option>
                    @endforeach
                </select>
                @if($errors->has('sitting_areas'))
                    <span class="text-danger">{{ $errors->first('sitting_areas') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.sitting_area_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.restaurant.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $restaurant->address) }}">
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.address_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="number_of_employees">{{ trans('cruds.restaurant.fields.number_of_employees') }}</label>
                <input class="form-control {{ $errors->has('number_of_employees') ? 'is-invalid' : '' }}" type="text" name="number_of_employees" id="number_of_employees" value="{{ old('number_of_employees', $restaurant->number_of_employees) }}">
                @if($errors->has('number_of_employees'))
                    <span class="text-danger">{{ $errors->first('number_of_employees') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.number_of_employees_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number_branches">{{ trans('cruds.restaurant.fields.number_branches') }}</label>
                <input class="form-control {{ $errors->has('number_branches') ? 'is-invalid' : '' }}" type="text" name="number_branches" id="number_branches" value="{{ old('number_branches', $restaurant->number_branches) }}">
                @if($errors->has('number_branches'))
                    <span class="text-danger">{{ $errors->first('number_branches') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.number_branches_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="country_id">{{ trans('cruds.restaurant.fields.country') }}</label>
                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id">
                    @foreach($countries as $id => $country)
                        <option value="{{ $id }}" {{ (old('country_id') ? old('country_id') : $restaurant->country->id ?? '') == $id ? 'selected' : '' }}>{{ $country }}</option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city_id">{{ trans('cruds.restaurant.fields.city') }}</label>
                <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                    @foreach($cities as $id => $city)
                        <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $restaurant->city->id ?? '') == $id ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
                @if($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.city_helper') }}</span>
            </div>
{{--            <div class="form-group">--}}
{{--                <label for="commercial_registration_image">{{ trans('cruds.restaurant.fields.commercial_registration_image') }}</label>--}}
{{--                <div class="needsclick dropzone {{ $errors->has('commercial_registration_image') ? 'is-invalid' : '' }}" id="commercial_registration_image-dropzone">--}}
{{--                </div>--}}
{{--                @if($errors->has('commercial_registration_image'))--}}
{{--                    <span class="text-danger">{{ $errors->first('commercial_registration_image') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.restaurant.fields.commercial_registration_image_helper') }}</span>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label for="identity_card_image">{{ trans('cruds.restaurant.fields.identity_card_image') }}</label>--}}
{{--                <div class="needsclick dropzone {{ $errors->has('identity_card_image') ? 'is-invalid' : '' }}" id="identity_card_image-dropzone">--}}
{{--                </div>--}}
{{--                @if($errors->has('identity_card_image'))--}}
{{--                    <span class="text-danger">{{ $errors->first('identity_card_image') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.restaurant.fields.identity_card_image_helper') }}</span>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label for="company_seal">{{ trans('cruds.restaurant.fields.company_seal') }}</label>--}}
{{--                <div class="needsclick dropzone {{ $errors->has('company_seal') ? 'is-invalid' : '' }}" id="company_seal-dropzone">--}}
{{--                </div>--}}
{{--                @if($errors->has('company_seal'))--}}
{{--                    <span class="text-danger">{{ $errors->first('company_seal') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.restaurant.fields.company_seal_helper') }}</span>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label for="other_image">{{ trans('cruds.restaurant.fields.other_image') }}</label>--}}
{{--                <div class="needsclick dropzone {{ $errors->has('other_image') ? 'is-invalid' : '' }}" id="other_image-dropzone">--}}
{{--                </div>--}}
{{--                @if($errors->has('other_image'))--}}
{{--                    <span class="text-danger">{{ $errors->first('other_image') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.restaurant.fields.other_image_helper') }}</span>--}}
{{--            </div>--}}
            <div class="form-group">
                <label for="open_time">{{ trans('cruds.restaurant.fields.open_time') }}</label>
                <input class="form-control timepicker {{ $errors->has('open_time') ? 'is-invalid' : '' }}" type="text" name="open_time" id="open_time" value="{{ old('open_time', $restaurant->open_time) }}">
                @if($errors->has('open_time'))
                    <span class="text-danger">{{ $errors->first('open_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.open_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="close_time">{{ trans('cruds.restaurant.fields.close_time') }}</label>
                <input class="form-control timepicker {{ $errors->has('close_time') ? 'is-invalid' : '' }}" type="text" name="close_time" id="close_time" value="{{ old('close_time', $restaurant->close_time) }}">
                @if($errors->has('close_time'))
                    <span class="text-danger">{{ $errors->first('close_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.close_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="min_waiting">{{ trans('cruds.restaurant.fields.min_waiting') }}</label>
                <input class="form-control {{ $errors->has('min_waiting') ? 'is-invalid' : '' }}" type="text" name="min_waiting" id="min_waiting" value="{{ old('min_waiting', $restaurant->min_waiting) }}">
                @if($errors->has('min_waiting'))
                    <span class="text-danger">{{ $errors->first('min_waiting') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.min_waiting_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="max_waiting">{{ trans('cruds.restaurant.fields.max_waiting') }}</label>
                <input class="form-control {{ $errors->has('max_waiting') ? 'is-invalid' : '' }}" type="text" name="max_waiting" id="max_waiting" value="{{ old('max_waiting', $restaurant->max_waiting) }}">
                @if($errors->has('max_waiting'))
                    <span class="text-danger">{{ $errors->first('max_waiting') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.max_waiting_helper') }}</span>
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
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.restaurants.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
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
@if(isset($restaurant) && $restaurant->image)
      var file = {!! json_encode($restaurant->image) !!}
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
<script>
    Dropzone.options.commercialRegistrationImageDropzone = {
    url: '{{ route('admin.restaurants.storeMedia') }}',
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
      $('form').find('input[name="commercial_registration_image"]').remove()
      $('form').append('<input type="hidden" name="commercial_registration_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="commercial_registration_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($restaurant) && $restaurant->commercial_registration_image)
      var file = {!! json_encode($restaurant->commercial_registration_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="commercial_registration_image" value="' + file.file_name + '">')
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
<script>
    Dropzone.options.identityCardImageDropzone = {
    url: '{{ route('admin.restaurants.storeMedia') }}',
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
      $('form').find('input[name="identity_card_image"]').remove()
      $('form').append('<input type="hidden" name="identity_card_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="identity_card_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($restaurant) && $restaurant->identity_card_image)
      var file = {!! json_encode($restaurant->identity_card_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="identity_card_image" value="' + file.file_name + '">')
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
<script>
    Dropzone.options.companySealDropzone = {
    url: '{{ route('admin.restaurants.storeMedia') }}',
    maxFilesize: 20, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="company_seal"]').remove()
      $('form').append('<input type="hidden" name="company_seal" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="company_seal"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($restaurant) && $restaurant->company_seal)
      var file = {!! json_encode($restaurant->company_seal) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="company_seal" value="' + file.file_name + '">')
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
<script>
    var uploadedOtherImageMap = {}
Dropzone.options.otherImageDropzone = {
    url: '{{ route('admin.restaurants.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
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
      $('form').append('<input type="hidden" name="other_image[]" value="' + response.name + '">')
      uploadedOtherImageMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedOtherImageMap[file.name]
      }
      $('form').find('input[name="other_image[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($restaurant) && $restaurant->other_image)
      var files = {!! json_encode($restaurant->other_image) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="other_image[]" value="' + file.file_name + '">')
        }
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