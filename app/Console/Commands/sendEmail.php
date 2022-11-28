<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendRequestEmailJob;


class sendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     *
     *
     * @return void
     */
    protected $drip;

    public function __construct(SendRequestEmailJob $drip)
    {
        parent::__construct();

        $this->drip = $drip;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('executing Jobs');
        dd($this->drip);
        return 0;
    }
}
