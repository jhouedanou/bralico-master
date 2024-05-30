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

<div id="pagecontent" class="container-fluid">
    <div class="contenudelapage">
        <?php 		
		while ( have_posts() ) :
		the_post();
	?>
        <h1><?php the_title();?></h1>
        
        <?php the_content();?>
        <?php
		endwhile; 
	?>
    </div>
</div>



<?php
get_footer();
?>