<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bralico
 */

get_header();
?>

<main id="primary" class="site-main they">

    <?php if ( have_posts() ) : ?>

    <header class="page-header">
        <?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
    </header><!-- .page-header -->
    <div id="catgrid" class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="actualites" class="row">
                    <?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						?>
                    <div class="japz col-md-4 col-sm-12 col-xs-12">
                        <a class="hassdiesel" href="<?php the_permalink();?>">
                            <?php the_post_thumbnail('actuhomepage', ['class' => 'd-block w-100 mpa']);?>
                            <div class="labouche">
                                <div class="jour">
                                    <?php
                                        $date = get_the_date('d');
                                        echo $date;
                                        ?>
                                </div>
                                <div class="mois">
                                    <?php
                                        $dated = get_the_date('M');
                                        echo $dated;
                                        ?>
                                </div>
                                <div class="annee">
                                    <?php
                                        $dateds = get_the_date('Y');
                                        echo $dateds;
                                        ?>
                                </div>
                            </div>
                            <div class="obvf d-md-block">
                                <h5><?php the_title();?></h5>
                                <p><?php the_excerpt();?></p>
                            </div>
                        </a>
                    </div>
                    <?php
					endwhile;
					?>
                </div>
            </div>
        </div>
        <?php
		

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
    </div>


</main><!-- #main -->

<?php
get_sidebar();
get_footer();