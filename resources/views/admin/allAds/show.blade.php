@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.allAd.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.all-ads.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.allAd.fields.id') }}
                        </th>
                        <td>
                            {{ $allAd->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allAd.fields.restaurant') }}
                        </th>
                        <td>
                            {{ $allAd->restaurant->name_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allAd.fields.category') }}
                        </th>
                        <td>
                            {{ $allAd->category->name_ar ?? '' }}
                        </td>
                    </tr>


                    @if ($allAd->category->id == 1)
                        <tr>
                            <th>
                                {{ trans('cruds.allAd.fields.description_ar') }}
                            </th>
                            <td>
                                {!! $allAd->description_ar !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.allAd.fields.description_en') }}
                            </th>
                            <td>
                                {!! $allAd->description_en !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.allAd.fields.number_requests') }}
                            </th>
                            <td>
                                {{ $allAd->number_requests }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.allAd.fields.voucher_number') }}
                            </th>
                            <td>
                                {{ $allAd->voucher_number }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.allAd.fields.image') }}
                            </th>
                            <td>
                                @if($allAd->image)
                                    <a href="{{ url('local/public/img/ads/' . $allAd->image) }}" target="_blank">
                                        <img src="{{ url('local/public/img/ads/' . $allAd->image) }}" width="50px" height="50px">
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.allAd.fields.winner') }}
                            </th>
                            <td>
                                {{ $allAd->winner->name ?? '' }}
                            </td>
                        </tr>
                        <tr  style="background-color:
@if(Carbon\Carbon::now() > $allAd->withdraw_day )
                        red
                        @endif
">
                            <th>
                                {{ trans('cruds.allAd.fields.withdraw_day') }}
                            </th>
                            <td>
                                {{ $allAd->withdraw_day }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <th>
                                {{ trans('cruds.allAd.fields.discount') }}
                            </th>
                            <td>
                                {{ $allAd->discount }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>
                            {{ trans('cruds.slideShow.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\AllAd::STATUS_RADIO[$allAd->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.all-ads.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection