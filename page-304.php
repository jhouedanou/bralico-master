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
    <?php the_post_thumbnail('full');?>
</div>
<div id="pagecontent">
    <div class="contenudelapage">
        <?php 		
		while ( have_posts() ) :
		the_post();
	?>
        <h1><?php //the_title();?></h1>
        <?php //0he_content();?>
        <?php
            if (!is_user_logged_in()) { // Si l'utilisateur n'est pas connecté
                // php include connexionforms.php
                include('connexionforms.php');
            } else {
                ?>
        <?php echo __('Liste des offres d\'emploi', 'bralico'); ?>
        <div class="row">
            <div class="col">
                <a href="<?php echo get_permalink('290');?>"><?php echo __('Allez au pôle emploi','bralico');?></a>
            </div>
            <div class="col">
                <!-- afficher le bouton de déconnexion avec un lien ramenant à la page 290-->
                <a href="<?php echo wp_logout_url( home_url() ); ?>"
                    class=" deconnexion"><?php echo __('Déconnexion','bralico');?></a>
            </div>
        </div>

        <?php 
            
            }?>
        <?php
		endwhile; 
	?>
    </div>
</div>



<?php
get_footer();
?>