<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoReporte extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $periodo;
    public $pdf;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $periodo, $pdf)
    {
        $this->nombre = $nombre;
        $this->periodo = $periodo;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('CorreoReporte')
                    ->subject('Planilla - '.$this->periodo)
                    ->attachData($this->pdf, 'planilla.pdf',[
                        'mime' => 'application/pdf',
                    ]);
    }
}
