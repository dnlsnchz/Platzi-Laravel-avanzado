<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Console\Commands\SendEmailVerificationCommand;
use Illuminate\Support\Facades\Artisan;

class NewsletterController extends Controller
{
    public function send(){
        Artisan::call(SendEmailVerificationCommand::class);
        return response()->json([
            'data'=>'Todo Ok'
        ]);
    }
}
