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
acf_form_head(); 
get_header();
if (isset($_GET['action']) && $_GET['action'] === 'clear_cookie') {
    setcookie('user_logged_in', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN);
    setcookie('user_login', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN);
    wp_redirect(get_permalink());
    exit;
}
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
            <div class="safezone">
                <div class="row">
                    <div class="col-md-12 welcomemessage">
                        <h1 class="white mouff">Espace candidat</h1>
                        <div id="oboarding">
                        <?php if (isset($_COOKIE['user_logged_in'])) {
    echo '<p class="mouff white">Bon retour, <span class="roumba">' . $_COOKIE['user_login'] . '</span>!</p>';
    if (!is_user_logged_in()) {
        include('formConnexionEmploi.php');
        // Ajout du lien de déconnexion qui supprime le cookie
        echo '<a href="' . add_query_arg('action', 'clear_cookie', get_permalink()) . '">Déconnexion</a>';
    } else { ?>
        <div class="commandecenter">
            <a href="<?php echo get_permalink('304');?>">Mon espace candidat</a>
            <a target="_blank" href="<?php echo get_permalink('119');?>">Offres d'emploi</a>
            <a target="_blank" href="<?php echo get_permalink('15916');?>" id="are">Candidature spontanée</a>
            <?php echo '<a href="' . wp_logout_url(get_permalink()) . '">Déconnexion</a>'; ?>
        </div>
    <?php }
} else { ?>
                                </div>
                                <p class="mouff white">Votre espace personnel pour gérer votre candidature et postuler à nos offres.</p>
                                <div id="connexioncenter" class="row">
                                    <?php 
                                    include('creationDeCompte.php');
                                    include('formConnexionEmploi.php'); 
                                    ?>
                                </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="section2poleemploi" class="container">
            <?php if (is_user_logged_in()) { ?>
                <?php dynamic_sidebar('notre-pole-emploi'); ?>
            <?php } ?>

            <div id="dad" class="safezone">
                <?php
                $args = array(
                    'post_type' => 'job_listing',
                    'posts_per_page' => 6,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'post__not_in' => array(15862)
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) { ?>
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
                        <div class="carousel-inner">
                            <?php
                            $counter = 0;
                            while ($query->have_posts()) {
                                $query->the_post();
                                $class = ($counter % 3 == 0) ? 'rouge' : (($counter % 3 == 1) ? 'vert' : 'jaune');

                                if ($counter % 3 == 0) { ?>
                                    <div class="carousel-item <?php echo ($counter == 0 ? 'active' : ''); ?>">
                                        <div class="row">
                                <?php } ?>
                                            <div class="col-md-4 <?php echo $class; ?>">
                                                <div class="paddingzsa">
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <?php the_post_thumbnail('poleemploiaccueil'); ?>
                                                    <?php else: ?>
                                                        <div style="padding-top: 383px;background: #EEE;"></div>
                                                    <?php endif; ?>
                                                    <a href="#" class="resumeduposte" data-post-id="<?php echo get_the_ID(); ?>" data-toggle="modal" data-target="#modal-<?php echo get_the_ID(); ?>">
                                                        <h5><?php echo __("Offre d'emploi", "bralico"); ?></h5>
                                                        <h3><?php the_title(); ?></h3>
                                                    </a>
                                                </div>

                                                <div class="modal fade" id="modal-<?php echo get_the_ID(); ?>" tabindex="-1" role="dialog" aria-labelledby="modal-<?php echo get_the_ID(); ?>-label" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-xl houseofebony" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modal-<?php echo get_the_ID(); ?>-label"><?php the_title(); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="chevydealership">
                                                                    <?php
                                                                    $fields = array(
                                                                        'lieu',
                                                                        'objectif_du_poste',
                                                                        'responsabilites_principales',
                                                                        'diplome_requis_pour_le_poste',
                                                                        'specialite',
                                                                        'competences_fonctionnelles',
                                                                        'experience_professionnelle',
                                                                        'date_limite_de_reception_des_dossiers_'
                                                                    );

                                                                    foreach ($fields as $field) {
                                                                        $field_object = get_field_object($field);
                                                                        $field_value = get_field($field);
                                                                        if ($field_object && $field_value) : ?>
                                                                            <div class="emploi-fields">
                                                                                <h5><?php echo $field_object['label']; ?></h5>
                                                                                <p><?php echo $field_value; ?></p>
                                                                            </div>
                                                                        <?php endif;
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <?php if (is_user_logged_in()) { ?>
                                                                    <a class="btn btn-primary btn-postuler" href="<?php the_job_permalink(); ?>"><?php echo __('Cliquez ici pour postuler','bralico');?></a>
                                                                <?php } else { ?>
                                                                    <div class="alert alert-warning" role="alert">
                                                                        Veuillez créer un compte avant de postuler à cette offre d'emploi.
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                <?php if ($counter % 3 == 2 || $counter == $query->post_count - 1) { ?>
                                        </div>
                                    </div>
                                <?php }
                                $counter++;
                            } ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                <?php }
                wp_reset_postdata(); ?>
            </div>
            <a id="jimmy" href="<?php echo get_permalink('119'); ?>">Voir plus</a>
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
                    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
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
                )); ?>
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
                )); ?>
            </div>
        </div>
    </div>
    <div id="creditsfooter">
        <div class="row">
            <div class="col">
                <?php dynamic_sidebar('credits-footer'); ?>
            </div>
            <div class="col">
                <?php dynamic_sidebar('avertissement-footer'); ?>
            </div>
        </div>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>