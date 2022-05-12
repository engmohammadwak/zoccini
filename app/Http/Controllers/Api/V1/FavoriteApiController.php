<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\Point;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FavoriteApiController extends Controller
{
    public function index(Request $request, $type)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = FavoriteResource::collection(Favorite::with('item', 'restaurant')->where('user_id', Auth::id())->where('type', $type)->get());
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
        $favority = new Favorite();
        $favority->type = $request->type;
        $favority->user_id = Auth::id();
        $favority->object_favority = $request->object_favority;
        $favority->save();
        $data = new FavoriteResource($favority);
        return successResponse(trans('cruds.api.success'), $data);
    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'type' => 'required',
            'object_favority' => 'required',
        ]);
    }


    public function destroy(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        if (isset($request->type) && $request->type != 0)
        {
            if ($request->type == 1)
            {
                $mail = Item::find($id);
                if ($mail)
                {
                    $favorite =Favorite::where('object_favority' , $id)->where('type' , $request->type)->where('user_id' , Auth::id())->first();
                    if ($favorite)
                    {
                        $favorite->delete();
                    }else{
                        return errorResponse('favorite not fount');
                    }


                }else{
                    return errorResponse('id mail not fount');
                }
            }elseif ($request->type == 2){
                $restaurant = Restaurant::find($id);
                if ($restaurant)
                {
                    $favorite =Favorite::where('object_favority' , $id)->where('type' , $request->type)->where('user_id' , Auth::id())->first();
                    if ($favorite)
                    {
                        $favorite->delete();
                    }else{
                        return errorResponse('favorite not fount');
                    }

                }else{
                    return errorResponse('id restaurant not fount');
                }
            }


        }else{
            $favorite = Favorite::find($id);
            if ($favorite) {
                $favorite->delete();
            } else {
                return errorResponse('id favority not fount');
            }
        }

        return successResponse(trans('cruds.api.success'));
    }
}
