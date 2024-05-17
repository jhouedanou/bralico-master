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
<div id='accueil' class='homepage'>
    <div id='sliderwrapper' class='carousel slide' data-ride='carousel'>
        <ol class='carousel-indicators'>
            <?php
            $args = array(
                'post_type' => 'Diapositives',
                'showposts' => 6,
            );
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) {
                $i = 0;
                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    $active = '';
                    if ($i == 0) {
                        $active = 'active';
                    }
                    echo '<li data-target="#sliderwrapper" data-slide-to="' . $i . '" class="' . $active . '"></li>';
                    $i++;
                }
            }
            wp_reset_postdata();
            ?>
        </ol>
        <div id="negromuffin" class='carousel-inner'>
            <?php
            $args = array(
                'post_type' => 'Diapositives',
                'posts_per_page' => -1,
            );
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) {
                $i = 0;
                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    $active = '';
                    if ($i == 0) {
                        $active = 'active';
                    }
                    echo '<div class="carousel-item ' . $active . '">';
                    the_post_thumbnail('full');
                    echo '</div>';
                    $i++;
                }
            }
            wp_reset_query(); // Remember to reset

            wp_reset_postdata();
            ?>
        </div>
    </div>

    <div id="chiffrescles">
        <div id="contenuchiffrecls">
            <div id="chiffreclewrapper" class="row">
                <div class="col">
                    <?php if (is_active_sidebar('chiffre-cle-1')): ?>
                    <div id="chiffre-cle-1" class="chiffre-cle-1 widget-area" role="complementary">
                        <?php dynamic_sidebar('chiffre-cle-1');?>
                    </div><!-- #primary-sidebar -->
                    <?php endif;?>
                </div>
                <div class="col">
                    <?php if (is_active_sidebar('chiffre-cle-2')): ?>
                    <div id="chiffre-cle-2" class="chiffre-cle-2 widget-area" role="complementary">
                        <?php dynamic_sidebar('chiffre-cle-2');?>
                    </div><!-- #primary-sidebar -->
                    <?php endif;?>
                </div>
                <div class="col">
                    <?php if (is_active_sidebar('chiffre-cle-3')): ?>
                    <div id="chiffre-cle-3" class="chiffre-cle-3 widget-area" role="complementary">
                        <?php dynamic_sidebar('chiffre-cle-3');?>
                    </div><!-- #primary-sidebar -->
                    <?php endif;?>
                </div>
                <div class="col">
                    <?php if (is_active_sidebar('chiffre-cle-4')): ?>
                    <div id="chiffre-cle-4" class="chiffre-cle-4 widget-area" role="complementary">
                        <?php dynamic_sidebar('chiffre-cle-4');?>
                    </div><!-- #primary-sidebar -->
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>

    <div id="actualites" class="homepage">
        <div id="contenuactualites">
            <?php if (is_active_sidebar('titre-actualites')): ?>
            <div id="titre-actualites" class="titre-actualites widget-area bralico-title" role="complementary">
                <?php dynamic_sidebar('titre-actualites');?>
            </div><!-- #primary-sidebar -->
            <?php endif;?>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Précédent</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Suivant</span>
                </a>
                <div class="carousel-inner">

                    <?php
                    $args = array('post_type' => 'post', 'posts_per_page' => 6);
                    $loop = new WP_Query($args);
                    $i = 0;
                    while ($loop->have_posts()): $loop->the_post();
                        if ($i % 3 == 0) { // div start for every 3 items
                            echo '<div class="carousel-item';
                            if ($i == 0) {
                                echo ' active';
                            }
                            echo '"><div class="row">';
                        }
                        ?>
                    <div class="japz col-md-4 col-sm-12 col-xs-12">
                        <a class="hassdiesel" href="<?php the_permalink();?>">
                            <?php the_post_thumbnail('actuhomepage', ['class' => 'd-block w-100 mpa']);?>
                            <div class="labouche">
                                <div class="jour">
                                    <?php
                                        $date = get_the_date('d');
                                        echo $date;
                                        ?>
                                </div>
                                <div class="mois">
                                    <?php
                                        $dated = get_the_date('M');
                                        echo $dated;
                                        ?>
                                </div>
                                <div class="annee">
                                    <?php
                                        $dateds = get_the_date('Y');
                                        echo $dateds;
                                        ?>
                                </div>
                            </div>
                            <div class="obvf d-md-block">
                                <h5><?php the_title();?></h5>
                                <p><?php the_excerpt();?></p>
                            </div>
                        </a>
                    </div>
                    <?php
                        if ($i % 3 == 2) { // div end for every 3 items
                            echo '</div></div>';
                        }
                        $i++;
                    endwhile;
                    if ($i % 3 != 0) { // end last item if not a complete group of 3
                        echo '</div></div>';
                    }
                    ?>
                </div>

                <!-- lien vers la catégorie avec un id 5 -->
                <a href="<?php echo get_category_link(5); ?>" class="btn btn-primary">Plus d'actualités</a>
            </div>
        </div>
        <div id="valeurdumoisdumai">
            <div class="innerz">
                <?php if (is_active_sidebar('valeur-du-mois')): ?>
                <div id="valeur-du-mois" class="valeur-du-mois widget-area" role="complementary">
                    <?php dynamic_sidebar('valeur-du-mois');?>
                </div>
                <?php endif;?>
            </div>
        </div>
        <div id="homepageproductwrapper">
            <div id="homepageproduct">
                <div id="contenuhomepageproduct">
                    <?php if (is_active_sidebar('titre-produits')): ?>
                    <div id="titre-produits" class="titre-produits widget-area bralico-title" role="complementary">
                        <?php dynamic_sidebar('titre-produits');?>
                    </div><!-- #primary-sidebar -->
                    <?php endif;?>
                    <div id="mayi" class="row no-gutter">
                        <?php
                    $terms = get_terms(
                        array(
                            'taxonomy' => 'type-de-boisson',
                            'hide_empty' => false,
                        )
                    );
                    if (!empty($terms) && is_array($terms)) {
                        foreach ($terms as $term) {
                            $term_link = get_term_link($term);
                            $type_de_boisson_image = get_term_meta($term->term_id, 'type_de_boisson_image', true);
                            ?>

                        <a class="col m-0 p-0" href="<?php echo $term_link; ?>">
                            <span class="responsive-img img-fluid"
                                style="background-image: url('<?php echo $type_de_boisson_image; ?>');"></span>
                        </a>

                        <?php
                        }
                    }
                    ?>
                        <?php wp_reset_query();?>
                    </div>

                </div>
            </div>
        </div>
        <div id="bralicocitywrapper">
            <div id="bralicocuty">
                <div class="row">
                    <div id="textebralico" class="col-md-5 col-sm-12 col-xs-12">
                        <div class="row">
                            <?php dynamic_sidebar('pub-bralico-texte');?>

                            <div class="col">
                                <?php dynamic_sidebar('pub-bralico-playstore');?>
                            </div>
                            <div class="col">
                                <?php dynamic_sidebar('pub-bralico-appstore');?>
                            </div>
                        </div>
                    </div>
                    <div id="decoapp" class="col-md-7 col-sm-12 col-xs-12">
                        <?php dynamic_sidebar('pub-bralico');?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    get_footer();
    ?>