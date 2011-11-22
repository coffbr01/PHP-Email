<?php

/*   
Usage   
=====   
    set $this->to
    set $this->subject
    set $this->message (with html tags)
    set $this->from (Optional)
    set $this->cc (this can be an array or a variable) (Optional)
    set $this->bcc (this can be an array or a variable) (Optional)
    set $this->reply_to (Optional)
    set $this->return_path (Optional)
    set $this->x_mailer (Optional)
    set $this->attach_name (this can be an array or a variable) (Optional)
    set $this->attach_file_name (this can be an array or a variable, must correspond to attach_name) (Optional)

    $this->SendMail();

This function returns an array of 2 elements which e[0] = true (on success) or false and e[1] = message
*/

class EMail {
    var $to;
    var $from;
    var $cc;
    var $bcc;
    var $reply_to;
    var $return_path;
    var $x_mailer;
    var $subject;
    var $message;
    var $attach_file_name;

    function EMail() {
        $this->to = "";
        $this->subject = "";
        $this->message = "";
        $this->from = "Administrator <admin@" . $_SERVER['SERVER_NAME'] . ">";
        $this->cc = "";
        $this->bcc = "";
        $this->reply_to = $this->from;
        $this->return_path = $this->from;
        $this->x_mailer = "PHP v" . phpversion();
        $this->attach_name = "";
        $this->attach_file_name = "";
    }

    // Setters.
    function setTo($to) {
        $this->to = $to;
    }
    function setSubject($subject) {
        $this->subject = $subject;
    }
    function setMessage($message) {
        $this->message = $message;
    }
    function setFrom($from) {
        $this->from = $from;
    }
    function setCC($cc) {
        $this->cc = $cc;
    }
    function setBCC($bcc) {
        $this->bcc = $bcc;
    }
    function setReplyTo($replyTo) {
        $this->reply_to = $replyTo;
    }
    function setReturnPath($returnPath) {
        $this->return_path = $returnPath;
    }
    function setAttachFileName($attachFileName) {
        $this->attach_file_name = $attachFileName;
    }
    function setAttachName($attachName) {
        $this->attach_name = $attachName;
    }

    function makeFileName ($url) {
        $pos=true;
        $PrePos=0;
        while (!$pos==false) {
            $pos = strpos($url,'\\',$PrePos);
            if ($pos===false) {
                $temp = substr($url,$PrePos);
            }
            else {
                $PrePos = $pos + 1;
            }
        }
        return $temp;
    }

    function processAttachment() {
        if(is_array($this->attach_file_name)) {
            $s = sizeof($this->attach_file_name);
            for($i=0; $i<$s; $i++) {
                if($this->attach_file_name[$i] != "") {
                    $handle = fopen($this->attach_file_name[$i], 'rb');
                    $file_contents = fread($handle, filesize($this->attach_file_name[$i]));
                    $Attach['contents'][$i] = chunk_split(base64_encode($file_contents));
                    fclose($handle);
                    $Attach['file_name'][$i] = $this->makeFileName ($this->attach_name[$i]);
                    $pos=true;
                    $PrePos=0;
                    while (!$pos==false) {
                        $pos = strpos($this->attach_file_name[$i], '.', $PrePos);
                        if ($pos===false) {
                            $Attach['file_type'][$i] = substr($this->attach_file_name[$i], $PrePos);
                        }
                        else {
                            $PrePos = $pos+1;
                        }
                    }
                }
            }
            return $Attach;
        }
        else {
            $handle = fopen($this->attach_file_name, 'rb');
            $file_contents = fread($handle, filesize($this->attach_file_name));
            $Attach['contents'][0] = chunk_split(base64_encode($file_contents));
            fclose($handle);
            $Attach['file_name'][0] = $this->makeFileName ($this->attach_name);
            $pos=true;
            $PrePos=0;
            while (!$pos==false) {
                $pos = strpos($this->attach_file_name, '.', $PrePos);
                if ($pos===false) {
                    $Attach['file_type'][0] = substr($this->attach_file_name, $PrePos);
                }
                else {
                    $PrePos = $pos+1;
                }
            }
        }
        return $Attach;
    }

    function validateMailAddress($MAddress) {
        if (eregi("@", $MAddress) && eregi(".", $MAddress)) {
            return true;
        }
        else {
            return false;
        }
    }

