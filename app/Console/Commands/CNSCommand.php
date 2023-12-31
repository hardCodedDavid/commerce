<?php

namespace App\Console\Commands;

use App\Http\Controllers\DeliveryController;
use Illuminate\Console\Command;

class CNSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CNS:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Click-N-Ship Access Token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        DeliveryController::getToken();
        $this->alert('ClickNShip token generated');
    }
}
