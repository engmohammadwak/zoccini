<?php

namespace App\Http\Controllers\Admin;

use App\Models\AllAd;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Slider;
use App\Models\TopRestaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use const http\Client\Curl\AUTH_ANY;

class HomeController
{
    public function index()
    {
        if (Auth::user()['user_type'] == 12)
        {
            return redirect()->to(url('lhome'));
        }


        if (Auth::user()['user_type'] == 3) {
            $restaurant = Restaurant::where('restaurant_id', Auth::id())->first();
            if ($restaurant)
            {
                $auth = $restaurant->id;
            }else{
                $auth = Auth::id();
            }
        } else {
            $auth = Auth::id();
        }
        $settings1 = [
            'chart_title' => web('user'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'email_verified_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings1['total_number'] = 0;

        if (class_exists($settings1['model'])) {
            $settings1['total_number'] = $settings1['model']::where('user_type', 2)->when(isset($settings1['filter_field']), function ($query) use ($settings1) {
                if (isset($settings1['filter_days'])) {
                    return $query->where(
                        $settings1['filter_field'],
                        '>=',
                        now()->subDays($settings1['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings1['filter_period'])) {
                    switch ($settings1['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings1['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings1['aggregate_function'] ?? 'count'}($settings1['aggregate_field'] ?? '*');
        }

        $settings2 = [
            'chart_title' => web('Restaurant'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'email_verified_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings2['total_number'] = 0;

        if (class_exists($settings2['model'])) {
            $settings2['total_number'] = $settings2['model']::where('user_type', 3)->when(isset($settings2['filter_field']), function ($query) use ($settings2) {
                if (isset($settings2['filter_days'])) {
                    return $query->where(
                        $settings2['filter_field'],
                        '>=',
                        now()->subDays($settings2['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings2['filter_period'])) {
                    switch ($settings2['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings2['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings2['aggregate_function'] ?? 'count'}($settings2['aggregate_field'] ?? '*');
        }

        $settings3 = [
            'chart_title' => web('order'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings3['total_number'] = 0;

        if (class_exists($settings3['model'])) {
            $settings3['total_number'] = $settings3['model']::when(isset($settings3['filter_field']), function ($query) use ($settings3, $auth) {
                if (Auth::user()['user_type'] == 3) {
                    return $query->where('restaurants_id', $auth);
                }

                if (isset($settings3['filter_days'])) {
                    return $query->where(
                        $settings3['filter_field'],
                        '>=',
                        now()->subDays($settings3['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings3['filter_period'])) {
                    switch ($settings3['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings3['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings3['aggregate_function'] ?? 'count'}($settings3['aggregate_field'] ?? '*');
        }

        $settings4 = [
            'chart_title' => web('item'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Item',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings4['total_number'] = 0;

        if (class_exists($settings4['model'])) {
            $settings4['total_number'] = $settings4['model']::when(isset($settings4['filter_field']), function ($query) use ($settings4, $auth) {
                if (Auth::user()['user_type'] == 3) {
                    return $query->where('restaurant_id', $auth);
                }
                if (isset($settings4['filter_days'])) {
                    return $query->where(
                        $settings4['filter_field'],
                        '>=',
                        now()->subDays($settings4['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings4['filter_period'])) {
                    switch ($settings4['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings4['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings4['aggregate_function'] ?? 'count'}($settings4['aggregate_field'] ?? '*');
        }

        if (Auth::user()['user_type'] != 3) {
            $settings5 = [
                'chart_title' => web('order by month') ,
                'chart_type' => 'bar',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Order',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'aggregate_function' => 'count',
                'filter_field' => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-12',
                'entries_number' => '5',
            ];
            $settings6 = [
                'chart_title' => web('order by status'),
                'chart_type' => 'pie',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Order',
                'group_by_field' => App::getLocale() == 'ar' ? 'name_ar' : 'name_en',
                'aggregate_function' => 'count',
                'filter_field' => 'created_at',
                'column_class' => 'col-md-6',
                'entries_number' => '5',
                'relationship_name' => 'status',
            ];
            $settings7 = [
                'chart_title' => web('order by restaurants'),
                'chart_type' => 'pie',
                'report_type' => 'group_by_relationship',
                'model' => 'App\Models\Order',
                'group_by_field' => App::getLocale() == 'ar' ? 'name_ar' : 'name_en',
                'aggregate_function' => 'count',
                'filter_field' => 'created_at',
                'column_class' => 'col-md-6',
                'entries_number' => '5',
                'relationship_name' => 'restaurants',
            ];
            $settings21 = [
                'chart_title' => web('order month price'),
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Order',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'aggregate_function' => 'sum',
                'aggregate_field' => 'final_price',
                'filter_field' => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-6',
                'entries_number' => '5',
            ];

            $settings18 = [
                'chart_title' => web('order day price'),
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Order',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'aggregate_function' => 'sum',
                'aggregate_field' => 'final_price',
                'filter_field' => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-6',
                'entries_number' => '5',
            ];


            $settings19 = [
                'chart_title' => web('order month avg'),
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Order',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'aggregate_function' => 'avg',
                'aggregate_field' => 'final_price',
                'filter_field' => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-6',
                'entries_number' => '5',
            ];


            $settings20 = [
                'chart_title' => web('order day avg'),
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Order',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'aggregate_function' => 'avg',
                'aggregate_field' => 'final_price',
                'filter_field' => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-6',
                'entries_number' => '5',
            ];

        } else {
            $settings5 = [
                'chart_title' => web('order by month'),
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Order',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'aggregate_function' => 'count',
                'filter_field' => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-12',
                'entries_number' => '5',
                'conditions' => [
                    ['name' => 'restaurant', 'condition' => 'restaurants_id = ' . $auth, 'color' => 'black'],
                ],
            ];

            $settings21 = [
                'chart_title' => web('order month price'),
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Order',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'aggregate_function' => 'sum',
                'aggregate_field' => 'final_price',
                'filter_field' => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-6',
                'entries_number' => '5',
                'conditions' => [
                    ['name' => web('restaurant'), 'condition' => 'restaurants_id = ' . $auth, 'color' => 'black'],
                ],
            ];

            $settings18 = [
                'chart_title' => web('order day price'),
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Order',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'aggregate_function' => 'sum',
                'aggregate_field' => 'final_price',
                'filter_field' => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-6',
                'entries_number' => '5',
                'conditions' => [
                    ['name' => web('restaurant'), 'condition' => 'restaurants_id = ' . $auth, 'color' => 'black'],
                ],
            ];
            $settings19 = [
                'chart_title' => web('order month avg'),
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Order',
                'group_by_field' => 'created_at',
                'group_by_period' => 'month',
                'aggregate_function' => 'avg',
                'aggregate_field' => 'final_price',
                'filter_field' => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-6',
                'entries_number' => '5',
                'conditions' => [
                    ['name' => web('restaurant'), 'condition' => 'restaurants_id = ' . $auth, 'color' => 'black'],
                ],
            ];

            $settings20 = [
                'chart_title' => web('order day avg'),
                'chart_type' => 'line',
                'report_type' => 'group_by_date',
                'model' => 'App\Models\Order',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'aggregate_function' => 'avg',
                'aggregate_field' => 'final_price',
                'filter_field' => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class' => 'col-md-6',
                'entries_number' => '5',
                'conditions' => [
                    ['name' => web('restaurant'), 'condition' => 'restaurants_id = ' . $auth, 'color' => 'black'],
                ],
            ];
        }

        $chart5 = new LaravelChart($settings5);

        if (Auth::user()['user_type'] != 3) {
            $chart6 = new LaravelChart($settings6);
            $chart7 = new LaravelChart($settings7);
        } else {
            $chart7 = null;
            $chart6 = null;
        }
        $chart18 = new LaravelChart($settings18);
        $chart19 = new LaravelChart($settings19);
        $chart20 = new LaravelChart($settings20);
        $chart17 = new LaravelChart($settings21);
        $settings8 = [
            'chart_title' => web('last user'),
            'chart_type' => 'latest_entries',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'email_verified_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-6',
            'entries_number' => '5',
            'fields' => [
                'id' => '',
                'name' => '',
                'email' => '',
            ],
        ];

        $settings8['data'] = [];

        if (class_exists($settings8['model'])) {
            $settings8['data'] = $settings8['model']::latest()
                ->take($settings8['entries_number'])
                ->get();
        }

        if (!array_key_exists('fields', $settings8)) {
            $settings8['fields'] = [];
        }

        $settings9 = [
            'chart_title' => web('last Restaurant'),
            'chart_type' => 'latest_entries',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'email_verified_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-6',
            'entries_number' => '5',
            'fields' => [
                'id' => '',
                'name' => '',
                'email' => '',
            ],
        ];

        $settings9['data'] = [];

        if (class_exists($settings9['model'])) {
            $settings9['data'] = $settings9['model']::latest()
                ->take($settings9['entries_number'])
                ->get();
        }

        if (!array_key_exists('fields', $settings9)) {
            $settings9['fields'] = [];
        }

        $settings10 = [
            'chart_title' => web('order last 7 day'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_days' => '7',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings10['total_number'] = 0;

        if (class_exists($settings10['model'])) {
            $settings10['total_number'] = $settings10['model']::when(isset($settings10['filter_field']), function ($query) use ($settings10, $auth) {
                if (Auth::user()['user_type'] == 3) {
                    return $query->where('restaurants_id', $auth);
                }
                if (isset($settings10['filter_days'])) {
                    return $query->where(
                        $settings10['filter_field'],
                        '>=',
                        now()->subDays($settings10['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings10['filter_period'])) {
                    switch ($settings10['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings10['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings10['aggregate_function'] ?? 'count'}($settings10['aggregate_field'] ?? '*');
        }

        $settings11 = [
            'chart_title' => web('order last 14 day'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_days' => '14',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings11['total_number'] = 0;

        if (class_exists($settings11['model'])) {
            $settings11['total_number'] = $settings11['model']::when(isset($settings11['filter_field']), function ($query) use ($settings11, $auth) {
                if (Auth::user()['user_type'] == 3) {
                    return $query->where('restaurants_id', $auth);
                }
                if (isset($settings11['filter_days'])) {
                    return $query->where(
                        $settings11['filter_field'],
                        '>=',
                        now()->subDays($settings11['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings11['filter_period'])) {
                    switch ($settings11['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings11['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings11['aggregate_function'] ?? 'count'}($settings11['aggregate_field'] ?? '*');
        }

        $settings12 = [
            'chart_title' => web('order last 30 day'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_days' => '30',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings12['total_number'] = 0;

        if (class_exists($settings12['model'])) {
            $settings12['total_number'] = $settings12['model']::when(isset($settings12['filter_field']), function ($query) use ($settings12, $auth) {
                if (Auth::user()['user_type'] == 3) {
                    return $query->where('restaurants_id', $auth);
                }
                if (isset($settings12['filter_days'])) {
                    return $query->where(
                        $settings12['filter_field'],
                        '>=',
                        now()->subDays($settings12['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings12['filter_period'])) {
                    switch ($settings12['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings12['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings12['aggregate_function'] ?? 'count'}($settings12['aggregate_field'] ?? '*');
        }

        $settings13 = [
            'chart_title' => web('order this week'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_period' => 'week',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings13['total_number'] = 0;

        if (class_exists($settings13['model'])) {
            $settings13['total_number'] = $settings13['model']::when(isset($settings13['filter_field']), function ($query) use ($settings13, $auth) {
                if (Auth::user()['user_type'] == 3) {
                    return $query->where('restaurants_id', $auth);
                }
                if (isset($settings13['filter_days'])) {
                    return $query->where(
                        $settings13['filter_field'],
                        '>=',
                        now()->subDays($settings13['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings13['filter_period'])) {
                    switch ($settings13['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings13['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings13['aggregate_function'] ?? 'count'}($settings13['aggregate_field'] ?? '*');
        }

        $settings14 = [
            'chart_title' => web('order this month'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_period' => 'month',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings14['total_number'] = 0;

        if (class_exists($settings14['model'])) {
            $settings14['total_number'] = $settings14['model']::when(isset($settings14['filter_field']), function ($query) use ($settings14, $auth) {
                if (Auth::user()['user_type'] == 3) {
                    return $query->where('restaurants_id', $auth);
                }
                if (isset($settings14['filter_days'])) {
                    return $query->where(
                        $settings14['filter_field'],
                        '>=',
                        now()->subDays($settings14['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings14['filter_period'])) {
                    switch ($settings14['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings14['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings14['aggregate_function'] ?? 'count'}($settings14['aggregate_field'] ?? '*');
        }

        $settings15 = [
            'chart_title' => web('order this year'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'filter_period' => 'year',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings15['total_number'] = 0;

        if (class_exists($settings15['model'])) {
            $settings15['total_number'] = $settings15['model']::when(isset($settings15['filter_field']), function ($query) use ($settings15, $auth) {
                if (Auth::user()['user_type'] == 3) {
                    return $query->where('restaurants_id', $auth);
                }
                if (isset($settings15['filter_days'])) {
                    return $query->where(
                        $settings15['filter_field'],
                        '>=',
                        now()->subDays($settings15['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings15['filter_period'])) {
                    switch ($settings15['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings15['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings15['aggregate_function'] ?? 'count'}($settings15['aggregate_field'] ?? '*');
        }

        $settings16 = [
            'chart_title' => web('order reservation'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings16['total_number'] = 0;

        if (class_exists($settings16['model'])) {
            $settings16['total_number'] = $settings16['model']::where('status_id', 3)->when(isset($settings16['filter_field']), function ($query) use ($settings16, $auth) {
                if (Auth::user()['user_type'] == 3) {
                    return $query->where('restaurants_id', $auth);
                }
                if (isset($settings16['filter_days'])) {
                    return $query->where(
                        $settings16['filter_field'],
                        '>=',
                        now()->subDays($settings16['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings16['filter_period'])) {
                    switch ($settings16['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings16['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings16['aggregate_function'] ?? 'count'}($settings16['aggregate_field'] ?? '*');
        }

        $settings17 = [
            'chart_title' => web('order complete'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings17['total_number'] = 0;

        if (class_exists($settings17['model'])) {
            $settings17['total_number'] = $settings17['model']::where('status_id', 2)->when(isset($settings17['filter_field']), function ($query) use ($settings17, $auth) {
                if (Auth::user()['user_type'] == 3) {
                    return $query->where('restaurants_id', $auth);
                }
                if (isset($settings17['filter_days'])) {
                    return $query->where(
                        $settings17['filter_field'],
                        '>=',
                        now()->subDays($settings17['filter_days'])->format('Y-m-d')
                    );
                } else if (isset($settings17['filter_period'])) {
                    switch ($settings17['filter_period']) {
                        case 'week':
                            $start = date('Y-m-d', strtotime('last Monday'));
                            break;
                        case 'month':
                            $start = date('Y-m') . '-01';
                            break;
                        case 'year':
                            $start = date('Y') . '-01-01';
                            break;
                    }

                    if (isset($start)) {
                        return $query->where($settings17['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings17['aggregate_function'] ?? 'count'}($settings17['aggregate_field'] ?? '*');
        }


        $settings24 = [
            'chart_title' => web('visits'),
            'chart_type' => 'number_block',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Restaurant',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'filter_field' => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class' => 'col-md-3',
            'entries_number' => '5',
        ];

        $settings24['total_number'] = 0;

        if (class_exists($settings24['model'])) {
            $settings24['total_number'] = $settings24['model']::find($auth)['visits'];
        }
        if (Auth::user()['user_type'] == 3) {
            $restaurant = Restaurant::where('restaurant_id', Auth::id())->first();
            if ($restaurant)
            {
                $auth = $restaurant->id;
            }else{
                $auth = Auth::id();
            }
            $order_day = Order::where('restaurants_id', $auth)->whereDate('created_at', Carbon::today())->count();

        } else {
            $order_day = Order::whereDate('created_at', Carbon::today())->count();
        }

        $settings18 = [
            'chart_title' => web('order today'),
            'chart_type' => 'number_block',
            'column_class' => 'col-md-3',
            'total_number' => $order_day,
        ];

        $settings19 = [
            'chart_title' => web('all ads active'),
            'chart_type' => 'number_block',
            'column_class' => 'col-md-3',
            'total_number' => AllAd::where('status' , 1)->count(),
        ];
        return view('home', compact('settings1', 'settings2', 'settings3', 'settings4', 'chart5', 'chart6', 'chart7', 'settings8', 'settings9', 'settings10', 'settings11', 'settings12', 'settings13', 'settings14', 'settings15', 'settings16', 'settings17', 'chart17', 'chart18', 'chart19', 'chart20', 'settings24', 'settings18', 'settings19'));
    }
}
