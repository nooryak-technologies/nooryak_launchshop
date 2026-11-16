<?php

namespace App\Http\Helpers;

use Config;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Str;

class BasicMailer
{
  public static function sendMail($data)
  {
    $sent = false;

    // Fetch DB basic_extendeds settings as fallback if needed
    $be = null;
    try {
      $be = DB::table('basic_extendeds')->first();
    } catch (\Throwable $e) {}

    $smtpStatus = isset($data['smtp_status']) ? (int)$data['smtp_status'] : ($be->is_smtp ?? 1);
    $smtpHost = !empty($data['smtp_host']) ? $data['smtp_host'] : (!empty($be->smtp_host) ? $be->smtp_host : env('MAIL_HOST', 'mail.nooryak.in'));
    $smtpPort = !empty($data['smtp_port']) ? (int)$data['smtp_port'] : (!empty($be->smtp_port) ? (int)$be->smtp_port : (int)env('MAIL_PORT', 465));
    $smtpEncryption = !empty($data['encryption']) ? $data['encryption'] : (!empty($be->encryption) ? $be->encryption : env('MAIL_ENCRYPTION', 'ssl'));
    $smtpUsername = !empty($data['smtp_username']) ? $data['smtp_username'] : (!empty($be->smtp_username) ? $be->smtp_username : env('MAIL_USERNAME', 'infosaasreselling@nooryak.in'));
    $smtpPassword = !empty($data['smtp_password']) ? $data['smtp_password'] : (!empty($be->smtp_password) ? $be->smtp_password : env('MAIL_PASSWORD', 'Admin@nooryak'));

    $fromMail = !empty($data['from_mail']) ? $data['from_mail'] : (!empty($be->from_mail) ? $be->from_mail : (env('MAIL_FROM_ADDRESS') ?: 'infosaasreselling@nooryak.in'));
    $fromName = !empty($data['from_name']) ? $data['from_name'] : (!empty($be->from_name) ? $be->from_name : (env('MAIL_FROM_NAME') ?: 'LaunchShop'));

    $recipient = $data['recipient'] ?? ($data['to'] ?? ($data['toMail'] ?? null));
    if (empty($recipient)) {
      Log::warning('BasicMailer: No recipient specified.');
      return false;
    }

    $subject = $data['subject'] ?? 'Notification';
    $rawBody = $data['body'] ?? '';
    $body = Common::wrapEmailBody($rawBody, $subject, null, null, $fromName);

    // Try SMTP if host is present
    if (!empty($smtpHost) && ($smtpStatus == 1 || !empty(env('MAIL_HOST')))) {
      try {
        $smtp = [
          'transport' => 'smtp',
          'host' => $smtpHost,
          'port' => $smtpPort,
          'encryption' => $smtpEncryption,
          'username' => $smtpUsername,
          'password' => $smtpPassword,
          'timeout' => 15,
          'auth_mode' => null,
        ];
        Config::set('mail.mailers.smtp', $smtp);
        Config::set('mail.default', 'smtp');
        Mail::purge('smtp');

        Mail::send([], [], function (Message $message) use ($recipient, $fromMail, $fromName, $subject, $body, $data) {
          $message->to($recipient)
            ->from($fromMail, $fromName)
            ->replyTo($fromMail, $fromName)
            ->subject($subject)
            ->html($body, 'text/html');

          if (array_key_exists('invoice', $data) && !empty($data['invoice']) && file_exists($data['invoice'])) {
            $message->attach($data['invoice']);
          }
        });
        $sent = true;
      } catch (\Throwable $e) {
        Log::warning('BasicMailer SMTP failed to ' . $recipient . ': ' . $e->getMessage());
      }
    }

    // Fail-safe: Always fallback to PHP native mail() if SMTP was not sent or failed
    if (!$sent) {
      try {
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: {$fromName} <{$fromMail}>\r\n";
        $headers .= "Reply-To: {$fromMail}\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        if (@mail($recipient, $subject, $body, $headers)) {
          $sent = true;
          Log::info('BasicMailer: Sent mail via native mail() fallback to ' . $recipient);
        } else {
          Log::warning('BasicMailer: Native mail() failed for ' . $recipient);
        }
      } catch (\Throwable $e) {
        Log::warning('BasicMailer native mail fallback error: ' . $e->getMessage());
      }
    }

    return $sent;
  }
}
