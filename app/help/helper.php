<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;

const EN = 'en';
const AR = 'ar';


function getSetting($settingname = 'sitename')
{

    if (\App\Models\Setting::where('namesetting', '=', $settingname)->count() > 0) {

        return \App\Models\Setting::where('namesetting', $settingname)->get()[0]->value;
    }

}

function checkIfImageIsExist($imagename, $pathImage = '/public/admin/img/user', $url = '/admin/img/user')
{
    if ($imagename != '') {
        $path = base_path() . $pathImage . $imagename;
        if (file_exists($path)) {
            return Request::root() . $url . $imagename;
        }
    } else {
        return getSetting('no_image');
    }
}

function uploadImage($request, $path = 'local/public/admin/img/user', $deleteFileWithName = '')
{
    if ($deleteFileWithName != '') {
        deleteImage(base_path() . $path . '/' . $deleteFileWithName);
    }
    $filename = $request->getClientOriginalName();
    $request->move(
        base_path() . $path, $filename
    );

    return $filename;
}

function deleteImage($deleteFileWithName)
{
    if (file_exists($deleteFileWithName)) {
        \Illuminate\Support\Facades\File::delete($deleteFileWithName);
    }
}

function uploadFile($request, $path = '/img/all', $deleteFileWithName = '')
{
    if ($deleteFileWithName != '') {
        deleteImage(env('APP_URL') . $path . '/' . $deleteFileWithName);
    }
    $filename = $request->getClientOriginalName();

    $c = $request->store($path, ['disk' => 'my_files']);

    return '/' . $c;
}

function setLang($lang)
{
    if ($lang == AR) {
        App::setLocale(AR);
    } else {
        App::setLocale(EN);
    }
}

function successResponse($message, $data = null, $token = null)
{
    $arr = [
        'message' => $message,
        'error' => "",
        'status' => true,
        'status_code' => 200,
        'data' => $data,
    ];
    if ($token != null) {
        $arr['token'] = $token;
    }
    return $arr;
}

function errorResponse($message, $status_code = 200)
{
    return [
        'message' => "",
        'error' => $message,
        'status' => false,
        'status_code' => $status_code,
        'data' => null,
    ];
}

function send_pin($code, $phone)
{

    return true;
}

function get_nearest_sql($table = "restaurants", $lat, $lng)
{
    $sql = DB::raw("1.609344 * 3956 * acos( cos( radians('$lat') ) * cos( radians($table.lat) ) * cos( radians($table.lang) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians($table.lat) ) ) as distance");
    return $sql;
}

function min_price($id)
{
    $min = \App\Models\Item::where('restaurant_id', $id)->min('price');

    return $min;
}

function final_price_cart($id)
{
    $cart = \App\Models\Cart::find($id);
    $price = 0;
    if ($cart) {
        foreach (json_decode($cart->item_json) as $item) {
            $price = $price + ($item->count * $item->price);
            foreach ($item->extra as $extra) {
                $price = $price + ($item->count * $item->price);
            }
        }
    }
    return $price;
}

function isFavority($id, $type)
{
    $user = auth('api')->user()['id'];

    if ($type == 1) {
        $check = \App\Models\Favorite::where('user_id' , $user)->where('type', '1')->where('object_favority', $id)->count();
    } else {
        $check = \App\Models\Favorite::where('user_id' , $user)->where('type', '2')->where('object_favority', $id)->count();
    }
    if ($check > 0) {
        return true;
    } else {
        return false;
    }

}