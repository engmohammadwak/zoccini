<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    private function buildPermissionsResult()
    {
        $allPermissions = Permission::where('category', '!=', 0)
            ->where('category', '!=', null)
            ->orderBy('category')
            ->orderBy('id')
            ->get();

        $result = [];
        foreach ($allPermissions as $perm) {
            $cat = $perm->category;
            if (!isset($result[$cat])) {
                $result[$cat] = [
                    'category_id' => $cat,
                    'link_name'   => App::getLocale() == 'ar' ? $perm->name_ar : $perm->name_en,
                    'permissions' => collect(),
                ];
            }
            $result[$cat]['permissions']->push($perm);
        }

        return array_values($result);
    }

    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $result = $this->buildPermissionsResult();
        return view('admin.roles.create', compact('result'));
    }

    public function store(StoreRoleRequest $request)
    {
        $perm = $request->perm ?? [];
        $role = Role::create($request->all());
        $role->permissions()->sync($perm);
        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        abort_if(Gate::denies('role_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role->load('permissions');
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role->load('permissions');
        $result = $this->buildPermissionsResult();
        return view('admin.roles.edit', compact('result', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $perm = $request->perm ?? [];
        $role->update($request->all());
        $role->permissions()->sync($perm);
        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role->delete();
        return back();
    }

    public function massDestroy(MassDestroyRoleRequest $request)
    {
        Role::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
