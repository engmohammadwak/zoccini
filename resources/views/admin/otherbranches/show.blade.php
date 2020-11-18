@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.otherbranch.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.otherbranches.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.otherbranch.fields.id') }}
                        </th>
                        <td>
                            {{ $otherbranch->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherbranch.fields.restaurants') }}
                        </th>
                        <td>
                            {{ $otherbranch->restaurants->name_en ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherbranch.fields.branch_name_ar') }}
                        </th>
                        <td>
                            {{ $otherbranch->branch_name_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherbranch.fields.branch_name_en') }}
                        </th>
                        <td>
                            {{ $otherbranch->branch_name_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherbranch.fields.branch_address_ar') }}
                        </th>
                        <td>
                            {{ $otherbranch->branch_address_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherbranch.fields.branch_address_en') }}
                        </th>
                        <td>
                            {{ $otherbranch->branch_address_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherbranch.fields.phone') }}
                        </th>
                        <td>
                            {{ $otherbranch->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherbranch.fields.email') }}
                        </th>
                        <td>
                            {{ $otherbranch->email }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.otherbranches.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection