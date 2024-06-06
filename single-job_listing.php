<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Bralico
 */

get_header();
?>

<div id="pagecontent" class="container-fluid what">
    <div class="row">
        <div id="article" class="col-md-12">
            <main id="primary" class="site-main">
                <div id="maincol" class="row">
                    <div class="col-md-6">
                        <div class="inseid">
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
                    <div class="col-md-6">
                        <div id="postsidebar">
                            <div class="content">
                                <?php
                                while (have_posts()) :
                                    the_post();
                                    get_template_part('template-parts/content', get_post_type());
                                ?>
                                <?php
                                /* 	the_post_navigation(
                                        array(
                                            'prev_text' => '<span class="nav-subtitle">' . esc_html__( '<', 'bralico' ) . '</span> <span class="nav-title">%title</span>',
                                            'next_text' => '<span class="nav-subtitle">' .  '</span> <span class="nav-title">%title</span>'.esc_html__( ' >', 'bralico' ) ,
                                        )
                                    );
                                 */
                                // If comments are open or we have at least one comment, load up the comment template.
                                /* if ( comments_open() || get_comments_number() ) :
                                    comments_template();
                                endif; */
                                endwhile; // End of the loop.
                                ?>
                                <div id="theacolyte">

                                    <a id="bbenchwap" href="<?php echo get_permalink('304'); ?>">Mon espace
                                        candidat</a>
                                    <a href="<?php echo get_permalink('119');?>">Offres d'emploi</a>
                                    <a href="' . wp_logout_url(home_url()) . '">Déconnexion</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main><!-- #main -->
        </div>
    </div>
</div>

<?php
get_sidebar();
get_footer();