@extends('layouts.admin')
@section('content')



    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{ url('local/public/img/setting/' . getSetting('user_image')) }}"
                                     alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $loopuser->user->name.' '.$loopuser->user->last_name }}</h3>

                            <p class="text-muted text-center">{{web('zoccini Loop')}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>{{web('referral subscription Count')}}</b> <a
                                        class="float-right">{{optional($loopuser->referral_subscription)->count()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{web('referral subscription price')}}</b> <a
                                        class="float-right">{{optional($loopuser->referral_subscription)->sum('price')}}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{web('About Me')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> {{web('phone')}}</strong>

                            <p class="text-muted">
                                {{ optional($loopuser->user)->phone }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-mail-bulk mr-1"></i> {{web('email')}}</strong>

                            <p class="text-muted">{{ optional($loopuser->user)->email }}</p>

                            <hr>

                            <strong><i class="fas fa-place-of-worship mr-1"></i> {{web('country')}}</strong>

                            <p class="text-muted"> {{ optional($loopuser->country)->name ?? '' }}</p>

                            <hr>

                            <strong><i class="fas fa-map-pin mr-1"></i> {{web('city')}}</strong>

                            <p class="text-muted"> {{ optional($loopuser->city)->name ?? '' }}</p>

                            <hr>


                            <strong><i class="fas fa-database mr-1"></i>  {{ trans('cruds.loopuser.fields.expire_date') }}</strong>

                            <p class="text-muted">  {{ $loopuser->expire_date }}</p>

                            <hr>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">{{web('images')}}</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">{{web('referral subscription')}}</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.loopuser.fields.id') }}
                                            </th>
                                            <td>
                                                {{ $loopuser->id }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.user.fields.name') }}
                                            </th>
                                            <td>
                                                {{ optional($loopuser->user)->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.user.fields.last_name') }}
                                            </th>
                                            <td>
                                                {{ optional($loopuser->user)->last_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.user.fields.phone') }}
                                            </th>
                                            <td>
                                                {{ optional($loopuser->user)->phone }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.user.fields.email') }}
                                            </th>
                                            <td>
                                                {{ optional($loopuser->user)->email }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.loopuser.fields.country') }}
                                            </th>
                                            <td>
                                                {{ optional($loopuser->country)->name ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.loopuser.fields.city') }}
                                            </th>
                                            <td>
                                                {{ optional($loopuser->city)->name_ar ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.loopuser.fields.user') }}
                                            </th>
                                            <td>
                                                {{ optional($loopuser->user)->name ?? '' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                {{ web('ID Verification') }}
                                            </th>
                                            <td>
                                                {{ $loopuser->verification_type ==  'national' ? web('National ID') : web('Passboard ID') }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                {{ web('National ID') }}
                                            </th>
                                            <td>
                                                {{ $loopuser->national }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                {{ trans('cruds.loopuser.fields.expire_date') }}
                                            </th>
                                            <td>
                                                {{ $loopuser->expire_date }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.loopuser.fields.attach_national') }}
                                            </th>
                                            <td>
                                                @if($loopuser->attach_national)
                                                    <a href="{{ url('local/public/img/user/' . $loopuser->attach_national) }}"
                                                       target="_blank">
                                                        <img src="{{ url('local/public/img/user/' . $loopuser->attach_national) }}"
                                                             width="50px" height="50px">
                                                    </a>
                                                @else
                                                    <a href="{{ url('local/public/img/setting/' . getSetting('user_image')) }}"
                                                       target="_blank">
                                                        <img src="{{ url('local/public/img/setting/' . getSetting('user_image')) }}"
                                                             width="50px" height="50px">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.loopuser.fields.invoice_image') }}
                                            </th>
                                            <td>
                                                @if($loopuser->invoice_image)
                                                    <a href="{{ url('local/public/img/user/' . $loopuser->invoice_image) }}"
                                                       target="_blank">
                                                        <img src="{{ url('local/public/img/user/' . $loopuser->invoice_image) }}"
                                                             width="50px" height="50px">
                                                    </a>
                                                @else
                                                    <a href="{{ url('local/public/img/setting/' . getSetting('user_image')) }}"
                                                       target="_blank">
                                                        <img src="{{ url('local/public/img/setting/' . getSetting('user_image')) }}"
                                                             width="50px" height="50px">
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    <div class="table-responsive">
                                        <table class=" table table-bordered table-striped table-hover datatable datatable-ReferralSubscription">
                                            <thead>
                                            <tr>
                                                <th width="10">

                                                </th>
                                                <th>
                                                    {{ trans('cruds.referralSubscription.fields.id') }}
                                                </th>
                                                <th>
                                                    {{ trans('cruds.referralSubscription.fields.user') }}
                                                </th>
                                                <th>
                                                    {{ trans('cruds.referralSubscription.fields.plan') }}
                                                </th>
                                                <th>
                                                    {{ trans('cruds.referralSubscription.fields.price') }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                </td>
                                                <td>
                                                </td>
                                                <td>
                                                    <select class="search">
                                                        <option value>{{ trans('global.all') }}</option>
                                                        @foreach($restaurant as $key => $item)
                                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="search">
                                                        <option value>{{ trans('global.all') }}</option>
                                                        @foreach($subscription_packages as $key => $item)
                                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                </td>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($referralSubscriptions as $key => $referralSubscription)
                                                <tr data-entry-id="{{ $referralSubscription->id }}">
                                                    <td>

                                                    </td>
                                                    <td>
                                                        {{ $referralSubscription->id ?? '' }}
                                                    </td>
                                                    <td>
                                                        {{ optional($referralSubscription->user)->name ?? '' }}
                                                    </td>

                                                    <td>
                                                        {{ optional($referralSubscription->plan)->name ?? '' }}
                                                    </td>
                                                    <td>
                                                        {{ $referralSubscription->price ?? '' }}
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>


@endsection
