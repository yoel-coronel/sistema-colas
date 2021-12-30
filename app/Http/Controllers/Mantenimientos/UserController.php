<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = User::orderBy('id')->paginate(12);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $tickets = collect($data['tickets'])->map(function ($ticket) {
                return $ticket['id'];
            });
            $roles = collect($data['roles'])->map(function ($ticket) {
                return $ticket['id'];
            });
            $user = User::create([
                    'id' => null,
                    'desk_id' => $data['desk_id']['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'full_name'=>$data['full_name'],
                    'is_admin' =>false,
                    'password' => Hash::make("password"),
                ]);


            $user->tickets()->attach($tickets);
            $user->roles()->attach($roles);

            return $this->successResponseCreate($this->show($user->id),trans('message.success'));

        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(),1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $tickets = collect($data['tickets'])->map(function ($ticket) {
                return $ticket['id'];
            });
            $roles = collect($data['roles'])->map(function ($ticket) {
                return $ticket['id'];
            });
            $user = User::find($id);
            $user->desk_id=$data['desk_id']['id'];
            $user->name=$data['name'];
            $user->email=$data['email'];
            $user->full_name=$data['full_name'];
            $user->save();

            $user->tickets()->sync($tickets);
            $user->roles()->sync($roles);

            return $this->successResponseCreate($this->show($user->id),trans('message.success'));

        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(),1);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
    }
}
