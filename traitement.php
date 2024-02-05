<?php
require_once "database.php";
define("DOMAINNAME", "localhost");


if(isset($_POST['sign-In'])){
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $db = Database::dbConnect();
    $request = $db->prepare("SELECT * FROM `user` WHERE email = ?");
    try {
        $request->execute(array($email));
        $user = $request->fetch(PDO::FETCH_ASSOC);
        if(empty($user)){
            // Aucun compte trouvé avec cet e-mail
            // Vous pouvez afficher un message d'erreur à l'utilisateur ici
        }else{
            // Vérifier le mot de passe
            if(password_verify($password, $user['password'])){
                // Mot de passe correct, définir le cookie, par exemple
                setcookie("user_id", $user['id_user'], time() + 3600 * 5, "/", DOMAINNAME);
                // Vous pouvez également rediriger l'utilisateur vers une page de succès, etc.
            }else{
                // Mot de passe incorrect
                // Vous pouvez afficher un message d'erreur à l'utilisateur ici
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if(isset($_POST['sign-up'])){
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    
    $db = Database::dbConnect();
    
    $requestVerify = $db->prepare("SELECT * FROM user WHERE name = ? OR email = ?");
    $request = $db->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $requestVerify->execute(array($name, $email));

    $userVerify = $requestVerify->fetch(PDO::FETCH_ASSOC);

    if(!empty($userVerify)){

    }else{
        try {
            $request->execute(array($name, $email, $passwordHash));
            
            $lastUserId = $db->lastInsertId();
            setcookie("user_id", $lastUserId, time() + 3600 * 5, "/", DOMAINNAME);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

if(isset($_POST['logout'])){
    setcookie("user_id", "", time() - 3600, "/", DOMAINNAME);
}

if (isset($_POST['credential'])) {
    $credential = $_POST['credential'];

    // Séparer le JWT en parties
    list($header, $payload, $signature) = explode('.', $credential);

    // Décoder les parties Base64
    $decodedHeader = base64_decode($header);
    $decodedPayload = base64_decode($payload);

    // Convertir les parties JSON en tableau associatif
    $headerData = json_decode($decodedHeader, true);
    $payloadData = json_decode($decodedPayload, true);

    // Afficher les informations de l'utilisateur
    $name = $payloadData['given_name'] ?? '';
    $family_name = $payloadData['family_name'] ?? '';
    $email = $payloadData['email'] ?? '';

    echo "Nom: $name<br>";
    echo "Prénom: $family_name<br>";
    echo "Email: $email<br>";
}
