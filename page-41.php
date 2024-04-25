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
<div id="listedesmarques">
	<div class="contenudelapage">
	<?php 		
		while ( have_posts() ) :
		the_post();
	?>
				<?php the_content();?>

	<?php
		endwhile; 
	?>
    <div id="listedesmarques">
    <?php
        $args = array(
            'post_type' => 'produits',
            'posts_per_page' => -1,
        );
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                echo '<div class="product">';
                the_post_thumbnail('full');
                echo '<h2>' . get_the_title() . '</h2>';
                $prix_detail = get_field('prix_detail');
                if (!empty($prix_detail)) {
                    echo '<p>Prix détail : ' . $prix_detail . '</p>';
                }
                $format = get_field('format');
                if (!empty($format)) {
                    echo '<p>Format : ' . $format . '</p>';
                }
                $taux_alcool = get_field('taux_alcool');
                if (!empty($taux_alcool)) {
                    echo '<p>Taux d\'alcool : ' . $taux_alcool . '</p>';
                }
                echo '</div>';
            }
            wp_reset_postdata();
        } else {
            echo '<p>Aucun produit trouvé.</p>';
        }
        ?>
    </div>
	</div>
</div>



<?php
get_footer();
?>