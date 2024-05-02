<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bralico
 */
?>
<footer id="colophon" class="site-footer">
    <div id="elementsdufooter" class="container-fluid">
        <div class="row">
            <div id="vome" class="col-md-5">
                <?php dynamic_sidebar('newsletter-footer');?>
                <!-- menu reseaux sociaux -->
                <?php
							class Image_Walker_Nav_Menu2 extends Walker_Nav_Menu {
								function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
									$image_url = get_post_meta( $item->ID, '_menu_item_image_url', true );
									$title = apply_filters( 'the_title', $item->title, $item->ID );
									$url = $item->url;
									$output .= "<li><a target='_blank' href='$url'><img src='$image_url' alt='$title' /></a></li>";
								}
							}

							wp_nav_menu(array(
								'menu' => 'Social Menu',
								'container_id' => 'reseauxsociauxbralicofooter',
								'menu_class' =>'reseauxsociauxbralicofooter',
								'menu_id'=>'reseauxsociauxbralicofooter',
								'theme_location' => 'Socialmenu',
								'walker' => new Image_Walker_Nav_Menu2()
							));
						?>
            </div>
            <div class="col-md-4 solidifie">
                <?php dynamic_sidebar('contacts-footer');?>
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
    <div id="creditsfooter">
        <div class="row">
            <div class="col">
                <?php dynamic_sidebar('credits-footer');?>
            </div>
            <div class="col">
                <?php dynamic_sidebar('avertissement-footer');?>
            </div>
        </div>
    </div>
</footer>
<!-- fin de la div /page  dans le header-->
</div>
<?php wp_footer();?>
</body>
</html>