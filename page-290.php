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
    <?php //wordpress post thumbnail
        if (has_post_thumbnail()) {
            the_post_thumbnail();
        }
     ?>
</div>

<div id="pagecontent">
    <div class="contenudelapage">
        <div id="section1poleemploi">
            <?php 		
            while ( have_posts() ) :
                the_post();
            ?>
            <?php //the_content(); ?>
            <?php
                if (!is_user_logged_in()) { // Si l'utilisateur n'est pas connecté
                    // formulaire de connexion
                    include('connexionforms.php');
                }
                ?>
            <?php if(is_user_logged_in()){?>
            <!-- afficher le nom d'utilisateur et un message de bienvenue -->
            <div id="bienvenue">
                <h2><?php echo __('Bienvenue','bralico'); ?><?php echo wp_get_current_user()->user_login; ?> !</h2>

                <div class="row">
                    <div class="col">
                        <a
                            href="<?php echo get_permalink('304');?>"><?php echo __('Allez à l\'espace candidat','bralico');?></a>
                    </div>
                    <div class="col">
                        <!-- afficher le bouton de déconnexion avec un lien ramenant à la page 290-->
                        <a href="<?php echo wp_logout_url( home_url() ); ?>"
                            class="deconnexion"><?php echo __('Déconnexion','bralico');?></a>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php endwhile; ?>
        </div>
        <div id="section2poleemploi">
            <div class="safezone">

                <?php include('emploicarousel.php');?>
                <a href="<?php echo get_permalink('119');?>">Voir plus</a>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>