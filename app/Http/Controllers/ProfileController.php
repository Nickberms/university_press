<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile');
    }
    public function update(ProfileUpdateRequest $request)
    {
        function formatInput(string $input): string
        {
            $input = preg_replace('/\s+/', ' ', trim($input));
            return $input;
        }
        $request['name'] = formatInput($request['name']);
        if ($request->password) {
            auth()->user()->update(['password' => Hash::make($request->password)]);
        }
        auth()->user()->update([
            'name' => $request->input('name'),
            'email' => $request->email,
        ]);
        return redirect()->back()->with('success', 'Your profile has been successfully updated!');
    }
}