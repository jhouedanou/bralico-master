<?php
/**
 * The template for displaying all offre d'emploi
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Bralico
 */

get_header();
?>

<div id="pagecontent" class="container-fluid empo">
    <div class="row">
        <div id="article" class="col-md-8">
            <main id="primary" class="site-main">

                <?php while ( have_posts() ) : the_post(); ?>
                <div class="emploithumbnail">
                    <?php the_post_thumbnail(); ?>
                </div>

                <?php the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'bralico' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'bralico' ) . '</span> <span class="nav-title">%title</span>',
					)
				);

				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				endwhile; ?>

                <div class="chevydealership">
                    <div class="emploi-fields">
                        <h3>Intitulé du poste</h3>
                        <?php the_field( 'intitule_du_poste' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Département</h3>
                        <?php the_field( 'departement' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Service</h3>
                        <?php the_field( 'service' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>N° du poste</h3>
                        <?php the_field( 'n°_du_poste' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Supérieur hiérarchique</h3>
                        <?php the_field( 'superieur_hierarchique' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Nombre de personnes sous sa direction</h3>
                        <?php the_field( 'nombre_de_personnes_sous_sa_direction' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Lieu</h3>
                        <?php the_field( 'lieu' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Objectif du poste</h3>
                        <?php the_field( 'objectif_du_poste' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Responsabilités principales</h3>
                        <?php the_field( 'responsabilites_principales' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Diplôme requis pour le poste</h3>
                        <?php the_field( 'diplome_requis_pour_le_poste' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Spécialité</h3>
                        <?php the_field( 'specialite' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Compétences fonctionnelles</h3>
                        <?php the_field( 'competences_fonctionnelles' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Expérience professionnelle</h3>
                        <?php the_field( 'experience_professionnelle' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Secteur/domaine</h3>
                        <?php the_field( 'secteurdomaine' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Aptitudes</h3>
                        <?php the_field( 'aptitudes' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Lieu du poste</h3>
                        <?php the_field( 'lieu_du_poste' ); ?>
                    </div>
                    <div class="emploi-fields">
                        <h3>Date limite de réception des dossiers</h3>
                        <?php the_field( 'date_limite_de_reception_des_dossiers_' ); ?>
                    </div>
                </div>

            </main><!-- #main -->
        </div>
        <div id="actions" class="col-md-4">
            <div id="porsche">
                <?php
      $post_id = get_the_ID();
      $post_title = get_the_title($post_id);
      if(empty($post_title)) {
          echo "Le titre du post est vide.";
      } else {
          echo $post_title;
      }
                $query_param = urlencode($post_title);
                ?>
                <a href="?page_id=304&titredupost=<?php echo $query_param; ?>">Postuler</a>
            </div>
        </div>
    </div>

</div>

<?php
get_sidebar();
get_footer();