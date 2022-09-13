<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderRestaurantDetailsResource;
use App\Http\Resources\OrderRestaurantResource;
use App\Http\Resources\SimpleOrderResource;
use App\Models\AllAd;
use App\Models\Cart;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Extra;
use App\Models\Income;
use App\Models\Item;
use App\Models\OfferUser;
use App\Models\Order;
use App\Models\Point;
use App\Models\Queue;
use App\Models\Rate;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use App\Notifications\SendMessageNotification;
use Carbon\Carbon;
use Facade\Ignition\Tabs\Tab;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = SimpleOrderResource::collection(Order::where('user_id', Auth::id())->get());
        return successResponse(trans('cruds.api.success'), $data);
    }



    public function store(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validator = $this->validator($request);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first());
        }
        $request->request->add(['status_id' => '3', 'user_id' => Auth::id(), 'sitting_area_id' => $request->sitting_area, 'car_number_id' => $request->car_id]);
        $order = Order::create($request->all());
        $order->vat = getSetting('vat');

        //Application_services
        $order->Application_services = getSetting('application_services');
        $order->Discount_Application_services = getSetting('discount_application_services');
        if ($request->offer_id) {
            $order->final_price = (float)getSetting('application_services') + ((float)getSetting('application_services') * ((int)getSetting('vat') / 100));
        } else {
            if ($request->type_id == 1) {
                if ($request->restaurants_id) {
                    $restaurants = Restaurant::find($request->restaurants_id);
                    if ($restaurants->number_order_automatically > 0) {
                        $restaurants_order = Order::where('restaurants_id', $request->restaurants_id)->where('status_id', 3)->count();
                        //It is -  1 to deduct this order because it was created
                        if ($restaurants_order - 1 < $restaurants->number_order_automatically) {
                            $order->status_id = 5;
                        }
                    }
                }


                $Discount_Application_services_final = (float)getSetting('application_services') * ((int)getSetting('rate_inside') / 100);
            } else {
                $Discount_Application_services_final = (float)getSetting('application_services') * ((int)getSetting('rate_outside') / 100);
            }
            $total = ((float)getSetting('application_services') - $Discount_Application_services_final);
            $order->final_price = $total + ($total * ((int)getSetting('vat') / 100));
        }

        $order->save();

        Income::create([
            'income_category_id' => 1,
            'entry_date' => Carbon::now()->format('Y-m-d'),
            'amount' => $order->final_price,
            'description' => 'طلب رقم ' . $order->id,
        ]);

        $data = new OrderResource($order);

        if ($order->status_id == 3) {
            $queue = new Queue();
            $queue->restaurant_id = $request->restaurants_id;
            $queue->user_id = Auth::id();
            $queue->order_id = $order->id;
            $queue->type = $request->type_id;
            $queue->save();
        }

        if ($request->offer_id) {
            $offer_user = new OfferUser();
            $offer_user->user_id = Auth::id();
            $offer_user->offer_id = $request->offer_id;
            $offer_user->order_id = $order->id;
            $offer_user->status = 1;
            $offer_user->save();
        }


        // send notification //////////////////////////
        $receivers = User::where('restaurant_id', $request->restaurants_id)->where('status_id', '1')->where('online', 1)->get();
        foreach ($receivers as $receiver) {
            $notification = new SendMessageNotification(trans('cruds.api.order_title'), trans('cruds.api.order_message'), $order->id, null, 'new_order');
            send_notification_fcm($receiver['fcm_token'], $notification->toFCM());
            Notification::send($receiver, $notification);
        }
        //////////////////////////////////////////////////


        return successResponse(trans('cruds.api.success'), $data);

    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'restaurants_id' => 'required|exists:restaurants,id',
            'type_id' => 'required|exists:order_types,id',
        ]);
    }

    public function show(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $ordr = Order::find($id);
        if ($ordr) {
            $data = new OrderResource($ordr);
            return successResponse(trans('cruds.api.success'), $data);
        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }

    }

    public function update(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $order = Order::find($id);
        if ($order) {
            $order->update($request->all());
            $data = new OrderResource($order);
            return successResponse(trans('cruds.api.success'), $data);
        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }

    }

    public function finished(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $order = Order::find($id);
        if ($order) {
            $request->request->add(['status_id' => '2']);
            $order->update($request->all());
            $data = new OrderResource($order);
            return successResponse(trans('cruds.api.success'), $data);
        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }
    }

    public function arrival(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $order = Order::find($id);
        if ($order) {
            $request->request->add(['status_id' => '6']);
            $order->update($request->all());
            $data = new OrderResource($order);
            return successResponse(trans('cruds.api.success'), $data);
        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }
    }

    public function confirm(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validator = $this->validatorConfirm($request);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first());
        }
        $order = Order::find($id);
        if ($order) {
            $request->request->add(['status_id' => '1']);
            $order->update($request->all());
            $final_price = 0;
            $products = [];
            $extras = [];
            if ($request->cart_id) {
                $cart = Cart::find($request->cart_id);
                if ($cart) {
                    $cart_json = json_decode($cart->item_json);
                    foreach ($cart_json as $key => $product) {
                        $item = Item::find($product->item_id);
                        $price = $item->price;
                        $count = $product->count;
                        if (isset($product->special_request)) {
                            $special_request = $product->special_request;
                        } else {
                            $special_request = null;
                        }
                        $final_price = $final_price + ($price * $count);
                        $products[$product->item_id] = ['price' => $price, 'final_price' => $price * $count, 'count' => $count, 'special_request' => $special_request];
                        foreach ($product->extra as $key => $extra) {
                            $extra_price = Extra::find($extra->extra_id)->price;
                            $extra_count = $extra->count;
                            $final_price = $final_price + ($extra_price * $extra_count);
                            $extras[$extra->extra_id] = ['item_id' => $product->item_id, 'price' => $extra_price, 'final_price' => $extra_price * $extra_count, 'count' => $extra_count];
                        }
                        $item->sale_count = $item->sale_count + 1;
                        $item->save();
                    }

                    $order->items()->sync($products, false);//dont delete old entries = false
                    $order->extras()->sync($extras, false);//dont delete old entries = false
                    $cart->delete();
                } else {
                    return errorResponse('cart not found');
                }
            }

            if ($order->type_id == 1) {
                $Discount_Application_services_final = ($final_price + (float)getSetting('application_services')) * ((int)getSetting('rate_inside') / 100);
            } else {
                $Discount_Application_services_final = ($final_price + (float)getSetting('application_services')) * ((int)getSetting('rate_outside') / 100);
            }

            $order->price = $final_price;
            $order->vat = getSetting('vat');
            $order->Application_services = getSetting('application_services');
            $order->Discount_Application_services = $order->type_id == 1 ? getSetting('rate_inside') : getSetting('rate_outside');
            if ($order->offer_id) {
                $total = ($final_price + (float)getSetting('application_services'));
                $order->final_price = $total + ($total * ((int)getSetting('vat') / 100));
            } else {
                $total = ($final_price + (float)getSetting('application_services') - $Discount_Application_services_final);
                $order->final_price = $total + ($total * ((int)getSetting('vat') / 100));
            }

            $order->save();


            $data = new OrderResource($order);


            if ($order->offer_id) {
                $offer_user = OfferUser::where('user_id', Auth::id())->where('order_id', $order->id)->first();
                $offer_user->status = 2;
                $offer_user->save();
            }

            if ($request->payment_method == 3) {
                $order_price = $order->final_price;
                $total = Point::where('user_id', Auth::id())->where('type_id', '!=', 4)->sum('value');
                $spent = Point::where('user_id', Auth::id())->where('type_id', 4)->sum('value');
                $coin = ($total - $spent) / getSetting('point_price');

                if ($coin >= $order_price) {
                    $value = $order_price;
                } else {
                    $value = $coin;
                }

                $point = new Point();
                $point->value = $value;
                $point->user_id = Auth::id();
                $point->type_id = 4;
                $point->save();

            }


            // send notification //////////////////////////
            $receivers = User::where('restaurant_id', $order->restaurants_id)->where('status_id', '1')->where('online', 1)->get();
            foreach ($receivers as $receiver) {
                $notification = new SendMessageNotification(trans('cruds.api.order_title'), trans('cruds.api.confirm_order_message'), $order->id, null, 'confirm_order');
                send_notification_fcm($receiver['fcm_token'], $notification->toFCM());
                Notification::send($receiver, $notification);
            }
            //////////////////////////////////////////////////

            return successResponse(trans('cruds.api.success'), $data);
        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }

    }

    private function validatorConfirm(Request $request)
    {
        return Validator::make($request->all(), [
//            'cart_id' => 'required|exists:carts,id',
//            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required',
        ]);
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->status_id = 4;
            $order->cancel_reason_id = $request->cancel_reason_id;
            $order->cancel_reason_message = $request->cancel_reason_message;
            $order->save();
            $data = new OrderResource($order);
            return successResponse(trans('cruds.api.success'), $data);

        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }

    }

    public function rating(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validator = $this->rate_validator($request);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first());
        }

        $order = Order::find($id);
        if ($order) {
            $rate = new Rate();
            $rate->user_id = Auth::id();
            $rate->restaurant_id = $order->restaurants_id;
            $rate->rating = $request->rating;
            $rate->order_id = $id;
            $rate->rate_1 = $request->rate_1;
            $rate->rate_2 = $request->rate_2;
            $rate->rate_3 = $request->rate_3;
            $rate->rate_4 = $request->rate_4;
            $rate->comment = $request->comment;
            $rate->save();

            $restaurants = Restaurant::find($order->restaurants_id);
            $average = $restaurants->rating;
            if ($average == 0 || is_null($average))
                $average_rate = $request->rating;
            else
                $average_rate = ($average + $request->rating) / 2;
            $restaurants->rating = $average_rate;
            $restaurants->number_rate = $restaurants->number_rate + 1;
            $restaurants->save();
            return successResponse(trans('cruds.api.success'));

        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }

    }

    public function share(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $user_id = null;
        if ($request->phone) {
            $user = User::where('phone', $request->phone)->first();
            if ($user) {
                $user_id = $user->id;
            } else {
                return errorResponse(trans('cruds.api.no_account'));
            }
        } elseif ($request->contact_id) {
            $contact = Contact::find($request->contact_id);
            if ($contact) {
                $user_id = $contact->user_id;
            } else {
                return errorResponse(trans('cruds.api.contact_not_found'));
            }
        }

        if ($request->order_id) {
            $order = Order::find($request->order_id);
            if ($order) {
                $order->share()->attach($user_id);
                // send notification //////////////////////////
                $receiver = User::find($user_id);
                $notification = new SendMessageNotification(trans('cruds.api.share_order_title'), trans('cruds.api.share_order_message'), $request->order_id);
                send_notification_fcm($receiver->fcm_token, $notification->toFCM());
                Notification::send($receiver, $notification);
                //////////////////////////////////////////////////
                return successResponse(trans('cruds.api.success'));

            } else {
                return errorResponse(trans('cruds.api.order_not_found'));
            }
        } elseif ($request->offer_id) {
            $offer = AllAd::find($request->offer_id);
            if ($offer) {
                // send notification //////////////////////////
                $receiver = User::find($user_id);
                $notification = new SendMessageNotification(trans('cruds.api.share_offer_title'), trans('cruds.api.share_offer_message'), null, $request->offer_id);
                send_notification_fcm($receiver->fcm_token, $notification->toFCM());
                Notification::send($receiver, $notification);
                //////////////////////////////////////////////////
                return successResponse(trans('cruds.api.success'));
            } else {
                return errorResponse(trans('cruds.api.ads_not_found'));
            }
        }


    }

    public function skip(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $order = Order::find($id);
        if ($order) {

            return successResponse(trans('cruds.api.success'));

        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }

    }

    private function rate_validator(Request $request)
    {
        return Validator::make($request->all(), [
            'rating' => 'required',
            'comment' => 'required',
        ]);
    }

    public function last_order(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
//        $order = Order::where('user_id', Auth::id())->whereIn('status_id', [5])->orderBy('id' , 'desc')->first();
        $order = Order::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        if (!$order) {
            $order = Order::whereHas('share', function ($query) {
                $query->where('user_id', Auth::id());
            })->whereIn('status_id', [5])->first();
            if ($order) {

                $data = ['type' => 'share', 'data' => new OrderResource($order)];

            } else {
                $data = null;
            }

        } else {
            $data = ['type' => 'order', 'data' => new OrderResource($order)];

        }
        return successResponse(trans('cruds.api.success'), $data);
    }

    public function show_Restaurants_app(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $ordr = Order::find($id);
        if ($ordr) {
            $data = new OrderRestaurantDetailsResource($ordr);
            return successResponse(trans('cruds.api.success'), $data);
        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }

    }

    public function accept(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $order = Order::find($id);
        if ($order) {

//            $validator = $this->accept_validator($request);
//
//            if ($validator->fails()) {
//                return errorResponse($validator->errors()->first());
//            }

            $order = Order::find($id);
            if ($order) {
                if ($request->table_id) {
                    $order->table_id = $request->table_id;
                    $table = Table::find($request->table_id);
                    $table->status_id = 2;
                    $table->save();
                }
                $order->status_id = 5;
                $order->save();
                optional(Queue::where('order_id', $id)->first())->delete();
                $queues = Queue::where('restaurant_id', $order->restaurants_id)->get();
                foreach ($queues as $key => $queue) {
                    $token = optional($queue->user)->fcm_token;
                    // send notification //////////////////////////
                    $notification = new SendMessageNotification(trans('cruds.api.role_title' , ['name' => optional($queue->user)->name ]), trans('cruds.api.role_message' , ['name' => optional($order->restaurants)->name , 'number' => $key + 1 ]), $order->id, null, 'role');
                    send_notification_fcm($token, $notification->toFCM());
                    Notification::send($queue->user, $notification);
                    //////////////////////////////////////////////////
                }

                return successResponse(trans('cruds.api.success'));

            } else {
                return errorResponse(trans('cruds.api.order_not_found'));
            }


        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }

    }

    public function order_restaurant(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $user_restaurant = User::find(Auth::id())->restaurant_id;
        $search = $request->search ? $request->search : "";

        if (isset($request->date)) {
            $order = Order::where('restaurants_id', $user_restaurant)->where('status_id', 5)->whereRaw('date(created_at) = ?', [$request->date]);
        } else {
            $order = Order::where('restaurants_id', $user_restaurant)->where('status_id', 5)->whereRaw('date(created_at) = ?', [Carbon::today()]);
        }

        if ($search) {
            $order = Order::Search($search);
        }
        $data = [
            'order_count' => $order->count(),
            'order' => OrderRestaurantResource::collection($order->get())
        ];

        return successResponse(trans('cruds.api.success'), $data);
    }

    public function confirm_restaurant(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $order = Order::find($id);
        if ($order) {
            $order->status_id = 2;
            $order->save();
            if ($order->table_id) {
                $table = Table::find($order->table_id);
                if ($table) {
                    $table->status_id = 1;
                    $table->save();
                } else {
                    return errorResponse('table not found in this order');
                }
            }

            return successResponse(trans('cruds.api.success'));

        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }

    }

    public function cancel_restaurant(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validator = $this->cancel_validator($request);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first());
        }

        $order = Order::find($id);
        if ($order) {
            $order->status_id = 4;
            $order->cancel_reason_message = $request->cancel_reason_message;
            $order->cancel_reason_name = Auth::id();
            $order->save();
            return successResponse(trans('cruds.api.success'));

        } else {
            return errorResponse(trans('cruds.api.order_not_found'));
        }

    }

    private function cancel_validator(Request $request)
    {
        return Validator::make($request->all(), [
            'cancel_reason_message' => 'required',
//            'cancel_reason_name' => 'required',
        ]);
    }


    public function payment(Request $request , $price)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $user = $this->auth();

        if (!$user)
            return errorResponse('ليس لديك صلاحيات');

        $userId = $user->id;
        Session::put('user', $user->id);

        return view('payment_api', compact('price', 'userId' , 'user'));

    }


    protected function auth()
    {
        if (Auth::guard('api')->check()) {
            Auth::shouldUse('api');
            return user();
        }

        if (Auth::guard('web')->check())
            return user('web');

        return false;
    }

}
