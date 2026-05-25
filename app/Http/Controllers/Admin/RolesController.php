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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // جلب الـ categories المميزة مع اسمها
        $categories = Permission::where('category', '!=', 0)
            ->orderBy('category')
            ->get()
            ->groupBy('category');

        $result = [];
        foreach ($categories as $catId => $perms) {
            $first = $perms->first();
            $result[] = [
                'category_id'  => $catId,
                'link_name'    => App::getLocale() == 'ar' ? $first->name_ar : $first->name_en,
                'permissions'  => $perms,
            ];
        }

        return view('admin.roles.create', compact('result'));
    }

    public function store(StoreRoleRequest $request)
    {
        $perm = [];
        if ($request->perm) {
            foreach ($request->perm as $value) {
                array_push($perm, $value);
            }
        }

        $role = Role::create($request->all());
        $role->permissions()->sync($perm);

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->load('permissions');

        // جلب الـ categories مع كل الصلاحيات مجمعة
        $categories = Permission::where('category', '!=', 0)
            ->orderBy('category')
            ->get()
            ->groupBy('category');

        $result = [];
        foreach ($categories as $catId => $perms) {
            $first = $perms->first();
            $result[] = [
                'category_id' => $catId,
                'link_name'   => App::getLocale() == 'ar' ? $first->name_ar : $first->name_en,
                'permissions' => $perms,
            ];
        }

        return view('admin.roles.edit', compact('result', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $perm = [];
        if ($request->perm) {
            foreach ($request->perm as $value) {
                array_push($perm, $value);
            }
        }
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
