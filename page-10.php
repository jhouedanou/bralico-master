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

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                        $args = array( 'post_type' => 'post', 'posts_per_page' => 6 );
                        $loop = new WP_Query( $args );
                        $i = 0;
                        while ( $loop->have_posts() ) : $loop->the_post();
                            if($i % 3 == 0) { // div start for every 3 items
                                echo '<div class="carousel-item';
                                if($i == 0) echo ' active';
                                echo '"><div class="row">';
                            }
                        ?>
                    <div class="col-md-4">
                        <?php the_post_thumbnail('full', ['class' => 'd-block w-100']); ?>
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
                                    $dateds = get_the_date('M');  
                                    echo $dateds;
                                ?>
                            </div>

                        </div>

                        <div class="obvf d-none d-md-block">
                            <h5><?php the_title(); ?></h5>
                            <p><?php the_excerpt(); ?></p>
                        </div>
                    </div>
                    <?php
            if($i % 3 == 2) { // div end for every 3 items
                echo '</div></div>';
            }
            $i++;
        endwhile;
        if($i % 3 != 0) { // end last item if not a complete group of 3
            echo '</div></div>';
        }
        ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Précédent</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Suivant</span>
                </a>
            </div>

        </div>
    </div>
    <?php
get_footer();