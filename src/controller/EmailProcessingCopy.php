<?php

// We check that the POST method is used 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // We check if the "recaptcha-response" field contains a value 
    if (empty($_POST['recaptcha-response'])) {
        header('Location: index.php');
    } else {
        // We prepare the URL 
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=votre code secret ici&response={$_POST['recaptcha-response']}";

        // We check if curl is installed 
        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
        } else {
            $response = file_get_contents($url);
        }

        // We check that we have an answer 
        if (empty($response) || is_null($response)) {
            header('Location: index.php');
        } else {
            $data = json_decode($response);
            if ($data->success) {
                if (
                    isset($_POST['nom']) && !empty($_POST['nom']) &&
                    isset($_POST['sujet']) && !empty($_POST['sujet']) &&
                    isset($_POST['email']) && !empty($_POST['email']) &&
                    isset($_POST['message']) && !empty($_POST['message'])
                ) {
                    // We clean the content 
                    $nom = strip_tags($_POST['nom']);
                    $sujet = strip_tags($_POST['sujet']);
                    $email = strip_tags($_POST['email']);
                    $message = htmlspecialchars($_POST['message']);
                }
            } else {
                header('Location: index.php');
            }
        }
    }
} else {
    http_response_code(405);
    echo 'Méthode non autorisée';
}


if ($_POST) {
    $email = 'votre email ici';

    $headers = 'MINE-Version: 1.0' . "\r\n";

    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

    $headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";

    $headers .= "From: $email" . "\r\n" . "Reply-To:$email" . "\r\n";

    $_POST['message'] = "De: $_POST[email] <br>Date: " . date('d/m/Y H:i:s') . "<br>Nom: $_POST[nom] <hr>Objet: $_POST[sujet] <hr>$_POST[message]";

    mail($email, $_POST['sujet'], $_POST['message'], $headers);
}
