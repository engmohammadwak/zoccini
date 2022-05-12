<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = ContactResource::collection(Contact::where('user_id', Auth::id())->get());
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
        $data = new ContactResource(Contact::create($request->all()));
        return successResponse(trans('cruds.api.success') , $data);
    }



    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
        ]);
    }


    public function destroy(Request $request , Contact $contact)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $contact->delete();

        return successResponse(trans('cruds.api.success'));
    }
}
