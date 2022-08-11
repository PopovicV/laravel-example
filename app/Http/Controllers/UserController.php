<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Returns all users
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $users = User::all();
            return response()->json(["users" => $users]);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            return response()->json(["message" => "Error occurred. Could not get users."], 500);
        }
    }

    /**
     * Creates user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = $this->validateUser($request->all());

        if ($validator->fails()) {
            return response()->json(['message' => json_encode($validator->errors())], 422);
        }

        $user = new User();
        $user = $this->updateUserProps($user, $request->all());
        $user->save();

        return response()->json(['message' => 'User successfully created']);
    }

    /**
     * Returns user by ID
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(["user" => $user]);
        } catch (ModelNotFoundException $exception) {
            Log::debug($exception->getMessage());
            return response()->json(["message" => "User not found."], 404);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            return response()->json(["message" => "Error occurred. Could not get user."], 500);
        }
    }

    /**
     * Updates user
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        $validator = $this->validateUser($request->all(), $id);

        if ($validator->fails()) {
            return response()->json(['message' => json_encode($validator->errors())], 422);
        }

        $user = $this->updateUserProps($user, $request->all());
        $user->save();

        return response()->json(['message' => 'User successfully updated']);
    }

    /**
     * Deletes user
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'User successfully deleted']);
        } catch(ModelNotFoundException $exception) {
            Log::debug($exception->getMessage());
            return response()->json(["message" => "User not found."], 404);
        } catch(Exception $exception) {
            Log::debug($exception->getMessage());
            return response()->json(["message" => "Error occurred. Could not delete user."], 500);
        }
    }

    /**
     * Updates user props
     *
     * @param $user
     * @param $propsValues
     * @return User
     */
    private function updateUserProps($user, $propsValues): User
    {
        foreach($propsValues as $prop => $value) {
            $user->{$prop} = $prop == 'password' ? Hash::make($value) : $value;
        }
        return $user;
    }

    /**
     * Validates user
     *
     * @param $params
     * @param $userId
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    private function validateUser($params, $userId = null): \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
    {
        $validate = [
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
        ];

        if ($userId) {
            $validate['email'] = ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,'. $userId];
        } else {
            $validate['email'] = ['sometimes', 'string', 'email', 'max:255', 'unique:users,email'];
        }

        return Validator::make($params, $validate);
    }
}
