<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Notifications\EmailVerificationNotification;
use Carbon\Carbon;

class SendEmailVerificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emailverification {emails?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia un correo electronico a los usuarios que no han verificado su cuenta despues de haberse registraod hace una semana';
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
     * @return int
     */
    public function handle()
    {
        $builder = User::query()
                        ->whereNull('email_verified_at')
                        //->whereDate('created_at', '<=', Carbon::now()->subDays(7)->format('Y-m-d'))
                        ;

        if ($count = $builder->count()) {
            $this->info("Se enviaran {$count} correos");
            $this->output->progressStart($count);

            $builder->each(function (User $user) {
                $user->notify(new EmailVerificationNotification());
                $this->output->progressAdvance();
            });

            $this->output->progressFinish();
            $this->info("Se enviaron {$count} correos");
            	
        } else {
            $this->info('No se enviaron correos');
        }

        return 0;
    }
}
