<div id="accordion">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                    aria-controls="collapseOne">
                    Collapsible Group Item #1
                </button>
            </h5>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <?php 
                            acf_form(array(
                                'post_id' => 'new_post',
                                'new_post' => array(
                                    'post_type' => 'curriculum_vitae',
                                    'post_status' => 'publish'
                                ),
                                'return' => home_url('?page_id=290'),
                                'submit_value' => 'Soumettre le CV'
                            )); ?>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="false" aria-controls="collapseTwo">
                    Collapsible Group Item #2
                </button>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
                <div id="dad">
                    <?php
                // Arguments pour WP_Query
                $args = array(
                    'post_type' => 'offre-emploi',
                    'posts_per_page' => 6,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );

                // Nouvelle instance de WP_Query
                $query = new WP_Query($args);

                // Vérifiez si nous avons des posts
                if ($query->have_posts()) {
                    // Début du carrousel
                ?>
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"
                        data-interval="false">
                        <div class="carousel-inner">
                            <?php
                            // Compteur pour les classes
                            $counter = 0;

                            // Boucle à travers les posts
                            while ($query->have_posts()) {
                                $query->the_post();

                                // Déterminez la classe en fonction du compteur
                                $class = '';
                                if ($counter % 3 == 0) {
                                    $class = 'rouge';
                                } elseif ($counter % 3 == 1) {
                                    $class = 'vert';
                                } else {
                                    $class = 'jaune';
                                }

                                // Affichez le post dans le carrousel
                                if ($counter % 3 == 0) {
                                    // Début d'un nouvel item de carrousel
                            ?>
                            <div class="carousel-item <?php echo ($counter == 0 ? 'active' : ''); ?>">
                                <div class="row">
                                    <?php
                                }
                                ?>
                                    <div class="col-md-4 <?php echo $class; ?>">
                                        <div class="paddingzsa">
                                            <?php the_post_thumbnail('poleemploiaccueil'); ?>
                                            <a href="#" class="resumeduposte" data-post-id="<?php echo get_the_ID(); ?>"
                                                data-toggle="modal" data-target="#modal-<?php echo get_the_ID(); ?>">
                                                <h5><?php echo __("Offre d'emploi", "bralico"); ?></h5>
                                                <h3><?php the_title(); ?></h3>
                                            </a>
                                        </div>
                                        <!-- fenetre detaillant l'offre d'emploi -->
                                        <div class="modal fade" id="modal-<?php echo get_the_ID(); ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="modal-<?php echo get_the_ID(); ?>-label"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-xl houseofebony"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="modal-<?php echo get_the_ID(); ?>-label">
                                                            <?php the_title(); ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="chevydealership">
                                                            <?php
                                                        $fields = array(
                                                            'intitule_du_poste',
                                                            'departement',
                                                            'service',
                                                            'n°_du_poste',
                                                            'superieur_hierarchique',
                                                            'nombre_de_personnes_sous_sa_direction',
                                                            'lieu',
                                                            'objectif_du_poste',
                                                            'responsabilites_principales',
                                                            'diplome_requis_pour_le_poste',
                                                            'specialite',
                                                            'competences_fonctionnelles',
                                                            'experience_professionnelle',
                                                            'secteurdomaine',
                                                            'aptitudes',
                                                            'lieu_du_poste',
                                                            'date_limite_de_reception_des_dossiers_'
                                                        );

                                                        foreach ($fields as $field) {
                                                            $field_object = get_field_object($field);
                                                            $field_value = get_field($field);
                                                            if ($field_object && $field_value) :
                                                        ?>
                                                            <div class="emploi-fields">
                                                                <h5><?php echo $field_object['label']; ?></h5>
                                                                <p><?php echo $field_value; ?></p>
                                                            </div>
                                                            <?php
                                                            endif;
                                                        }
                                                        ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <?php
                                                    $post_id = get_the_ID();
                                                    $post_title = get_the_title($post_id);
                                                    if (empty($post_title)) {
                                                        // echo "Le titre du post est vide.";
                                                    } else {
                                                        //  echo $post_title;
                                                    }
                                                    $query_param = urlencode($post_title);
                                                    ?>
                                                        <?php
                                                    if (is_user_logged_in()) {
                                                        // L'utilisateur est connecté, affichez le bouton
                                                        echo '<a class="btn btn-primary btn-postuler" href="?page_id=304&titredupost=' . $query_param . '">' . __('Cliquez ici pour postuler', 'bralico') . '</a>';
                                                    } else {
                                                        // L'utilisateur n'est pas connecté, affichez un avertissement Bootstrap
                                                        echo '<div class="alert alert-warning" role="alert">
                                                                Veuillez créer un compte afin de postuler à cette offre d\'emploi.
                                                            </div>';
                                                    }
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                if ($counter % 3 == 2 || $counter == $query->post_count - 1) {
                                    // Fin de l'item de carrousel
                                ?>
                                </div>
                            </div>
                            <?php
                                }

                                // Incrémentez le compteur
                                $counter++;
                            }

                            // Fin du carrousel
                                ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <?php
                }
                // Réinitialisez la requête principale
                wp_reset_postdata();
                ?>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="false" aria-controls="collapseThree">
                    Collapsible Group Item #3
                </button>
            </h5>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                <?php echo do_shortcode('[forminator_form id="15665"]'); ?>
            </div>
        </div>
    </div>
</div>