<?php

namespace App\Backup;

use Spatie\Backup\Notifications\Notifiable;
use Mailgun;

class NotificationBackupHasFailed extends Notifiable
{
    public function send()
    {
        $setting = [
            'email_from' => env('BACKUP_MAIL_FROM_ADDRESS'),
            'email_sender' => env('BACKUP_MAIL_FROM_NAME'),
            'email_logo' => env('BACKUP_MAIL_LOGO'),
            'email_copyright' => env('BACKUP_MAIL_COPY_RIGHT'),
            'email_contact' => env('BACKUP_MAIL_COPY_RIGHT'),
            'email_logo_position' => 'center'
        ];
        $data = array(
            'html_message' => "Hello Team, <br> Date : " . date('l') . "," . date('d') . " " . date('F') . " " . date('Y') . " <br> A failure occurred in backup process, please check this process.",
            'setting' => $setting
        );
        $mailMessage = Mailgun::send('emails.test', $data, function ($message) use ($setting) {
            $message->subject('Backup up File BE');
            if (!empty($setting['email_from']) && !empty($setting['email_sender'])) {
                $message->from($setting['email_from'], $setting['email_sender']);
            } elseif (!empty($setting['email_from'])) {
                $message->from($setting['email_from']);
            }
            $message->to(env('BACKUP_MAIL_TO'));
        });

        return $mailMessage;
    }
}
