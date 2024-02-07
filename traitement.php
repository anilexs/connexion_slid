<?php
require_once "database.php";
define("DOMAINNAME", "localhost");

if(isset($_POST['sign-In'])){
    $db = Database::dbConnect();
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

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

    list($header, $payload, $signature) = explode('.', $credential);

    $decodedHeader = base64_decode($header);
    $decodedPayload = base64_decode($payload);

    $headerData = json_decode($decodedHeader, true);
    $payloadData = json_decode($decodedPayload, true);

    $name = $payloadData['given_name'] ?? '';
    $email = $payloadData['email'] ?? '';
    $sub = $payloadData['sub'] ?? '';
    $hashedSub = password_hash($sub, PASSWORD_DEFAULT);

    $db = Database::dbConnect();
    $request = $db->prepare("SELECT google_sub FROM `user` WHERE google_email = ?");

    try {
        $request->execute(array($email));
        $userSub = $request->fetch(PDO::FETCH_ASSOC);
        $acount = (!empty($userSub)) ? true : false;
        if($acount){
            if(password_verify($sub, $userSub['google_sub'])){
                $request = $db->prepare("SELECT * FROM `user` WHERE google_email = ?");
                $request->execute(array($email));
                $userInfo = $request->fetch(PDO::FETCH_ASSOC);
                setcookie("user_id", $userInfo['id_user'], time() + 3600 * 5, "/", DOMAINNAME);
                echo 'connexion sucefull';
            }else{
                echo 'erreur de connexion <a href="connexion.html">page de connexion</a>';
            }
        }else{
            $request = $db->prepare("INSERT INTO user (google_email, google_sub) VALUES (?,?)");
            $request->execute(array($email, $hashedSub));
            $lastUserId = $db->lastInsertId();
            setcookie("user_id", $lastUserId, time() + 3600 * 5, "/", DOMAINNAME);
            echo 'inscription sucefull';
            
        }
        // echo $userSub['google_sub'];
        // setcookie("user_id", $lastUserId, time() + 3600 * 5, "/", DOMAINNAME);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    // echo "Nom: $name<br>";
    // echo "Email: $email<br>";
    // echo "sub: $sub<br>";
    // echo "sub hach: $hashedSub<br>";
}
