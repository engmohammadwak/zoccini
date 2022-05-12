<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Point;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $purchase_get = Point::where('user_id', Auth::id())->where('type_id' , 5)->sum('value');
        $inviting_get = Point::where('user_id', Auth::id())->where('type_id' , 2)->sum('value') ;
        $competitions_get  = Point::where('user_id', Auth::id())->where('type_id' , 3)->sum('value') ;
        $coupon_get = Point::where('user_id', Auth::id())->where('type_id' , 1)->sum('value');
        $total = Point::where('user_id', Auth::id())->where('type_id' ,'!=' ,  4)->sum('value');
        $spent = Point::where('user_id', Auth::id())->where('type_id' ,  4)->sum('value');
        $data = [
            'purchase_get' => $purchase_get,
            'inviting_get' => $inviting_get,
            'competitions_get' => $competitions_get,
            'coupon_get' => $coupon_get,
            'total_earned' => $total,
            'total_spent' => $spent,
            'available_balance' => $total - $spent,
            'coin' => ($total - $spent) / getSetting('point_price'),
        ];
        return successResponse(trans('cruds.api.success') , $data);
    }
}
