<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotificationApiController extends Controller
{
    public function index()
    {
        foreach (Notification::where('notifiable_id' , Auth::id())->where('read_at' , null)->get() as $value)
        {
            $value->read_at = Carbon::now();
            $value->save();
        }
        $query = Notification::where('notifiable_id',Auth::id())->orderByDesc('created_at')->paginate(10);
        $data = NotificationResource::collection($query);
        return successResponse(trans('cruds.api.success'),[
            'data' => $data,
            'data_not_read' => Notification::where('notifiable_id',Auth::id())->where('read_at'  , null)->count(),
            'meta' => collect($query)->except('data'),
        ]);

    }
}
