<?php

namespace App\Jobs;

use App\Mail\SendEmailRequest;
use App\Mail\SendEmailWelcome;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendRequestEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request = 1)
    {

        $this->request =  User::find($request)->get();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->request['email'])->send(new SendEmailRequest($this->request['name'], $this->request['estado']));
        } catch (\Throwable $th) {
            Log::error('Ocurrio un error al enviar email ' . $th->getMessage());
        }
    }
}
