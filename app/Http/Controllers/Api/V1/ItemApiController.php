<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExtraResource;
use App\Http\Resources\ItemResource;
use App\Models\Extra;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemApiController extends Controller
{
public function food_extra($id , Request $request)
{
    $lang = $request->header('lang');
    setLang($lang);
    $data = ExtraResource::collection(Extra::where('item_id' , $id)->whereStatus('1')->get());
    return successResponse(trans('cruds.api.success') , $data);
}

public function show($id , Request $request)
{
    $lang = $request->header('lang');
    setLang($lang);

    $food = Item::find($id);
    if ($food)
    {
        $data = new ItemResource($food);
        return successResponse(trans('cruds.api.success') , $data);
    }else{
        return errorResponse(trans('cruds.api.food_not_found'));

    }

}

}
