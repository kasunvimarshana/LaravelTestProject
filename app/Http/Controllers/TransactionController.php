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
use Carbon\Carbon;

use App\User as User;
use App\Rules\ValidAmountRule;
use App\Enums\TransactionTypeEnum as TransactionTypeEnum;
use App\Jobs\TransactionDataMailJob;

class TransactionController extends Controller
{
    //
    public function create(){
        if(view()->exists('money_transfer')){
            return View::make('money_transfer', []);
        }
    }
    
    public function store(Request $request){
        //
        $dataArray = array();
        $current_user = auth()->user();
        $data = array();
        
        $rules = array(
            'email'    => 'required|exists:users,email',
            'balance' => ['required', new ValidAmountRule( $current_user )]
        );
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors( $validator )
                ->withInput();
        } else {
            //
            try {
                DB::beginTransaction();
                
                if( $current_user ){
                    $dataArray = array(
                        'balance' => $request->input('balance'),
                        'transaction_type' => TransactionTypeEnum::USER_TRANSACTION
                    );
                    
                    $withdrawalObject = $current_user->withdrawals()->create( $dataArray );
                    
                    $userObject = new User();
                    $email = $request->input('email');
                    $userObject = $userObject->where('email', '=', $email)->first();
                    
                    $depositObject = $userObject->deposits()->create( $dataArray );
                    
                    $data["sender"] = $current_user;
                    $data["recipient"] = $userObject;
                    $data["balance"] = $request->input('balance');
                }

                unset($dataArray);
                
                $emailJob = (new TransactionDataMailJob( $data ))
                    ->delay(Carbon::now()->addSeconds(10));
                dispatch($emailJob);
                
                unset($data);
                
                DB::commit();
            }catch(Exception $e){dd($e);
                DB::rollback(); 
                return redirect()->back()->withInput();
            }
        }
        
        return redirect()->route('home', []);
    }
    
    public function createDetailView(Request $request){
        //
        $dataArray = array();
        $current_user = auth()->user();
        $transactions = null;
        
        $deposits = DB::table('deposits')->select(
            'id as id', 
            'user_id as user_id', 
            'balance as balance', 
            'transaction_type as transaction_type',
            'created_at as created_at',
            DB::raw("'DEPOSIT' as record_type")
        )
        ->where('user_id', '=', $current_user->id);
        
        $withdrawals = DB::table('withdrawals')->select(
            'id as id', 
            'user_id as user_id', 
            'balance as balance', 
            'transaction_type as transaction_type',
            'created_at as created_at',
            DB::raw("'WITHDRAWAL' as record_type")
        )
        ->where('user_id', '=', $current_user->id);
        
        $transactions = $deposits
            ->UnionAll($withdrawals)
            ->orderBy('created_at', 'asc')
            ->get();
        
        if(view()->exists('transaction_data')){
            return View::make('transaction_data', ['transactions' => $transactions]);
        }
    }
}
