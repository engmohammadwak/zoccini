<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $settings = Setting::all();

        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request  $request ,Setting  $sitesetting)
    {
        foreach (array_except($request->toArray(), ['_token','submit']) as $key=>$req) {
            $sitesettingupdate = $sitesetting->where('namesetting',$key)->get()[0];
            if ($sitesettingupdate ->type !=3) {
                $sitesettingupdate->fill(['value' => $req])->save();
            }else{
                $fileName = uploadImage($req ,'/public/img/setting' , $sitesettingupdate->value);
                if ($fileName) {
                    $sitesettingupdate->fill(['value' => $fileName])->save();
                }
            }
        }
        return redirect('/admin/settings');
    }
}

