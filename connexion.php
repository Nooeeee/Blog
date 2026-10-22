<?php
    require_once("header.php");
?>
    <div>
        <h1>Connexion</h1>
        <h3>Saisissez vos informations de connexion</h3>

        <form method="POST">
            <label>
                Identifiant <i>(email)</i> :
                <input type="text" name="email" value="<?=  $_SESSION['email']??''; ?>"/>
            </label>
            <br/>
            <label>
                Mot de passe :
                <input type="password" name="motdepasse" value="<?= $_SESSION['mdp']??'' ?>"/>
            </label>
        </form>
        <button type="submit">Se connecter</button>
    </div>
    <br/>

<?php
    require_once("footer.php");
?>