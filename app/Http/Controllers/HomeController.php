<?php

namespace App\Http\Controllers;

use App\Models\BecomePartner;
use App\Models\CategoryTopRestaurant;
use App\Models\City;
use App\Models\Expense;
use App\Models\Image;
use App\Models\Income;
use App\Models\LoopBank;
use App\Models\Loopuser;
use App\Models\ReferralSubscription;
use App\Models\Restaurant;
use App\Models\Slider;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionUser;
use App\Models\TopRestaurant;
use App\Models\User;
use App\Models\VentureCompany;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $top_restaurant = TopRestaurant::all();
        $slider = Slider::all();
        $slider_count = Slider::count();
        $categories = CategoryTopRestaurant::all();
        $venture_company = VentureCompany::all();

        return view('welcome', compact('top_restaurant', 'slider', 'slider_count', 'categories', 'venture_company'));

    }

    public function map(Request $request)
    {
        $collection = collect([]);
        $tag = Restaurant::all()->pluck('tag');
        foreach ($tag as $value)
        {
            $text = explode("#",$value);
            foreach ($text as $value)
            {
                $collection->push($value);
            }
        }

        $tag_all = $collection->unique()->all();

        $restaurant = Restaurant::where('lat', '!=', null)->where('lang', '!=', null);
        if ($request->key) {
            $restaurant = $restaurant->where('name_ar', 'like', '%' . $request->key . '%')->orWhere('name_en', 'like', '%' . $request->key . '%');
        }

        if ($request->city_id) {
            $restaurant = $restaurant->where('city_id', $request->city_id);
        }

        if ($request->tag) {
            $restaurant = $restaurant->where('tag',  'LIKE', "%{$request->tag}%");
        }

        $restaurant = $restaurant->get();
        $city = City::where('status', 1)->get();
        return view('map', compact('restaurant', 'city' , 'tag_all'));

    }

    public function become_partner()
    {
        $become_partner = BecomePartner::all();

        return view('become_partner', compact('become_partner'));

    }

    public function become_partner_store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'name_ar' => 'required|min:3',
            'email' => 'required|email:rfc,dns|unique:users',
            'phone' => 'required',
            'address' => 'required|min:3',
            'company_email' => 'required|email:rfc,dns',
            'phone_company' => 'required',
            'logo' => 'mimes:jpeg,jpg,png,gif,pdf|required|max:10000',
            'restaurant_licence' => 'mimes:jpeg,jpg,png,gif,pdf|required|max:10000',
            'have_tablet' => 'required',
            'agree' => 'required',
        ], [
                'first_name.required' => web('first name is required'),
                'have_tablet.required' => web('have tablet is required'),
                'agree.required' => web('agree is required'),
                'first_name.min' => web('first name min 3'),
                'address.required' => web('address is required'),
                'address.min' => web('address min 3'),
                'last_name.required' => web('last name is required'),
                'last_name.min' => web('last name min 3'),
                'name_ar.required' => web('restaurant name is required'),
                'name_ar.min' => web('restaurant name min 3'),
                'email.required' => web('Email is required'),
                'email.email' => web('Email is not email'),
                'email.unique' => web('Email is not unique'),
                'phone.required' => web('mobile is required'),
                'phone.regex' => web('mobile is not valid format'),
                'company_email.required' => web('company Email is required'),
                'company_email.email' => web('company Email is not email'),
                'phone_company.required' => web('company phone is required'),
                'phone_company.regex' => web('company phone is not valid format'),
                'logo.required' => web('logo is required'),
                'restaurant_licence.required' => web('restaurant licence is required'),
                'password.min' => web('password min 6'),
                'password.required' => web('password is required'),
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();

        } else {
            $user = new User();
            $user->name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->country_code . $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = 3;
            $user->status_id = 4;
            $user->save();
            $user->roles()->sync(3);
            if ($request->file('logo')) {
                $image = uploadImage($request->file('logo'), '/public/img/user', $user->image);
                $user->fill(['image' => $image])->save();
            }

            if ($request->file('commercial_registration_image')) {
                $image = uploadImage($request->file('commercial_registration_image'), '/public/img/user', $user->image);
                $user->fill(['commercial_registration_image' => $image])->save();
            }

            $request->request->add(['restaurant_id' => $user->id]);
            $request->request->add(['name_en' => $request->name_ar, 'plan_id' => $request->id]);
            if (Auth::check()) {
                $request->request->add(['referral_id' => Auth::id()]);
            }
            $request->request->add(['name_en' => $request->name_ar, 'plan_id' => $request->id]);

            $restaurant = Restaurant::create($request->all());
            $restaurant->payment_methods()->sync($request->input('payment_methods', []));
            $restaurant->sitting_areas()->sync($request->input('sitting_areas', []));

            if ($request->file('image')) {
                $image = uploadImage($request->file('image'), '/public/img/' . Restaurant::DIR_UPLOAD, $restaurant->image);
                $restaurant->fill(['image' => $image])->save();
            }
            if ($request->file('photo')) {
                foreach ($request->file('photo') as $file) {
                    $photo_name = uploadImage($file, '/public/img/' . Image::DIR_UPLOAD);

                    Image::create([
                        'name' => $photo_name,
                        'model' => Image::COMPANY_MODEL,
                        'item' => $restaurant->id,
                    ]);
                }
            }
            $referral_price = 0;
            if (Auth::check()) {
                $request->request->add(['referral_id' => Auth::id()]);

                $plan = SubscriptionPackage::find($request->id);
                if ($plan) {
                    $referral_price = $plan->referral_price;
                } else {
                    $referral_price = 0;
                }
                ReferralSubscription::create([
                    'user_id' => $restaurant->id,
                    'user_loop_id' => Auth::id(),
                    'plan_id' => $request->id,
                    'price' => $referral_price,
                ]);

            }
            $plan = SubscriptionPackage::find($request->id);
            $price = $plan->price;
            $offer = $plan->offer;
            if ($offer &&$offer > 0)
            {
                $offer_price = $price * ($offer / 100);
                $price = $price - $offer_price;
            }
            $subscription = SubscriptionUser::create([
                'user_id' => $restaurant->id,
                'package_id' => $request->id,
                'start_date' => Carbon::now()->format('Y-m-d'),
                'end_day' => Carbon::now()->addMonth($plan->duration)->format('Y-m-d'),
                'price' => $price,
                'status' => 1,
            ]);

            Income::create([
                'income_category_id' => 2,
                'entry_date' => Carbon::now()->format('Y-m-d'),
                'amount' => $price,
                'description' => 'اشتراك رقم  ' . $subscription->id,
            ]);

            if ($referral_price > 0)
            {
                Expense::create([
                    'expense_category_id' => 1,
                    'entry_date' => Carbon::now()->format('Y-m-d'),
                    'amount' => $referral_price,
                    'description' => 'اشتراك رقم  ' . $subscription->id,
                ]);
            }

        }

        return view('payment', compact('price', 'user', 'restaurant' , 'subscription'));
    }

    public function join_loop_post(Request $request)
    {


        $validation = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email:rfc,dns|unique:users',
            'phone' => 'required|regex:/[0-9]{9}/',
            'country_id' => 'required',
            'city_id' => 'required',
            'date_of_birth' => 'required',
            'password' => 'required|min:6',
            'payment_type' => 'required',
            'bank_name' => 'required_if:payment_type,==,bank:',
            'swift_code' => 'required_if:payment_type,==,bank:',
            'iban' => 'required_if:payment_type,==,bank:',
            'branch_no' => 'required_if:payment_type,==,bank:',
            'national' => 'required|min:3',
            'expire_date' => 'required',
            'attach_national' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'invoice_image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',

        ], [
                'name.required' => web('first name is required'),
                'name.min' => web('first name min 2'),
                'last_name.required' => web('last name is required'),
                'last_name.min' => web('last name min 2'),
                'email.required' => web('Email is required'),
                'email.email' => web('Email is not email'),
                'email.unique' => web('Email is not unique'),
                'phone.required' => web('mobile is required'),
                'phone.regex' => web('mobile is not valid format'),
                'country_id.required' => web('country id is required'),
                'city_id.required' => web('city id is required'),
                'payment_type.required' => web('payment type is required'),
                'iban.required' => web('iban is required'),
                'expire_date.required' => web('expire date is required'),
                'national.required' => web('national is required'),
                'branch_no.required' => web('branch no is required'),
                'swift_code.required' => web('swift code is required'),
                'bank_name.required' => web('bank name is required'),
                'date_of_birth.required' => web('date of birth is required'),
                'password.required' => web('password is required'),
                'attach_national.required' => web('attach national is required'),
                'invoice_image.required' => web('invoice image is required'),
                'password.min' => web('password min 6'),
            ]

        );

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();

        } else {
            $user = new User();
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->phone = $request->country_code . $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = 12;
            $user->status_id = 2;
            $user->save();
            $user->roles()->sync([12]);

            $request->request->add(['user_id' => $user->id]);

            $loop = Loopuser::create($request->all());

            if ($request->file('attach_national')) {
                $image = uploadImage($request->file('attach_national'), '/public/img/user');
                $loop->fill(['attach_national' => $image])->save();
            }

            if ($request->file('invoice_image')) {
                $image = uploadImage($request->file('invoice_image'), '/public/img/user');
                $loop->fill(['invoice_image' => $image])->save();
            }

            if ($request->bank_name) {
                LoopBank::create([
                    'bank_name' => $request->bank_name,
                    'swift_code' => $request->swift_code,
                    'iban' => $request->iban,
                    'branch_no' => $request->branch_no,
                    'user_id' => $loop->id,
                ]);
            }

            return view('success');
        }


    }

    public function update_profile(Request $request)
    {
        $user = User::find(Auth::id());
        $user->update($request->all());

        $loop = Loopuser::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
        $loop->update($request->all());

        if ($request->file('attach_national')) {
            $image = uploadImage($request->file('attach_national'), '/public/img/user');
            $loop->fill(['attach_national' => $image])->save();
        }

        if ($request->radio_1) {

            if ($loop->bank) {
                $loop->bank->update($request->all());
            } else {
                LoopBank::create([
                    'bank_name' => $request->bank_name,
                    'swift_code' => $request->swift_code,
                    'iban' => $request->iban,
                    'branch_no' => $request->branch_no,
                    'user_id' => $loop->id,
                ]);
            }
        }

        return view('success');
    }

    public function update_profile_payment(Request $request)
    {
        $loop = Loopuser::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
        if ($loop->bank) {
            $loop->bank->delete();
        }
        return view('success');
    }
}
