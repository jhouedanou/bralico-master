<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bralico
 */
get_header();
?>

<div id="thumbnailpage">
    <div id="lepaddingdesteven"></div>
    <?php the_post_thumbnail('full'); ?>
</div>

<div id="pagecontent">
    <div class="contenudelapage">
        <?php 		
        while ( have_posts() ) :
            the_post();
        ?>
        <h1><?php //the_title(); ?></h1>
        <?php //the_content(); ?>
        <?php
            if (!is_user_logged_in()) { // Si l'utilisateur n'est pas connecté
            ?>
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
        <?php
            }
            ?>
        <?php if(is_user_logged_in()){
            ?>
        <h1>Yue</h1>
        <?php
            } ?>
        <?php
        endwhile; 
        ?>
    </div>
</div>

<?php
get_footer();
?>