@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sittingArea.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sitting-areas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.sittingArea.fields.id') }}
                        </th>
                        <td>
                            {{ $sittingArea->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sittingArea.fields.name_ar') }}
                        </th>
                        <td>
                            {{ $sittingArea->name_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sittingArea.fields.name_en') }}
                        </th>
                        <td>
                            {{ $sittingArea->name_en }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sitting-areas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection