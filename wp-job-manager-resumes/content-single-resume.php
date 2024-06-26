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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( resume_manager_user_can_view_resume( $post->ID ) ) : ?>
<div class="single-resume-content">

    <?php do_action( 'single_resume_start' ); ?>
    <div class="row contenuzslms">

        <div id="contenucv" class="col-md-8 col-xs-12 col-sm-12">
            <div class="boxedin">
                <h1><?php the_title(); ?></h1>
                <div class="lkecarotutc">
                    <p class="job-title badge"><?php the_candidate_title(); ?></p>
                    <p class="location badge"><?php the_candidate_location(); ?></p>

                </div>
                <hr>
                <div class="resume_description">
                    <?php echo apply_filters( 'the_resume_description', get_the_content() ); ?>
                </div>

                <?php if ( ( $skills = wp_get_object_terms( $post->ID, 'resume_skill', [ 'fields' => 'names' ] ) ) && is_array( $skills ) ) : ?>
                <h2><?php esc_html_e( 'Skills', 'wp-job-manager-resumes' ); ?></h2>
                <ul class="resume-manager-skills">
                    <?php echo '<li>' . implode( '</li><li>', $skills ) . '</li>'; ?>
                </ul>
                <?php endif; ?>

                <?php if ( $items = get_post_meta( $post->ID, '_candidate_education', true ) ) : ?>
                <h2><?php esc_html_e( 'Education', 'wp-job-manager-resumes' ); ?></h2>
                <dl class="resume-manager-education">
                    <?php
			foreach ( $items as $item ) :
				?>

                    <dt>
                        <small class="date"><?php echo esc_html( $item['date'] ); ?></small>
                        <h3><?php printf( __( '%1$s at %2$s', 'wp-job-manager-resumes' ), '<strong class="qualification">' . esc_html( $item['qualification'] ) . '</strong>', '<strong class="location">' . esc_html( $item['location'] ) . '</strong>' ); ?>
                        </h3>
                    </dt>
                    <dd>
                        <?php echo wpautop( wptexturize( $item['notes'] ) ); ?>
                    </dd>

                    <?php
				endforeach;
			?>
                </dl>
                <?php endif; ?>

                <?php if ( $items = get_post_meta( $post->ID, '_candidate_experience', true ) ) : ?>
                <h2><?php esc_html_e( 'Experience', 'wp-job-manager-resumes' ); ?></h2>
                <dl class="resume-manager-experience">
                    <?php
			foreach ( $items as $item ) :
				?>

                    <dt>
                        <small class="date"><?php echo esc_html( $item['date'] ); ?></small>
                        <h3><?php printf( __( '%1$s at %2$s', 'wp-job-manager-resumes' ), '<strong class="job_title">' . esc_html( $item['job_title'] ) . '</strong>', '<strong class="employer">' . esc_html( $item['employer'] ) . '</strong>' ); ?>
                        </h3>
                    </dt>
                    <dd>
                        <?php echo wpautop( wptexturize( $item['notes'] ) ); ?>
                    </dd>

                    <?php
				endforeach;
			?>
                </dl>
                <?php endif; ?>

                <ul class="meta">
                    <?php do_action( 'single_resume_meta_start' ); ?>

                    <?php if ( get_the_resume_category() ) : ?>
                    <li class="resume-category"><?php the_resume_category(); ?></li>
                    <?php endif; ?>

                    <li class="date-posted" itemprop="datePosted">
                        <date>
                            <?php printf( __( 'Updated %s ago', 'wp-job-manager-resumes' ), human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                        </date>
                    </li>

                    <?php do_action( 'single_resume_meta_end' ); ?>
                </ul>
            </div>

        </div>
        <div id="sios" class="col-md-4 col-xs-12.col-sm-12">
            <div class="photoducandidat">
                <?php the_candidate_photo( $size = 'engagementhumb')?>
            </div>
            <div class="contactsdsm">
                <?php get_job_manager_template( 'contact-details.php', [ 'post' => $post ], 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

            </div>
            <div class="lienducv">
                <?php the_resume_links(); ?>

            </div>


            <?php //the_candidate_video(); ?>

        </div>

    </div>




    <?php do_action( 'single_resume_end' ); ?>
</div>
<?php else : ?>

<?php get_job_manager_template_part( 'access-denied', 'single-resume', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

<?php endif; ?>