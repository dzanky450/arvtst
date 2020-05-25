<?php
header('Content-Type: text/html; charset=utf-8');

$to = 'info@arvisual.eu';

$subj     = 'New email from online form';
$email    = !empty($_POST['email']) ? htmlentities($_POST['email']) : "";
$message  = !empty($_POST['message']) ? htmlentities($_POST['message']) : "";

if (empty($subj) || empty($email) || empty($message)) {
    http_response_code(400);
    exit();
}

$headers = "From: demo@arvisual.eu" . "\r\n" .
           "Reply-To: $email" . "\r\n" .
           'X-Mailer: PHP/' . phpversion() .
           'MIME-Version: 1.0' . "\r\n" .
           'Content-Type: text/html; charset=utf-8' . "\r\n";

$txt = "<html>
        <body>
            <p><b>From:</b> " . $email . " <br><br>
            " . $message . "</p>
        </body>
            </html>";

mail($to, $subj, $txt, $headers);
?>