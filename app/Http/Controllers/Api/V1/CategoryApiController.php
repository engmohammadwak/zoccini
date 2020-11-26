<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function index($id , Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $data = CategoryResource::collection(Category::with(['restaurant'])->where('restaurant_id' , $id)->where('status' , 1)->get());
        return successResponse(trans('cruds.api.success') , $data);
    }


    public function show($id,  Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        if ($id != 0){
            $category = Category::find($id);
            if ($category){
                $data = ItemResource::collection(Item::where('category_id' , $id)->paginate(10));
            }else{
                return errorResponse(trans('cruds.api.category_not_found'));
            }
        }else{
            $data = "test";
        }

        return successResponse(trans('cruds.api.success') , $data);

    }
}
