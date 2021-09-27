<?php
require 'public/include/init.php';


if($_POST)
{
    $email = 'frederic.vanmarcke@free.fr';

    // MINE version 
    $headers = 'MINE-Version: 1.0' . "\r\n";

    // Content type and encoding 
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

    // Transport code 
    $headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";

    // entêtes d'email
    $headers .= "From: $email" . "\r\n" . "Reply-To:$email" . "\r\n";

    $_POST['message'] = "De: $_POST[email] <br>Date: " . date('d/m/Y H:i:s') . "<br>Nom: $_POST[nom] <hr>Objet: $_POST[sujet] <hr>$_POST[message]";

    mail($email, $_POST['sujet'], $_POST['message'], $headers);
}
?>
