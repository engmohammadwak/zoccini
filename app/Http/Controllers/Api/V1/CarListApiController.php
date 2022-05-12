<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarListRequest;
use App\Http\Requests\UpdateCarListRequest;
use App\Http\Resources\CarListResource;
use App\Models\CarList;
use App\Models\Cart;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CarListApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = CarListResource::collection(CarList::with(['car_brand', 'car_type', 'car_color'])->where('user_id' , Auth::id())->get());
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
        $data = new CarListResource(CarList::create($request->all()));
        return successResponse(trans('cruds.api.success') , $data);
    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'car_brand_id' => 'required|exists:carbrands,id',
            'car_type_id' => 'required|exists:type_of_cars,id' ,
            'car_color_id' => 'required|exists:car_colors,id' ,
        ]);
    }

    public function destroy(Request $request ,  CarList $carList)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $carList->delete();

        return successResponse(trans('cruds.api.success'));
    }
}
