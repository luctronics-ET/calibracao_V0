<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CalibracaoVencendoNotification extends Notification
{
    use Queueable;

    protected $equipamentos;
    protected $diasParaVencimento;

    public function __construct($equipamentos, $diasParaVencimento)
    {
        $this->equipamentos = $equipamentos;
        $this->diasParaVencimento = $diasParaVencimento;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject("Calibrações Vencendo em {$this->diasParaVencimento} Dias")
            ->line("Existem {$this->equipamentos->count()} equipamento(s) com calibração próxima do vencimento.")
            ->line('Equipamentos:');

        foreach ($this->equipamentos->take(10) as $equipamento) {
            $message->line("• {$equipamento->codigo_interno} - {$equipamento->descricao}");
        }

        if ($this->equipamentos->count() > 10) {
            $message->line("... e mais " . ($this->equipamentos->count() - 10) . " equipamento(s)");
        }

        return $message
            ->action('Ver Equipamentos', url('/equipamentos'))
            ->line('Verifique os equipamentos e agende as calibrações necessárias.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'titulo' => "Calibrações Vencendo em {$this->diasParaVencimento} Dias",
            'mensagem' => "Existem {$this->equipamentos->count()} equipamento(s) com calibração próxima do vencimento.",
            'equipamentos' => $this->equipamentos->pluck('id')->toArray(),
            'dias_para_vencimento' => $this->diasParaVencimento,
        ];
    }
}
