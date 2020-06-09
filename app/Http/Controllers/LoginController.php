<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session as Session;
use DB;
use \Exception;
use Illuminate\Support\Facades\Route;

use App\User as User;

class LoginController extends Controller
{
    //
    public function index(Request $request){ /*return response()->json( $request );*/ }
    
    public function create(){
        if( auth::check() ){
            return redirect()->route('home', []);
        }else if(view()->exists('login')){
            return View::make('login', []);
        }
    }
    
    public function doLogin(Request $request){
        $rules = array(
            'email'    => 'required|exists:users,email',
            'password' => 'required|min:3'
        );
        
        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails()){
            return redirect()
                ->back()
                ->withErrors( $validator )
                ->withInput( $request->except(['password']) );
        }else{
            $email = urldecode($request->input('email'));
            $password = urldecode($request->input('password'));
            $credentials = array(
                'email' => $email,
                'password' => $password
            );

            auth()->attempt( $credentials );
            
            if( auth()->check() ){
                return redirect()->route('home', []);
            }else{
                return redirect()
                    ->back()
                    ->withInput( $request->except(['password']) );
            }
        }
    }
    
    public function doLogout(Request $request){
        //
        Auth::logout();
        Session::flush();
        return redirect()->route('login.create', []);
    }
}
