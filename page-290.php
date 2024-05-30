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
    <div id="lepaddingdesteven"></div>
    <?php if (has_post_thumbnail()) {
        the_post_thumbnail();
    } ?>
</div>

<div id="pagecontent">
    <div class="contenudelapage">
        <div id="section1poleemploi">
            <?php //include('connexiontoggler.php'); ?>
        </div>
        <div id="section2poleemploi" class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php 
            if (have_posts()) : while (have_posts()) : the_post();
                if (is_user_logged_in()) {
                    acf_form(array(
                        'post_id' => 'new_post',
                        'new_post' => array(
                            'post_type' => 'curriculum_vitae',
                            'post_status' => 'publish'
                        ),
                        'return'        => home_url('contact-form-thank-you'),

                        'submit_value' => 'Soumettre le CV'
                    ));
                } else {
                    echo 'Vous devez être connecté pour soumettre votre CV.';
                    wp_login_form();
                }
            endwhile; endif;
            ?> </div>
            </div>

        </div>
    </div>
</div>

<footer id="colophon" class="site-footer">
    <div id="elementsdufooter" class="container-fluid">
        <div class="row">
            <div id="vome" class="col-md-5">
                <?php dynamic_sidebar('newsletter-footer'); ?>
                <?php
                class Image_Walker_Nav_Menu2 extends Walker_Nav_Menu {
                    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
                        $image_url = get_post_meta($item->ID, '_menu_item_image_url', true);
                        $title = apply_filters('the_title', $item->title, $item->ID);
                        $url = $item->url;
                        $output .= "<li><a target='_blank' href='$url'><img src='$image_url' alt='$title' /></a></li>";
                    }
                }

                wp_nav_menu(array(
                    'menu' => 'Social Menu',
                    'container_id' => 'reseauxsociauxbralicofooter',
                    'menu_class' => 'reseauxsociauxbralicofooter',
                    'menu_id' => 'reseauxsociauxbralicofooter',
                    'theme_location' => 'Socialmenu',
                    'walker' => new Image_Walker_Nav_Menu2()
                ));
                ?>
            </div>
            <div class="col-md-4 solidifie">
                <?php dynamic_sidebar('contacts-footer'); ?>
            </div>
            <div class="col-md-3 solidifie">
                <h2>Nous écrire</h2>
                <?php
                wp_nav_menu(array(
                    'menu' => 'Nous écrire',
                    'container_id' => 'footermenuwrapper',
                    'menu_class' => 'footermenu',
                    'menu_id' => 'footermenu',
                    'theme_location' => 'Footermenu',
                ));
                ?>
            </div>
        </div>
    </div>
    <div id="creditsfo