<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryFullResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
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

    public function index_all_food($id , Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $data = CategoryFullResource::collection(Category::with(['restaurant'])->where('restaurant_id' , $id)->where('status' , 1)->get());
        return successResponse(trans('cruds.api.success') , $data);
    }

    public function show($id,  Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $search = $request->search ? $request->search : "";

        if ($id != 0){
            $category = Category::find($id);
            if ($category){
                $data = ItemResource::collection(Item::where('category_id' , $id)->Search($search)->where('status' , 1)->paginate(10));
            }else{
                return errorResponse(trans('cruds.api.category_not_found'));
            }
        }else{
            $restaurant_id = Restaurant::find($request->restaurant_id);
            if ($restaurant_id)
            {
                $data = ItemResource::collection(Item::where('restaurant_id' , $request->restaurant_id)->Search($search)->where('status' , 1)->paginate(10));
            }else{
                return errorResponse(trans('cruds.api.restaurant_not_found'));

            }

        }

        return successResponse(trans('cruds.api.success') , $data);

    }
}
