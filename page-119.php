<?php
/**
 * The template for displaying the emploi
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

<div id="pagecontent" style="padding-top:18em">
    <div class="contenudelapage">
        <div id="filtre" class="row filters">
            <div class="col-md-6">
                <?php 
                $statut_terms = get_terms('statut');
                if ($statut_terms && !is_wp_error($statut_terms)) {
                    echo '<select class="filter" id="statut-filter">';
                    echo '<option value="">Tous les statuts</option>';
                    foreach ($statut_terms as $term) {
                        echo '<option value=".' . $term->slug . '">' . $term->name . '</option>';
                    }
                    echo '</select>';
                }
                ?>
            </div>
            <div class="col-md-6">
                <?php 
                $lieu_terms = get_terms('lieu');
                if ($lieu_terms && !is_wp_error($lieu_terms)) {
                    echo '<select class="filter" id="lieu-filter">';
                    echo '<option value="">Tous les lieux</option>';
                    foreach ($lieu_terms as $term) {
                        echo '<option value=".' . $term->slug . '">' . $term->name . '</option>';
                    }
                    echo '</select>';
                }
                ?>
            </div>
            <div class="col-md-6">
                <?php 
                $fonctions_terms = get_terms('fonctions');
                if ($fonctions_terms && !is_wp_error($fonctions_terms)) {
                    echo '<select class="filter" id="fonctions-filter">';
                    echo '<option value="">Tous les fonctions</option>';
                    foreach ($fonctions_terms as $term) {
                        echo '<option value=".' . $term->slug . '">' . $term->name . '</option>';
                    }
                    echo '</select>';
                }
                ?>
            </div>
            <div class="col-md-6">
                <?php 
                $secteurs_terms = get_terms('secteurs');
                if ($secteurs_terms && !is_wp_error($secteurs_terms)) {
                    echo '<select class="filter" id="secteurs-filter">';
                    echo '<option value="">Tous les secteurs</option>';
                    foreach ($secteurs_terms as $term) {
                        echo '<option value=".' . $term->slug . '">' . $term->name . '</option>';
                    }
                    echo '</select>';
                }
                ?>
            </div>
            <div class="col-md-12">
                <a id="resetfilter" href="">Reset filters</a>
            </div>
        </div>
        <div id="emploi" class="row">
            <?php
            // Arguments pour WP_Query
            $args = array(
                'post_type' => 'offre-emploi',
                'showposts' => -1,
                'orderby' => 'date',
                'order' => 'DESC'
            );

            // Nouvelle instance de WP_Query
            $query = new WP_Query($args);

            // Vérifiez si nous avons des posts
            if ($query->have_posts()) {
                // Boucle à travers les posts
                while ($query->have_posts()) {
                    $query->the_post();

                    // Obtenez les termes de la taxonomie "statut"
                    $statut_terms = get_the_terms(get_the_ID(), 'statut');
                    $fonctions_terms = get_the_terms(get_the_ID(), 'fonctions');
                    $secteurs_terms = get_the_terms(get_the_ID(), 'secteurs');
                    $lieu_terms = get_the_terms(get_the_ID(), 'lieu');
                    $term_classes = '';

                    // Ajoutez les slugs des termes à la chaîne de classes
                    foreach (array($fonctions_terms, $secteurs_terms, $lieu_terms, $statut_terms) as $terms) {
                        if ($terms && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $term_classes .= ' ' . $term->slug;
                            }
                        }
                    }
            ?>
            <div id="post-<?php echo get_the_ID(); ?>"
                class="element-item item <?php echo $term_classes; ?> col-md-3 col-xs-12 col-xs-12 ">
                <a href="<?php the_permalink(); ?>" class="paddingzsa">
                    <?php the_post_thumbnail('poleemploiaccueil'); ?>
                    <div class="resumeduposte">
                        <?php the_title(); ?>
                        <?php
                        //le contenu avant la  balise more
                        the_content();
                         
                        ?>
                        <div class="terms">

                            <?php //liste des termes 
                        if ($statut_terms && !is_wp_error($statut_terms)) {
                            echo '<ul>';
                            foreach ($statut_terms as $term) {
                                echo '<li>' . $term->name . '</li>';
                            }
                            echo '</ul>';
                        }
                        if ($fonctions_terms && !is_wp_error($fonctions_terms)) {
                            echo '<ul>';
                            foreach ($fonctions_terms as $term) {
                                echo '<li>' . $term->name . '</li>';
                            }
                            echo '</ul>';
                        }
                        if ($secteurs_terms && !is_wp_error($secteurs_terms)) {
                            echo '<ul>';
                            foreach ($secteurs_terms as $term) {
                                echo '<li>' . $term->name . '</li>';
                            }
                            echo '</ul>';
                        }
                        if ($lieu_terms && !is_wp_error($lieu_terms)) {
                            echo '<ul>';
                            foreach ($lieu_terms as $term) {
                                echo '<li>' . $term->name . '</li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                        </div>
                    </div>
                </a>
            </div>
            <?php
                }

                // Réinitialisez la requête principale
                wp_reset_postdata();
            }
            ?>

        </div>
        <button id="showMore" class="button showMore" id="showMore">
            <?php _e('Voir plus', 'bralico'); ?></button>
    </div>
</div>

<?php
get_footer();
?>