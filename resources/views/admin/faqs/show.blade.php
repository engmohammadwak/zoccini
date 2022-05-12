@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.faq.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.faqs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.faq.fields.id') }}
                        </th>
                        <td>
                            {{ $faq->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faq.fields.q_ar') }}
                        </th>
                        <td>
                            {{ $faq->q_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faq.fields.a_ar') }}
                        </th>
                        <td>
                            {{ $faq->a_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faq.fields.q_en') }}
                        </th>
                        <td>
                            {{ $faq->q_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faq.fields.a_en') }}
                        </th>
                        <td>
                            {{ $faq->a_en ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.faqs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
