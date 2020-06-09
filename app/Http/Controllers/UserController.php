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
use App\Enums\TransactionTypeEnum as TransactionTypeEnum;

class UserController extends Controller
{
    //
    public function create(){
        if(view()->exists('register')){
            return View::make('register');
        }
    }
    
    public function store(Request $request){
        //
        $dataArray = array();
        
        $rules = array(
            'name'    => 'required',
            'email'    => 'required|unique:users,email',
            'password' => 'required|min:3',
            'balance' => 'required'
        );
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors( $validator )
                ->withInput( $request->except(['password']) );
        } else {
            try {
                DB::beginTransaction();
                
                $dataArray = array(
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make( $request->input('password') )
                );

                $userObject = User::create( $dataArray );
                unset($dataArray);
                
                if( $userObject ){
                    $depositObject = $userObject->deposits()->create([
                        'balance' => $request->input('balance'),
                        'transaction_type' => TransactionTypeEnum::CREATE_ACCOUNT
                    ]);
                    
                    $userObject->deposits()->save( $depositObject );
                }

                unset($dataArray);
                
                DB::commit();
            }catch(Exception $e){
                DB::rollback(); 
                return redirect()
                    ->back()
                    ->withInput( $request->except(['password']) );
            }
        }
        
        return redirect()->route('login.create', []);
    }
    
    public function home(Request $request){
        $current_user = auth()->user();
        
        if(view()->exists('home')){
            return View::make('home', ['current_user' => $current_user]);
        }
    }
    
    public function checkValidUser(Request $request){
        //
        $data = array();
        $userObject = new User();
        $isValidUser = false;
        
        if ( ($request->has('email')) && ($request->filled('email')) ) {
            $email = $request->input('email');
            $userObject = $userObject->where('email', '=', $email)->first();
        }
        
        if( ($userObject) && ($userObject->id) ){
            $isValidUser = true;
        }
        
        $data['isValidUser'] = $isValidUser;
        
        return Response::json( $data );
    }
    
    public function getTotalAmount(Request $request){
        //
        $data = array();
        $userObject = auth()->user();
        $totalAmount = 0;
        
        if ( ($userObject) && ($userObject->id) ) {
            $totalAmount = $userObject->getTotalAmount();
        }
        
        $data['totalAmount'] = $totalAmount;
        
        return Response::json( $data );
    }
}
