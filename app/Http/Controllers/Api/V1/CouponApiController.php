<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Point;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CouponApiController extends Controller
{
    public function check_coupon(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validator = $this->coupon_validator($request);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first());
        }

        $coupon = Coupon::where('code' , $request->coupon)->where('status' , 1)->first();
        if ($coupon) {
            if ($coupon->number_used >= $coupon->maximum_usage) {
                $coupon->status = 0;
                $coupon->save();
                return errorResponse(trans('cruds.api.Uses_exceeded'));
            } elseif (Carbon::now() > $coupon->end_day) {
                $coupon->status = 0;
                $coupon->save();
                return errorResponse(trans('cruds.api.coupon_expired'));
            } else {
                $data = [
                    'value' => $coupon->value,
//                   'type' => $coupon->type == 1 ? 'fixed' : 'percent',
                ];
                $point  = new Point();
                $point->user_id = Auth::id();
                $point->type_id = 1;
                $point->value = $coupon->value;
                $point->save() ;

                $coupon->number_used = $coupon->number_used + 1;
                $coupon->save();


                return successResponse(trans('cruds.api.success'), $data);

            }
        }else{
            return errorResponse(trans('cruds.api.coupon_expired'));
        }

    }

    private function coupon_validator(Request $request)
    {
        return Validator::make($request->all(), [
            'coupon' => 'required|exists:coupons,code',
        ]);
    }
}
