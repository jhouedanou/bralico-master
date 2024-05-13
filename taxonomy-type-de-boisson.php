<?php get_header(); ?>
<div id='thumbnailpage'>
    <img src="<?php echo get_template_directory_uri(); ?>/img/banner-2-jpg.webp" alt="">
</div>
<main class="archive tax-type-de-boisson">

    <?php if (have_posts()) : ?>
    <header>
        <h1 class="crodie-mark"><?php single_term_title(); ?></h1>
    </header>
    <div id='product-row' class='row'>
        <?php while (have_posts()) : the_post(); ?>
        <div class='product col-md-4 col-xs-12'>
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
        <?php endwhile; ?>
    </div>
    <?php the_posts_navigation(); ?>

    <?php else : ?>
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>