<div id="ilauncompte" class="col-md-6 col-xs-12">
    <div class="gbox">
        <p class="mello">2</p>
        <h4>Vous avez déjà un compte ?</h4>
        <ul>
            <li>Connectez-vous pour mettre à jour votre CV et postuler aux offres.</li>
            <li>Gérez vos candidatures et suivez leur avancement.</li>
        </ul>

        <button id="open-login-modal">Se connecter</button>
        <div id="login-modal" title="J'ai un compte" style="display: none;">
            <?php
                echo 'Veuillez vous connecter pour postuler aux offres d\'emploi.';
                wp_login_form();
            ?>
        </div>
    </div>
</div>
