<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Bralico
 */

get_header();
?>
<div id="pagecontent" class="container what theactual">
<?php 
                            if (isset($_COOKIE['user_logged_in'])) {
                                echo '<p class="safezone mouff white">Bon retour, <span class="roumba">' . $_COOKIE['user_login'] . '</span>!</p>';
                                if (!is_user_logged_in()) {
                                    include('formConnexionEmploi.php');
                                } else { ?>
	<div class="row">
        <div id="article" class="col-md-12">
            <main id="primary" class="site-main">

                <?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', get_post_type() );

						/* the_post_navigation(
							array(
								'prev_text' => '<span class="nav-subtitle">' . esc_html__( '<', 'bralico' ) . '</span> <span class="nav-title">%title</span>',
								'next_text' => '<span class="nav-subtitle">' .  '</span> <span class="nav-title">%title</span>'.esc_html__( ' >', 'bralico' ) ,
							)
						); */

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>
                <!-- bouton javascript qui ram_ne vers la page précédente -->
                <button id="juslikeme" onclick="goBack()" class="btn btn-primary">Retour</button>
            </main><!-- #main -->
        </div>
    </div>

	<?php }
                            } else { ?>
                                </div>
								<div class="col-md-12 welcomemessage">

                                <p class="mouff white">Votre espace personnel pour gérer votre candidature et postuler à nos offres.</p>
                                <div id="connexioncenter" class="row">
                                    <?php 
                                    include('creationDeCompte.php');
                                    include('formConnexionEmploi.php'); 
                                    ?>
                                </div>
								</div>
                            <?php } ?>
</div>

<?php
get_sidebar();
get_footer();