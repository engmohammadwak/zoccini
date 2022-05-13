<?php

use App\Models\OfferUser;
use App\Models\UserAlert;
use App\Notifications\SendMessageNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;
//use SendsPasswordResetEmails;

const EN = 'en';
const AR = 'ar';

define('DIR_UPLOAD', 'img');

function assetUpload($dir)
{
    return asset(DIR_UPLOAD . '/' . $dir);
}

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
    $filename_img = $request->getClientOriginalName();
    $mime = explode('.', $filename_img)[1];
    $filename = rand(100, 9999999) . '.' . $mime;
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

function saveOriginalImage($image, $direction)
{
    $dir = DIR_UPLOAD . '/' . $direction;
    \File::exists(myPublic() . $dir) or \File::makeDirectory(myPublic() . $dir, 755, true);
    $img = \Image::make($image);
    $mime = explode('/', $img->mime)[1];
    $file_name = rand(100, 9999999) . '.' . $mime;
    $img->save(myPublic() . $dir . '/' . $file_name);
    return $file_name;
}

function myPublic()
{
    return base_path() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR;
}

function setLang($lang)
{
    if ($lang == AR) {
        App::setLocale(AR);
    } else {
        App::setLocale(EN);
    }
}

function successResponse($message, $data = null, $token = null, $meta = null)
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
    if ($meta != null) {
        $arr['meta'] = $meta;
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

//type = 0 phone  - type= 1 email

function send_pin($code, $phone, $type = 0)
{
    $message = 'رمز التفعيل هو ' . $code;
    $user = \App\Models\User::where('phone', $phone)->orWhere('email', $phone)->first();
    if ($user) {
        if ($user->fcm_token) {
            // send notification //////////////////////////
            $notification = new SendMessageNotification('Zoccini', $message, null, null, 'activation');
            send_notification_fcm($user->fcm_token, $notification->toFCM());
            Notification::send($user, $notification);
            //////////////////////////////////////////////////
        }
    }
//    if ($type == 0) {
//        $curl = curl_init();
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'https://www.nsms.ps/api.php?comm=sendsms&user=zoccini&pass=zoccini2021&to=' . $phone . '&message=' . urlencode($message) . '&sender=Zoccini',
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'GET',
//            CURLOPT_HTTPHEADER => array(
//                'Cookie: ci_session=a%3A5%3A%7Bs%3A10%3A%22session_id%22%3Bs%3A32%3A%2255d914e3d2b764328350fbafcfbab423%22%3Bs%3A10%3A%22ip_address%22%3Bs%3A13%3A%2294.26.119.165%22%3Bs%3A10%3A%22user_agent%22%3Bs%3A21%3A%22PostmanRuntime%2F7.28.0%22%3Bs%3A13%3A%22last_activity%22%3Bi%3A1622242590%3Bs%3A9%3A%22user_data%22%3Bs%3A0%3A%22%22%3B%7D58ff8290c666462587fbbe1ab08477b5'
//            ),
//        ));
//
//        $response = curl_exec($curl);
//
//        curl_close($curl);
////        return $response;
//
//
//        $sms = new \App\Models\SmsHistory();
//        $sms->phone = $phone;
//        $sms->code = $message;
//        $sms->status = $response;
//        $sms->balance = chk_balance();
//        $sms->save();
//    }
//    else{
//        $email_data = array(
//            'from' => env('MAIL_USERNAME'),
//            'to' => [$phone]);
//
//        $blade_data = array(
//
//            'email' => $phone,
//            'code' => $code,
//
//        );
//        \Illuminate\Support\Facades\Mail::send('emails.reset_password', $blade_data, function ($message) use ($phone) {
//            $message->to($phone)
//                ->subject(web('resset password'))
//                ->from('info@zoccini.com', 'zoccini');
//
//        });
//
//    }

    return true;
}


function chk_balance()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.nsms.ps/api.php?comm=chk_balance&user=zoccini&pass=zoccini2021',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: ci_session=a%3A5%3A%7Bs%3A10%3A%22session_id%22%3Bs%3A32%3A%22b3bad6becf56bd4e75fef5c49fc5787f%22%3Bs%3A10%3A%22ip_address%22%3Bs%3A13%3A%2294.26.119.165%22%3Bs%3A10%3A%22user_agent%22%3Bs%3A21%3A%22PostmanRuntime%2F7.28.0%22%3Bs%3A13%3A%22last_activity%22%3Bi%3A1622266970%3Bs%3A9%3A%22user_data%22%3Bs%3A0%3A%22%22%3B%7Df7c6a6a4dc779480d199e17841cdcf37'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}

