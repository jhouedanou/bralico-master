<?php
/**
 * Fonctionnalité pour afficher les dernières candidatures de WP Job Manager sur la page d'accueil
 */

// Fonction pour afficher les dernières candidatures via un shortcode
function bralico_display_recent_applications($atts) {
    // Définition des paramètres par défaut
    $atts = shortcode_atts(array(
        'nombre' => 5,          // Nombre de candidatures à afficher
        'titre' => 'Dernières candidatures',  // Titre du widget
        'class' => 'recent-applications-widget', // Classe CSS pour personnaliser
    ), $atts);
    
    // Récupérer les candidatures récentes
    $args = array(
        'post_type' => 'job_application',
        'posts_per_page' => intval($atts['nombre']),
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    $applications = get_posts($args);
    
    // Commencer la sortie avec mise en mémoire tampon
    ob_start();
    
    echo '<div class="' . esc_attr($atts['class']) . '">';
    echo '<h3 class="widget-title">' . esc_html($atts['titre']) . '</h3>';
    
    if (!empty($applications)) {
        echo '<ul class="application-list">';
        
        foreach ($applications as $application) {
            $job_id = get_post_meta($application->ID, '_job_id', true);
            $job_title = get_the_title($job_id);
            $candidate_name = get_post_meta($application->ID, '_candidate_name', true);
            $resume_id = get_post_meta($application->ID, '_resume_id', true);
            $application_date = get_the_date('d/m/Y', $application->ID);
            
            echo '<li class="application-item">';
            echo '<span class="candidate-name">' . esc_html($candidate_name) . '</span>';
            echo '<div class="application-meta">';
            echo '<span class="job-title">' . esc_html($job_title) . '</span>';
            echo '<span class="application-date">' . $application_date . '</span>';
            echo '</div>';
            
            if (current_user_can('manage_job_applications')) {
                echo '<a href="' . admin_url('post.php?post=' . $application->ID . '&action=edit') . '" class="view-application-button">';
                echo 'Voir les détails';
                echo '</a>';
            }
            
            echo '</li>';
        }
        
        echo '</ul>';
        
        if (current_user_can('manage_job_applications')) {
            echo '<a href="' . admin_url('edit.php?post_type=job_application') . '" class="view-all-applications">';
            echo 'Voir toutes les candidatures';
            echo '</a>';
        }
    } else {
        echo '<p>Aucune candidature trouvée.</p>';
    }
    
    echo '</div>';
    
    // Ajouter du CSS pour le style
    echo '<style>
        .' . esc_attr($atts['class']) . ' {
            background-color: #fff;
            border: 1px solid #e5e5e5;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        .' . esc_attr($atts['class']) . ' .widget-title {
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .' . esc_attr($atts['class']) . ' .application-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .' . esc_attr($atts['class']) . ' .application-item {
            border-bottom: 1px solid #f5f5f5;
            padding: 10px 0;
            margin-bottom: 10px;
        }
        .' . esc_attr($atts['class']) . ' .application-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .' . esc_attr($atts['class']) . ' .candidate-name {
            font-weight: bold;
            display: block;
        }
        .' . esc_attr($atts['class']) . ' .application-meta {
            font-size: 0.9em;
            color: #666;
            margin: 5px 0;
        }
        .' . esc_attr($atts['class']) . ' .job-title {
            margin-right: 10px;
        }
        .' . esc_attr($atts['class']) . ' .application-date {
            color: #999;
        }
        .' . esc_attr($atts['class']) . ' .view-application-button {
            display: inline-block;
            padding: 3px 10px;
            background-color: #f7f7f7;
            border: 1px solid #ccc;
            border-radius: 3px;
            text-decoration: none;
            font-size: 12px;
            color: #555;
            margin-top: 5px;
        }
        .' . esc_attr($atts['class']) . ' .view-application-button:hover {
            background-color: #f0f0f0;
            color: #23282d;
        }
        .' . esc_attr($atts['class']) . ' .view-all-applications {
            display: block;
            text-align: center;
            margin-top: 15px;
            padding: 5px;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            text-decoration: none;
        }
    </style>';
    
    // Récupérer le contenu du tampon et le retourner
    return ob_get_clean();
}
add_shortcode('dernieres_candidatures', 'bralico_display_recent_applications');

// Création d'un widget pour afficher les dernières candidatures
class Bralico_Recent_Applications_Widget extends WP_Widget {
    // Constructeur
    public function __construct() {
        parent::__construct(
            'bralico_recent_applications',
            'Bralico - Dernières Candidatures',
            array('description' => 'Affiche les dernières candidatures reçues')
        );
    }

    // Front-end du widget
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'Dernières candidatures';
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;

        echo $args['before_widget'];
        echo $args['before_title'] . esc_html($title) . $args['after_title'];
        
        // Utilisation de la fonction de shortcode pour l'affichage
        echo bralico_display_recent_applications(array(
            'nombre' => $number,
            'titre' => '',  // Le titre est déjà affiché par le widget
            'class' => 'recent-applications-widget-content'
        ));
        
        echo $args['after_widget'];
    }

    // Back-end du widget (formulaire d'administration)
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'Dernières candidatures';
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Titre:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>">Nombre de candidatures à afficher:</label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3">
        </p>
        <?php
    }

    // Mise à jour des paramètres du widget
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;

        return $instance;
    }
}

// Enregistrement du widget
function bralico_register_recent_applications_widget() {
    register_widget('Bralico_Recent_Applications_Widget');
}
add_action('widgets_init', 'bralico_register_recent_applications_widget');
