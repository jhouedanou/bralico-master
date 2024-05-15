<?php
/**
 * Bralico functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bralico
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

function bralico_setup()
{
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Bralico, use a find and replace
     * to change 'bralico' to the name of your theme in all the template files.
     */
    load_theme_textdomain('bralico', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'bralico'),
        )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'bralico_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'bralico_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */

function bralico_content_width()
{
    $GLOBALS['content_width'] = apply_filters('bralico_content_width', 640);
}
add_action('after_setup_theme', 'bralico_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function bralico_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'bralico'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here.', 'bralico'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}
add_action('widgets_init', 'bralico_widgets_init');

/**
 * Enqueue scripts and styles.
 */

function bralico_scripts()
{
    wp_enqueue_style('bralico-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('bralico-style', 'rtl', 'replace');

    wp_enqueue_script('bralico-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'bralico_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

//ajouter une fonction pour créer un template personnalisé pour chaque page, basé sur le slug de la page

function page_template_slug($template)
{
    global $post;
    if ($post) {
        $page_template_slug = get_post_meta($post->ID, '_wp_page_template', true);
        if ($page_template_slug) {
            $template = get_stylesheet_directory() . '/page-' . $page_template_slug;
        }
    }
    return $template;
}
//fonction pour créer un template personnalisé pour chaque page, basé sur l'id de la page

function page_template_id($template)
{
    global $post;
    if ($post) {
        $page_template_id = get_post_meta($post->ID, '_wp_page_template', true);
        if ($page_template_id) {
            $template = get_stylesheet_directory() . '/page-' . $page_template_id;
        }
    }
    return $template;
}

//add id to body
function add_page_id_to_body_class($classes)
{
    if (is_page()) {
        $page_id = get_the_ID();
        $classes[] = 'page-id-' . $page_id;
    }
    return $classes;
}
add_filter('body_class', 'add_page_id_to_body_class');

//inclure les cdn de bootstrap css et js

function bootstrap_css()
{
    wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
}
add_action('wp_enqueue_scripts', 'bootstrap_css');

function enqueue_scripts()
{
    
// Enqueue jQuery
    wp_enqueue_script('jquery-slim', 'https://code.jquery.com/jquery-3.5.1.min.js', array(), '3.5.1', true);

    // Enqueue Popper.js
    wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', array('jquery-slim'), '1.16.0', true);

    // Enqueue Bootstrap JS
    wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery-slim', 'popper'), '4.5.2', true);
 //enqueue jquery.stickOnScroll.js 
 wp_enqueue_script('stickOnScroll', get_template_directory_uri() . '/js/jquery.stickOnScroll.js', array('jquery-slim', 'popper', 'bootstrap'), '1.0', true);
    // Enqueue scripts.js
    wp_enqueue_script('scripts', get_template_directory_uri() . '/scripts.js', array('jquery-slim', 'popper', 'bootstrap'), '1.0', true);
   

}
add_action('wp_enqueue_scripts', 'enqueue_scripts');

register_nav_menus(array(
    'Socialmenu' => 'Navigation du haut pour les réseaux sociaux',
    'Footermenu' => 'Menu du footer',
    'Primarymenu'=>'Menu principal'
));

//permettre la mise en ligne de fichiers svg

function custom_upload_mimes($existing_mimes)
{
    // Ajoute webm comme type MIME autorisé
    $existing_mimes['svg'] = 'image/svg+xml';

    return $existing_mimes;
}
add_filter('upload_mimes', 'custom_upload_mimes');

//permettre d'ajouter des images ou des icônes aux menus
// Ajoute un champ personnalisé à chaque élément de menu

function add_custom_nav_fields($menu_item)
{
    $menu_item->image_url = get_post_meta($menu_item->ID, '_menu_item_image_url', true);
    return $menu_item;
}
add_filter('wp_setup_nav_menu_item', 'add_custom_nav_fields');

// Affiche le champ personnalisé dans l'interface d'administration

function display_custom_nav_fields($id, $item, $depth, $args)
{
    ?>
<p class='field-image-url description description-wide'>
    <label for="edit-menu-item-image-url-<?php echo $item->ID; ?>">
        <?php _e('Image URL', 'text_domain');
    ?><br />
        <input type='text' id="edit-menu-item-image-url-<?php echo $item->ID; ?>"
            class='widefat code edit-menu-item-image-url' name="menu-item-image-url[<?php echo $item->ID; ?>]"
            value="<?php echo esc_attr($item->image_url); ?>" />
    </label>
</p>
<?php
}
add_action('wp_nav_menu_item_custom_fields', 'display_custom_nav_fields', 10, 4);

// Enregistre la valeur du champ personnalisé

function update_custom_nav_fields($menu_id, $menu_item_db_id, $args)
{
    if (isset($_POST['menu-item-image-url'][$menu_item_db_id])) {
        $image_url = $_POST['menu-item-image-url'][$menu_item_db_id];
        update_post_meta($menu_item_db_id, '_menu_item_image_url', $image_url);
    }
}
add_action('wp_update_nav_menu_item', 'update_custom_nav_fields', 10, 3);
// contenu personnalisé nommé "produits"
function produits_register_post_type()
{
    $labels = array(
        'name' => 'Produits',
        'singular_name' => 'Produit',
        'add_new' => 'Ajouter',
        'add_new_item' => 'Ajouter un produit',
        'edit_item' => 'Modifier le produit',
        'new_item' => 'Nouveau produit',
        'view_item' => 'Voir le produit',
        'search_items' => 'Rechercher parmi les produits',
        'not_found' => 'Aucun produit trouvé',
        'not_found_in_trash' => 'Aucun produit trouvé dans la corbeille',
        'parent_item_colon' => '',
        'menu_name' => 'Produits',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'produits'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
    );
    register_post_type('produits', $args);
}
add_action('init', 'produits_register_post_type');

function produits_register_taxonomy()
{
    $labels = array(
        'name' => 'Types de boisson',
        'singular_name' => 'Type de boisson',
        'search_items' => 'Rechercher parmi les types de boisson',
        'all_items' => 'Tous les types de boisson',
        'parent_item' => 'Type de boisson parent',
        'parent_item_colon' => 'Type de boisson parent:',
        'edit_item' => 'Modifier le type de boisson',
        'update_item' => 'Mettre à jour le type de boisson',
        'add_new_item' => 'Ajouter un nouveau type de boisson',
        'new_item_name' => 'Nouveau nom du type de boisson',
        'menu_name' => 'Types de boisson',
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'type-de-boisson'),
    );
    register_taxonomy('type-de-boisson', 'produits', $args);
}
add_action('init', 'produits_register_taxonomy');
// Ajouter le champ d'image lors de la création d'un nouveau terme
function add_type_de_boisson_image_field()
{
    echo '<div class="form-field">
        <label for="type_de_boisson_image">Image</label>
        <input type="text" name="type_de_boisson_image" id="type_de_boisson_image" value="">
        <p class="description">Entrez l\'URL de l\'image.</p>
    </div>';
}
add_action('type-de-boisson_add_form_fields', 'add_type_de_boisson_image_field');

// Enregistrer le champ d'image lors de la création d'un nouveau terme
function save_type_de_boisson_image_field($term_id)
{
    if (isset($_POST['type_de_boisson_image'])) {
        update_term_meta($term_id, 'type_de_boisson_image', esc_url_raw($_POST['type_de_boisson_image']));
    }
}
add_action('created_type-de-boisson', 'save_type_de_boisson_image_field');

// Ajouter le champ d'image lors de l'édition d'un terme existant
function edit_type_de_boisson_image_field($term)
{
    $image_url = get_term_meta($term->term_id, 'type_de_boisson_image', true);
    echo '<tr class="form-field">
        <th scope="row"><label for="type_de_boisson_image">Image</label></th>
        <td><input type="text" name="type_de_boisson_image" id="type_de_boisson_image" value="' . esc_url($image_url) . '">
        <p class="description">Entrez l\'URL de l\'image.</p></td>
    </tr>';
}
add_action('type-de-boisson_edit_form_fields', 'edit_type_de_boisson_image_field');

// Enregistrer le champ d'image lors de l'édition d'un terme existant
function update_type_de_boisson_image_field($term_id)
{
    if (isset($_POST['type_de_boisson_image'])) {
        update_term_meta($term_id, 'type_de_boisson_image', esc_url_raw($_POST['type_de_boisson_image']));
    }
}
add_action('edited_type-de-boisson', 'update_type_de_boisson_image_field');
// Add meta box for custom fields
function produits_add_meta_box()
{
    add_meta_box(
        'produits_custom_fields',
        'Informations sur le produit',
        'produits_render_meta_box',
        'produits',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'produits_add_meta_box');

// Render the meta box content
function produits_render_meta_box($post)
{
    // Retrieve the current values of the custom fields
    $style = get_post_meta($post->ID, 'style', true);
    $gout = get_post_meta($post->ID, 'gout', true);
    $date = get_post_meta($post->ID, 'date', true);
    $date_creation = get_post_meta($post->ID, 'date_creation', true);
    $taux_alcool = get_post_meta($post->ID, 'taux_alcool', true);
    $ingredients = get_post_meta($post->ID, 'ingredients', true);
    $format = get_post_meta($post->ID, 'format', true);
    $prix_detail = get_post_meta($post->ID, 'prix_detail', true);
    $prix_grossiste = get_post_meta($post->ID, 'prix_grossiste', true);

    // Output the HTML for the custom fields
    ?>
<div class="formwrapper">

    <div class="formgroup">
        <label for="style">Style:</label>
        <input type="text" id="style" name="style" value="<?php echo esc_attr($style); ?>">
    </div>

    <div class="formgroup">
        <label for="gout">Goût:</label>
        <input type="text" id="gout" name="gout" value="<?php echo esc_attr($gout); ?>">
    </div>


    <div class="formgroup">
        <label for="date_creation">Date de création:</label>
        <input type="text" id="date_creation" name="date_creation" value="<?php echo esc_attr($date_creation); ?>">
    </div>

    <div class="formgroup">
        <label for="taux_alcool">Taux d'alcool:</label>
        <input type="text" id="taux_alcool" name="taux_alcool" value="<?php echo esc_attr($taux_alcool); ?>">
    </div>

    <div class="formgroup">
        <label for="ingredients">Ingrédients:</label>
        <input type="text" id="ingredients" name="ingredients" value="<?php echo esc_attr($ingredients); ?>">
    </div>

    <div class="formgroup">
        <label for="format">Format:</label>
        <input type="text" id="format" name="format" value="<?php echo esc_attr($format); ?>">
    </div>

    <div class="formgroup">
        <label for="prix_detail">Prix détail:</label>
        <input type="text" id="prix_detail" name="prix_detail" value="<?php echo esc_attr($prix_detail); ?>">
    </div>

    <div class="formgroup">
        <label for="prix_grossiste">Prix grossiste:</label>
        <input type="text" id="prix_grossiste" name="prix_grossiste" value="<?php echo esc_attr($prix_grossiste); ?>">
    </div>

</div>
<?php
}

// Save the custom field values
function produits_save_meta_box($post_id)
{
    if (isset($_POST['style'])) {
        update_post_meta($post_id, 'style', sanitize_text_field($_POST['style']));
    }
    if (isset($_POST['gout'])) {
        update_post_meta($post_id, 'gout', sanitize_text_field($_POST['gout']));
    }
    if (isset($_POST['date_creation'])) {
        update_post_meta($post_id, 'date_creation', sanitize_text_field($_POST['date_creation']));
    }
    if (isset($_POST['taux_alcool'])) {
        update_post_meta($post_id, 'taux_alcool', sanitize_text_field($_POST['taux_alcool']));
    }
    if (isset($_POST['ingredients'])) {
        update_post_meta($post_id, 'ingredients', sanitize_text_field($_POST['ingredients']));
    }
    if (isset($_POST['format'])) {
        update_post_meta($post_id, 'format', sanitize_text_field($_POST['format']));
    }
    if (isset($_POST['prix_detail'])) {
        update_post_meta($post_id, 'prix_detail', sanitize_text_field($_POST['prix_detail']));
    }
    if (isset($_POST['prix_grossiste'])) {
        update_post_meta($post_id, 'prix_grossiste', sanitize_text_field($_POST['prix_grossiste']));
    }
}
add_action('save_post_produits', 'produits_save_meta_box');

//contenu personnalisé nommé 'diapositives' pour les diapositives de la page d'accueil
function diapositives_register_post_type()
{
    $labels = array(
        'name' => 'Diapositives',
        'singular_name' => 'Diapositive',
        'add_new' => 'Ajouter',
        'add_new_item' => 'Ajouter une diapositive',
        'edit_item' => 'Modifier la diapositive',
        'new_item' => 'Nouvelle diapositive',
        'view_item' => 'Voir la diapositive',
        'search_items' => 'Rechercher parmi les diapositives',
        'not_found' => 'Aucun diapositive trouvée',
        'not_found_in_trash' => 'Aucun diapositive trouvée dans la corbeille',
        'parent_item_colon' => '',
        'menu_name' => 'Diapositives',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'diapositives'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
    );
    register_post_type('diapositives', $args);
}
add_action('init', 'diapositives_register_post_type');

// commande pour dupliquer un post
function rd_duplicate_post_as_draft()
{
    global $wpdb;
    if (!(isset($_GET['post']) || isset($_POST['post']) || (isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action']))) {
        wp_die('No post to duplicate has been supplied!');
    }

    if (!isset($_GET['duplicate_nonce']) || !wp_verify_nonce($_GET['duplicate_nonce'], basename(__FILE__))) {
        return;
    }

    $post_id = (isset($_GET['post']) ? absint($_GET['post']) : absint($_POST['post']));
    $post = get_post($post_id);

    $current_user = wp_get_current_user();
    $new_post_author = $current_user->ID;

    if (isset($post) && $post != null) {

        $args = array(
            'comment_status' => $post->comment_status,
            'ping_status' => $post->ping_status,
            'post_author' => $new_post_author,
            'post_content' => $post->post_content,
            'post_excerpt' => $post->post_excerpt,
            'post_name' => $post->post_name,
            'post_parent' => $post->post_parent,
            'post_password' => $post->post_password,
            'post_status' => 'draft',
            'post_title' => $post->post_title,
            'post_type' => $post->post_type,
            'to_ping' => $post->to_ping,
            'menu_order' => $post->menu_order,
        );

        $new_post_id = wp_insert_post($args);

        $taxonomies = get_object_taxonomies($post->post_type);
        if (!empty($taxonomies) && is_array($taxonomies)):
            foreach ($taxonomies as $taxonomy) {
                $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
                wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
            }
        endif;

        $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
        if (count($post_meta_infos) != 0) {
            $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
            foreach ($post_meta_infos as $meta_info) {
                $meta_key = $meta_info->meta_key;
                $meta_value = addslashes($meta_info->meta_value);
                $sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
            }
            $sql_query .= implode(" UNION ALL ", $sql_query_sel);
            $wpdb->query($sql_query);
        }

        wp_redirect(admin_url('post.php?action = edit&post = ' . $new_post_id));
        wp_redirect($_SERVER['HTTP_REFERER']);

        exit;
    } else {
        wp_die('Post creation failed, could not find original post: ' . $post_id);
    }
}
add_action('admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft');

function rd_duplicate_post_link($actions, $post)
{
    if (current_user_can('edit_posts')) {
        $actions['duplicate'] = '<a href = "' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce') . '"  rel = "permalink">Duplicate</a>';
    }
    return $actions;
}

add_filter('post_row_actions', 'rd_duplicate_post_link', 10, 2);
add_filter('page_row_actions', 'rd_duplicate_post_link', 10, 2);

function rd_edit_featured_image_link($actions, $post)
{
    if (current_user_can('edit_posts')) {
        $featured_image_id = get_post_thumbnail_id($post->ID);
        if ($featured_image_id) {
            $edit_link = get_edit_post_link($featured_image_id);
            $actions['edit_featured_image'] = '<a href="' . $edit_link . '" title="" rel="permalink">Edit Featured Image</a>';
        }
    }
    return $actions;
}

add_filter('post_row_actions', 'rd_edit_featured_image_link', 10, 2);
add_filter('page_row_actions', 'rd_edit_featured_image_link', 10, 2);

//widget pour les chiffres clés
function arphabet_widgets_init()
{

    register_sidebar(array(
        'name' => 'Chiffre clé 1',
        'id' => 'chiffre-cle-1',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));
    // register 3 other widgets

    register_sidebar(array(
        'name' => 'Chiffre clé 2',
        'id' => 'chiffre-cle-2',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Chiffre clé 3',
        'id' => 'chiffre-cle-3',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Chiffre clé 4',
        'id' => 'chiffre-cle-4',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Valeur du mois',
        'id' => 'valeur-du-mois',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));
    //register 3 another widgets, 1 titled "titre actualités" , 1 titled "nos produits" 1 titles "pub bralico"
    register_sidebar(array(
        'name' => 'Titre actualités',
        'id' => 'titre-actualites',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Titre produits',
        'id' => 'titre-produits',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Pub Bralico Image',
        'id' => 'pub-bralico',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Pub Bralico texte',
        'id' => 'pub-bralico-texte',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Pub Bralico play store',
        'id' => 'pub-bralico-playstore',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Pub Bralico app store',
        'id' => 'pub-bralico-appstore',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Newsletter footer',
        'id' => 'newsletter-footer',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',

    ));
    register_sidebar(array(
        'name' => 'Contacts footer',
        'id' => 'contacts-footer',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Menu footer',
        'id' => 'menu-footer',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'credits footer',
        'id' => 'credits-footer',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'avertissement footer',
        'id' => 'avertissement-footer',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

    //register 3 more widgets , 1 titled "titre espace candidat" , 1 titled "tittre formulaire inscription" , 1 titteld "creation compte"
    
    register_sidebar(array(
        'name' => 'Titre espace candidat',
        'id' => 'titre-espace-candidat',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Titre formulaire connexion',
        'id' => 'titre-formulaire-connexion',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => 'Création compte',
        'id' => 'creation-compte',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        
        'name' => 'Notre pôle emploi',
        'id' => 'notre-pole-emploi',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));


}
add_action('widgets_init', 'arphabet_widgets_init');
// css pour l'admin
function my_admin_theme_style()
{
    wp_enqueue_style('my-admin-theme', get_template_directory_uri() . '/admin-style.css');
}
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
// template personnalisé pour le contenu produit
function single_produits_template($single)
{
    global $wp_query, $post;
    /* Checks for single template by post type */
    if ($post->post_type == "produits") {
        if (file_exists(get_stylesheet_directory() . '/single-produits.php')) {
            return get_stylesheet_directory() . '/single-produits.php';
        }
    }
    return $single;
}

function enqueue_google_fonts()
{
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap', false);
}
add_action('wp_enqueue_scripts', 'enqueue_google_fonts');



//boucle pour la section emploi
function display_posts_from_category_15($atts) {
    ob_start();
    $args = array(
        'cat' => 15,
        'posts_per_page' => 4,
    );

    $query = new WP_Query($args);
    $flip = false;

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $flip = !$flip;
            //get the post id
            $post_id = get_the_ID();
            ?>
<?php 
    $color = $flip ? 'gray' : 'white';
    ?>

<a class="greenda <?php echo $color;?>" href="<?php the_permalink();?>" rel="dofollow">
    <div class="row">
        <div class="col-md-6 imagez <?php echo $flip ? 'order-md-2' : '' ?>">
            <?php the_post_thumbnail(); ?>
        </div>
        <div class="col-md-6 textez <?php echo $flip ? 'order-md-1' : '' ?>">
            <div class="freddzy">
                <div class="psotdate"><?php the_time('j F Y'); ?></div>
                <h2><?php the_title(); ?></h2>
                <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
            </div>
        </div>
    </div>
</a>
<?php
        }
    } else {
        echo 'Pas d\'articles dans cette catégorie.';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('display_posts', 'display_posts_from_category_15');
//boucle pour la page enagements
// Fonction pour obtenir le dernier article d'engagement
function get_latest_engagement_post() {
    $args = array(
        'numberposts' => 5,
        'category_name' => 'engagement',
    );

    $latest_posts = get_posts( $args );

    if ( ! empty( $latest_posts ) ) {
        $output = '<div id="articlerse" class="row">';

        // Premier article
        $post = array_shift($latest_posts);
        $output .= '<div class="row">';
        $output .= '<div class="col-md-6 engagement-post">';
        $output .= '<a href="' . get_permalink( $post ) . '">';
        $output .= get_the_post_thumbnail( $post, 'engagementhumbune' );
        $output .= '</a>';
        $output .= '<p class="post-date">' . get_the_date( 'd M Y', $post ) . '</p>';
        $output .= '<h2 class="post-title">' . $post->post_title . '</h2>';
        $content = get_the_content(null, false, $post);
        $more_position = strpos($content, '<!--more-->');
        if ($more_position !== false) {
            $content_before_more = substr($content, 0, $more_position);
        } else {
            $content_before_more = $content;
        }
        $output .= '<div class="post-excerpt">' . $content_before_more . '</div>';
        $output .= '</div>';
        $output .= '<div id="presita" class="col-md-6">';
        $output .= '<div class="khalif">';
        $output .= '<h4>Articles les plus récents</h4>';
        // Autres articles
        foreach ($latest_posts as $post) {
            $output .= '<div class="winelda">';
            
            $output .= '<div class="wbox">';
            $output .= '<div class="row statos">';
            $output .= '<div class="col-md-4">';
            $output .= '<a href="' . get_permalink( $post ) . '">';
            $output .= get_the_post_thumbnail( $post, 'engagementhumb' );
            $output .= '</a>';
            $output .= '</div>';
            $output .= '<div class="col-md-8">';
            $output .= '<p class="post-date">' . get_the_date( 'd M Y', $post ) . '</p>';
            $output .= '<h2 class="post-title">' . $post->post_title . '</h2>';
            $content = get_the_content(null, false, $post);
            $more_position = strpos($content, '<!--more-->');
            if ($more_position !== false) {
                $content_before_more = substr($content, 0, $more_position);
            } else {
                $content_before_more = $content;
            }
            $content_before_more = mb_strimwidth($content_before_more, 0, 45, '...');
            $output .= '<div class="post-excerpt">' . $content_before_more . '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    return 'Aucun article trouvé dans la catégorie Engagement.';
}

add_shortcode('latest_engagement_post', 'get_latest_engagement_post');

//miniatures pour les produits
function add_salif_image_size() {
    add_image_size('salif', 0, 464, false);
    add_image_size('actuhomepage', 492, 310, true);
    add_image_size('visuelproduit',0,448,false);
    add_image_size('engagementhumb',180,180,true);
    add_image_size('engagementhumbune',743,460,true);
    add_image_size('emploithumbnail',960,463,true);
    add_image_size('poleemploiaccueil',428,466,true);
}
//miniature de 492px sur 310px


add_action('after_setup_theme', 'add_salif_image_size');

function modify_read_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '">Lire plus</a>';
}
add_filter('the_content_more_link', 'modify_read_more_link');

//fonction pour ajouter un champ personnalisé à la page d'accueil
function ajouter_champ_personnalise() {
    // Vérifiez si nous sommes sur la page avec l'ID 290
    global $post;
    if ($post->ID == 290) {
        // Ajoutez votre champ personnalisé
        add_meta_box(
            'mon_champ_personnalise', // ID de la metabox
            'Sous-titre de la page', // Titre de la metabox
            'afficher_champ_personnalise', // Fonction d'affichage
            'page', // Type de post
            'normal', // Contexte
            'high' // Priorité
        );
    }
}

//sous titre de la section emploi 

add_action('add_meta_boxes', 'ajouter_champ_personnalise');

function afficher_champ_personnalise($post) {
    // Utilisez nonce pour la vérification
    wp_nonce_field(plugin_basename(__FILE__), 'mon_champ_personnalise_nonce');

    // Récupérez la valeur du champ personnalisé si elle existe
    $valeur = get_post_meta($post->ID, 'mon_champ_personnalise', true);

    // Affichez le formulaire de champ personnalisé
    echo '<label for="mon_champ_personnalise">Sous-titre de la page</label>';
    echo '<input type="text" id="mon_champ_personnalise" name="mon_champ_personnalise" value="'.esc_attr($valeur).'" size="25" />';
}

function sauvegarder_champ_personnalise($post_id) {
    // Vérifiez si notre nonce est défini.
    if (!isset($_POST['mon_champ_personnalise_nonce'])) {
        return $post_id;
    }

    // Vérifiez si le nonce est valide.
    if (!wp_verify_nonce($_POST['mon_champ_personnalise_nonce'], plugin_basename(__FILE__))) {
        return $post_id;
    }

    // Si c'est une sauvegarde automatique, notre formulaire n'a pas été soumis, donc nous ne voulons rien faire.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Vérifiez les permissions de l'utilisateur.
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    // OK, il est sécuritaire pour nous de sauvegarder les données maintenant.

    // Sanitisez l'entrée de l'utilisateur.
    $ma_data = sanitize_text_field($_POST['mon_champ_personnalise']);

    // Mettez à jour la meta post dans la base de données.
    update_post_meta($post_id, 'mon_champ_personnalise', $ma_data);
}
add_action('save_post', 'sauvegarder_champ_personnalise');

// Ajouter le champ dans la page de profil de l'utilisateur
add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');

function extra_user_profile_fields($user) {
    ?>
<h3><?php _e("Informations supplémentaires", "blank"); ?></h3>

<table class="form-table">
    <tr>
        <th><label for="phone"><?php _e("Téléphone"); ?></label></th>
        <td>
            <input type="text" name="phone" id="phone"
                value="<?php echo esc_attr(get_the_author_meta('phone', $user->ID)); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Veuillez entrer votre numéro de téléphone."); ?></span>
        </td>
    </tr>
</table>
<?php
}

// Sauvegarder la valeur du champ
add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');

function save_extra_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) { 
        return false; 
    }
    update_user_meta($user_id, 'phone', $_POST['phone']);
}
//desactiver l'accès à l'admin pour les utilisateurs non-administrateurs

function disable_admin_access_for_subscribers() {
    // Si l'utilisateur actuel est un abonné et nous sommes dans l'administration de WordPress
    if (current_user_can('subscriber') && is_admin()) {
        // Redirigez l'utilisateur vers la page d'accueil
        wp_redirect(home_url());
        exit;
    }
}
add_action('admin_init', 'disable_admin_access_for_subscribers');
//désactiver la barre d'administration pour les abonnés
function desactiver_barre_admin_pour_abonnes($show_admin_bar) {
    if (current_user_can('subscriber')) {
        $show_admin_bar = false;
    }
    return $show_admin_bar;
}
add_filter('show_admin_bar', 'desactiver_barre_admin_pour_abonnes');
//fonction pour éditer les termes des taxonomies "statut" ,"fonctions", "secteurs" et "lieu" depuis l'interface d'administration et la liste des articles du type de contenu "offre-emploi"

    // Ajoutez de nouvelles colonnes à la liste des posts
function add_new_columns($columns) {
    $columns['statut'] = __('Statut', 'textdomain');
    $columns['fonctions'] = __('Fonctions', 'textdomain');
    $columns['secteurs'] = __('Secteurs', 'textdomain');
    $columns['lieu'] = __('Lieu', 'textdomain');
    return $columns;
}
add_filter('manage_edit-offre-emploi_columns', 'add_new_columns');

// Affichez les termes de la taxonomie dans les nouvelles colonnes
function custom_columns_content($column, $post_id) {
    switch ($column) {
        case 'statut':
            $terms = get_the_term_list($post_id, 'statut', '', ', ', '');
            if (is_string($terms)) echo $terms;
            break;

        case 'fonctions':
            $terms = get_the_term_list($post_id, 'fonctions', '', ', ', '');
            if (is_string($terms)) echo $terms;
            break;

        case 'secteurs':
            $terms = get_the_term_list($post_id, 'secteurs', '', ', ', '');
            if (is_string($terms)) echo $terms;
            break;

        case 'lieu':
            $terms = get_the_term_list($post_id, 'lieu', '', ', ', '');
            if (is_string($terms)) echo $terms;
            break;
    }
}
add_action('manage_offre-emploi_posts_custom_column', 'custom_columns_content', 10, 2);
// Ajoutez des champs à la boîte de modification rapide
// Ajoutez des champs à la boîte de modification rapide
function add_quick_edit_fields($column_name, $post_type) {
    if ($post_type == 'offre-emploi' && ($column_name == 'statut' || $column_name == 'fonctions' || $column_name == 'secteurs' || $column_name == 'lieu')) {
        $taxonomy = get_taxonomy($column_name);
        $terms = get_terms($column_name, array('hide_empty' => false));
        ?>
<fieldset class="inline-edit-col-right">
    <div class="inline-edit-col">
        <label>
            <span class="title"><?php echo ucfirst($column_name); ?></span>
            <span class="input-text-wrap">
                <?php foreach ($terms as $term) { ?>
                <input type="radio" name="<?php echo $column_name; ?>" value="<?php echo $term->slug; ?>">
                <?php echo $term->name; ?><br>
                <?php } ?>
            </span>
        </label>
    </div>
</fieldset>
<?php
    }
}
add_action('quick_edit_custom_box', 'add_quick_edit_fields', 10, 2);

// Enregistrez les données de la boîte de modification rapide
function save_quick_edit_data($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['statut'])) {
        wp_set_object_terms($post_id, sanitize_text_field($_POST['statut']), 'statut', false);
    }

    if (isset($_POST['fonctions'])) {
        wp_set_object_terms($post_id, sanitize_text_field($_POST['fonctions']), 'fonctions', false);
    }

    if (isset($_POST['secteurs'])) {
        wp_set_object_terms($post_id, sanitize_text_field($_POST['secteurs']), 'secteurs', false);
    }

    if (isset($_POST['lieu'])) {
        wp_set_object_terms($post_id, sanitize_text_field($_POST['lieu']), 'lieu', false);
    }
}
add_action('save_post', 'save_quick_edit_data');


// Remplacez les champs de texte par des boutons radio
function replace_textbox_with_radios($args, $post_id) {
    if (!empty($args['taxonomy'])) {
        if (empty($args['walker']) || is_a($args['walker'], 'Walker')) {
            if (!class_exists('Walker_Radio_Checklist')) {
                class Walker_Radio_Checklist extends Walker_Category_Checklist {
                    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
                        extract($args);
                        if (empty($taxonomy)) $taxonomy = 'category';
                        if ($taxonomy == 'category') $name = 'post_category';
                        else $name = 'tax_input[' . $taxonomy . ']';
                        $class = in_array($category->term_id, $popular_cats) ? ' class="popular-category"' : '';
                        $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->term_id . '" type="radio" name="'.$name.'[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked(in_array($category->term_id, $selected_cats), true, false) . disabled(empty($args['disabled']), false, false) . ' /> ' . esc_html(apply_filters('the_category', $category->name)) . '</label>';
                    }
                }
            }
            $args['walker'] = new Walker_Radio_Checklist;
        }
    }
    return $args;
}
add_filter('wp_terms_checklist_args', 'replace_textbox_with_radios', 10, 2);

//isotope pour les offres d'emploi
function enqueue_isotope() {
    // Enregistrez et mettez en file d'attente Isotope depuis le CDN
    wp_enqueue_script('isotope', 'https://cdn.jsdelivr.net/npm/isotope-layout@3.0.6/dist/isotope.pkgd.min.js', array('jquery'), '3.0.6', true);

    // Enregistrez et mettez en file d'attente imagesLoaded depuis le CDN
    wp_enqueue_script('imagesloaded', 'https://cdn.jsdelivr.net/npm/imagesloaded@4.1.4/dist/imagesloaded.pkgd.min.js', array('jquery'), '4.1.4', true);
}
add_action('wp_enqueue_scripts', 'enqueue_isotope');
?>