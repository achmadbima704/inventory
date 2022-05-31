<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class PetugasController extends Controller
{
    public function index()
    {
        $roles = Role::all()->pluck('name');
        return view('app.data_master.master_petugas.index', ['roles' => $roles]);
    }

    public function getPetugas()
    {
        $user = User::with('roles');
        return DataTables::of($user)
            ->addColumn('action', function () {
                return '<button class="btn btn-warning edit">Edit</button>';
            })
            ->make();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'string'],
            'role' => ['required', 'string']
        ]);

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt('secret')
        ]);

        if ($user->save()) {
            $user->assignRole($data['role']);

            return ['success' => true];
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'string'],
            'role' => ['string'],
        ]);

        $user = User::find($request->id);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($request['password']);

        if ($user->update()) {
            return ['success' => true];
        }
    }
}
