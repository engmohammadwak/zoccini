<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\CarListResource;
use App\Http\Resources\CartResource;
use App\Models\CarList;
use App\Models\Cart;
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
        $data = CartResource::collection(Cart::with(['restaurant', 'user'])->where('user_id' , Auth::id())->get());
        return successResponse(trans('cruds.api.success') , $data);
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
        return successResponse(trans('cruds.api.success') , $data);

    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'item_json' => 'required' ,
        ]);
    }



    public function update(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $cart = Cart::find($id);
        if ($cart){
            $validator = $this->validator($request);
            if ($validator->fails()) {
                return errorResponse($validator->errors()->first());
            }
            $cart->update($request->all());
            $data = new CartResource($cart);
            return successResponse(trans('cruds.api.success') , $data);
        }else{
            return errorResponse(trans('cruds.api.cart_not_found'));
        }
    }

    public function destroy(Request $request ,  Cart $cart)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $cart->delete();

        return successResponse(trans('cruds.api.success'));
    }
}
