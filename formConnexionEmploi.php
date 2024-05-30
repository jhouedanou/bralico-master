<div id="espacecandidat" class="col-md-12">
    <div class="gbox">
        <!--widget titre espace candidat-->

        <div id="titreformulaireu">
            <?php 
                    if ( is_active_sidebar( 'titre-formulaire-connexion' ) ) {
                        dynamic_sidebar( 'titre-formulaire-connexion' );
                    }
                    ?>

        </div>
        <?php echo do_shortcode('[forminator_form id="303"]'); ?>
    </div>
</div>