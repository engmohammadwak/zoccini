<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTableStatusRequest;
use App\Http\Requests\StoreTableStatusRequest;
use App\Http\Requests\UpdateTableStatusRequest;
use App\Models\TableStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TableStatusController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('table_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tableStatuses = TableStatus::all();

        return view('admin.tableStatuses.index', compact('tableStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('table_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tableStatuses.create');
    }

    public function store(StoreTableStatusRequest $request)
    {
        $tableStatus = TableStatus::create($request->all());

        return redirect()->route('admin.table-statuses.index');
    }

    public function edit(TableStatus $tableStatus)
    {
        abort_if(Gate::denies('table_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tableStatuses.edit', compact('tableStatus'));
    }

    public function update(UpdateTableStatusRequest $request, TableStatus $tableStatus)
    {
        $tableStatus->update($request->all());

        return redirect()->route('admin.table-statuses.index');
    }

    public function show(TableStatus $tableStatus)
    {
        abort_if(Gate::denies('table_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tableStatuses.show', compact('tableStatus'));
    }

    public function destroy(TableStatus $tableStatus)
    {
        abort_if(Gate::denies('table_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tableStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyTableStatusRequest $request)
    {
        TableStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
