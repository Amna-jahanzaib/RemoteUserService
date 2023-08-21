<?php

namespace App\Http\Controllers;

use AmnaJahanzaib\RemoteUserService\RemoteUserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getUser($id)
    {
        $userService = new RemoteUserService();
        $user = $userService->getUserById($id);
        return $user;
    }

    public function getUsers(Request $request)
    {
        $page = $request->input('page', 1);
        
        $userService = new RemoteUserService();
        $usersData = $userService->getPaginatedUsers($page);
        return $usersData;

    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'job' => 'required|min:2|max:255',
        ]);
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }
        $name = $request->input('name', 'xyz');
        $job = $request->input('job', 'abc');

        $userService = new RemoteUserService();
        $data = $userService->createUser($name,$job);
        return $data;

    }

}
