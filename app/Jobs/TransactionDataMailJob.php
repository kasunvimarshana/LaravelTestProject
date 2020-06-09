<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Mail;
use App\Mail\TransactionDataMail;

class TransactionDataMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 60;
    
    /**
    * Delete the job if its models no longer exist.
    *
    * @var bool
    */
    public $deleteWhenMissingModels = true;
    
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $data = array() )
    {
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $data = $this->data;
        
        $toUserArray = array();
        $ccUserArray = array();
        $bccUserArray = array();
        
        array_push($toUserArray, $data["recipient"]->email);
        array_push($ccUserArray, $data["sender"]->email);
            
        $toUserArray = array_unique($toUserArray);
        $ccUserArray = array_unique($ccUserArray);
        
        if( $toUserArray ){
            Mail::to( $toUserArray )
                //->subject("SUBJECT")
                ->cc( $ccUserArray )
                //->bcc( $ccUserArray )
                ->send(new TransactionDataMail($data));
        }
    }
}
