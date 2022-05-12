@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.loopBank.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loop-banks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.loopBank.fields.id') }}
                        </th>
                        <td>
                            {{ $loopBank->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loopBank.fields.bank_name') }}
                        </th>
                        <td>
                            {{ $loopBank->bank_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loopBank.fields.swift_code') }}
                        </th>
                        <td>
                            {{ $loopBank->swift_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loopBank.fields.iban') }}
                        </th>
                        <td>
                            {{ $loopBank->iban }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loopBank.fields.branch_no') }}
                        </th>
                        <td>
                            {{ $loopBank->branch_no }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loop-banks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection