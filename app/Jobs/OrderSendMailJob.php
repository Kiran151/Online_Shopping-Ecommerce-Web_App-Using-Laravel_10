<?php

namespace App\Jobs;

use App\Mail\OrderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OrderSendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $mail_data;
    private $shipping_email;
    public function __construct($mail_data, $shipping_email)
    {
        $this->mail_data = $mail_data;
        $this->shipping_email = $shipping_email;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->shipping_email)->send(new OrderMail($this->mail_data));
    }
}