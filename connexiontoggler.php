<div class="mouff">
    <div id="connecion" class="row">
        <?php 
        if (!is_user_logged_in()) {
            //si l'utilisateur n'est pas connecté au site web,affciher le formulaire de connexion
            include('formCreation.php');
    ?>

        <?php 
        }else{
            //si l'utilisateur est onnecté au site web, afficher le formulaie de connexion et les oofres d'emploi disponibles
            include('formConnexionEmploi.php');
    ?>

        <div id="bienvenue">
            <div class="row">
                <div class="col">
                    <?php echo do_shortcode('[forminator_form id="15636"]'); ?>
                </div>
            </div>

            <h2><?php echo __('Bienvenue', 'bralico'); ?>&nbsp;<?php echo wp_get_current_user()->user_login; ?> !
            </h2>
            <div class="row">
                <div class="col">
                    <a href="<?php echo get_permalink('304'); ?>"><?php echo __('Uploader votre CV', 'bralico'); ?></a>
                </div>
                <div class="col">
                    <!-- afficher le bouton de déconnexion avec un lien ramenant à la page 290-->
                    <a href="<?php echo wp_logout_url(home_url()); ?>"
                        class="deconnexion"><?php echo __('Déconnexion', 'bralico'); ?></a>
                </div>
            </div>
        </div>

        <?php 
        }
    ?>
    </div>

</div>