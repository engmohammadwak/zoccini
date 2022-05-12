@extends('layouts.website')
@section('content')

    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="loader-page"><span></span><span></span></div>
        <div class="mobile-menu-overlay"></div>
        @include('partials.header')

        <div class="page-content bg-gray-2">
            <div class="container pb-5">
                <section class="section wow fadeInUp" data-wow-delay="0.2s">
                    <div class="container">
                        <h2 class="title-section font-bold">{{web('Welcome Back, ') . \Illuminate\Support\Facades\Auth::user()['name']}}!</h2>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="bg-white rounded_md p-4 mb-4">
                                    <h3 class="font-medium mb-1">{{web('total')}}</h3>
                                    <h2 class="h1 font-medium mb-4 mb-lg-5">${{\App\Models\ReferralSubscription::where('user_loop_id' , \Illuminate\Support\Facades\Auth::id())->where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth()->subMonth()->toDateString())->sum('price')}}</h2>
                                </div>
                            </div>
                            @foreach($plan as $value)
                            <div class="col-lg-4">
                                <div class="bg-white rounded_md p-4 mb-4">
                                    <h3 class="font-medium mb-1">{{$value->name}}  </h3>
                                    <h2 class="h1 font-medium mb-4 mb-lg-5">{{\App\Models\ReferralSubscription::where('user_loop_id' , \Illuminate\Support\Facades\Auth::id())->where('plan_id' ,$value->id )->where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth()->subMonth()->toDateString())->count()}}</h2>
                                </div>
                            </div>
                            @endforeach

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="container-table">
                                    <table class="table table-borderless table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <td width="30%">Name</td>
                                            <td>price</td>
                                            <td>plans</td>
                                            <td>Date</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($subscription as $value)
                                        <tr>
                                            <td>{{ optional(\App\Models\Restaurant::find($value->user_id))->name}}</td>
                                            <td>{{$value->price}}</td>
                                            <td><span class="plans-nu plans-success">{{optional($value->plan)->name}}</span></td>
                                            <td>{{date('F d , Y', strtotime($value->created_at))}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        @include('partials.footer')

    </div>
    <!-- end:: Page -->

@endsection
@section('scripts')

@endsection
