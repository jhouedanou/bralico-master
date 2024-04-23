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

<main id="primary" class="site-main">
    <?php
while (have_posts()):
    the_post();

    get_template_part('template-parts/content', 'produits');
// Assurez-vous d'avoir l'ID du post
    $post_id = get_the_ID();

// Utilisez get_post_meta pour obtenir la valeur du champ personnalisé
    $style = get_post_meta($post_id, 'style', true);
    $gout = get_post_meta($post_id, 'gout', true);
    $date_creation = get_post_meta($post_id, 'date_creation', true);
    $taux_alcool = get_post_meta($post_id, 'taux_alcool', true);
    $ingredients = get_post_meta($post_id, 'ingredients', true);
    $format = get_post_meta($post_id, 'format', true);
    $prix_detail = get_post_meta($post_id, 'prix_detail', true);
    $prix_grossiste = get_post_meta($post_id, 'prix_grossiste', true);

    // Affichez les valeurs

    if (!empty($style)) {
        echo '<p><span class="kendrick">Style:</span> ' . esc_html($style) . '</p>';
    }
    if (!empty($gout)) {
        echo '<p><span class="kendrick">Goût:</span> ' . esc_html($gout) . '</p>';
    }
    if (!empty($date_creation)) {
        echo '<p><span class="kendrick">Date de création:</span> ' . esc_html($date_creation) . '</p>';
    }
    if (!empty($taux_alcool)) {
        echo '<p><span class="kendrick">Taux d\'alcool:</span> ' . esc_html($taux_alcool) . '</p>';
    }
    if (!empty($ingredients)) {
        echo '<p><span class="kendrick">Ingrédients:</span> ' . esc_html($ingredients) . '</p>';
    }
    if (!empty($format)) {
        echo '<p><span class="kendrick">Format:</span> ' . esc_html($format) . '</p>';
    }
    if (!empty($prix_detail)) {
        echo '<p><span class="kendrick">Prix détail:</span> ' . esc_html($prix_detail) . '</p>';
    }
    if (!empty($prix_grossiste)) {
        echo '<p><span class="kendrick">Prix grossiste:</span> ' . esc_html($prix_grossiste) . '</p>';
    }

    the_post_navigation(
        array(
            'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'bralico') . '</span> <span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'bralico') . '</span> <span class="nav-title">%title</span>',
        )
    );

    // If comments are open or we have at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()):
        comments_template();
    endif;

endwhile; // End of the loop.
?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();