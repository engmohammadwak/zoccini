<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\CarListResource;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Models\CarList;
use App\Models\Cart;
use App\Models\Extra;
use App\Models\Item;
use App\Models\OfferUser;
use App\Models\Order;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CartApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = CartResource::collection(Cart::with(['restaurant', 'user'])->where('user_id', Auth::id())->get());
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
        $request->request->add(['user_id' => Auth::id()]);
        $data = new CartResource(Cart::create($request->all()));
        return successResponse(trans('cruds.api.success'), $data);

    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'item_json' => 'required',
        ]);
    }

    public function update(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $cart = Cart::find($id);
        if ($cart) {
            $validator = $this->validator($request);
            if ($validator->fails()) {
                return errorResponse($validator->errors()->first());
            }
            $cart->update($request->all());
            $data = new CartResource($cart);
            return successResponse(trans('cruds.api.success'), $data);
        } else {
            return errorResponse(trans('cruds.api.cart_not_found'));
        }
    }

    public function destroy(Request $request, Cart $cart)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $cart->delete();

        return successResponse(trans('cruds.api.success'));
    }

    public function price(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $cart = Cart::find($id);
        if ($cart) {
            $cart_json = json_decode($cart->item_json);
            $final_price = 0;
            foreach ($cart_json as $key => $product) {
                $item = Item::find($product->item_id);
                $price = $item->price;
                $count = $product->count;
                $final_price = $final_price + ($price * $count);
                foreach ($product->extra as $key => $extra) {
                    $extra_price = Extra::find($extra->extra_id)->price;
                    $extra_count = $extra->count;
                    $final_price = $final_price + ($extra_price * $extra_count);
                }
            }
            $application_services = (float)getSetting('application_services');
            $total  = $final_price + $application_services ;
            $Discount_Application_services_final =  number_format($total * ((int)getSetting('rate_inside') / 100), 2, '.', '') ;  //as default  inside discount
            $final_total = 0;
            $vat_price = 0;
            $vat = (int)getSetting('vat') / 100;
            if ($request->type)
            {
                if ($request->type == 1)
                {
                    $Discount_Application_services_final = number_format($total * ((int)getSetting('rate_inside') / 100), 2, '.', '') ;

                }else{
                    $Discount_Application_services_final =  number_format($total * ((int)getSetting('rate_outside') / 100), 2, '.', '');
                }
            }

            if ($request->is_offer && $request->is_offer == 1)
            {
                $vat_price = $total * $vat;
                $final_total = $total + $vat_price;
            }else{
                $total_after_discount = $total - $Discount_Application_services_final;
                $vat_price = $total_after_discount * $vat;
                $final_total = $total_after_discount + $vat_price ;
            }
            return successResponse(trans('cruds.api.success'), [
                'price' => $final_price,
                'vat' => getSetting('vat'),
                'vat_price' => number_format($vat_price, 2, '.', '') ,
                'application_services' => $application_services,
                'Discount_Application_services' => $Discount_Application_services_final,
                'discount_application_services' => $Discount_Application_services_final,
                'final_price' => number_format($final_total, 2, '.', ''),

                ]);

        } else {
            return errorResponse('cart not found');
        }

    }
}
