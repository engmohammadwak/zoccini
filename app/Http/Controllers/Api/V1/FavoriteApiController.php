<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FavoriteApiController extends Controller
{
    public function index(Request $request , $type)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = FavoriteResource::collection(Favorite::with('item' , 'restaurant')->where('user_id', Auth::id())->where('type',$type)->get());
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
        $favority = new Favorite();
        $favority->type = $request->type;
        $favority->user_id = Auth::id();
        $favority->object_favority = $request->object_favority;
        $favority->save();
        $data = new FavoriteResource($favority);
        return successResponse(trans('cruds.api.success') , $data);
    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'type' => 'required',
            'object_favority' => 'required',
        ]);
    }


    public function destroy(Request $request , Favorite $favorite)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $favorite->delete();

        return successResponse(trans('cruds.api.success'));
    }
}
