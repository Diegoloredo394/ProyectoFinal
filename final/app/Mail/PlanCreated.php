<?php

namespace App\Mail;

use App\Models\Plan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PlanCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    public function build()
    {
        // Genera el PDF a partir de tu vista plans.pdf
        $pdf = PDF::loadView('plans.pdf', [
            'plan' => $this->plan
        ]);

        return $this
            ->subject("Nuevo plan semanal: {$this->plan->name}")
            ->markdown('emails.plans.created')
            // Aquí adjuntas el PDF en memoria:
            ->attachData(
                $pdf->output(),
                "plan-{$this->plan->id}.pdf",
                ['mime' => 'application/pdf']
            );
    }
}
