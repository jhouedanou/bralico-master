<?php acf_form_head(); ?>
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
            <div class="row">
                <div class="col-md-12">
                    <?php 
            if (have_posts()) : while (have_posts()) : the_post();
                if (is_user_logged_in()) {?>
                    <!-- fenêtre odale qui afficher le formulaire pour mettre à jour le cv -->
                    <div id="modal" title="Mettre à jour votre CV" style="display:none;">
                        <?php echo do_shortcode('[forminator_form id="293"]'); ?>
                    </div>
                    <button id="toogle">Mettre à jour votre CV</button>
                    <div id="toggle">
                        <?php
                  echo do_shortcode('[acf_form]');
                  ?>
                    </div>

                    <?php
                } else {?>
                    <div id="leformulairedelamortkitue">

                        <?php
                    echo 'Veuillez vous connecter pour postuler aux offres d\'emploi.';
                    wp_login_form();?>
                        <div id="modal" title="Créer un compte" style="display:none;">
                            <?php echo do_shortcode('[forminator_form id="301"]'); ?>
                        </div>

                        <button id="open-modal">Créer un compte</button>
                        <script>
                        jQuery(document).ready(function($) {
                            $("#open-modal").click(function() {
                                $("#modal").dialog({
                                    width: 400,
                                    modal: true
                                });
                            });
                        });
                        </script>
                    </div>
                    <?php 
                    //fin du else 
                }
            endwhile; endif;
            ?>
                </div>
            </div>
        </div>
        <div id="section2poleemploi" class="container">
            <?php include('listeEmplois.php'); ?>
        </div>
    </div>
</div>


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