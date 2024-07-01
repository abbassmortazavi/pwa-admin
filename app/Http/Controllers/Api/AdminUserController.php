<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $users = User::query()->paginate(10);
        return response()->json([
            'message' => "User Lists Successfully!",
            'data' => $users,
        ]);
    }

    /**
     * @param UserStoreRequest $request
     * @return JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $users = User::query()->create($input);
        return response()->json([
            'message' => "User Register Successfully!!",
            'data' => $users
        ]);
    }

    /**
     * @param UserUpdateRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return response()->json([
            'message' => 'User Update Successfully!!'
        ]);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'User Deleted Successfully!!'
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function changeRole(Request $request, User $user)
    {
        $role = (int)$request->role;
        $user->update([
            'role' => (int)request('role')
        ]);
        return response()->json([
            'message' => 'User Role Update Successfully!!'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $text = $request->input('query');
        $users = User::query()->where('name', 'like', "%{$text}%")->paginate(10);
        return response()->json([
            'message' => "User Lists Successfully!",
            'data' => $users,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteBulk(Request $request)
    {
        User::query()->whereIn('id', $request->input('ids'))->delete();
        return response()->json([
            'message' => "User Successfully Deleted!!"
        ]);
    }
}
