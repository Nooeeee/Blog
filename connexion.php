<?php require_once("header.php"); ?>
<?php
    $msgErreurMail = null;
    $msgErreurMdp = null;
    $emailValide = false;

    if( !empty($_POST) ) {
        if( isset($_POST['email']) && !empty($_POST['email']) ) {
            if ( mb_strlen($_POST['email']) > 12 ) { // (@gmail.com = 10 | 3 = nom)
                if ( str_contains($_POST['email'], "@gmail.com") ) {
                    $emailValide = true;
                    $_SESSION['email'] = htmlspecialchars($_POST['email']);
                } else {
                    $msgErreurMail = "L'adresse email n'est pas valide.";
                }
            } else {
                $msgErreurMail = "L'adresse email doit contenir au moins 3 caractères";
            }
        }

        if ( $emailValide ){
            if ( isset($_POST['mdp']) && !empty($_POST['mdp']) ) {
                if ( mb_strlen($_POST['mdp']) >= 5 ) {
                    $mail = mb_strstr($_POST['email'], '@', true);

                    if ( !str_contains($_POST['mdp'], $mail) ) {
                        $_SESSION['mdp'] = htmlspecialchars($_POST['mdp']);
                    } else {
                        $msgErreurMdp = "Le mot de passe ne doit pas contenir l'adresse email.";
                    }
                } else {
                    $msgErreurMdp = "Le mot de passe doit contenir au moins 5 caractères";
                }
            }
        }
    } else {
        session_destroy();
    }

    if( isset($_SESSION['email']) && isset($_SESSION['mdp']) ) {
        $connexion = getConnexion();
        saveUser($connexion);

        unset($_SESSION['email']);
        unset($_SESSION['mdp']);
    }
?>
    <div>
        <h1>Connexion</h1>
        <h3>Saisissez vos informations de connexion</h3>

        <form method="POST">
            <label>
                Email :
                <input type="text" name="email" placeholder="Email">
                <?php showMsgErreur($msgErreurMail, 'red', FontStyle::ITALIC); ?>
            </label>
            <br/>
            <label>
                Mot de passe :
                <input type="password" name="mdp" placeholder="Mot de passe" >
                <?php showMsgErreur($msgErreurMdp, 'red', FontStyle::ITALIC); ?>
            </label>
            <br/>

            <button type="submit">Se connecter</button>
        </form>
    </div>
    <br/>

<?php
    require_once("footer.php");
?>