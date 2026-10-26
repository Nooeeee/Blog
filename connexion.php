<?php
    require_once("init.php");

    $ErrorMsgMail = null;
    $ErrorMsgPwd = null;
    $isValidMail = false;
    $email = $_POST['email'] ?? '';
    $pseudo = null;

    getConnexion();
    if( isConnected() ){
        header("Location: blog.php");
        exit;
    }

    if( !empty($_POST) ) {
        if( isset($_POST['email']) && !empty($_POST['email']) ) {
            $email = $_POST['email'];
            if ( filter_var($email, FILTER_VALIDATE_EMAIL) ) {
                $isValidMail = true;
                $_SESSION['email'] = htmlspecialchars($email);
            } else {
                $ErrorMsgMail = "L'adresse email n'est pas valide.";
            }
        }

        if ( $isValidMail ) {
            if ( isset($_POST['pwd']) && !empty($_POST['pwd']) ) {
                if ( mb_strlen($_POST['pwd']) >= 5 ) {
                    $user = getUserByEmail($_SESSION['email']);
                    if ( $user ) {
                        if ( password_verify($_POST['pwd'], $user['mdp']) ) {
                            $_SESSION['userId'] = (int) $user['id'];
                            $_SESSION['isAdmin'] = (bool) $user['admin'];

                            header("Location: blog.php");
                            exit(0);
                        } else {
                            $ErrorMsgPwd = 'Mot de passe incorrecte.';
                        }
                    } else {
                        $pseudo = mb_strstr($_POST['email'], '@', true);
                        if ( !str_contains($_POST['pwd'], $pseudo) ) {
                            $_SESSION['pwd'] = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
                            $_SESSION['pseudo'] = $pseudo;
                            $_SESSION['isAdmin'] = false;
                        } else {
                            $ErrorMsgPwd = "Le mot de passe ne doit pas contenir l'adresse email.";
                        }
                    }
                } else {
                    $ErrorMsgPwd = "Le mot de passe doit contenir au moins 5 caractères.";
                }
            }
        }
    } else {
        session_unset();
    }

    if( isset($_SESSION['email']) && isset($_SESSION['pwd']) ) {
        $_SESSION['userId'] = createUser($_SESSION['email'], $_SESSION['pwd'], $_SESSION['pseudo'], $_SESSION['isAdmin']);

        unset($_SESSION['email']);
        unset($_SESSION['pwd']);
        header("Location: blog.php");
    }

    require_once("header.php");
?>
    <div>
        <h1>Inscription</h1>
        <h3>Saisissez vos informations de connexion</h3>

        <form method="POST">
            <label>
                Email :
                <input type="text" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>" required <?= empty($email) ? 'autofocus' : ''?>>
                <?php showMsgErreur($ErrorMsgMail, 'red', FontStyle::ITALIC); ?>
            </label>
            <br/>
            <label>
                Mot de passe :
                <input type="password" name="pwd" placeholder="Mot de passe" required <?= empty($email) ? '' : 'autofocus'?>>
                <?php showMsgErreur($ErrorMsgPwd, 'red', FontStyle::ITALIC); ?>
            </label>
            <br/>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
    <br/>

<?php
    require_once("footer.php");
?>