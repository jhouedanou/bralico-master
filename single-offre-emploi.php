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
        if ($field_object) : ?>
                    <div class="emploi-fields">

                        <h3><?php echo $field_object['label']; ?></h3>
                        <?php the_field($field); ?>
                    </div>
                    <?php endif;
    }
    ?>
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