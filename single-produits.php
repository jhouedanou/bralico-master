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

<main id='primary' class='site-main'>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php 
        $prev_post = get_previous_post(true);
        if (!empty($prev_post)) {
            echo '<a href="' . get_permalink($prev_post->ID) . '">Post précédent</a>';
        }

        $next_post = get_next_post(true);
        if (!empty($next_post)) {
            echo '<a href="' . get_permalink($next_post->ID) . '">Post suivant</a>';
        }
        ?>

    <div id='mainproduit' class='row'>
        <div id='informationprodiut' class='col-md-5 offset-md-1'>
            <div id='detailsurleproduit'>
                <div class='paddinzg'>
                    <h3><?php the_title(); ?></h3>

                    <?php
                        // the_content();
                        // Apply content filters manually
                        $content = apply_filters('the_content', get_the_content());
                        echo $content;
                        ?>

                    <div id='moain'>
                        <?php
                            $post_id = get_the_ID();
                            $style = get_post_meta($post_id, 'style', true);
                            $gout = get_post_meta($post_id, 'gout', true);
                            $date_creation = get_post_meta($post_id, 'date_creation', true);
                            $taux_alcool = get_post_meta($post_id, 'taux_alcool', true);
                            $ingredients = get_post_meta($post_id, 'ingredients', true);
                            $format = get_post_meta($post_id, 'format', true);
                            $prix_detail = get_post_meta($post_id, 'prix_detail', true);
                            $prix_grossiste = get_post_meta($post_id, 'prix_grossiste', true);

                            if (!empty($style)) {
                                echo '<p><span class="kendrick">Style :</span> ' . esc_html($style) . '</p>';
                            }
                            if (!empty($gout)) {
                                echo '<p><span class="kendrick">Goût :</span> ' . esc_html($gout) . '</p>';
                            }
                            if (!empty($date_creation)) {
                                echo '<p><span class="kendrick">Date de création :</span> ' . esc_html($date_creation) . '</p>';
                            }
                            if (!empty($taux_alcool)) {
                                echo '<p><span class="kendrick">Taux d\'alcool :</span> ' . esc_html($taux_alcool) . '%</p>';
                            }
                            if (!empty($ingredients)) {
                                echo '<p><span class="kendrick">Ingrédients :</span> ' . esc_html($ingredients) . '</p>';
                            }
                            if (!empty($format)) {
                                echo '<p><span class="kendrick">Format :</span> ' . esc_html($format) . 'cl</p>';
                            }
                            if (!empty($prix_detail)) {
                                echo '<p><span class="kendrick">Prix détail :</span> ' . esc_html($prix_detail) . ' FCFA </p>';
                            }
                            if (!empty($prix_grossiste)) {
                                echo '<p><span class="kendrick">Prix grossiste :</span> ' . esc_html($prix_grossiste) . ' FCFA </p>';
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="visuelproduit" class="col-md-6">
            <div class="dflex">
                <?php if (has_post_thumbnail()) {
                        $thumbnail_id = get_post_thumbnail_id();
                        $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'visuelproduit')[0];
                        $full_image_url = wp_get_attachment_image_src($thumbnail_id, 'full')[0];
                        ?>
                <a href="#" data-toggle="modal" data-target="#myModal">
                    <img src="<?php echo $thumbnail_url; ?>" alt="Thumbnail">
                </a>

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="<?php echo $full_image_url; ?>" alt="Full Image">
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php endwhile;
    wp_reset_postdata();
    endif; ?>
</main>

<div id="pagenavigatio">
    <?php 
    //recupere la liste de tous les produits , ainsi que l'id du produit actuel. Afficher les produits precedents et suivants ainsi que le lien vers la page d'accueil
    $all_products = get_posts(array('post_type' => 'produits', 'numberposts' => -1));
    $current_product_id = get_the_ID();
    $previous_product = null;
    $next_product = null;
    $previous_product_id = null;
    $next_product_id = null;
    foreach ($all_products as $key => $product) {
        if ($product->ID == $current_product_id) {
            if ($key > 0) {
                $previous_product = $all_products[$key - 1];
                $previous_product_id = $previous_product->ID;
            }
            if ($key < count($all_products) - 1) {
                $next_product = $all_products[$key + 1];
                $next_product_id = $next_product->ID;
            }
            break;
        }
    }
    ?>

    <div id="navigationentrelesposts" class="row">
        <div id="previousarticle" class="col-md-5 ">
            <?php
            if ($previous_product_id) {
                echo '<a href="' . get_permalink($previous_product_id) . '"><span class="material-symbols-outlined">arrow_back_ios</span>&nbsp;Produit précédent</a>';
            }
            ?>
        </div>
        <div id="retouralaccueil" class='col-md-2'>
            <a href="<?php echo get_permalink(41); ?>">
                <!-- link to image icon.png in the wordpress img , in the theme folder -->
                <img src="<?php echo get_template_directory_uri(); ?>/img/icon.png" alt="icon">
            </a>
        </div>
        <div id="nextarticle" class='col-md-5'>
            <?php
            if ($next_product_id) {
                echo '<a href="' . get_permalink($next_product_id) . '">Produit suivant&nbsp;<span class="material-symbols-outlined">arrow_forward_ios</span></a>';
            }
            ?>
        </div>
    </div>
</div>

<?php
get_sidebar();
get_footer();