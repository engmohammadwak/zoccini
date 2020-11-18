@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.table.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tables.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.table.fields.id') }}
                        </th>
                        <td>
                            {{ $table->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.table.fields.number') }}
                        </th>
                        <td>
                            {{ $table->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.table.fields.sitting_area') }}
                        </th>
                        <td>
                            {{ $table->sitting_area->name_en ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.table.fields.chares') }}
                        </th>
                        <td>
                            {{ $table->chares }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.table.fields.status') }}
                        </th>
                        <td>
                            {{ $table->status->name_en ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tables.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection