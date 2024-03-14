<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy(DB::raw('COALESCE(updated_at, created_at)'), 'desc')->get();
        if (request()->ajax()) {
            return response()->json($users);
        } else {
            return view('user_management.manage_users', compact('users'));
        }
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        function formatInput(string $input): string
        {
            $input = preg_replace('/\s+/', ' ', trim($input));
            return $input;
        }
        $request['name'] = formatInput($request['name']);
        $email = strtolower($request->input('email'));
        if (User::where('email', $email)->exists()) {
            return response()->json(['error' => 'The email you inputted has already been taken.'], 422);
        }
        $password = 'cmu_press_' . $email;
        $user = new User([
            'name' => $request->input('name'),
            'email' => $email,
            'account_type' => $request->input('account_type'),
            'password' => bcrypt($password),
        ]);
        $user->save();
        return response()->json(['success' => 'The user has been successfully added!'], 200);
    }
    public function show(User $user)
    {
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->account_type === 'Super Admin') {
            return response()->json(['error' => 'The super admin account cannot be updated!'], 422);
        }
        function formatInput(string $input): string
        {
            $input = preg_replace('/\s+/', ' ', trim($input));
            return $input;
        }
        $request['name'] = formatInput($request['name']);
        $email = strtolower($request->input('email'));
        if ($email !== $user->email) {
            if (User::where('email', $email)->exists()) {
                return response()->json(['error' => 'The email you inputted has already been taken.'], 422);
            }
        }
        $user->update([
            'name' => $request->input('name'),
            'email' => $email,
            'account_type' => $request->input('account_type'),
        ]);
        return response()->json(['success' => 'The user has been successfully updated!'], 200);
    }
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->account_type === 'Super Admin') {
                return response()->json(['error' => 'The super admin account cannot be deleted!'], 422);
            }
            $user->delete();
            return response()->json(['success' => 'The user has been successfully deleted!'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return view('user_management.manage_users', compact('users'));
        }
    }
}