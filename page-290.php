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
            <div class="mouff">
                <?php
                if (!is_user_logged_in()) { // Si l'utilisateur n'est pas connecté
                    // formulaire de connexion
                    include('connexionforms.php');
                }else{
                    ?>
                <!-- afficher le nom d'utilisateur et un message de bienvenue -->
            </div>

            <div id="bienvenue">
                <h2><?php echo __('Bienvenue','bralico'); ?>&nbsp;<?php echo wp_get_current_user()->user_login; ?> !
                </h2>
                <div class="row">
                    <div class="col">
                        <a href="<?php echo get_permalink('304');?>"><?php echo __('Uploader votre CV','bralico');?></a>
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
                <!--insert wordpress widget-->
                <?php dynamic_sidebar('notre-pole-emploi'); ?>
                <div id="naado" class="row">
                    <div class="col">
                        <a href="?page_id=119"><?php echo __('Offres','bralico'); ?></a>
                    </div>
                    <div class="col">
                        <a href="?page_id=304"><?php echo __('Candidature spontanée','bralico');?></a>
                    </div>
                </div>
                <div id="dad">
                    <?php include('emploicarousel.php');?>

                </div>
                <a id="jimmy" href="<?php echo get_permalink('119');?>">Voir plus</a>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>