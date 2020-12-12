<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = OrderResource::collection(Order::where('user_id' , Auth::id())->get());
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
        $request->request->add(['status_id' => '3' , 'user_id' => Auth::id()]);
        $data = new OrderResource(Order::create($request->all()));
        return successResponse(trans('cruds.api.success') , $data);

    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'restaurants_id' => 'required|exists:restaurants,id',
            'type_id' => 'required|exists:order_types,id' ,
        ]);
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OrderResource($order->load(['restaurants', 'user', 'type', 'sitting_area', 'delivery_company', 'status', 'items', 'cansel_reason', 'winner', 'car_number']));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->all());
        $order->items()->sync($request->input('items', []));

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function cancel(Request $request , $id)
    {
        $order = Order::find($id);
        if ($order)
        {
            $order->status_id = 4;
            $order->cancel_reason_id = $request->cancel_reason_id;
            $order->cancel_reason_message = $request->cancel_reason_message;
            $order->save();
            $data = new OrderResource($order);
            return successResponse(trans('cruds.api.success') , $data);

        }else{
            return errorResponse(trans('cruds.api.order_not_found'));
        }

    }
}
