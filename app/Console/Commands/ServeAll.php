<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServeAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serveall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the built in web server, the queue listener, and the Laravel echo server';

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
     * @return mixed
     */
    public function handle()
    {
        call_in_background('queue:listen --tries 1');
        call_in_background('', './node_modules/laravel-echo-server/bin/server.js start');
        $this->call('serve');
    }
}
