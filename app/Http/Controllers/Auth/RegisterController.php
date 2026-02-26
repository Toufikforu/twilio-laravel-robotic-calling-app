<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RegQuestion;
use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered; // Add this at the top

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'usage' => 'required|string|min:10|max:100',
            'dyes' => 'nullable|string|min:2|max:15',
            'training' => 'nullable|array',
        ]);
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'company' => $data['company'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);
    
        // Store the registration question data
        RegQuestion::create([
            'user_id' => $user->id, // Use the created user's ID
            'usage' => $data['usage'],
            'dyes' => $data['dyes'],
            'trainings_taken' => implode(', ', $data['training']), // Convert array to JSON
        ]);

        // Fire event to send verification email
        event(new Registered($user));
        \Log::info('Verification email event fired for user: ' . $user->email);

    
        return $user; // Only return the User model, NOT an array
    }
    


}
