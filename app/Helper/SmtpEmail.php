<?php

namespace App\Helper;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use stdClass;

class SmtpEmail
{
    static public function email(stdClass $dados)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->CharSet = 'utf-8';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Host = env('MAIL_HOST'); //gmail has host > smtp.gmail.com
            $mail->Port = env('MAIL_PORT'); //gmail has port > 587 . without double quotes
            $mail->Username = env('MAIL_USERNAME'); //your username. actually your email
            $mail->Password = env('MAIL_PASSWORD'); // your password. your mail password
            $mail->setFrom(env('MY_EMAIL'), env('MY_NAME'));
            $mail->Subject = $dados->subject;
            $mail->MsgHTML($dados->text);
            $mail->addAddress($dados->email, $dados->name);

            if (!$mail->send()) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            dd($e);
        }

        return view("result")
            ->with("result", $mail ? "success" : "failed")
            ->with("title", $mail ? "Success" : "Failed");
    }
}
