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
                        <h1>Espace candidat</h1>
                        <div id="oboarding">
                            <?php 
                        // vérifier si le cookie indiquant la connexion de l'utilisateur est présent
                        if (isset($_COOKIE['user_logged_in'])) {
                            echo 'Bon retour, ' . $_COOKIE['user_login'] . '!';
                            // si l'utilisateur n'est pas connecté, afficher le include. 
                            if (!is_user_logged_in()) {
                                include('formConnexionEmploi.php');
                            } else {
                                // si l'utilisateur est connecté, afficher le lien de déconnexion
                                echo '<a href="' . wp_logout_url(home_url()) . '">Déconnexion</a>';
                            }
                        } else {
                            // L'utilisateur ne s'est jamais connecté, affichez le formulaire de connexion et le formulaire de création de compte
                            ?>
                        </div>
                        <p>L'espace candidat est vous offre la possibilité de mettre en ligne votre cv et de le rendre
                            consultable par notre service de recrutement</p>
                        <div id="connexioncenter" class="row">

                            <?php include('creationDeCompte.php');include('formConnexionEmploi.php'); ?>
                        </div>
                        <?php
                        }//fin du else
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="section2poleemploi" class="container">
            <?php if (is_user_logged_in()) { ?>
            <!-- insert wordpress widget -->
            <?php dynamic_sidebar('notre-pole-emploi'); ?>
            <?php include('gestionCV.php'); ?>
            <?php } ?>
            <!-- liste des emplois -->
   
            <a id="jimmy" href="<?php echo get_permalink('119'); ?>">Voir plus</a>
        </div>
    </div>
</div>
</div>
<footer id="colophon" class="site-footer">
    <div id="elementsdufooter" class="container-fluid">
        <div class="row">
            <div id="vome" class="col-md-5">
                <?php dynamic_sidebar('newsletter-footer'); ?>
                <!-- menu reseaux sociaux -->
                <?php
                class Image_Walker_Nav_Menu2 extends Walker_Nav_Menu
                {
                    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
                    {
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
<!-- fin de la div /page  dans le header-->
</div>
<?php wp_footer(); ?>
</body>

</html>