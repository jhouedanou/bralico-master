<?php
/**
 * Content for a single resume.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-resumes/content-single-resume.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager-resumes
 * @category    Template
 * @version     1.7.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (resume_manager_user_can_view_resume($post->ID)) : ?>
<div class="single-resume-content">
    <div class="row contenuzslms">
        <div id="contenucv" class="col-md-12 col-xs-12 col-sm-12">
            <div class="boxedin">


                <div class="resume-details">
                    <!-- <h1>Details</h1> -->
                    <?php if (get_post_meta($post->ID, '_candidate_speciality', true)) : ?>
                    <div class="resume-section">
                        <p><strong>Spécialité du candidat : </strong><?php echo esc_html(get_post_meta($post->ID, '_candidate_speciality', true)); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (get_post_meta($post->ID, '_candidate_diploma', true)) : ?>
                    <div class="resume-section">
                        <p><strong>Dernier diplôme : </strong><?php echo esc_html(get_post_meta($post->ID, '_candidate_diploma', true)); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (get_post_meta($post->ID, '_candidate_experience_years', true)) : ?>
                    <div class="resume-section">
                        <p><strong>Expérience professionnelle : </strong><?php echo esc_html(get_post_meta($post->ID, '_candidate_experience_years', true)); ?> années d'expérience</p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (get_post_meta($post->ID, '_candidate_email', true)) : ?>
                    <div class="resume-section">
                        <p><strong>Email : </strong><?php echo esc_html(get_post_meta($post->ID, '_candidate_email', true)); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (get_post_meta($post->ID, '_candidate_nationality', true)) : ?>
                    <div class="resume-section">
                        <p><strong>Nationalité : </strong><?php echo esc_html(get_post_meta($post->ID, '_candidate_nationality', true)); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (get_post_meta($post->ID, '_candidate_date_of_birth', true)) : ?>
                    <div class="resume-section">
                        <p><strong>Date de naissance : </strong><?php echo esc_html(get_post_meta($post->ID, '_candidate_date_of_birth', true)); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (get_post_meta($post->ID, '_candidate_location', true)) : ?>
                    <div class="resume-section">
                        <p><strong>Localisation : </strong><?php the_candidate_location(); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (get_post_meta($post->ID, '_candidate_phone', true)) : ?>
                    <div class="resume-section">
                        <p><strong>Téléphone : </strong><?php echo esc_html(get_post_meta($post->ID, '_candidate_phone', true)); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
  <div class="resume-details">
  <?php if (get_post_meta($post->ID, '_candidate_experience', true)) : ?>
<div class="resume-section">
    <h3>Expériences professionnelles</h3>
    <table class="resume-table">
        <thead>
            <tr>
                <th>Poste</th>
                <th>Entreprise</th>
                <th>Période</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (get_post_meta($post->ID, '_candidate_experience', true) as $experience) : ?>
            <tr>
                <td><?php echo esc_html($experience['job_title']); ?></td>
                <td><?php echo esc_html($experience['employer']); ?></td>
                <td><?php echo esc_html($experience['date']); ?></td>
                <td><?php echo wpautop($experience['notes']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php if (get_post_meta($post->ID, '_candidate_education', true)) : ?>
<div class="resume-section">
    <h3>Formation</h3>
    <table class="resume-table">
        <thead>
            <tr>
                <th>Diplôme</th>
                <th>École</th>
                <th>Période</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (get_post_meta($post->ID, '_candidate_education', true) as $education) : ?>
            <tr>
                <td><?php echo esc_html($education['qualification']); ?></td>
                <td><?php echo esc_html($education['location']); ?></td>
                <td><?php echo esc_html($education['date']); ?></td>
                <td><?php echo wpautop($education['notes']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

  </div>
            </div>
        </div>

        <div id="sios" class="col-md-12 col-xs-12 col-sm-12 p-4">
            <div class="row d-flex flex-column justify-content-center align-items-center">
                <br>
                <!-- <div class="contactsdsm col-md-12">
                    <?php get_job_manager_template('contact-details.php', ['post' => $post], 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/'); ?>
                </div> -->

                <div class="lienducv col-md-12 text-center d-flex flex-column align-items-center">
                            <p>Télécharger le CV</p>
                            <?php the_resume_links(); ?>
                        </div>
            </div>
        </div>
    </div>
</div>
<?php else : ?>
    <?php get_job_manager_template_part('access-denied', 'single-resume', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/'); ?>
<?php endif; ?>