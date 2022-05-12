@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.order.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-globe"></i> {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? $order->restaurants->name_ar : $order->restaurants->name_en}}
                                <small class="float-right">{{trans('cruds.date')}}
                                    : {{\Carbon\Carbon::now()->translatedFormat('d/m/Y')}}</small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>{{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? optional($order->restaurants)->name_ar : optional($order->restaurants)->name_en}}</strong><br>
                                {{$order->restaurants->addess}}<br>
                                {{trans('cruds.user.fields.phone')}}: {{optional(optional($order->restaurants)->restaurant)->phone}}<br>
                                {{trans('cruds.user.fields.email')}}: {{optional(optional($order->restaurants)->restaurant)->email}}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong>{{optional($order->user)->name .' '.optional($order->user)->last_name}}</strong><br>
                                {{trans('cruds.user.fields.phone')}}: {{optional($order->user)->phone}}<br>
                                {{trans('cruds.user.fields.email')}}: {{optional($order->user)->email}}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>{{ trans('cruds.order_id') }}:</b> #{{$order->id}}<br>
                            <b>{{ trans('cruds.payment_due') }}
                                :</b> {{$order->created_at->translatedFormat('d/m/Y  h:i A')}}<br>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>{{trans('cruds.qty')}}</th>
                                    <th>{{trans('cruds.product')}}</th>
                                    <th>{{trans('cruds.price')}}</th>
                                    <th>{{trans('cruds.extra_invoice')}}</th>
                                    <th>{{trans('cruds.subtotal')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{$item->pivot->count}}</td>
                                        <td>{{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? $item->name_ar : $item->name_en}}</td>
                                        <td>{{$item->pivot->price}}</td>
                                        <td>
                                            @php
                                                $extra_final = 0;
                                                    $extra =  \Illuminate\Support\Facades\DB::table('extra_order')
                                                              ->where('order_id', $item->pivot->order_id)
                                                              ->where('item_id', $item->id)
                                                              ->get();

                                                 foreach($extra as $value){
                                                   $extra = \App\Models\Extra::find($value->extra_id);
                                                 echo 'name : &nbsp;'.$extra->name .'&nbsp;&nbsp;&nbsp;count : &nbsp;'.$value->count.'&nbsp;&nbsp;&nbsp;price : &nbsp;'.$value->price;
                                                 echo '<br>';
                                                   $extra_final = $extra_final + $value->final_price;
                                                 }
                                            @endphp
                                        </td>
                                        <td>{{$item->pivot->final_price + $extra_final}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                    {{--                        <!-- accepted payments column -->--}}
                    {{--                        <div class="col-6">--}}
                    {{--                            <p class="lead">Payment Methods:</p>--}}
                    {{--                            <img src="../../dist/img/credit/visa.png" alt="Visa">--}}
                    {{--                            <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">--}}
                    {{--                            <img src="../../dist/img/credit/american-express.png" alt="American Express">--}}
                    {{--                            <img src="../../dist/img/credit/paypal2.png" alt="Paypal">--}}

                    {{--                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">--}}
                    {{--                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya--}}
                    {{--                                handango imeem--}}
                    {{--                                plugg--}}
                    {{--                                dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.--}}
                    {{--                            </p>--}}
                    {{--                        </div>--}}
                    <!-- /.col -->
                        <div class="col-6">
                            <p class="lead">{{ trans('cruds.payment_due') }} {{$order->created_at->translatedFormat('d/m/Y  h:i A')}}</p>

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">{{trans('cruds.subtotal')}}:</th>
                                        <td>{{$order->price}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">{{trans('cruds.vat')}}:</th>
                                        <td>{{$order->vat ?? 0}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">{{trans('cruds.application_services')}}:</th>
                                        <td>{{$order->Application_services ?? 0}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">{{trans('cruds.discount_Application_services')}}:</th>
                                        <td>{{$order->Discount_Application_services ?? 0}}</td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('cruds.total')}}:</th>
                                        <td>{{$order->final_price}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
{{--                    <div class="row no-print">--}}
{{--                        <div class="col-12">--}}
{{--                            <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i--}}
{{--                                        class="fas fa-print"></i> Print</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>



@endsection
