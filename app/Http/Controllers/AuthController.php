<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\UserRoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Notifications\WelcomeMail;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Str;
 
class AuthController extends Controller
{
    public function add(Request $request)
   {
        
        $validaiton = Validator::make($request->all(), [
            "name"      =>  'required',
            'email'     =>  'required|email|unique:users,email',
            'phone'     =>  'required|numeric|unique:users,phone',
            'password'  =>  'required',
            'roles'     =>  'required|array|exists:roles,id',
        ]);   
        if ($validaiton->fails())
            return $validaiton->errors();
        $user = new User();
        $user->name =$request->name;
        $user->email =$request->email;
        $user->phone =$request->phone;
        $user->password = Hash::make($request->password);
        $result=$user->save();
        $token = $user->createToken('Ahg')->plainTextToken;
        $user->roles()->sync($request->input('roles')); 
            return response()->json(['user' => $user, 'token' => $token ],201);         
         
        if($result){

            return["user data hase been saved"];

        }else{

            return["user data not saved"];     
        }
    }

    public function verifyAccount($token)
    {
        $user = User::where('email_verify_token','=',$token)->first();
        if($user)
        {
            $user->update([
                'email_verify_token'    =>  null,
                'email_verified_at'     => Carbon::now(),
                'is_active'             =>  true,
            ]);
             return message('Account Verify Successfuly');
        }else{
             return message('Account Already Verified');
        }
    }
    public function login(Request $request)
        {            
            $request->only('email','password');

            if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])){                
            $user = User::where('email',$request->email)->first();
            $token = $user->createToken('Token')->plainTextToken;

            return response()->json([
                'user'  => $user,
                'token' => $token
            ]); 
            }
            return response()->json(['The email address or password you entered is incorrect.' ], 401);
         
        }


        public function sendResetLinkEmail(Request $request)
        {
    
    
            $validation = Validator::make($request->all(), [
                'email' => 'exists:users,email'
            ]);
    
            $user = User::where('email', $request->email)->first();
            $user['token'] = Str::random(12);
    
            return $user->notify(new ResetPasswordNotification($user));
          
            $this->validateEmail($request);
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );
            return $response == Password::RESET_LINK_SENT
                ? response()->json(['message' => 'Reset password link sent on your email id.'])
                : response()->json(['message' => 'Unable to send reset link']);
        }
    
        protected function validateEmail(Request $request)
        {
            $request->validate(['email' => 'required|email']);
        }
    
        protected function broker()
        {
            return Password::broker();
        }
       
        public function forgotPasswordLink(Request $request)
        {
            $validaiton = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email'
            ]);
    
            if ($validaiton->fails())
                return $validaiton->errors();
    
            $user = User::where('email', $request->email)->first();
            $token = Str::random(16);
    
            $user->notify(new ResetPasswordNotification($token));
      
            PasswordReset::create([
                'token' => $token,
                'email' => $request->email
            ]);
    
            return "Mail Sent Successfully";
        }
    
        public function forgotPassword(Request $request)
        {
            $validaiton = Validator::make($request->all(), [
                'token'                 => 'required|exists:password_resets,token',
                'email'                 => 'required|exists:password_resets,email|exists:users,email',
                'password'              => 'required|min:8|confirmed',
                'password_confirmation' => 'required'
            ]);
    
            if ($validaiton->fails())
                return $validaiton->errors();
    
            $passwordReset = PasswordReset::where('token', $request->token)->first();
            $user = User::where('email', $passwordReset->email)->first();
    
            $user->update([
                'password'  => Hash::make($request->password)
            ]);
    
            return 'Password Changed Successfully';
        }
    }