function get_nearest_sql($table = "restaurants", $lat="", $lng="")
{
    $sql = DB::raw("1.609344 * 3956 * acos( cos( radians('$lat') ) * cos( radians($table.lat) ) * cos( radians($table.lang) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians($table.lat) ) ) as distance");
    return $sql;
}

function get_nearest_sql_n($table = "restaurants", $lat="=", $lng="")
{
    $sql = DB::raw("1.609344 * 3956 * acos( cos( radians('$lat') ) * cos( radians($table.lat) ) * cos( radians($table.lang) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians($table.lat) ) )");
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
    $user = auth('api')->user();
    if ($user) {
        if ($type == 1) {
            $check = \App\Models\Favorite::where('user_id', $user->id)->where('type', '1')->where('object_favority', $id)->count();
        } else {
            $check = \App\Models\Favorite::where('user_id', $user->id)->where('type', '2')->where('object_favority', $id)->count();
        }
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function number_reservation($id)
{
    $number = \App\Models\Order::where('restaurants_id', $id)->where('status_id', 3)->count();
    return $number;
}

function number_offer_join($id)
{
    $number = \App\Models\OfferUser::where('offer_id', $id)->count();
    return $number;
}

function number_join_offer($id)
{
    $check = OfferUser::with('offer')->where('offer_id', $id)->where('status', 1)->count();
    return $check;
}


if (!function_exists('send_notification_fcm')) {
    function send_notification_fcm($token, $notification)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $extranotification = [
            'message' => $notification,
            'moredata' => 'dd'
        ];

        /**
         *
         * {
         * "notification": {
         * "title": "Portugal vs. Denmark",
         * "body": "5 to 1",
         * "icon": "firebase-logo.png",
         * "click_action": "http://localhost:8081"
         * },
         * "to": "YOUR-IID-TOKEN"
         * }
         **/
        if (!is_array($token)) {
            $token = [$token];
        }

        $fcmNotification = [
            'registration_ids' => $token, //multple token array
            //'to' => $token, //single token
            'notification' => $notification,
            'data' => $notification
        ];
        $headers = [
            'Authorization: key=' . config('fcm')['fcm_key'],
            'Content-Type: application/json'
        ];
        return curl($fcmUrl, $headers, $fcmNotification);
    }
}

if (!function_exists('curl')) {
    function curl($url, $headers, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

function alert_user($text, $link)
{
    $alert = new UserAlert();
    $alert->alert_text = $text;
    $alert->alert_link = $link;
    $alert->save();
    $alert->users()->sync(1);
    return true;
}


function isRate($id)
{
    $user = auth('api')->user();
    if ($user) {
        $rate = \App\Models\Rate::where('order_id', $id)->where('user_id', $user->id)->count();
        if ($rate > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }

    function number_reservation($id)
    {
        $number = \App\Models\Order::where('restaurants_id', $id)->where('status_id', 3)->count();
        return $number;
    }

    function number_offer_join($id)
    {
        $number = \App\Models\OfferUser::where('offer_id', $id)->count();
        return $number;
    }

}


function web($key, $placeholder = [], $locale = null)
{

    $group = 'panel';
    if (is_null($locale))
        $locale = config('app.locale');
    $key = trim($key);
    $word = $group . '.' . $key;
    if (\Illuminate\Support\Facades\Lang::has($word))
        return trans($word, $placeholder, $locale);

    $messages = [
        $word => $key,
    ];

    app('translator')->addLines($messages, $locale);
    $langs = ['ar', 'en'];
    foreach ($langs as $lang) {
        $translation_file = base_path() . '/resources/lang/' . $lang . '/' . $group . '.php';
        $fh = fopen($translation_file, 'r+');
        $new_key = "  \n  '$key' => '$key',\n];\n";
        fseek($fh, -4, SEEK_END);
        fwrite($fh, $new_key);
        fclose($fh);
    }
    return trans($word, $placeholder, $locale);
//    return $key;

}

if (!function_exists('user')) {
    function user($guard = 'api')
    {
        return auth()->guard($guard)->user();
    }
}

