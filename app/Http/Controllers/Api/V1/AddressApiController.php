<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = AddressResource::collection(Address::where('user_id', Auth::id())->get());
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
        $data = new AddressResource(Address::create($request->all()));
        return successResponse(trans('cruds.api.success') , $data);
    }


    public function update(Request $request , $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $address = Address::find($id);
        if ($address){
            $validator = $this->validator($request);
            if ($validator->fails()) {
                return errorResponse($validator->errors()->first());
            }
            $address->update($request->all());
            $data = new AddressResource($address);
            return successResponse(trans('cruds.api.success') , $data);
        }else{
            return errorResponse(trans('cruds.api.address_not_found'));
        }

    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'area' => 'required',
            'street' => 'required',
            'floor' => 'required',
            'building' => 'required',
            'apartment_no' => 'required',
            'phone' => 'required',
            'lat' => 'required',
            'lang' => 'required',
        ]);
    }


    public function destroy(Request $request , Address $address)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $address->delete();

        return successResponse(trans('cruds.api.success'));
    }
}
