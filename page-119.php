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
<div id="thumbnailpage">
    <div id="lepaddingdesteven"></div>
    <?php 
        if (has_post_thumbnail()) {
            the_post_thumbnail();
        }
     ?>
</div>
<div id="filtrewrapper">

    <div id="filtre" class="row filters">
        <div class="col-md-12">
            <h2><?php echo __("Offres d'emploi","bralico");?></h2>
            <p><?php echo __("Nos dernières offres d'emploi","bralico");?></p>
        </div>
        <div class="col-md-6">
            <div class="zwrapper">
                <span>
                    <?php echo __("Statut","bralico");?>
                </span>
                <div class="liste">
                    <?php 
                $statut_terms = get_terms('statut', array('hide_empty' => false));
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
            </div>

        </div>
        <div class="col-md-6">
            <div class="zwrapper">
                <span>
                    <?php echo __("Lieu","bralico");?>
                </span>
                <div class="liste">
                    <?php 
                $lieu_terms = get_terms('lieu', array('hide_empty' => false));
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
            </div>

        </div>
        <!--<div class="col-md-6">
            <div class="zwrapper">
                <span>
                    <?php echo __("Métiers","bralico");?>
                </span>
                <div class="liste">

                    <?php 
                $secteurs_terms = get_terms('secteurs', array('hide_empty' => false));
                if ($secteurs_terms && !is_wp_error($secteurs_terms)) {
                    echo '<select class="filter" id="secteurs-filter">';
                    echo '<option value="">Tous les métiers</option>';
                    foreach ($secteurs_terms as $term) {
                        echo '<option value=".' . $term->slug . '">' . $term->name . '</option>';
                    }
                    echo '</select>';
                }
                ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="zwrapper">
                <span>
                    <?php echo __(" Pôles","bralico");?>
                </span>
                <div class="liste">
                    <?php 
                $fonctions_terms = get_terms('fonctions', array('hide_empty' => false));
                if ($fonctions_terms && !is_wp_error($fonctions_terms)) {
                    echo '<select class="filter" id="fonctions-filter">';
                    echo '<option value="">Tous les pôles</option>';
                    foreach ($fonctions_terms as $term) {
                        echo '<option value=".' . $term->slug . '">' . $term->name . '</option>';
                    }
                    echo '</select>';
                }
                ?>
                </div>
            </div>

        </div>-->

        <div class="col-md-6">
    <div class="zwrapper">
        <span><?php echo __("Métiers","bralico");?></span>
        <div class="liste">
            <?php 
            $secteurs_terms = get_terms('secteurs', array('hide_empty' => false, 'parent' => 0));
            if ($secteurs_terms && !is_wp_error($secteurs_terms)) {
                echo '<select class="filter-no" id="secteurs-filter">';
                echo '<option value="">Tous les métiers</option>';
                foreach ($secteurs_terms as $term) {
                    echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                }
                echo '</select>';
            }
            ?>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="zwrapper">
        <span><?php echo __("Pôles","bralico");?></span>
        <div class="liste sous-secteurs">
            <?php
            // Ajout du select par défaut
            echo '<select class="filter sous-secteur-select" id="sous-secteur-default">';
            echo '<option value="">Veuillez sélectionner un métier</option>';
            echo '</select>';

            foreach ($secteurs_terms as $parent_term) {
                echo '<select class="filter sous-secteur-select" id="sous-secteur-' . $parent_term->term_id . '" style="display:none;">';
                echo '<option value="">Tous les pôles de ' . $parent_term->name . '</option>';
                
                $sous_secteurs = get_terms('secteurs', array(
                    'hide_empty' => false,
                    'parent' => $parent_term->term_id
                ));
                
                if ($sous_secteurs && !is_wp_error($sous_secteurs)) {
                    foreach ($sous_secteurs as $term) {
                        echo '<option value=".' . $term->slug . '">' . $term->name . '</option>';
                    }
                }
                echo '</select>';
            }
            ?>
        </div>
    </div>
</div>



        <div class="col-md-12">
            <a id="resetfilter" href=""><?php echo __('Réinitialisation des filtres','bralico');?></a>
        </div>
    </div>
</div>
<div id="pagecontent">

    <div class="contenudelapage">
        <h2 id="drake"><?php echo __("Les offres d'emploi","bralico"); ?></h2>
        <div id="emploi" class="row">
            <?php
            // Arguments pour WP_Query
            $args = array(
                'post_type' => 'job_listing',
                'showposts' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'post__not_in' => array(15862) // Exclure le post avec l'ID 4

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
                <a href="#" class="paddingzsa" data-toggle="modal" data-target="#modal-<?php echo get_the_ID(); ?>">
                    <?php the_post_thumbnail('poleemploiaccueil'); ?>
                    <div class="baka">

                        <span class="resumeduposte">
                            <?php the_title(); ?>
                        </span>
                        <span class="dateexpiration">
                            <?php if (get_field('date_limite_de_reception_des_dossiers_')) : ?>
                            <br />
                            <?php 
                            $field_object = get_field_object('date_limite_de_reception_des_dossiers_');
                            if ($field_object) {
                                echo $field_object['label'].' : ';
                            }
                   
                        ?>
                            <?php the_field('date_limite_de_reception_des_dossiers_'); ?>
                            <?php endif; ?>
                        </span>

                    </div>
                </a>
                <!-- Modal -->
                <div class="modal fade" id="modal-<?php echo get_the_ID(); ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modal-<?php echo get_the_ID(); ?>-label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl houseofebony" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-<?php echo get_the_ID(); ?>-label">
                                    <?php the_title(); ?>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="chevydealership">

                                    <?php
                                    $fields = array(
                                        /* 'intitule_du_poste',
                                        'departement',
                                        'service',
                                        'n°_du_poste',
                                        'superieur_hierarchique',
                                        'nombre_de_personnes_sous_sa_direction',
                                         */'lieu',
                                        'objectif_du_poste',
                                        'responsabilites_principales',
                                        'diplome_requis_pour_le_poste',
                                        'specialite',
                                        'competences_fonctionnelles',
                                        'experience_professionnelle',
                                        /* 'secteurdomaine',
                                        'aptitudes',
                                        'lieu_du_poste',
                                         */'date_limite_de_reception_des_dossiers_'
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
                                        }
                                        ?>
                                </div>

                            </div>
                            <div class="modal-footer">

                                <?php
                                    $post_id = get_the_ID();
                                    $post_title = get_the_title($post_id);
                                    if(empty($post_title)) {
                                        // echo "Le titre du post est vide.";
                                    } else {
                                        //  echo $post_title;
                                    }
                                    $query_param = urlencode($post_title);
                                ?>
                                <!--  <a class="btn btn-primary btn-postuler"
                                    href="?page_id=304&titredupost=<?php echo $query_param; ?>"><?php  echo __('Cliquez ici pour postuler','bralico');?></a> -->
                                <a class="btn btn-primary btn-postuler"
                                    href="<?php the_job_permalink(); ?>"><?php  echo __('Cliquez ici pour postuler','bralico');?></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
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