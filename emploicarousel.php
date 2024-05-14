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
                    <a href="<?php the_permalink();?>" class="paddingzsa">
                        <?php the_post_thumbnail('poleemploiaccueil'); ?>
                        <div class="resumeduposte">
                            <?php the_title(); ?>
                            <?php the_content(); ?>
                        </div>
                    </a>
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
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<?php
}

// Réinitialisez la requête principale
wp_reset_postdata();
?>