    function Validate() {
        if(is_array($this->to)) {
            $msg[0] = false;
            $msg[1] = "You should provide only one receiver email address";
            return $msg;
        }
        if(is_array($this->from)) {
            $msg[0] = false;
            $msg[1] = "You should provide only one sender email address";
            return $msg;
        }
        if($this->to == "") {
            $msg[0] = false;
            $msg[1] = "You should provide a receiver email address";
            return $msg;
        }
        if($this->subject == "") {
            $msg[0] = false;
            $msg[1] = "You should provide a subject for your email";
            return $msg;
        }
        if($this->message == "") {
            $msg[0] = false;
            $msg[1] = "You should provide message for your email";
            return $msg;
        }
        if(!$this->validateMailAddress($this->to)) {
            $msg[0] = false;
            $msg[1] = "Receiver E-Mail Address is not valid";
            return $msg;
        }
        if(!$this->validateMailAddress($this->from)) {
            $msg[0] = false;
            $msg[1] = "Sender E-Mail Address is not valid";
            return $msg;
        }
        if(is_array($this->cc)) {
            $s = sizeof($this->cc);
            for($i=0; $i<$s; $i++) {
                if(!$this->validateMailAddress($this->cc[$i]) && $this->cc[$i] != "") {
                    $msg[0] = false;
                    $msg[1] = $this->cc[$i] . " is not a valid E-Mail Address";
                    return $msg;
                }
            }
        }
        else {
            if(!$this->validateMailAddress($this->cc) && $this->cc[$i] != "") {
                $msg[0] = false;
                $msg[1] = "CC E-Mail Address is not valid";
                return $msg;
            }
        }
        if(is_array($this->bcc)) {
            $s = sizeof($this->bcc);
            for($i=0; $i<$s; $i++) {
                if(!$this->validateMailAddress($this->bcc[$i]) && $this->bcc[$i] != "") {
                    $msg[0] = false;
                    $msg[1] = $this->bcc[$i] . " is not a valid E-Mail Address";
                    return $msg;
                }
            }
        }
        else {
            if(!$this->validateMailAddress($this->bcc) && $this->bcc[$i] != "") {
                $msg[0] = false;
                $msg[1] = "BCC E-Mail Address is not valid";
                return $msg;
            }
        }
        if(is_array($this->reply_to)) {
            $msg[0] = false;
            $msg[1] = "You should provide only one Reply-to address";
            return $msg;
        }
        else {
            if(!$this->validateMailAddress($this->reply_to)) {
                $msg[0] = false;
                $msg[1] = "Reply-to E-Mail Address is not valid";
                return $msg;
            }
        }
        if(is_array($this->return_path)) {
            $msg[0] = false;
            $msg[1] = "You should provide only one Return-Path address";
            return $msg;
        }
        else {
            if(!$this->validateMailAddress($this->return_path)) {
                $msg[0] = false;
                $msg[1] = "Return-Path E-Mail Address is not valid";
                return $msg;
            }
        }
        $msg[0] = true;
        return $msg;
    }

    function SendMail() {
        $mess = $this->Validate();
        if(!$mess[0]) {
            return $mess;
        }

        # Common Headers
        $headers  = "From: " . $this->from . "\r\n";
        $headers .= "To: <" . $this->to . ">\r\n";

        if(is_array($this->cc)) {
            $headers .= "Cc: " . implode(", ", $this->cc) . "\r\n";
        }
        else {
            if($this->cc != "") {
                $headers .= "Cc: " . $this->cc . "\r\n";
            }
        }

        if(is_array($this->bcc)) {
            $headers .= "BCc: " . implode(", ", $this->bcc) . "\r\n";
        }
        else {
            if($this->bcc != "") {
                $headers .= "BCc: " . $this->bcc . "\r\n";
            }
        }

        // these two to set reply address
        $headers .= "Reply-To: " . $this->reply_to . "\r\n";
        $headers .= "Return-Path: " . $this->return_path . "\r\n";

        // these two to help avoid spam-filters
        $headers .= "Message-ID: <message-on " . date("d-m-Y h:i:s A") . "@".$_SERVER['SERVER_NAME'].">\r\n";
        $headers .= "X-Mailer: " . $this->x_mailer . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";

        # Tell the E-Mail client to look for multiple parts or chunks
        $headers .= "Content-type: multipart/mixed; boundary=AttachMail0123456\r\n";

        # Message Starts here
        $msg  = "--AttachMail0123456\r\n";

        $msg .= "Content-type: multipart/alternative; boundary=AttachMail7890123\r\n\r\n";
        $msg .= "--AttachMail7890123\r\n";

        $msg .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
        $msg .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";

        $msg .= strip_tags($this->message) . "\r\n";

        $msg .= "--AttachMail7890123\r\n";

        $msg .= "Content-Type: text/html; charset=iso-8859-1\r\n";
        $msg .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";

        $msg .= "<html><head></head><body>" . $this->message . "</body></html>\r\n";

        $msg .= "--AttachMail7890123--\r\n";


        if($this->attach_file_name != "" || is_array($this->attach_file_name)) {
            $Attach = $this->processAttachment();

            $s = sizeof($Attach['file_name']);
            for($i=0; $i<$s; $i++) {
                # Start of Attachment chunk
                $msg .= "--AttachMail0123456\r\n";

                // This API is deprecated ... might need to switch it in the future.
                $mimeType = mime_content_type($Attach['file_name']);

                $msg .= "Content-Type: " . $mimeType . "; name=" . $Attach['file_name'][$i] . "\r\n";
                $msg .= "Content-Transfer-Encoding: base64\r\n";
                $msg .= "Content-Disposition: attachment; filename=" . $Attach['file_name'][$i] . "\r\n\r\n";

                $msg .= $Attach['contents'][$i] . "\r\n";
            }
        }

        $msg .= "--AttachMail0123456--";

        $result = mail($this->to, $this->subject, $msg, $headers);
        if ($result) {
            $mess[0] = true;
            $mess[1] = "Mail Successfully delivered";
        }
        else {
            $mess[0] = false;       
            $mess[1] = "Mail can not be send this time. Please try latter.";
        }
        return $mess;
    }
}
?>

