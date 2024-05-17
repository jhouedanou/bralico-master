<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Raleway:ital,wght@0,300..800;1,300..800&display=swap">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'bralico' ); ?></a>
        <header id="masthead" class="site-header fixed">
            <div class="row">
                <div id="btnlogowrapper" class="col">
                    <a href="#" type="button" id="sidebarCollapse">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/icon.svg" />
                    </a>
                    <!-- end sidebar -->
                    <?php
								the_custom_logo();
							?>
                </div>
                <div id="menuwrapper" class="col">
                    <?php
					    wp_nav_menu(array(
                            'container_id' => 'headermenuwrapper',
                            'menu_class' => 'headermenu',
                            'menu_id' => 'headermenu',
                            'theme_location' => 'Primarymenu',
                        ));
					?>

                </div>
                <div id="searchrswrapper" class="col">
                    <div class="inner">
                        <?php
							class Image_Walker_Nav_Menu extends Walker_Nav_Menu {
								function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
									$image_url = get_post_meta( $item->ID, '_menu_item_image_url', true );
									$title = apply_filters( 'the_title', $item->title, $item->ID );
									$url = $item->url;
									$output .= "<li><a target='_blank' href='$url'><img src='$image_url' alt='$title' /></a></li>";
								}
							}

							wp_nav_menu(array(
								'menu' => 'Social Menu',
								'container_id' => 'reseauxsociauxbralicowrapper',
								'menu_class' =>'reseauxsociauxbralico',
								'menu_id'=>'reseauxsociauxbralico',
								'theme_location' => 'Socialmenu',
								'walker' => new Image_Walker_Nav_Menu()
							));
						?>
                        <div id="bondy">

                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#searchModal">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/search.svg" />
                            </button>

                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo do_shortcode('[ivory-search id="403" title="AJAX Search Form"]'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </header>