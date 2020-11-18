@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.saveCreditCard.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.save-credit-cards.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.saveCreditCard.fields.id') }}
                        </th>
                        <td>
                            {{ $saveCreditCard->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.saveCreditCard.fields.user') }}
                        </th>
                        <td>
                            {{ $saveCreditCard->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.saveCreditCard.fields.name') }}
                        </th>
                        <td>
                            {{ $saveCreditCard->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.saveCreditCard.fields.card_number') }}
                        </th>
                        <td>
                            {{ $saveCreditCard->card_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.saveCreditCard.fields.month') }}
                        </th>
                        <td>
                            {{ $saveCreditCard->month }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.saveCreditCard.fields.year') }}
                        </th>
                        <td>
                            {{ $saveCreditCard->year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.saveCreditCard.fields.cvc') }}
                        </th>
                        <td>
                            {{ $saveCreditCard->cvc }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.save-credit-cards.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection