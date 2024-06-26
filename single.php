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
<div id="pagecontent" class="container-fluid what">
    <div class="row">
        <div id="article" class="col-md-12">


            <main id="primary" class="site-main">

                <?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', get_post_type() );

		the_post_navigation(
			array(
				'prev_text' => '<span class="nav-subtitle">' . esc_html__( '<', 'bralico' ) . '</span> <span class="nav-title">%title</span>',
				'next_text' => '<span class="nav-subtitle">' .  '</span> <span class="nav-title">%title</span>'.esc_html__( ' >', 'bralico' ) ,
			)
		);

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile; // End of the loop.
	?>

            </main><!-- #main -->
        </div>
    </div>
</div>

<?php
get_sidebar();
get_footer();