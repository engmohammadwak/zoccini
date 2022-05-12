<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SystemCalendarController extends Controller
{
    public $sources = [
        [
            'model'      => '\App\Models\Order',
            'date_field' => 'schedule_date',
            'field'      => 'id',
            'prefix'     => '',
            'suffix'     => '',
            'route'      => 'admin.orders.edit',
        ],
    ];

    public function index()
    {
        $events = [];
        $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();

        foreach ($this->sources as $source) {
            foreach ($source['model']::where('restaurants_id' , $restaurant->id)->get() as $model) {
                $crudFieldValue = $model->getAttributes()[$source['date_field']];

                if (!$crudFieldValue) {
                    continue;
                }

                $events[] = [
                    'title' => trim($source['prefix'] . " " . $model->{$source['field']}
                        . " " . $source['suffix']),
                    'start' => $crudFieldValue,
                    'url'   => route($source['route'], $model->id),
                ];
            }
        }

        return view('admin.calendar.calendar', compact('events'));
    }
}
