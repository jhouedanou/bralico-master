<div id="connecion" class="row">
    <div id="espacecandidat" class="col">
        <!--widget titre espace candidat-->
        <div id="titreespacecandidat">
            <?php 
                            if ( is_active_sidebar( 'titre-espace-candidat' ) ) {
                                dynamic_sidebar( 'titre-espace-candidat' );
                            }
                            ?>
        </div>
        <div id="titreformulaireu">
            <?php 
                            if ( is_active_sidebar( 'titre-formulaire-connexion' ) ) {
                                dynamic_sidebar( 'titre-formulaire-connexion' );
                            }
                            ?>
        </div>

        <?php echo do_shortcode('[forminator_form id="303"]'); ?>
    </div>
    <div id="creationcompte" class="col">
        <?php 
                        if(is_active_sidebar('creation-compte')){
                            dynamic_sidebar('creation-compte');
                        }
                        ?>
        <?php echo do_shortcode('[forminator_form id="301"]'); ?>
    </div>
</div>