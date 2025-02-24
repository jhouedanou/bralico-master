<?php
get_header();

// Récupération des données utilisateur et CV en début de page
$user_id = get_current_user_id();
$cv_count = get_posts(array(
    'post_type' => 'resume',
    'author' => $user_id,
    'posts_per_page' => -1,
    'post_status' => array('publish', 'pending', 'draft'),
    'fields' => 'ids'
));
$nombre_cv = count($cv_count);
?>

<style>
<?php if ($nombre_cv >= 1) : ?>
    table.resume-manager-resumes tfoot,
    table.resume-manager-resumes tr:nth-child(2) {
        display: none !important;
    }else {
        table.resume-manager-resumes tfoot,
        table.resume-manager-resumes tr:nth-child(2) {
            display: table-row !important;
        }
    }
<?php endif; ?>
</style>

<div id="pagecontent" class="container-fluid">
    <div class="contenudelapage">
        <?php while (have_posts()) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
            <?php //echo $nombre_cv; ?>
            <h2>Vos candidatures</h2>
            <?php echo do_shortcode('[past_applications]'); ?>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
