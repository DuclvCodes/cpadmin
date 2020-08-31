<?php

/**
*| --------------------------------------------------------------------------
*| Mail Model
*| --------------------------------------------------------------------------
*| For mail model
*|
*/

class Mail_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pkey = "mail_id";
        $this->tbl = DB_PREFIX."system_mail";
    }
    public function sendMail($to, $subject, $content, $send_date = 'now', $note = null, $fullname = null, $from_name=null, $from_email=null)
    {
        $time = ($send_date=='now')?date('l d F'):date('l d F', strtotime($send_date));
        if ($fullname) {
            $content = '<p>Kính gửi <b>'.$fullname.'</b> !</p>'.$content;
        }
        if (!$from_name) {
            $from_name = DOMAIN_NAME;
        }
        if (!$from_email) {
            $from_email = MAIL_DOMAIN;
        }
        
        $data = array('title'=>$subject, 'reg_date'=>date('Y-m-d H:i:s'), 'mail_to'=>$to, 'content'=>$content, 'note'=>$note);
        if ($send_date=='now') {
            require_once(APPPATH.'libraries/phpMailer/PHPMailerAutoload.php');

            //Create a new PHPMailer instance
            $mail = new PHPMailer;
            //Tell PHPMailer to use SMTP
            $mail->isSMTP();
            $mail->CharSet = "UTF-8";
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            //$mail->Debugoutput = 'html';
            //Set the hostname of the mail server
            $mail->Host = "smtp.gmail.com";
            //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->Port = 25;
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            //Username to use for SMTP authentication
            $mail->Username = "lazzick@gmail.com";
            //Password to use for SMTP authentication
            $mail->Password = "123ChaobaN";
            //Set who the message is to be sent from
            $mail->setFrom('noreply@phapluatplus.vn', 'PhapluatPlus');
            //Set an alternative reply-to address
            $mail->addReplyTo('noreply@phapluatplus.vn', 'PhapluatPlus');
            //Set who the message is to be sent to
            $mail->addAddress($to, $to);
            //Set the subject line
            $mail->Subject = $subject;
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($content);
            //Replace the plain text body with one created manually
            $mail->AltBody = 'xin chao';
            //Attach an image file
            //$mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
            if (!$mail->send()) {
                //$mail->ErrorInfo;
                $server_output = 0;
            } else {
                $server_output = 1;
            }

            if ($server_output=='1') {
                $res = true;
            } else {
                $res = false;
            }
            
            if ($res) {
                $data['status'] = 1;
            } else {
                $data['status'] = 2;
            }
            $data['send_date'] = date('Y-d-m H:i:s');
        } else {
            $res = true;
            $data['status'] = 0;
            $data['send_date'] = $send_date;
        }
        
        $this->insertOne($data);
        return $res;
    }
    public function reportError($content, $is_die=true)
    {
        $content .= "<br><br>Send from: ".getAddress();
        $this->sendMail(ADMIN_EMAIL, 'Lỗi hệ thống', $content);
        $msg = 'Oops!!! Có lỗi xảy ra. Hệ thống sẽ tự động gửi lỗi này đến nhóm IT để sớm khắc phục.';
        if ($is_die) {
            die($msg.' (Click <a onclick="javascript: history.back(); return false;">here</a> to back)');
        } else {
            return $msg.' Thanks !';
        }
    }
    public function sendAdmin($title, $content)
    {
        $content .= "<br><br>Send from: ".getAddress();
        $this->sendMail(ADMIN_EMAIL, $title, $content);
    }
    public function genTable($data, $define=null, $letter=null)
    {
        $html = '<table cellspacing="0" cellpadding="0" border="0" align="center" style="border-collapse:collapse">';
        if ($letter) {
            $html .= '<tr><td colspan="2" style="font-size:12px;color:#c32c2c;font-weight:bold; padding: 5px 0;">'.$letter.'</td></tr>';
        }
        if ($data) {
            foreach ($data as $key=>$value) {
                if (is_array($define) && $define[$key]) {
                    $key = $define[$key];
                }
                $html .= '<tr><td style="text-align:right;background:#f4f4f4;font-size:12px;font-weight:bold;padding:5px;border:1px solid #ccc">'.$key.'</td><td style="border:1px solid #ccc;padding:5px;font-size:12px;font-weight:bold">'.$value.'</td></tr>';
            }
        }
        return $html.'</table>';
    }
    public function genButton($link, $text)
    {
        return '<a target="_blank" href="'.$link.'" style="color: white;background-color: #35aa47;border: 0;padding: 7px 14px;font-size: 14px;cursor: pointer;line-height: 20px;text-decoration: none;">'.$text.'</a>';
    }
}
