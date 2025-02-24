<?php
/**
 * Template pour la candidature spontanée
 *
 * @package Bralico
 */

get_header();
wp_enqueue_script('jquery');
wp_enqueue_script('bootstrap');

if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    $args = array(
        'post_type' => 'resume',
        'author' => $user_id,
        'posts_per_page' => 1
    );
    $resumes = get_posts($args);
}
?>

<div class="modal fade" id="cvModal" tabindex="-1" role="dialog" aria-labelledby="cvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cvModalLabel">Information importante</h5>
            </div>
            <div class="modal-body text-center">
            <p>Pour accéder à la page de candidature spontanée, vous devez d'abord être enregistré dans notre système et avoir créé votre CV. Celui-ci doit inclure une copie de votre CV au format PDF ainsi que le détail de vos expériences professionnelles. <br>Une fois ces éléments renseignés,vous pourrez poser votre candidature.</p>

                <a target="_blank" href="<?php echo home_url('/mise-a-jour-du-cv/'); ?>" class="btn btn-primary">Créer mon CV</a>
            </div>
        </div>
    </div>
</div>

<div id="pagecontent" class="container what theactual <?php echo empty($resumes) ? 'blur-effect' : ''; ?>">
    <?php 
    if (isset($_COOKIE['user_logged_in'])) {
        echo '<p class="safezone mouff white">Bon retour, <span class="roumba">' . $_COOKIE['user_login'] . '</span>!</p>';
        if (!is_user_logged_in()) {
            include('formConnexionEmploi.php');
        } else { ?>
            <div class="row">
                <div id="article" class="col-md-12">
                    <main id="primary" class="site-main">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/content', get_post_type());
                            if (comments_open() || get_comments_number()) :
                                comments_template();
                            endif;
                        endwhile;
                        ?>
                        <button id="juslikeme" onclick="goBack()" class="btn btn-primary">Retour</button>
                    </main>
                </div>
            </div>
        <?php }
    } else { ?>
        </div>
        <div class="col-md-12 welcomemessage">
            <p class="mouff white">Votre espace personnel pour gérer votre candidature et postuler à nos offres.</p>
            <div id="connexioncenter" class="row">
                <?php 
                include('creationDeCompte.php');
                include('formConnexionEmploi.php'); 
                ?>
            </div>
        </div>
    <?php } ?>
</div>

<style>
.blur-effect {
    filter: blur(5px);
    pointer-events: none;
}
.modal {
    backdrop-filter: blur(5px);
}
.modal-content {
    border-radius: 10px;
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}
.modal-header {
    border-bottom: none;
    padding: 20px;
}
.modal-body {
    padding: 30px;
}
.modal-body p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
}
.btn-primary {
    background-color: #0a6535;
    border-color: #0a6535;
    padding: 10px 25px;
}
.btn-primary:hover {
    background-color: #084a27;
    border-color: #084a27;
}
</style>

<script>
jQuery(document).ready(function($) {
    <?php if (is_user_logged_in() && empty($resumes)) : ?>
    $('#cvModal').modal({
        backdrop: 'static',
        keyboard: false
    });
    <?php endif; ?>
});
</script>

<?php
get_sidebar();
get_footer(); 
