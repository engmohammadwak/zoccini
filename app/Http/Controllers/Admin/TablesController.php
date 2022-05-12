<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTableRequest;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Models\Restaurant;
use App\Models\SittingArea;
use App\Models\Table;
use App\Models\TableStatus;
use App\Models\User;
use Gate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TablesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('table_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();
        if (Auth::user()['user_type'] == 3) {
            $tables = Table::where('restaurants_id' , $restaurant->id)->get();
        } else {
            $tables = Table::all();
        }
        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        abort_if(Gate::denies('table_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();
        if ($restaurant->sitting_areas)
        {
               $sitting_areas =  $restaurant->sitting_areas;
        }else{
            $sitting_areas = [];
        }

        $statuses = TableStatus::all()->pluck('name_'.App::getLocale(), 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.tables.create', compact('sitting_areas', 'statuses'));
    }

    public function store(StoreTableRequest $request)
    {
        $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();
        $request->request->add(['restaurants_id' => $restaurant->id]);
        $table = Table::create($request->all());

        return redirect()->route('admin.tables.index');
    }

    public function edit(Table $table)
    {
        abort_if(Gate::denies('table_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();
        if ($restaurant->sitting_areas)
        {
            $sitting_areas =  $restaurant->sitting_areas;
        }else{
            $sitting_areas = [];
        }
        $statuses = TableStatus::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $table->load( 'status');

        return view('admin.tables.edit', compact('sitting_areas', 'statuses', 'table'));
    }

    public function update(UpdateTableRequest $request, Table $table)
    {
        $table->update($request->all());

        return redirect()->route('admin.tables.index');
    }

    public function show(Table $table)
    {
        abort_if(Gate::denies('table_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $table->load('sitting_area', 'status');

        return view('admin.tables.show', compact('table'));
    }

    public function destroy(Table $table)
    {
        abort_if(Gate::denies('table_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $table->delete();

        return back();
    }

    public function massDestroy(MassDestroyTableRequest $request)
    {
        Table::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
