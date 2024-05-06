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
get_header(); ?>

<div id='thumbnailpage'>
    <?php the_post_thumbnail("full"); ?>
</div>

<div id='pagecontent'>
    <div class='contenudelapage'>
        <?php while (have_posts()):
            the_post(); ?>
        <div class="crodie">

            <?php the_content(); ?>
        </div>
        <?php
        endwhile; ?>
    </div>
</div>

<div id='product-row' class='row'>
    <?php
    $paged = get_query_var("paged") ? get_query_var("paged") : 1;
    $args = [
        "post_type" => "produits",
        "posts_per_page" => 12,
        "paged" => $paged,
    ];
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post(); ?>
    <div class='product col-md-3 col-xs-12'>
        <div class="paddingz">
            <a href='<?php the_permalink(); ?>' class="nza">
                <?php if (has_post_thumbnail()) {
                        the_post_thumbnail("salif");
                    } ?>
            </a>
            <div class="product-card">
                <?php
                    //variables
                    $post_id = get_the_ID();
                    $style = get_post_meta($post_id, "style", true);
                    $gout = get_post_meta($post_id, "gout", true);
                    $date_creation = get_post_meta(
                        $post_id,
                        "date_creation",
                        true
                    );
                    $taux_alcool = get_post_meta($post_id, "taux_alcool", true);
                    $ingredients = get_post_meta($post_id, "ingredients", true);
                    $format = get_post_meta($post_id, "format", true);
                    $prix_detail = get_post_meta($post_id, "prix_detail", true);
                    $prix_grossiste = get_post_meta(
                        $post_id,
                        "prix_grossiste",
                        true
                    );
                    ?>
                <div class="row">
                    <div class="col col-md-8 infodroite">
                        <div class="zepad">
                            <h2><?php the_title(); ?></h2>

                            <div class="tyler">
                                <?php echo "<p>" . esc_html($format) . "</p>"; ?>
                                <?php if (!empty($taux_alcool)) {
                                            echo "<p>&nbsp;" . "|&nbsp;" . esc_html($taux_alcool) . " %";
                                        } ?>
                            </div>
                        </div>

                    </div>
                    <?php if (!empty($prix_detail)) { ?>
                    <div class="col col-md-4 infogauche">
                        <p class="prixdetail"><?php echo $prix_detail; ?>FCFA</p>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>

    </div>
    <?php
        }
        // Pagination
        $big = 999999999; // need an unlikely integer
        echo paginate_links([
            "base" => str_replace($big, "%#%", esc_url(get_pagenum_link($big))),
            "format" => "?paged=%#%",
            "current" => max(1, get_query_var("paged")),
            "total" => $the_query->max_num_pages,
        ]);
    } else {
        echo "<p>Aucun produit trouvé.</p>";
    }
    wp_reset_postdata();
    ?>
</div>

<?php get_footer();
?>