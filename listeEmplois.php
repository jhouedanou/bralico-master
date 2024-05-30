    <div class="safezone">
                <!--insert wordpress widget-->
                <?php dynamic_sidebar('notre-pole-emploi'); ?>
                <div id="naado" class="row">
                    <div class="col">
                        <a href="?page_id=119"><?php echo __('Offres', 'bralico'); ?></a>
                    </div>
                    <div class="col">
                        <a href="?page_id=304"><?php echo __('Candidature spontanée', 'bralico'); ?></a>
                    </div>
                </div>
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
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
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
                                            <a href="#" class="resumeduposte" data-toggle="modal"
                                                data-target="#modal-<?php echo get_the_ID(); ?>">
                                                <h5><?php echo __("Offre d'emploi", "bralico"); ?></h5>
                                                <h3><?php the_title(); ?></h3>
                                            </a>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modal-<?php echo get_the_ID(); ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="modal-<?php echo get_the_ID(); ?>-label"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-xl houseofebony" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="modal-<?php echo get_the_ID(); ?>-label">
                                                            <?php the_title(); ?>
                                                        </h5>
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
                                                            <?php endif;
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
                                                        <a class="btn btn-primary btn-postuler"
                                                            href="?page_id=304&titredupost=<?php echo $query_param; ?>"><?php echo __('Cliquez ici pour postuler', 'bralico'); ?></a>

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
                <a id="jimmy" href="<?php echo get_permalink('119'); ?>">Voir plus</a>
            </div>