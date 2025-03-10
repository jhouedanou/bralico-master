<?php
    /**
     * Bralico functions and definitions
     *
     * @link https://developer.wordpress.org/themes/basics/theme-functions/
     *
     * @package Bralico
     */

    if (! defined('_S_VERSION')) {
        // Replace the version number of the theme on each release.
        define('_S_VERSION', '2.0.0');
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
            [
                'menu-1' => esc_html__('Primary', 'bralico'),
            ]
        );

        /*
* Switch default core markup for search form, comment form, and comments
* to output valid HTML5.
*/
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            ]
        );

        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters(
                'bralico_custom_background_args',
                [
                    'default-color' => 'ffffff',
                    'default-image' => '',
                ]
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
            [
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            ]
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
            [
                'name'          => esc_html__('Sidebar', 'bralico'),
                'id'            => 'sidebar-1',
                'de ion'        => esc_html__('Add widgets here.', 'bralico'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ]
        );
    }
    add_action('widgets_init', 'bralico_widgets_init');

    /**
     * Enqueue scripts and styles.
     */

    function bralico_scripts()
    {
        wp_enqueue_style('bralico-style', get_stylesheet_uri(), [], _S_VERSION);
        wp_style_add_data('bralico-style', 'rtl', 'replace');

        wp_enqueue_script('bralico-navigation', get_template_directory_uri() . '/js/navigation.js', [], _S_VERSION, true);

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
            $page_id   = get_the_ID();
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
        // Enqueue Popper.js
        wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', ['jquery'], '1.16.0', true);

        // Enqueue Bootstrap JS
        wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', ['jquery', 'popper'], '4.5.2', true);

        // Enqueue jquery.stickOnScroll.js
        wp_enqueue_script('stickOnScroll', get_template_directory_uri() . '/js/jquery.stickOnScroll.js', ['jquery'], '1.0', true);

        // Enqueue scripts.js
        wp_enqueue_script('scripts', get_template_directory_uri() . '/scripts.js', ['jquery'], '1.0', true);
    }
    add_action('wp_enqueue_scripts', 'enqueue_scripts');

    function enqueue_acf_scripts()
    {
        // Enqueue jQuery
        //wp_enqueue_script('jquery');
        // Enqueue ACF scripts and styles
        // wp_enqueue_script('acf-input');
        // wp_enqueue_script('acf-field-group');
        // wp_enqueue_style('acf-global');
        // wp_enqueue_style('acf-input');
        // wp_enqueue_style('acf-field-group');
        // Enqueue jQuery UI scripts
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-ui-mouse');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-autocomplete');
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_style('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');

    }
    add_action('wp_enqueue_scripts', 'enqueue_acf_scripts');

    register_nav_menus([
        'Socialmenu'  => 'Navigation du haut pour les réseaux sociaux',
        'Footermenu'  => 'Menu du footer',
        'Primarymenu' => 'Menu principal',
    ]);

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
        $labels = [
            'name'               => 'Produits',
            'singular_name'      => 'Produit',
            'add_new'            => 'Ajouter',
            'add_new_item'       => 'Ajouter un produit',
            'edit_item'          => 'Modifier le produit',
            'new_item'           => 'Nouveau produit',
            'view_item'          => 'Voir le produit',
            'search_items'       => 'Rechercher parmi les produits',
            'not_found'          => 'Aucun produit trouvé',
            'not_found_in_trash' => 'Aucun produit trouvé dans la corbeille',
            'parent_item_colon'  => '',
            'menu_name'          => 'Produits',
        ];
        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'produits'],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
        ];
        register_post_type('produits', $args);
    }
    add_action('init', 'produits_register_post_type');

    function produits_register_taxonomy()
    {
        $labels = [
            'name'              => 'Types de boisson',
            'singular_name'     => 'Type de boisson',
            'search_items'      => 'Rechercher parmi les types de boisson',
            'all_items'         => 'Tous les types de boisson',
            'parent_item'       => 'Type de boisson parent',
            'parent_item_colon' => 'Type de boisson parent:',
            'edit_item'         => 'Modifier le type de boisson',
            'update_item'       => 'Mettre à jour le type de boisson',
            'add_new_item'      => 'Ajouter un nouveau type de boisson',
            'new_item_name'     => 'Nouveau nom du type de boisson',
            'menu_name'         => 'Types de boisson',
        ];
        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'type-de-boisson'],
        ];
        register_taxonomy('type-de-boisson', 'produits', $args);
    }
    add_action('init', 'produits_register_taxonomy');
    // Ajouter le champ d'image lors de la création d'un nouveau terme
    // Ajouter les champs d'image et d'icône lors de la création d'un nouveau terme
    function add_type_de_boisson_fields()
    {
        echo '<div class="form-field">
<label for="type_de_boisson_image">Image</label>
<input type="text" name="type_de_boisson_image" id="type_de_boisson_image" value="">
<p class="description">Entrez l\'URL de l\'image.</p>
</div>';

        echo '<div class="form-field">
<label for="type_de_boisson_icon">Icône</label>
<input type="text" name="type_de_boisson_icon" id="type_de_boisson_icon" value="">
<p class="description">Entrez l\'URL de l\'icône.</p>
</div>';
    }
    add_action('type-de-boisson_add_form_fields', 'add_type_de_boisson_fields');

    // Enregistrer les champs d'image et d'icône lors de la création d'un nouveau terme
    function save_type_de_boisson_fields($term_id)
    {
        if (isset($_POST['type_de_boisson_image'])) {
            update_term_meta($term_id, 'type_de_boisson_image', esc_url_raw($_POST['type_de_boisson_image']));
        }
        if (isset($_POST['type_de_boisson_icon'])) {
            update_term_meta($term_id, 'type_de_boisson_icon', esc_url_raw($_POST['type_de_boisson_icon']));
        }
    }
    add_action('created_type-de-boisson', 'save_type_de_boisson_fields');

    // Ajouter les champs d'image et d'icône lors de l'édition d'un terme existant
    function edit_type_de_boisson_fields($term)
    {
        $image_url = get_term_meta($term->term_id, 'type_de_boisson_image', true);
        $icon_url  = get_term_meta($term->term_id, 'type_de_boisson_icon', true);

        echo '<tr class="form-field">
<th scope="row"><label for="type_de_boisson_image">Image</label></th>
<td><input type="text" name="type_de_boisson_image" id="type_de_boisson_image" value="' . esc_url($image_url) . '">
<p class="description">Entrez l\'URL de l\'image.</p></td>
</tr>';

        echo '<tr class="form-field">
<th scope="row"><label for="type_de_boisson_icon">Icône</label></th>
<td><input type="text" name="type_de_boisson_icon" id="type_de_boisson_icon" value="' . esc_url($icon_url) . '">
<p class="description">Entrez l\'URL de l\'icône.</p></td>
</tr>';
    }
    add_action('type-de-boisson_edit_form_fields', 'edit_type_de_boisson_fields');

    // Enregistrer les champs d'image et d'icône lors de l'édition d'un terme existant
    function update_type_de_boisson_fields($term_id)
    {
        if (isset($_POST['type_de_boisson_image'])) {
            update_term_meta($term_id, 'type_de_boisson_image', esc_url_raw($_POST['type_de_boisson_image']));
        }
        if (isset($_POST['type_de_boisson_icon'])) {
            update_term_meta($term_id, 'type_de_boisson_icon', esc_url_raw($_POST['type_de_boisson_icon']));
        }
    }
    add_action('edited_type-de-boisson', 'update_type_de_boisson_fields');
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
        $style          = get_post_meta($post->ID, 'style', true);
        $gout           = get_post_meta($post->ID, 'gout', true);
        $date           = get_post_meta($post->ID, 'date', true);
        $date_creation  = get_post_meta($post->ID, 'date_creation', true);
        $taux_alcool    = get_post_meta($post->ID, 'taux_alcool', true);
        $ingredients    = get_post_meta($post->ID, 'ingredients', true);
        $format         = get_post_meta($post->ID, 'format', true);
        $prix_detail    = get_post_meta($post->ID, 'prix_detail', true);
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
        $labels = [
            'name'               => 'Diapositives',
            'singular_name'      => 'Diapositive',
            'add_new'            => 'Ajouter',
            'add_new_item'       => 'Ajouter une diapositive',
            'edit_item'          => 'Modifier la diapositive',
            'new_item'           => 'Nouvelle diapositive',
            'view_item'          => 'Voir la diapositive',
            'search_items'       => 'Rechercher parmi les diapositives',
            'not_found'          => 'Aucun diapositive trouvée',
            'not_found_in_trash' => 'Aucun diapositive trouvée dans la corbeille',
            'parent_item_colon'  => '',
            'menu_name'          => 'Diapositives',
        ];
        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'diapositives'],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
        ];
        register_post_type('diapositives', $args);
    }
    add_action('init', 'diapositives_register_post_type');

    // commande pour dupliquer un post
    function rd_duplicate_post_as_draft()
    {
        global $wpdb;
        if (! (isset($_GET['post']) || isset($_POST['post']) || (isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action']))) {
            wp_die('No post to duplicate has been supplied!');
        }

        if (! isset($_GET['duplicate_nonce']) || ! wp_verify_nonce($_GET['duplicate_nonce'], basename(__FILE__))) {
            return;
        }

        $post_id = (isset($_GET['post']) ? absint($_GET['post']) : absint($_POST['post']));
        $post    = get_post($post_id);

        $current_user    = wp_get_current_user();
        $new_post_author = $current_user->ID;

        if (isset($post) && $post != null) {

            $args = [
                'comment_status' => $post->comment_status,
                'ping_status'    => $post->ping_status,
                'post_author'    => $new_post_author,
                'post_content'   => $post->post_content,
                'post_excerpt'   => $post->post_excerpt,
                'post_name'      => $post->post_name,
                'post_parent'    => $post->post_parent,
                'post_password'  => $post->post_password,
                'post_status'    => 'draft',
                'post_title'     => $post->post_title,
                'post_type'      => $post->post_type,
                'to_ping'        => $post->to_ping,
                'menu_order'     => $post->menu_order,
            ];

            $new_post_id = wp_insert_post($args);

            $taxonomies = get_object_taxonomies($post->post_type);
            if (! empty($taxonomies) && is_array($taxonomies)):
                foreach ($taxonomies as $taxonomy) {
                    $post_terms = wp_get_object_terms($post_id, $taxonomy, ['fields' => 'slugs']);
                    wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
                }
            endif;

            $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
            if (count($post_meta_infos) != 0) {
                $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
                foreach ($post_meta_infos as $meta_info) {
                    $meta_key        = $meta_info->meta_key;
                    $meta_value      = addslashes($meta_info->meta_value);
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
                $edit_link                      = get_edit_post_link($featured_image_id);
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

        register_sidebar([
            'name'          => 'Chiffre clé 1',
            'id'            => 'chiffre-cle-1',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);
        // register 3 other widgets

        register_sidebar([
            'name'          => 'Chiffre clé 2',
            'id'            => 'chiffre-cle-2',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        register_sidebar([
            'name'          => 'Chiffre clé 3',
            'id'            => 'chiffre-cle-3',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        register_sidebar([
            'name'          => 'Chiffre clé 4',
            'id'            => 'chiffre-cle-4',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);
        register_sidebar([
            'name'          => 'Valeur du mois',
            'id'            => 'valeur-du-mois',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);
        //register 3 another widgets, 1 titled "titre actualités" , 1 titled "nos produits" 1 titles "pub bralico"
        register_sidebar([
            'name'          => 'Titre actualités',
            'id'            => 'titre-actualites',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        register_sidebar([
            'name'          => 'Titre produits',
            'id'            => 'titre-produits',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        register_sidebar([
            'name'          => 'Pub Bralico Image',
            'id'            => 'pub-bralico',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        register_sidebar([
            'name'          => 'Pub Bralico texte',
            'id'            => 'pub-bralico-texte',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        register_sidebar([
            'name'          => 'Pub Bralico play store',
            'id'            => 'pub-bralico-playstore',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);
        register_sidebar([
            'name'          => 'Pub Bralico app store',
            'id'            => 'pub-bralico-appstore',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);
        register_sidebar([
            'name'          => 'Newsletter footer',
            'id'            => 'newsletter-footer',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',

        ]);
        register_sidebar([
            'name'          => 'Contacts footer',
            'id'            => 'contacts-footer',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);
        register_sidebar([
            'name'          => 'Menu footer',
            'id'            => 'menu-footer',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        register_sidebar([
            'name'          => 'credits footer',
            'id'            => 'credits-footer',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        register_sidebar([
            'name'          => 'avertissement footer',
            'id'            => 'avertissement-footer',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        //register 3 more widgets , 1 titled "titre espace candidat" , 1 titled "tittre formulaire inscription" , 1 titteld "creation compte"

        register_sidebar([
            'name'          => 'Titre espace candidat',
            'id'            => 'titre-espace-candidat',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        register_sidebar([
            'name'          => 'Titre formulaire connexion',
            'id'            => 'titre-formulaire-connexion',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        register_sidebar([
            'name'          => 'Création compte',
            'id'            => 'creation-compte',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);
        register_sidebar([

            'name'          => 'Notre pôle emploi',
            'id'            => 'notre-pole-emploi',
            'before_widget' => '<div id="polemploi">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

        register_sidebar([

            'name'          => 'Popup Vidéo',
            'id'            => 'popup-video',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ]);

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
    function display_posts_from_category_15($atts)
    {
        ob_start();
        $args = [
            'cat'            => 15,
            'posts_per_page' => 4,
        ];

        $query = new WP_Query($args);
        $flip  = false;

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $flip = ! $flip;
                //get the post id
                $post_id = get_the_ID();
            ?>
<?php
    $color = $flip ? 'gray' : 'white';
            ?>

<a class="greenda                                                                     <?php echo $color; ?>" href="<?php the_permalink(); ?>" rel="dofollow">
<div class="row">
<div class="col-md-6 imagez                                                                                                                     <?php echo $flip ? 'order-md-2' : '' ?>">
    <?php the_post_thumbnail(); ?>
</div>
<div class="col-md-6 textez                                                                                                                     <?php echo $flip ? 'order-md-1' : '' ?>">
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
    function get_latest_engagement_post()
    {
        $args = [
            'numberposts'   => 5,
            'category_name' => 'engagement',
        ];

        $latest_posts = get_posts($args);

        if (! empty($latest_posts)) {
            $output = '<div id="articlerse" class="row">';

            // Premier article
            $post = array_shift($latest_posts);
            $output .= '<div class="row">';
            $output .= '<div class="col-md-6 engagement-post">';
            $output .= '<a href="' . get_permalink($post) . '">';
            $output .= get_the_post_thumbnail($post, 'engagementhumbune');
            $output .= '</a>';
            $output .= '<p class="post-date">' . get_the_date('d M Y', $post) . '</p>';
            $output .= '<h2 class="post-title">' . $post->post_title . '</h2>';
            $content       = get_the_content(null, false, $post);
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
                $output .= '<a href="' . get_permalink($post) . '">';
                $output .= get_the_post_thumbnail($post, 'engagementhumb');
                $output .= '</a>';
                $output .= '</div>';
                $output .= '<div class="col-md-8">';
                $output .= '<p class="post-date">' . get_the_date('d M Y', $post) . '</p>';
                $output .= '<h2 class="post-title"><a href="' . get_permalink($post) . '">' . $post->post_title . '</a></h2>';
                $content       = get_the_content(null, false, $post);
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

            return $output;
        }

        return 'Aucun article trouvé dans la catégorie Engagement.';
    }

    add_shortcode('latest_engagement_post', 'get_latest_engagement_post');

    //miniatures pour les produits
    function add_salif_image_size()
    {
        add_image_size('salif', 0, 464, false);
        add_image_size('actuhomepage', 492, 310, true);
        add_image_size('visuelproduit', 0, 448, false);
        add_image_size('engagementhumb', 180, 180, true);
        add_image_size('engagementhumbune', 743, 460, true);
        add_image_size('emploithumbnail', 960, 463, true);
        add_image_size('poleemploiaccueil', 428, 466, true);
    }
    //miniature de 492px sur 310px

    add_action('after_setup_theme', 'add_salif_image_size');

    function modify_read_more_link()
    {
        return '<a class="more-link" href="' . get_permalink() . '">Lire plus</a>';
    }
    add_filter('the_content_more_link', 'modify_read_more_link');

    //fonction pour ajouter un champ personnalisé à la page d'accueil
    function ajouter_champ_personnalise()
    {
        // Vérifiez si nous sommes sur la page avec l'ID 290
        global $post;
        if ($post->ID == 290) {
            // Ajoutez votre champ personnalisé
            add_meta_box(
                'mon_champ_personnalise',      // ID de la metabox
                'Sous-titre de la page',       // Titre de la metabox
                'afficher_champ_personnalise', // Fonction d'affichage
                'page',                        // Type de post
                'normal',                      // Contexte
                'high'                         // Priorité
            );
        }
    }

    //sous titre de la section emploi

    add_action('add_meta_boxes', 'ajouter_champ_personnalise');

    function afficher_champ_personnalise($post)
    {
        // Utilisez nonce pour la vérification
        wp_nonce_field(plugin_basename(__FILE__), 'mon_champ_personnalise_nonce');

        // Récupérez la valeur du champ personnalisé si elle existe
        $valeur = get_post_meta($post->ID, 'mon_champ_personnalise', true);

        // Affichez le formulaire de champ personnalisé
        echo '<label for="mon_champ_personnalise">Sous-titre de la page</label>';
        echo '<input type="text" id="mon_champ_personnalise" name="mon_champ_personnalise" value="' . esc_attr($valeur) . '" size="25" />';
    }

    function sauvegarder_champ_personnalise($post_id)
    {
        // Vérifiez si notre nonce est défini.
        if (! isset($_POST['mon_champ_personnalise_nonce'])) {
            return $post_id;
        }

        // Vérifiez si le nonce est valide.
        if (! wp_verify_nonce($_POST['mon_champ_personnalise_nonce'], plugin_basename(__FILE__))) {
            return $post_id;
        }

        // Si c'est une sauvegarde automatique, notre formulaire n'a pas été soumis, donc nous ne voulons rien faire.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // Vérifiez les permissions de l'utilisateur.
        if ('page' == $_POST['post_type']) {
            if (! current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (! current_user_can('edit_post', $post_id)) {
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

    function extra_user_profile_fields($user)
    {
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

    function save_extra_user_profile_fields($user_id)
    {
        if (! current_user_can('edit_user', $user_id)) {
            return false;
        }
        update_user_meta($user_id, 'phone', $_POST['phone']);
    }
    //desactiver l'accès à l'admin pour les utilisateurs non-administrateurs
    /* 
function disable_admin_access_for_subscribers() {
if (current_user_can('subscriber') && is_admin()) {
// Redirigez l'utilisateur vers la page d'accueil
wp_redirect(home_url());
exit;
}
}
add_action('admin_init', 'disable_admin_access_for_subscribers');
function desactiver_barre_admin_pour_abonnes($show_admin_bar) {
if (current_user_can('subscriber')) {
$show_admin_bar = false;
}
return $show_admin_bar;
}
add_filter('show_admin_bar', 'desactiver_barre_admin_pour_abonnes');
*/
    //fonction pour éditer les termes des taxonomies "statut" ,"fonctions", "secteurs" et "lieu" depuis l'interface d'administration et la liste des articles du type de contenu "offre-emploi"

    // Ajoutez de nouvelles colonnes à la liste des posts
    function add_new_columns($columns)
    {
        $columns['statut']    = __('Statut', 'textdomain');
        $columns['fonctions'] = __('Fonctions', 'textdomain');
        $columns['secteurs']  = __('Secteurs', 'textdomain');
        $columns['lieu']      = __('Lieu', 'textdomain');
        return $columns;
    }
    add_filter('manage_edit-offre-emploi_columns', 'add_new_columns');

    // Affichez les termes de la taxonomie dans les nouvelles colonnes
    function custom_columns_content($column, $post_id)
    {
        switch ($column) {
            case 'statut':
                $terms = get_the_term_list($post_id, 'statut', '', ', ', '');
                if (is_string($terms)) {
                    echo $terms;
                }

                break;

            case 'fonctions':
                $terms = get_the_term_list($post_id, 'fonctions', '', ', ', '');
                if (is_string($terms)) {
                    echo $terms;
                }

                break;

            case 'secteurs':
                $terms = get_the_term_list($post_id, 'secteurs', '', ', ', '');
                if (is_string($terms)) {
                    echo $terms;
                }

                break;

            case 'lieu':
                $terms = get_the_term_list($post_id, 'lieu', '', ', ', '');
                if (is_string($terms)) {
                    echo $terms;
                }

                break;
        }
    }
    add_action('manage_offre-emploi_posts_custom_column', 'custom_columns_content', 10, 2);
    // Ajoutez des champs à la boîte de modification rapide
    // Ajoutez des champs à la boîte de modification rapide
    function add_quick_edit_fields($column_name, $post_type)
    {
        if ($post_type == 'offre-emploi' && ($column_name == 'statut' || $column_name == 'fonctions' || $column_name == 'secteurs' || $column_name == 'lieu')) {
            $taxonomy = get_taxonomy($column_name);
            $terms    = get_terms($column_name, ['hide_empty' => false]);
        ?>
<fieldset class="inline-edit-col-right">
<div class="inline-edit-col">
<label>
    <span class="title"><?php echo ucfirst($column_name); ?></span>
    <span class="input-text-wrap">
        <?php foreach ($terms as $term) {?>
        <input type="radio" name="<?php echo $column_name; ?>" value="<?php echo $term->slug; ?>">
        <?php echo $term->name; ?><br>
        <?php }?>
    </span>
</label>
</div>
</fieldset>
<?php
    }
    }
    add_action('quick_edit_custom_box', 'add_quick_edit_fields', 10, 2);

    // Enregistrez les données de la boîte de modification rapide
    function save_quick_edit_data($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (! current_user_can('edit_post', $post_id)) {
            return;
        }

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
    function replace_textbox_with_radios($args, $post_id)
    {
        if (! empty($args['taxonomy'])) {
            if (empty($args['walker']) || is_a($args['walker'], 'Walker')) {
                if (! class_exists('Walker_Radio_Checklist')) {
                    class Walker_Radio_Checklist extends Walker_Category_Checklist
                    {
                        public function start_el(&$output, $category, $depth = 0, $args = [], $id = 0)
                        {
                            extract($args);
                            if (empty($taxonomy)) {
                                $taxonomy = 'category';
                            }

                            if ($taxonomy == 'category') {
                                $name = 'post_category';
                            } else {
                                $name = 'tax_input[' . $taxonomy . ']';
                            }

                            $class = in_array($category->term_id, $popular_cats) ? ' class="popular-category"' : '';
                            $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->term_id . '" type="radio" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked(in_array($category->term_id, $selected_cats), true, false) . disabled(empty($args['disabled']), false, false) . ' /> ' . esc_html(apply_filters('the_category', $category->name)) . '</label>';
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
    function enqueue_isotope()
    {
        // Enregistrez et mettez en file d'attente Isotope depuis le CDN
        wp_enqueue_script('isotope', 'https://cdn.jsdelivr.net/npm/isotope-layout@3.0.6/dist/isotope.pkgd.min.js', ['jquery'], '3.0.6', true);

        // Enregistrez et mettez en file d'attente imagesLoaded depuis le CDN
        wp_enqueue_script('imagesloaded', 'https://cdn.jsdelivr.net/npm/imagesloaded@4.1.4/dist/imagesloaded.pkgd.min.js', ['jquery'], '4.1.4', true);
    }
    add_action('wp_enqueue_scripts', 'enqueue_isotope');

    function set_login_cookie($user_login, $user)
    {
        // Définir un cookie qui expire dans 1 jour (24 * 60 * 60 secondes)
        setcookie('user_logged_in', '1', time() + (24 * 60 * 60), COOKIEPATH, COOKIE_DOMAIN);
        setcookie('user_login', $user_login, time() + (24 * 60 * 60), COOKIEPATH, COOKIE_DOMAIN);
    }
    add_action('wp_login', 'set_login_cookie', 10, 2);

    //changement des labels de champs
    add_filter('submit_resume_form_fields', 'modifier_libelles_formulaire_candidature');

    function modifier_libelles_formulaire_candidature($fields)
    {
        // Modification du libellé du champ nom
        $fields['resume_fields']['candidate_name']['label'] = 'Nom et prénoms *';
        // Modification du libellé du champ localisation
        $fields['resume_fields']['candidate_location']['label'] = 'Lieu de résidence *';
        $fields['resume_fields']['resume_file']['label']        = 'Votre CV (format PDF uniquement) *';
        $fields['resume_fields']['candidate_email']['label']    = "Votre adresse email*";

        return $fields;
    }

    //disable editor for custom post type emploi
    function prefix_disable_gutenberg($current_status, $post_type)
    {
        // Use your post type key instead of 'job_listing'
        if ($post_type === 'job_listing') {
            return false;
        }

        return $current_status;
    }
    add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);

    // Add fields to admin
    add_filter('resume_manager_resume_fields', 'wpjms_admin_resume_form_fields');
    function wpjms_admin_resume_form_fields($fields){




        // Add "nombres d'années d'expérience" field
        $fields['_candidate_experience_years'] = [
            'label'       => __("Nombre d'années d'expérience *", 'job_manager'),
            'type'        => 'text',
            'placeholder' => __('5 years', 'job_manager'),
            'description' => '',
            'required'    => true,
            'priority'    => 1,
        ];
        $fields['_candidate_date_of_birth'] = [
            'label'    => __('Date de naissance *', 'job_manager'),
            'type'     => 'date',
            'required' => true,
            'priority' => 3,
        ];

        // Add "téléphone" field
        $fields['_candidate_phone'] = [
            'label'       => __('Téléphone *', 'job_manager'),
            'required'    => true,
            'type'        => 'text',
            'placeholder' => __('+123456789', 'job_manager'),
            'description' => '',
            'priority'    => 4,
        ];

        // Add "diplôme" field
        $fields['_candidate_diploma'] = [
            'label'    => __('Dernier diplôme obtenu *', 'job_manager'),
            'type'     => 'select',
            'required' => true,
            'options'  => [
                'bac'      => 'Baccalauréat',
                'bts'      => 'BTS',
                'licence'  => 'Licence',
                'master'   => 'Master',
                'doctorat' => 'Doctorat',
                'autre'    => 'Autre',
            ],
            'priority' => 5,
        ];
        //plus haut diplome 

        
        return $fields;
    }

    add_filter('submit_resume_form_fields', 'wpjms_frontend_resume_form_fields');
    function wpjms_frontend_resume_form_fields($fields){
      // la spécialité 
      // Suppression du champ existant et ajout de deux nouveaux champs hiérarchiques
$fields['resume_fields']['candidate_job_category'] = array(
    'label' => __('Métier *', 'job_manager'),
    'type' => 'select',
    'required' => true,
    'priority' => 2,
    'options' => array(
        '' => 'Sélectionnez un métier',
        'achats-et-moyens-generaux' => 'ACHATS ET MOYENS GENERAUX',
        'administration' => 'ADMINISTRATION',
        'commercial' => 'COMMERCIAL',
        'finance' => 'FINANCE',
        'informatique' => 'INFORMATIQUE',
        'laboratoire' => 'LABORATOIRE',
        'logistique' => 'LOGISTIQUE',
        'maintenance' => 'MAINTENANCE',
        'marketing' => 'MARKETING',
        'production' => 'PRODUCTION',
        'qhse' => 'QHSE',
        'ressources-humaines' => 'RESSOURCES HUMAINES'
    )
);

$fields['resume_fields']['candidate_speciality'] = array(
    'label' => __('Pôle *', 'job_manager'),
    'type' => 'select',
    'required' => true,
    'priority' => 2,
    'options' => array(
        '' => 'Sélectionnez d\'abord un métier'
    )
);

// JavaScript pour rendre la liste des pôles dynamique en fonction du métier sélectionné
add_action('wp_footer', 'add_speciality_dependency_script');
function add_speciality_dependency_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Définition des pôles par métier
        var specialities = {
            'achats-et-moyens-generaux': {
                'achats': 'Achats',
                'moyens-generaux': 'Moyens Généraux'
            },
            'administration': {
                'rse': 'RSE',
                'secretariat': 'Secrétariat'
            },
            'commercial': {
                'analyse-commerciale': 'Analyse Commerciale',
                'prevente': 'Prévente',
                'ventes': 'Ventes'
            },
            'finance': {
                'comptabilite': 'Comptabilité',
                'controle-de-gestion': 'Contrôle de Gestion',
                'fiscalite': 'Fiscalité',
                'juridique': 'Juridique',
                'transit': 'Transit',
                'tresorie': 'Trésorerie'
            },
            'informatique': {
                'applications': 'Applications',
                'infrastructures': 'Infrastructures',
                'support': 'Support'
            },
            'laboratoire': {
                'microbiologie': 'Microbiologie',
                'physico-chimie': 'Physico-chimie'
            },
            'logistique': {
                'administration-vente': 'Administration Vente',
                'logistique-clients': 'Logistique-Clients',
                'parc-auto': 'Parc-Auto'
            },
            'maintenance': {
                'bureau-methode': 'Bureau Méthode',
                'electricite': 'Electricité',
                'mecanique': 'Mécanique',
                'metrologie': 'Métrologie',
                'projet-et-moyens-generaux': 'Projet et Moyens Généraux',
                'salles-des-machines': 'Salles des machines'
            },
            'marketing': {
                'brand': 'Brand (Gestion des Marques)',
                'communication': 'Communication',
                'digital': 'Digital',
                'evenementiel-sponsoring': 'Événementiel & Sponsoring',
                'infographie': 'Infographie',
                'trade-marketing': 'Trade Marketing'
            },
            'production': {
                'brassage': 'Brassage',
                'conditionnement': 'Conditionnement',
                'filtration': 'Filtration',
                'process': 'Process',
                'siroperie': 'Siroperie'
            },
            'qhse': {
                'hse': 'HSE',
                'qualite': 'Qualité'
            },
            'ressources-humaines': {
                'administration-du-personnel': 'Administration du Personnel',
                'developpement-rh': 'Développement RH',
                'paie': 'Paie'
            }
        };

        // Fonction pour mettre à jour les options du champ de spécialité
        function updateSpecialityOptions() {
            var jobCategory = $('#candidate_job_category').val();
            var specialitySelect = $('#candidate_speciality');
            
            // Réinitialiser les options
            specialitySelect.empty().append('<option value="">Sélectionnez un pôle</option>');
            
            // Ajouter les nouvelles options si un métier est sélectionné
            if (jobCategory && specialities[jobCategory]) {
                $.each(specialities[jobCategory], function(key, value) {
                    specialitySelect.append('<option value="' + key + '">' + value + '</option>');
                });
                specialitySelect.prop('disabled', false);
            } else {
                specialitySelect.prop('disabled', true);
            }
        }

        // Déclencher la mise à jour lorsque le métier change
        $('#candidate_job_category').change(updateSpecialityOptions);
        
        // Initialiser au chargement de la page
        updateSpecialityOptions();
    });
    </script>
    <?php
}


            $fields['resume_fields']['candidate_highest_diploma'] = [
                'label'    => 'Diplôme le plus élevé',
                'type'     => 'select',
                'required' => true,
                'priority' => 1,
                'options'  => [
                    'cap'  => 'CAP',
                    'bep'  => 'BEP',
                    'bac'  => 'Baccalauréat',
                    'bac2' => 'Bac+2 (DUT, BTS)',
                    'bac3' => 'Bac+3 (Licence)',
                    'bac4' => 'Bac+4 (Master 1)',
                    'bac5' => 'Bac+5 (Master 2, Ingénieur)',
                    'bac8' => 'Bac+8 (Doctorat)',
                ],
            ];

            $fields['resume_fields']['candidate_experience_years'] = [
                'label'       => __("Nombre d'années d'expérience *", 'job_manager'),
                'type'        => 'select',
                'required'    => true,
                'placeholder' => 'Expérience professionnelle ( nombre d\'années )',
                'options'     => [
                    '1'  => '1 an',
                    '2'  => '2 ans',
                    '3'  => '3 ans',
                    '4'  => '4 ans',
                    '5'  => '5 ans',
                    '6'  => '6 ans',
                    '7'  => '7 ans',
                    '8'  => '8 ans',
                    '9'  => '9 ans',
                    '10' => '10 ans',
                    '11' => '11 ans',
                    '12' => '12 ans',
                    '13' => '13 ans',
                    '14' => '14 ans',
                    '15' => '15 ans',
                    '16' => '16 ans',
                    '17' => '17 ans',
                    '18' => '18 ans',
                    '19' => '19 ans',
                    '20' => '20 ans',
                    '21' => '21 ans',
                    '22' => '22 ans',
                    '23' => '23 ans',
                    '24' => '24 ans',
                    '25' => '25 ans',
                    '26' => '26 ans',
                    '27' => '27 ans',
                    '28' => '28 ans',
                    '29' => '29 ans',
                    '30' => '30 ans',
                    '31' => '31 ans',
                    '32' => '32 ans',
                    '33' => '33 ans',
                    '34' => '34 ans',
                    '35' => '35 ans',
                    '36' => '36 ans',
                    '37' => '37 ans',
                    '38' => '38 ans',
                    '39' => '39 ans',
                    '40' => '40 ans',
                    '41' => '41 ans',
                    '42' => '42 ans',
                    '43' => '43 ans',
                    '44' => '44 ans',
                    '45' => '45 ans',
                    '46' => '46 ans',
                    '47' => '47 ans',
                    '48' => '48 ans',
                    '49' => '49 ans',
                    '50' => '50 ans',
                    '51' => '51 ans',
                    '52' => '52 ans',
                    '53' => '53 ans',
                    '54' => '54 ans',
                    '55' => '55 ans',
                    '56' => '56 ans',
                    '57' => '57 ans',
                    '58' => '58 ans',
                    '59' => '59 ans',
                    '60' => '60 ans',
                    '61' => '61 ans',
                    '62' => '62 ans',
                    '63' => '63 ans',
                    '64' => '64 ans',
                    '65' => '65 ans',
                    '66' => '66 ans',
                    '67' => '67 ans',
                    '68' => '68 ans',
                    '69' => '69 ans',
                    '70' => '70 ans',
                    '71' => '71 ans',
                    '72' => '72 ans',
                    '73' => '73 ans',
                    '74' => '74 ans',
                    '75' => '75 ans',
                    '76' => '76 ans',
                    '77' => '77 ans',
                    '78' => '78 ans',
                    '79' => '79 ans',
                    '80' => '80 ans',
                    '81' => '81 ans',
                    '82' => '82 ans',
                    '83' => '83 ans',
                    '84' => '84 ans',
                    '85' => '85 ans',
                    '86' => '86 ans',
                    '87' => '87 ans',
                    '88' => '88 ans',
                    '89' => '89 ans',
                    '90' => '90 ans',
                    '91' => '91 ans',
                    '92' => '92 ans',
                    '93' => '93 ans',
                    '94' => '94 ans',
                    '95' => '95 ans',
                    '96' => '96 ans',
                    '97' => '97 ans',
                    '98' => '98 ans',
                    '99' => '99 ans',
                ], 'priority' => 1,
            ];
            // Add "nationalité" field avec liste déroulante
            $fields['resume_fields']['candidate_nationality_type'] = [
                'label'    => __('Nationalité *', 'job_manager'),
                'type'     => 'radio',
                'required' => true,
                'options'  => [
                    'congolaise' => 'Congolaise',
                    'autres'     => 'Autres',
                ],
                'priority' => 2,
                'fieldset' => 'nationality_type_fieldset',
            ];
            $fields['resume_fields']['candidate_nationality'] = [
                'label'      => __('Sélectionnez votre nationalité *', 'job_manager'),
                'type'       => 'select',
                'required'   => true,
                'default'    => 'congolaise-',
                'options'    => [
                    'afghane'                   => 'Afghane',
                    'albanaise'                 => 'Albanaise',
                    'algerienne'                => 'Algérienne',
                    'allemande'                 => 'Allemande',
                    'americaine'                => 'Américaine',
                    'andorrane'                 => 'Andorrane',
                    'angolaise'                 => 'Angolaise',
                    'antiguaise-et-barbudienne' => 'Antiguaise-et-Barbudienne',
                    'argentine'                 => 'Argentine',
                    'armenienne'                => 'Arménienne',
                    'australienne'              => 'Australienne',
                    'autrichienne'              => 'Autrichienne',
                    'azerbaidjanaise'           => 'Azerbaïdjanaise',
                    'bahamienne'                => 'Bahamienne',
                    'bahreïnienne'              => 'Bahreïnienne',
                    'bangladaise'               => 'Bangladaise',
                    'barbadienne'               => 'Barbadienne',
                    'belarusse'                 => 'Bélarusse',
                    'belge'                     => 'Belge',
                    'beninoise'                 => 'Béninoise',
                    'bhoutanaise'               => 'Bhoutanaise',
                    'bolivienne'                => 'Bolivienne',
                    'bosnienne'                 => 'Bosnienne',
                    'botswanaise'               => 'Botswanaise',
                    'bresilienne'               => 'Brésilienne',
                    'britannique'               => 'Britannique',
                    'bruneienne'                => 'Brunéienne',
                    'bulgare'                   => 'Bulgare',
                    'burkinabe'                 => 'Burkinabé',
                    'burundaise'                => 'Burundaise',
                    'cambodgienne'              => 'Cambodgienne',
                    'camerounaise'              => 'Camerounaise',
                    'canadienne'                => 'Canadienne',
                    'cap-verdienne'             => 'Cap-verdienne',
                    'centrafricaine'            => 'Centrafricaine',
                    'chilienne'                 => 'Chilienne',
                    'chinoise'                  => 'Chinoise',
                    'chypriote'                 => 'Chypriote',
                    'colombienne'               => 'Colombienne',
                    'comorienne'                => 'Comorienne',
                    'congolaise-rdc'            => 'Congolaise (République démocratique du Congo)',
                    'congolaise-'               => 'Congolaise (République du Congo)',
                    'costaricienne'             => 'Costaricienne',
                    'croate'                    => 'Croate',
                    'cubaine'                   => 'Cubaine',
                    'danoise'                   => 'Danoise',
                    'djiboutienne'              => 'Djiboutienne',
                    'dominicaine'               => 'Dominicaine',
                    'dominiquaise'              => 'Dominiquaise',
                    'egyptienne'                => 'Égyptienne',
                    'emiratie'                  => 'Émiratie',
                    'equatorienne'              => 'Équatorienne',
                    'erythreenne'               => 'Érythréenne',
                    'espagnole'                 => 'Espagnole',
                    'estonienne'                => 'Estonienne',
                    'ethiopienne'               => 'Éthiopienne',
                    'fidjienne'                 => 'Fidjienne',
                    'finlandaise'               => 'Finlandaise',
                    'francaise'                 => 'Française',
                    'gabonaise'                 => 'Gabonaise',
                    'gambienne'                 => 'Gambienne',
                    'georgienne'                => 'Georgienne',
                    'ghaneenne'                 => 'Ghanéenne',
                    'grenadienne'               => 'Grenadienne',
                    'guatemalteque'             => 'Guatémaltèque',
                    'guineenne'                 => 'Guinéenne',
                    'guineenne-equatoriale'     => 'Guinéenne équatoriale',
                    'guyanienne'                => 'Guyanienne',
                    'haitienne'                 => 'Haïtienne',
                    'hondurienne'               => 'Hondurienne',
                    'hongroise'                 => 'Hongroise',
                    'indienne'                  => 'Indienne',
                    'indonesienne'              => 'Indonésienne',
                    'irakienne'                 => 'Irakienne',
                    'iranienne'                 => 'Iranienne',
                    'irlandaise'                => 'Irlandaise',
                    'islandaise'                => 'Islandaise',
                    'israelienne'               => 'Israélienne',
                    'italienne'                 => 'Italienne',
                    'ivoirienne'                => 'Ivoirienne',
                    'jamaicaine'                => 'Jamaïcaine',
                    'japonaise'                 => 'Japonaise',
                    'jordanienne'               => 'Jordanienne',
                    'kazakhe'                   => 'Kazakhe',
                    'kenyane'                   => 'Kényane',
                    'kirghize'                  => 'Kirghize',
                    'kiribatienne'              => 'Kiribatienne',
                    'kosovare'                  => 'Kosovare',
                    'koweitienne'               => 'Koweïtienne',
                    'laotienne'                 => 'Laotienne',
                    'lesothane'                 => 'Lesothane',
                    'lettone'                   => 'Lettone',
                    'libanaise'                 => 'Libanaise',
                    'liberienne'                => 'Libérienne',
                    'libyenne'                  => 'Libyenne',
                    'liechtensteinoise'         => 'Liechtensteinoise',
                    'lituanienne'               => 'Lituanienne',
                    'luxembourgeoise'           => 'Luxembourgeoise',
                    'macedonienne'              => 'Macédonienne',
                    'malaisienne'               => 'Malaisienne',
                    'malawienne'                => 'Malawienne',
                    'maldivienne'               => 'Maldivienne',
                    'malienne'                  => 'Malienne',
                    'maltaise'                  => 'Maltaise',
                    'marocaine'                 => 'Marocaine',
                    'marshallaise'              => 'Marshallaise',
                    'mauricienne'               => 'Mauricienne',
                    'mauritanienne'             => 'Mauritanienne',
                    'mexicaine'                 => 'Mexicaine',
                    'micronesienne'             => 'Micronésienne',
                    'moldave'                   => 'Moldave',
                    'monegasque'                => 'Monegasque',
                    'mongole'                   => 'Mongole',
                    'montenegrine'              => 'Monténégrine',
                    'mozambicaine'              => 'Mozambicaine',
                    'myanmarienne'              => 'Myanmarienne',
                    'namibienne'                => 'Namibienne',
                    'nauruane'                  => 'Nauruane',
                    'nepalaise'                 => 'Népalaise',
                    'neerlandaise'              => 'Néerlandaise',
                    'neo-zelandaise'            => 'Néo-Zélandaise',
                    'nigeriane'                 => 'Nigériane',
                    'nigerienne'                => 'Nigérienne',
                    'nord-coreenne'             => 'Nord-coréenne',
                    'norvegienne'               => 'Norvégienne',
                    'omanaise'                  => 'Omanaise',
                    'pakistanaise'              => 'Pakistanaise',
                    'palaosienne'               => 'Palaosienne',
                    'palestinienne'             => 'Palestinienne',
                    'panameenne'                => 'Panaméenne',
                    'papouasienne'              => 'Papouasienne-Néo-Guinéenne',
                    'paraguayenne'              => 'Paraguayenne',
                    'peruvienne'                => 'Péruvienne',
                    'philippine'                => 'Philippine',
                    'polonaise'                 => 'Polonaise',
                    'portugaise'                => 'Portugaise',
                    'qatarienne'                => 'Qatarienne',
                    'roumaine'                  => 'Roumaine',
                    'rwandaise'                 => 'Rwandaise',
                    'russe'                     => 'Russe',
                    'saint-lucienne'            => 'Saint-Lucienne',
                    'saint-marinaise'           => 'Saint-Marinaise',
                    'saint-vincentaise'         => 'Saint-Vincentaise',
                    'salomonaise'               => 'Salomonaise',
                    'salvadorienne'             => 'Salvadorienne',
                    'samoaienne'                => 'Samoaienne',
                    'sao-tomeenne'              => 'Sao-toméenne',
                    'saoudienne'                => 'Saoudienne',
                    'senegalaise'               => 'Sénégalaise',
                    'serbe'                     => 'Serbe',
                    'seychelloise'              => 'Seychelloise',
                    'sierra-leonaise'           => 'Sierra-Léonaise',
                    'singapourienne'            => 'Singapourienne',
                    'slovaque'                  => 'Slovaque',
                    'slovene'                   => 'Slovène',
                    'somalienne'                => 'Somalienne',
                    'soudanaise'                => 'Soudanaise',
                    'sud-africaine'             => 'Sud-africaine',
                    'sud-coreenne'              => 'Sud-coréenne',
                    'sud-soudanaise'            => 'Sud-soudanaise',
                    'suedoise'                  => 'Suédoise',
                    'suisse'                    => 'Suisse',
                    'syrienne'                  => 'Syrienne',
                    'tadjike'                   => 'Tadjike',
                    'tanzanienne'               => 'Tanzanienne',
                    'tchadienne'                => 'Tchadienne',
                    'tcheque'                   => 'Tchèque',
                    'thailandaise'              => 'Thaïlandaise',
                    'togolaise'                 => 'Togolaise',
                    'tongienne'                 => 'Tongienne',
                    'trinidadienne'             => 'Trinidadienne',
                    'tunisienne'                => 'Tunisienne',
                    'turkmene'                  => 'Turkmène',
                    'turque'                    => 'Turque',
                    'tuvaluane'                 => 'Tuvaluane',
                    'ukrainienne'               => 'Ukrainienne',
                    'uruguayenne'               => 'Uruguayenne',
                    'uzbekistanaise'            => 'Uzbekistanaise',
                    'vanuatuane'                => 'Vanuatuane',
                    'venezuelienne'             => 'Vénézuélienne',
                    'vietnamienne'              => 'Vietnamienne',
                    'yemenite'                  => 'Yéménite',
                    'zambienne'                 => 'Zambienne',
                    'zimbabweenne'              => 'Zimbabwéenne',

                ],
                'priority'   => 2,
                'fieldset'   => 'nationality_select_fieldset',
                'depends_on' => [
                    'candidate_nationality_type' => 'autres',
                ],
            ];
            // Add "date de naissance" field
            $fields['resume_fields']['candidate_date_of_birth'] = [
                'label'       => __('Date de naissance *', 'job_manager'),
                'type'        => 'text',
                'required'    => true,
                'placeholder' => '',
                'priority'    => 3,
            ];

            // Add "téléphone" field
            $fields['resume_fields']['candidate_phone'] = [
                'label'       => __('Téléphone *', 'job_manager'),
                'type'        => 'text',
                'required'    => true,
                'placeholder' => '+225 XX XX XX XX XX',
                'priority'    => 4,
            ];
            return $fields;
        }
        // Ajout des scripts pour le datepicker
        function add_datepicker_scripts()
        {
            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        }
        add_action('wp_enqueue_scripts', 'add_datepicker_scripts');

        // Initialisation du datepicker
        function init_datepicker()
        {
        ?>
<script>
jQuery(document).ready(function($) {
$('#candidate_date_of_birth').datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    yearRange: '-65:-18'
});
});
</script>
<?php
    }
    add_action('wp_footer', 'init_datepicker');
    // Add lines to the notification email with custom fields
    add_filter('apply_with_resume_email_message', 'wpjms_custom_field_email_message', 10, 2);
    function wpjms_custom_field_email_message($message, $resume_id)
    {
        $message[] = "\n" . "Nombre d'années d'expérience: " . get_post_meta($resume_id, '_candidate_experience_years', true);
        $message[] = "\n" . "Nationalité: " . get_post_meta($resume_id, '_candidate_nationality', true);
        $message[] = "\n" . "Date de naissance: " . get_post_meta($resume_id, '_candidate_date_of_birth', true);
        $message[] = "\n" . "Téléphone: " . get_post_meta($resume_id, '_candidate_phone', true);

        return $message;
    }

    add_filter('submit_resume_form_fields', 'remove_submit_resume_form_fields');

    //suprimer les champs inutiles
    function remove_submit_resume_form_fields($fields)
    {

        // Unset any of the fields you'd like to remove - copy and repeat as needed
        unset($fields['resume_fields']['candidate_title']);
        unset($fields['resume_fields']['resume_content']);
        unset($fields['resume_fields']['candidate_video']);
        unset($fields['resume_fields']['links']);
        // those has been put back thanks to the vision of ceo. Note to self :  NEVER listen to RH
        //unset( $fields['resume_fields']['candidate_experience'] );
        //unset( $fields['resume_fields']['candidate_education'] );
        unset($fields['resume_fields']['candidate_photo']);
        // And return the modified fields
        return $fields;

    }

    //rendre les champs nécessaires obligatoires
    add_filter('submit_resume_form_fields', 'resume_file_required');

    // This is your function which takes the fields, modifies them, and returns them
    function resume_file_required($fields)
    {

        $fields['resume_fields']['candidate_experience_years']['required'] = true;
        $fields['resume_fields']['resume_file']['required']                = true;
        $fields['resume_fields']['candidate_name']['required']             = true;
        $fields['resume_fields']['candidate_location']['required']         = true;
        $fields['resume_fields']['candidate_nationality']['required']      = true;
        $fields['resume_fields']['candidate_date_of_birth']['required']    = true;
        $fields['resume_fields']['candidate_phone']['required']            = true;
        $fields['resume_fields']['candidate_experience']['required']       = true;
        $fields['resume_fields']['candidate_education']['required']        = true;

        return $fields;
    }

    //ajout du téléphone au preview du CV
    add_action('resume_manager_contact_details', 'ajouter_telephone_contact_details');

    function ajouter_telephone_contact_details()
    {
        global $post;
        $telephone = get_post_meta($post->ID, '_candidate_phone', true);
        if ($telephone) {
            echo '<p class="telephone"><strong>' . __('Téléphone:', 'bralico') . '</strong> ' . esc_html($telephone) . '</p>';
        }
    }

    //offre d'emploi spontanée

    // Ajout des scripts pour le toast
    function add_toast_scripts()
    {
        wp_enqueue_script('toastr', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js', ['jquery']);
        wp_enqueue_style('toastr', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css');
    }
    add_action('wp_enqueue_scripts', 'add_toast_scripts');

    // Fonction pour récupérer les CVs existants
    function get_user_resumes()
    {
        $user_id = get_current_user_id();
        $args    = [
            'post_type'      => 'resume',
            'author'         => $user_id,
            'posts_per_page' => -1,
        ];

        $resumes = get_posts($args);
        if (! empty($resumes)) {
            $output = '<div class="existing-cvs">';
            $output .= '<h4>Sélectionnez un CV</h4>';
            foreach ($resumes as $resume) {
                $cv_url = get_post_meta($resume->ID, '_resume_file', true);
                if ($cv_url) {
                    $output .= '<div class="cv-item">';
                    $output .= '<input type="radio" name="selected_cv" value="' . $resume->ID . '" required>';
                    $output .= '<span>' . $resume->post_title . '</span>';
                    $output .= '</div>';
                }
            }
            $output .= '</div>';
            return $output;
        } else {
            return '<div class="no-cv-message">
    <p>Vous n\'avez pas encore de CV enregistré.</p>
    <a href="' . esc_url(home_url('/mise-a-jour-du-cv/')) . '" class="buttonless">Créer mon CV</a>


</div>';
        }
    }
    function custom_job_application_form_shortcode($atts)
    {
        $styles = '<style>
.char-count {
    font-size: 0.8em;
    color: #666;
    margin-top: 0.25rem;
}
.file-upload {
    margin-bottom: 1rem;
}
.file-upload label {
    display: block;
    margin-bottom: 0.5rem;
}
.file-requirements {
    font-size: 0.8em;
    color: #666;
    margin-top: 0.25rem;
}

.job-application-form {
max-width: 800px;
margin: 2rem auto;
padding: 2.5rem;
background: #fff;
border-radius: 12px;
box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.form-group {
margin-bottom: 1.8rem;
position: relative;
}

.form-group label {
display: block;
margin-bottom: 0.7rem;
font-weight: 600;
color: #2c3e50;
font-size: 0.95rem;
}

.input-text {
display: block;
width: 100%;
padding: 0.8rem 1rem;
font-size: 1rem;
line-height: 1.5;
color: #495057;
background-color: #fff;
border: 2px solid #e9ecef;
border-radius: 8px;
transition: all 0.3s ease;
}

.input-text:focus {
border-color: #80bdff;
box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15);
outline: none;
}

textarea.input-text {
min-height: 120px;
resize: vertical;
}

.button {
display: inline-block;
font-weight: 600;
text-align: center;
padding: 0.8rem 1.8rem;
font-size: 1rem;
line-height: 1.5;
border-radius: 8px;
color: #fff;
background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
border: none;
cursor: pointer;
transition: all 0.3s ease;
box-shadow: 0 4px 6px rgba(50,50,93,.11), 0 1px 3px rgba(0,0,0,.08);
}

.button:hover {
transform: translateY(-1px);
box-shadow: 0 7px 14px rgba(50,50,93,.1), 0 3px 6px rgba(0,0,0,.08);
background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
}

.button:active {
transform: translateY(1px);
}

input[type="file"] {
padding: 0.6rem;
background: #f8f9fa;
border: 2px dashed #dee2e6;
border-radius: 8px;
cursor: pointer;
}

.file-requirements {
font-size: 0.85rem;
color: #6c757d;
margin-top: 0.5rem;
}

.char-count {
position: absolute;
right: 0;
top: 0;
font-size: 0.85rem;
color: #6c757d;
}

.cv-item {
background: #f8f9fa;
padding: 1rem;
border-radius: 8px;
margin-bottom: 0.8rem;
border: 2px solid #e9ecef;
transition: all 0.3s ease;
}

.cv-item:hover {
border-color: #007bff;
background: #fff;
}

.job-manager-error {
background-color: #fff3f3;
border-left: 4px solid #dc3545;
padding: 1rem 1.5rem;
margin-bottom: 1.5rem;
border-radius: 4px;
color: #dc3545;
}

@media (max-width: 768px) {
.job-application-form {
    padding: 1.5rem;
}
}
</style>';

        if (! is_user_logged_in()) {
            return $styles . '<div class="login-required">Veuillez vous <a href="' . wp_login_url() . '">connecter</a> pour postuler.</div>';
        }

        $attributes = shortcode_atts(['job_id' => '15862'], $atts);
        $job        = get_post($attributes['job_id']);

        if (! $job || $job->post_type !== 'job_listing') {
            return 'Offre d\'emploi non trouvée.';
        }

        ob_start();
        echo $styles;
    ?>
<div class="job-application-form">
<form method="post" class="job-manager-application-form" enctype="multipart/form-data">
<?php wp_nonce_field('apply_job_' . $attributes['job_id']); ?>
<input type="hidden" name="job_id" value="<?php echo esc_attr($attributes['job_id']); ?>">
<input type="hidden" name="action" value="apply_job">

<div class="form-group">
    <label for="candidate_name">Nom complet *</label>
    <input type="text" class="input-text" name="candidate_name" id="candidate_name" required>
</div>

<div class="form-group">
    <label for="candidate_email">Email *</label>
    <input type="email" class="input-text" name="candidate_email" id="candidate_email" required>
</div>

<div class="form-group">
    <label for="candidate_phone">Téléphone</label>
    <input type="tel" class="input-text" name="candidate_phone" id="candidate_phone">
</div>
<div class="form-group">
    <label for="job_category">Catégorie de métier *</label>
    <select class="input-text" name="job_category" id="job_category" required>


        <optgroup label="MANAGEMENT">
            <option value="ressources_humaines">Ressources humaines</option>
            <option value="secretariat">Secrétariat</option>
            <option value="rse">RSE</option>
            <option value="hse">HSE</option>
            <option value="qualite">Qualité</option>
        </optgroup>
        <optgroup label="INFORMATIQUE">
            <option value="systemes_et_reseaux">Systèmes et Réseaux</option>
            <option value="securite_des_si">Sécurité des SI</option>
        </optgroup>
        <optgroup label="MARKETING">
            <option value="trade_marketing">Trade Marketing</option>
            <option value="marketing_operationnel">Marketing opérationnel</option>
        </optgroup>
        <optgroup label="COMMERCIAL">
            <option value="ventes">Ventes</option>
            <option value="analyse_commerciale">Analyse Commerciale</option>
            <option value="administration_des_ventes">Administration des ventes</option>
        </optgroup>
        <optgroup label="FINANCE">
            <option value="comptabilite">Comptabilité</option>
            <option value="controle_de_gestion">Contrôle de Gestion</option>
            <option value="tresorerie">Trésorerie</option>
        </optgroup>
        <optgroup label="PRODUCTION">
            <option value="brassage">Brassage</option>
            <option value="conditionnement">Conditionnement</option>
            <option value="fabrication">Fabrication</option>
            <option value="siroperie">Siroperie</option>
        </optgroup>
        <optgroup label="LABORATOIRE">
            <option value="physico_chimie">Physico-chimie</option>
            <option value="microbiologie">Microbiologie</option>
        </optgroup>
        <optgroup label="MAINTENANCE">
            <option value="electricite">Électricité</option>
            <option value="mecanique">Mécanique</option>
            <option value="projet_et_moyens_generaux">Projet et Moyens Généraux</option>
            <option value="salles_des_machines">Salles des machines</option>
            <option value="metrologie">Métrologie</option>
        </optgroup>
        <optgroup label="LOGISTIQUE">
            <option value="logistique">Logistique</option>
            <option value="parc_auto">Parc-Auto</option>
            <option value="transit">Transit</option>
            <option value="achats">Achats</option>
        </optgroup>
    </select>
</div>

<div class="form-group">
    <label for="motivation_letter">Lettre de motivation (PDF) *</label>
    <input type="file" class="input-text" name="motivation_letter" id="motivation_letter" accept=".pdf"
        required>
    <div class="file-requirements">Format accepté: PDF. Taille maximale: 2MB</div>
</div>

<div class="form-group">
    <label for="portfolio">Documents nécessaires/Portfolio (PDF)</label>
    <input type="file" class="input-text" name="portfolio" id="portfolio" accept=".pdf">
    <div class="file-requirements">Format accepté: PDF. Taille maximale: 5MB</div>
</div>

<div class="form-group">
    <label for="application_message">Message * <span class="char-count">0/255 caractères</span></label>
    <textarea class="input-text" name="application_message" id="application_message" maxlength="255"
        required></textarea>
</div>

<div class="form-group">
    <?php echo get_user_resumes(); ?>
</div>

<!-- <input type="submit" class="button" value="Envoyer ma candidature"> -->
</form>
</div>

<script>
jQuery(document).ready(function($) {
$('#application_message').on('input', function() {
var maxLength = 255;
var currentLength = $(this).val().length;
$(this).siblings('label').find('.char-count').text(currentLength + '/' + maxLength +
    ' caractères');
});
});
</script>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'apply_job') {
            if (! wp_verify_nonce($_POST['_wpnonce'], 'apply_job_' . $attributes['job_id'])) {
                wp_die('Action non autorisée');
            }

            $errors = [];
            if (empty($_POST['candidate_name'])) {
                $errors[] = 'Le nom est requis';
            }

            if (empty($_POST['candidate_email'])) {
                $errors[] = 'L\'email est requis';
            }

            if (empty($_POST['application_message'])) {
                $errors[] = 'Le message est requis';
            }

            if (empty($_POST['selected_cv'])) {
                $errors[] = 'Veuillez sélectionner un CV';
            }

            if (empty($_FILES['motivation_letter'])) {
                $errors[] = 'La lettre de motivation est requise';
            }

            if (empty($_POST['job_category'])) {
                $errors[] = 'Veuillez sélectionner un métier';
            }

            if (empty($errors)) {
                $resume_id = intval($_POST['selected_cv']);
                $cv_path   = get_post_meta($resume_id, '_resume_file', true);

                $application_data = [
                    'post_title'   => wp_strip_all_tags($_POST['candidate_name']),
                    'post_content' => sanitize_textarea_field($_POST['application_message']),
                    'post_status'  => 'publish',
                    'post_type'    => 'job_application',
                ];

                $application_id = wp_insert_post($application_data);

                if ($application_id) {
                    update_post_meta($application_id, '_candidate_email', sanitize_email($_POST['candidate_email']));
                    update_post_meta($application_id, '_candidate_phone', sanitize_text_field($_POST['candidate_phone']));
                    update_post_meta($application_id, '_job_id', $attributes['job_id']);
                    update_post_meta($application_id, '_cv_path', $cv_path);
                    update_post_meta($application_id, '_resume_id', $resume_id);
                    update_post_meta($application_id, '_job_category', sanitize_text_field($_POST['job_category']));

                    // Gérer les fichiers uploadés
                    if (! empty($_FILES['motivation_letter'])) {
                        $motivation_letter = wp_handle_upload($_FILES['motivation_letter'], ['test_form' => false]);
                        if (! empty($motivation_letter['url'])) {
                            update_post_meta($application_id, '_motivation_letter', $motivation_letter['url']);
                        }
                    }

                    if (! empty($_FILES['portfolio'])) {
                        $portfolio = wp_handle_upload($_FILES['portfolio'], ['test_form' => false]);
                        if (! empty($portfolio['url'])) {
                            update_post_meta($application_id, '_portfolio', $portfolio['url']);
                        }
                    }

                    $to      = 'jeanluc@bigfiveabidjan.com';
                    $subject = 'Nouvelle candidature pour le poste ' . get_the_title($attributes['job_id']);
                    // Récupération du CV sélectionné
                    $resume_id = intval($_POST['selected_cv']);
                    // Récupérer l'ID de l'attachement du CV
                    $cv_attachment_id = get_post_meta($resume_id, '_resume_file', true);
                    // Obtenir l'URL directe de l'attachement
                    $cv_url  = get_permalink($resume_id);
                    $cv_name = get_the_title($resume_id);

                    // $message = "Nouvelle candidature reçue :\n\n";
                    // $message .= "Nom : " . $_POST['candidate_name'] . "\n";
                    // $message .= "Email : " . $_POST['candidate_email'] . "\n";

                    // $message .= "Téléphone : " . $_POST['candidate_phone'] . "\n";
                    // $message .= "Métier sélectionné : " . $_POST['job_category'] . "\n\n";
                    // $message .= "Message : \n" . $_POST['application_message'];

                    // $job_categories = wp_get_post_terms($attributes['job_id'], 'job_listing_category');
                    // if (!empty($job_categories)) {

                    //     $message .= "\n\nCatégorie du poste : " . $job_categories[0]->name;
                    //}
                    // Construction du message HTML
                    $message = '<html>
<head>
<style>
body { font-family: Arial, sans-serif; line-height: 1.6; }
.container { max-width: 600px; margin: 0 auto; padding: 20px; }
.header { background: #f8f9fa; padding: 15px; border-radius: 5px; }
.content { margin: 20px 0; }
.footer { border-top: 1px solid #eee; padding-top: 15px; }
.btn { display: inline-block; padding: 10px 20px; background: #0a6535; color: #fff !important; text-decoration: none; border-radius: 5px; }
.documents { background: #f8f9fa; padding: 15px; margin: 15px 0; border-radius: 5px; }
</style>
</head>
<body>
<div class="container">
<div class="header">
<h2>Nouvelle candidature reçue</h2>
</div>
<div class="content">
<p><strong>Nom :</strong> ' . $_POST['candidate_name'] . '</p>
<p><strong>Email :</strong> ' . $_POST['candidate_email'] . '</p>
<p><strong>Téléphone :</strong> ' . $_POST['candidate_phone'] . '</p>
<p><strong>Métier sélectionné :</strong> ' . $_POST['job_category'] . '</p>
<p><strong>Message du candidat :</strong><br>' . nl2br($_POST['application_message']) . '</p>

<div class="documents">
<p><strong>Documents du candidat :</strong></p>
<p>CV : <a href="' . esc_url($cv_url) . '" class="btn">Consulter le CV - ' . esc_html($cv_name) . '</a></p>
<p>Lettre de motivation : <a href="' . esc_url($motivation_letter['url']) . '" class="btn">Télécharger la lettre</a></p>
</div>
</div>
<div class="footer">
<p>Cette candidature a été envoyée depuis le site web de Bralico.</p>
</div>
</div>
</body>
</html>';

                    $headers = [
                        'Content-Type: text/html; charset=UTF-8',
                        'From: Bralico Recrutement <recrutement@bralico.com>',
                    ];
                    wp_mail($to, $subject, $message, $headers);

                    echo "<script>
            toastr.success('Votre candidature a été envoyée avec succès!', 'Succès', {
                timeOut: 5000,
                closeButton: true,
                progressBar: true
            });
        </script>";
                }
            } else {
                echo '<div class="job-manager-error">' . implode('<br>', $errors) . '</div>';
            }
        }

        return ob_get_clean();
    }
    add_shortcode('postuler_job', 'custom_job_application_form_shortcode');

    function display_past_applications_shortcode()
    {
        ob_start();

        $args = [
            'post_type'      => 'job_application',
            'author'         => get_current_user_id(),
            'posts_per_page' => -1,
        ];

        $applications = get_posts($args);

        if (! empty($applications)) {
            echo '<table class="job-manager-past-applications">
    <thead>
        <tr>
            <th>Date</th>
            <th>Poste</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>';

            foreach ($applications as $application) {
                $job_id            = get_post_meta($application->ID, '_job_id', true);
                $cv_url            = get_post_meta($application->ID, '_cv_path', true);
                $motivation_letter = get_post_meta($application->ID, '_motivation_letter', true);

                echo '<tr>
        <td>' . get_the_date('d/m/Y', $application->ID) . '</td>
        <td>' . get_the_title($job_id) . '</td>
        <td> En cours d examen</td>
    </tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<p>Vous n\'avez pas encore envoyé de candidature.</p>';
        }

        return ob_get_clean();
    }
    add_shortcode('past_applications2', 'display_past_applications_shortcode');
    // function charger_script_forminator_observer() {
    //     if (class_exists('Forminator')) {
    //         wp_enqueue_script('forminator-checker', get_template_directory_uri() . '/js/forminator-checker.js', array(), '1.0', true);
    //     }
    // }
    // add_action('wp_enqueue_scripts', 'charger_script_forminator_observer');

    // function ajouter_sticky_safezone() {
    //     if (is_page(290)) {
    //         wp_enqueue_script('sticky-safezone', get_template_directory_uri() . '/js/sticky-safezone.js', array(), '1.0', true);
    //     }
    // }
    // add_action('wp_enqueue_scripts', 'ajouter_sticky_safezone');

    function redirection_utilisateurs_specifiques($redirect_to, $request, $user)
    {
        if (isset($user->roles) && is_array($user->roles)) {
            // Rôles à rediriger
            $roles_a_rediriger = ['subscriber', 'candidate'];

            // Vérifie si l'utilisateur a un des rôles ciblés
            if (array_intersect($roles_a_rediriger, $user->roles)) {
                return get_permalink(290);
            }
        }
        return $redirect_to;
    }
    add_filter('login_redirect', 'redirection_utilisateurs_specifiques', 10, 3);

    // Redirection depuis l'admin
    function bloquer_acces_admin()
    {
        $user              = wp_get_current_user();
        $roles_a_rediriger = ['subscriber', 'candidate'];

        if (is_admin() && array_intersect($roles_a_rediriger, (array) $user->roles)) {
            wp_redirect(get_permalink(290));
            exit;
        }
    }
    add_action('admin_init', 'bloquer_acces_admin');

    // Redirection depuis la page profile.php
    function redirection_profile()
    {
        $user              = wp_get_current_user();
        $roles_a_rediriger = ['subscriber', 'candidate'];

        if (array_intersect($roles_a_rediriger, (array) $user->roles)) {
            wp_redirect(get_permalink(290));
            exit;
        }
    }
    add_action('load-profile.php', 'redirection_profile');

    // lister les

    add_action('wp_ajax_get_fonctions_terms', 'get_fonctions_terms');
    add_action('wp_ajax_nopriv_get_fonctions_terms', 'get_fonctions_terms');

    function get_fonctions_terms()
    {
        if (isset($_POST['secteur_id'])) {
            $secteur_id = intval($_POST['secteur_id']);

            $terms = get_terms('secteurs', [
                'hide_empty' => false,
                'parent'     => $secteur_id,
            ]);

            if (! is_wp_error($terms)) {
                wp_send_json_success($terms);
            }
        }
        wp_send_json_error();
    }

    // Autoriser les candidats à télécharger des fichiers
    function autoriser_upload_candidats()
    {
        // Autoriser les abonnés (subscribers)
        $subscriber_role = get_role('subscriber');
        if ($subscriber_role) {
            $subscriber_role->add_cap('upload_files', true);
            $subscriber_role->add_cap('edit_files', true);
        }

        // Autoriser les candidats
        $candidate_role = get_role('candidate');
        if ($candidate_role) {
            $candidate_role->add_cap('upload_files', true);
            $candidate_role->add_cap('edit_files', true);
        }
    }
    function autoriser_ajax_candidats()
    {
        // Vérifier si l'utilisateur a un rôle de candidat
        $user            = wp_get_current_user();
        $roles_candidats = ['candidate', 'Candidate', 'candidat', 'Candidat'];

        if (array_intersect($roles_candidats, (array) $user->roles)) {
            // Autoriser l'action AJAX pour les candidats
            add_filter('wp_ajax_get_fonctions_terms', 'get_fonctions_terms');
        }
    }
    add_action('init', 'autoriser_ajax_candidats');

    // Ajouter les capacités nécessaires aux rôles de candidats
    function ajouter_capacites_candidats()
    {
        $roles_candidats = ['candidate', 'Candidate', 'candidat', 'Candidat'];

        foreach ($roles_candidats as $role) {
            $role_obj = get_role($role);
            if ($role_obj) {
                $role_obj->add_cap('ajax_query', true);
            }
        }
    }
    add_action('init', 'ajouter_capacites_candidats');

    // Définir les types de fichiers autorisés
    function filtrer_types_fichiers_autorises($mime_types)
    {
        $mime_types['pdf']  = 'application/pdf';
        $mime_types['doc']  = 'application/msword';
        $mime_types['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        return $mime_types;
    }
    add_filter('upload_mimes', 'filtrer_types_fichiers_autorises');

    // Limiter la taille des fichiers
    function limiter_taille_upload($file)
    {
        $size_limit = 25 * 1024 * 1024; // 5 MB
        $file_size  = $file['size'];
        if ($file_size > $size_limit) {
            $file['error'] = "La taille du fichier ne doit pas dépasser 18 MB.";
        }
        return $file;
    }
    add_filter('wp_handle_upload_prefilter', 'limiter_taille_upload');
    //supprimer toutes les rpioels

    function supprimer_tous_roles_forminator($user_id, $form_id)
    {
        if ($form_id == 301) {
            $user  = new WP_User($user_id);
            $roles = $user->roles;
            foreach ($roles as $role) {
                $user->remove_role($role);
            }
        }
    }
    add_action('forminator_after_save_custom_form', 'supprimer_tous_roles_forminator', 10, 2);

    function limiter_soumission_cv($can_submit)
    {
        if (! is_user_logged_in()) {
            return $can_submit;
        }

        $user_id  = get_current_user_id();
        $cv_count = resume_manager_count_user_resumes($user_id);

        if ($cv_count >= 1) {
            add_action('resume_manager_output_messages', function () {
                echo '<div class="job-manager-message error">';
                echo 'Vous avez déjà un CV enregistré. Veuillez supprimer votre CV existant avant d\'en soumettre un nouveau.';
                echo '</div>';
            });
            return false;
        }

        return $can_submit;
    }
    add_filter('resume_manager_can_post_resume', 'limiter_soumission_cv', 10, 1);
   

    function modifier_champs_dates_resume($fields)
    {
        // Années pour le sélecteur (de 1970 à aujourd'hui)
        $annees         = range(date('Y'), 1970);
        $options_annees = array_combine($annees, $annees);

        return $fields;
    }

    add_filter('submit_resume_form_fields', 'modifier_champs_dates_resume');

    //espâce pour filtrer les CV
    function creer_page_admin_cv()
    {
        add_menu_page(
            'Gestion des CV - Bralico RH',
            'Filtrer les CV',
            'manage_options',
            'gestion-cv',
            'afficher_page_cv',
            'dashicons-star-filled', // Icône étoile
            4                        // Position (4 = juste après le tableau de bord)
        );
    }
    add_action('admin_menu', 'creer_page_admin_cv');

    function afficher_page_cv()
    {
        global $wpdb;
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');

        // Récupération des offres d'emploi pour le filtre
        $jobs = get_posts([
            'post_type'      => 'job_listing',
            'posts_per_page' => -1,
        ]);

        // Configuration de la pagination
        $per_page     = 100;
        $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
        $offset       = ($current_page - 1) * $per_page;

        $args = [
            'post_type'      => 'resume',
            'posts_per_page' => $per_page,
            'offset'         => $offset,
        ];

        $resumes     = get_posts($args);
        $total_posts = wp_count_posts('resume')->publish;
        $total_pages = ceil($total_posts / $per_page);
    ?>
<div class="wrap">
<h1>Gestion des CV</h1>


<table class="wp-list-table widefat fixed striped">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Spécialité</th>
            <th>Années d'expérience</th>
            <th>Diplôme le plus élevé</th>
            <<!-- th>Email</th>
            <th>Téléphone</th> -->
            <th>Date de naissance</th>
            <th>Emplois postulés</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="tableau-cv">
    <?php
        foreach ($resumes as $resume) {
                $user_id = $resume->post_author;
                $cv_url  = get_post_meta($resume->ID, '_resume_file', true);

                // Récupération des candidatures
                $candidate_email = get_post_meta($resume->ID, '_candidate_email', true);

                $applications = get_posts([
                    'post_type'      => 'job_application',
                    'posts_per_page' => -1,
                    'meta_query'     => [
                        [
                            'key'     => '_candidate_email',
                            'value'   => $candidate_email,
                            'compare' => '=',
                        ],
                    ],
                ]);

                echo '<tr>';
                echo '<td>' . $resume->post_title . '</td>';
                echo '<td>' . get_post_meta($resume->ID, '_candidate_speciality', true) . '</td>';
                echo '<td>' . get_post_meta($resume->ID, '_candidate_experience_years', true) . ' ans</td>';
                echo '<td>' . get_post_meta($resume->ID, '_candidate_highest_diploma', true) . '</td>';
                /*     echo '<td>' . get_post_meta($resume->ID, '_candidate_email', true) . '</td>';
        echo '<td>' . get_post_meta($resume->ID, '_candidate_phone', true) . '</td>'; */
                echo '<td>' . get_post_meta($resume->ID, '_candidate_date_of_birth', true) . '</td>';

                // Nouvelle colonne des emplois postulés
                echo '<td>';
                $jobs_postules = $wpdb->get_results($wpdb->prepare(
                    "SELECT pm2.meta_value as job_id
            FROM {$wpdb->postmeta} pm1
            JOIN {$wpdb->postmeta} pm2 ON pm1.post_id = pm2.post_id
            WHERE pm1.meta_key = '_candidate_email'
            AND pm1.meta_value = %s
            AND pm2.meta_key = '_applying_for_job_id'",
                    $candidate_email
                ));

                if ($jobs_postules) {
                    foreach ($jobs_postules as $job) {
                        $job_title = get_the_title($job->job_id);
                        echo '<div class="job-application">';
                        echo esc_html($job_title);
                        echo '</div>';
                    }
                } else {
                    echo 'Aucun emploi postulé';
                }
                echo '</td>';

                // Actions
                echo '<td>';
                if ($cv_url) {
                    echo '<a href="' . esc_url($cv_url) . '" class="button button-primary" download><span class="dashicons dashicons-download"></span> Télécharger</a> ';
                }
                echo '</td>';
                echo '</tr>';
            }
        ?>
    </tbody>
</table>

<div class="tablenav bottom">
    <div class="tablenav-pages">
        <?php
            echo paginate_links([
                    'base'      => add_query_arg('paged', '%#%'),
                    'format'    => '',
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                    'total'     => $total_pages,
                    'current'   => $current_page,
                ]);
            ?>
    </div>
</div>
</div>
<?php
    }

    function charger_scripts_admin_cv($hook)
    {
        if ('toplevel_page_gestion-cv' !== $hook) {
            return;
        }
        wp_enqueue_script('admin-cv', get_template_directory_uri() . '/js/admin.js', ['jquery'], '1.0.0', true);
        wp_enqueue_style('admin-cv-style', get_template_directory_uri() . '/css/admin.css', [], '1.0.0');
    }
    add_action('admin_enqueue_scripts', 'charger_scripts_admin_cv');

    // Modifier et réorganiser les colonnes des candidatures
    function modifier_colonnes_candidatures($columns)
    {
        // Supprimer les colonnes non désirées
        if (isset($columns['comments'])) {
            unset($columns['comments']);
        }

        if (isset($columns['attachments'])) {
            unset($columns['attachments']);
        }

        if (isset($columns['job'])) {
            unset($columns['job']);
        }

        if (isset($columns['application_notes'])) {
            unset($columns['application_notes']);
        }

        // Stocker temporairement les colonnes que nous voulons mettre en premier
        $status_column    = isset($columns['application_status']) ? $columns['application_status'] : '';
        $candidate_column = isset($columns['candidate']) ? $columns['candidate'] : '';

        // Supprimer ces colonnes de l'array original
        if (isset($columns['application_status'])) {
            unset($columns['application_status']);
        }

        if (isset($columns['candidate'])) {
            unset($columns['candidate']);
        }

        // Créer un nouvel array avec l'ordre souhaité
        $new_columns = [];

        // Ajouter la case à cocher (si présente)
        if (isset($columns['cb'])) {
            $new_columns['cb'] = $columns['cb'];
            unset($columns['cb']);
        }

        // Ajouter status et candidate en premier
        if ($status_column) {
            $new_columns['application_status'] = $status_column;
        }

        if ($candidate_column) {
            $new_columns['candidate'] = $candidate_column;
        }

        // Ajouter le reste des colonnes
        $new_columns = array_merge($new_columns, $columns);

        return $new_columns;
    }
    add_filter('manage_job_application_posts_columns', 'modifier_colonnes_candidatures', 20);
// Charger les scripts ThickBox sur la page des candidatures
function bralico_load_thickbox_for_applications() {
    $screen = get_current_screen();
    if ($screen->id === 'edit-job_application') {
        add_thickbox();
    }
}
add_action('admin_enqueue_scripts', 'bralico_load_thickbox_for_applications');


    // Ajouter/modifier les colonnes dans la liste des job_application
function bralico_job_applications_columns($columns)
    {
        // On conserve la case à cocher et la date, mais on réorganise l'ordre
        $new_columns       = [];
        $new_columns['cb'] = $columns['cb'];
        $new_columns['application_status'] = __('Statut', 'bralico');
           // Le titre (nom du candidat) en deuxième position
           $new_columns['candidate'] = __('Candidat/postulant', 'bralico');
           $new_columns['title'] = __('Candidat/postulant', 'bralico');
    
        $new_columns['title']                      = __('Candidat/postulant', 'bralico'); // Renommé en "Candidat" pour plus de clarté

        $new_columns['candidate_phone']            = __('Téléphone', 'bralico');
        $new_columns['candidate_speciality']       = __('Spécialité', 'bralico');
        $new_columns['candidate_experience_years'] = __('Années d\'expérience', 'bralico');
        $new_columns['candidate_highest_diploma']  = __('Diplôme le plus élevé', 'bralico');
        $new_columns['application_details']        = __('Aperçu & Documents', 'bralico');
        $new_columns['actions']                    = __('Lettre de motivation', 'bralico');
        
        $new_columns['date']                       = $columns['date'];
        $new_columns['candidate_email']            = __('Email', 'bralico');
        return $new_columns;
    }
    add_filter('manage_edit-job_application_columns', 'bralico_job_applications_columns');

    // Remplissage des colonnes personnalisées
    function bralico_job_applications_custom_column($column, $post_id)
    {
        switch ($column) {
            //affichage d'une thickbox avec les détails de la candidature 
            case 'actions':
                // ID unique pour la ThickBox
                $thickbox_id = 'application-details-' . $post_id;
                
                // Créer l'URL avec les paramètres de la ThickBox
                $thickbox_url = '#TB_inline?width=600&height=550&inlineId=' . $thickbox_id;
                
                // Afficher le bouton qui ouvre la ThickBox
                echo '<a href="' . esc_url($thickbox_url) . '" class="icon-view button tips thickbox" title="' . esc_attr__('Voir le message du candidat', 'bralico') . '">';
                echo '<span class="dashicons dashicons-visibility"></span>';
                echo '</a>';
                
                // Contenu caché de la ThickBox
                echo '<div id="' . esc_attr($thickbox_id) . '" style="display:none;">';
                echo '<h2>' . esc_html__('Message du candidat', 'bralico') . '</h2>';
                
                // Tenter de récupérer le message de deux façons possibles
                $message = get_post_meta($post_id, '_candidate_message', true);
                
                // Si pas de message trouvé via la métadonnée, essayer le contenu du post
                if (empty($message)) {
                    $application_post = get_post($post_id);
                    $message = $application_post->post_content;
                }
                
                echo '<div class="application-details-content">';
                
                // Message du candidat
                if (!empty($message)) {
                    echo '<div class="candidate-message">';
                    echo '<div class="message-content">' . wpautop($message) . '</div>';
                    echo '</div>';
                } else {
                    echo '<p>' . esc_html__('Aucun message disponible pour ce candidat.', 'bralico') . '</p>';
                }
                
                echo '</div>'; // .application-details-content
                echo '</div>'; // #thickbox_id
                break;
            
            
            //afichage du status 
            case 'application_status':
                $status = get_post_meta($post_id, '_application_status', true);
                $status_labels = [
                    'new' => __('Nouvelle', 'bralico'),
                    'interview' => __('Entretien', 'bralico'),
                    'offer' => __('Offre', 'bralico'),
                    'hired' => __('Embauché', 'bralico'),
                    'rejected' => __('Rejeté', 'bralico')
                ];
                
                $status_label = isset($status_labels[$status]) ? $status_labels[$status] : __('Nouvelle', 'bralico');
                echo '<span class="application-status status-' . esc_attr($status) . '">' . esc_html($status_label) . '</span>';
                break;
            case 'candidate_email':
                echo esc_html(get_post_meta($post_id, '_candidate_email', true));
                break;
            case 'candidate_phone':
                echo esc_html(get_post_meta($post_id, '_candidate_phone', true));
                break;
            case 'candidate_speciality':
                echo esc_html(get_post_meta($post_id, '_candidate_speciality', true));
                break;
            case 'candidate_experience_years':
                $years = get_post_meta($post_id, '_candidate_experience_years', true);
                echo ! empty($years) ? esc_html($years . ' ans') : '';
                break;
            case 'candidate_highest_diploma':
                echo esc_html(get_post_meta($post_id, '_candidate_highest_diploma', true));
                break;
            case 'application_details':
                // Afficher directement les documents au lieu du message
                echo '<div class="application-documents">';

                // Méthode améliorée pour récupérer le CV
                $cv_url = '';

                // Méthode 1: Essayer de récupérer directement le chemin du CV
                $cv_path = get_post_meta($post_id, '_cv_path', true);
                if (! empty($cv_path)) {
                    $cv_url = $cv_path;
                }

                // Méthode 2: Si pas de chemin direct, essayer via l'ID du CV
                if (empty($cv_url)) {
                    $resume_id = get_post_meta($post_id, '_resume_id', true);
                    if (! empty($resume_id)) {
                        // Récupérer l'URL du fichier CV depuis le CV
                        $resume_file = get_post_meta($resume_id, '_resume_file', true);
                        if (! empty($resume_file)) {
                            $cv_url = $resume_file;
                        }

                        // Si _resume_file est vide, essayer d'autres champs possibles
                        if (empty($cv_url)) {
                            $cv_url = get_the_permalink($resume_id); // Lien vers le CV
                        }
                    }
                }

                // Afficher le lien vers le CV
                if (! empty($cv_url)) {
                    echo '<a href="' . esc_url($cv_url) . '" class="button button-small" target="_blank">';
                    echo '<span class="dashicons dashicons-pdf"></span> CV</a> ';
                } else {
                    echo '<span class="no-cv">Aucun CV</span> ';
                }

                // Lien vers la lettre de motivation si elle existe
                $motivation_letter = get_post_meta($post_id, '_motivation_letter', true);
                if (! empty($motivation_letter)) {
                    echo '<a href="' . esc_url($motivation_letter) . '" class="button button-small" target="_blank">';
                    echo '<span class="dashicons dashicons-media-document"></span> Lettre</a> ';
                }

                // Lien vers le portfolio si disponible
                $portfolio = get_post_meta($post_id, '_portfolio', true);
                if (! empty($portfolio)) {
                    echo '<a href="' . esc_url($portfolio) . '" class="button button-small" target="_blank">';
                    echo '<span class="dashicons dashicons-portfolio"></span> Portfolio</a>';
                }

                echo '</div>';
                break;
        }
    }
    add_action('manage_job_application_posts_custom_column', 'bralico_job_applications_custom_column', 10, 2);
// Ajouter des styles pour la ThickBox des candidatures
function bralico_application_thickbox_styles() {
    $screen = get_current_screen();
    if ($screen->id === 'edit-job_application') {
        ?>
        <style type="text/css">
            .application-details-content {
                padding: 15px;
                max-height: 450px;
                overflow-y: auto;
            }
            .candidate-message {
                margin-top: 20px;
                border-top: 1px solid #ddd;
                padding-top: 15px;
            }
            .message-content {
                background: #f9f9f9;
                padding: 12px;
                border-left: 4px solid #2271b1;
            }
        </style>
        <?php
    }
}
add_action('admin_head', 'bralico_application_thickbox_styles');

    // Déclarer les colonnes triables
    function bralico_job_applications_sortable_columns($columns)
    {
        $columns['candidate_email']            = 'candidate_email';
        $columns['candidate_phone']            = 'candidate_phone';
        $columns['candidate_speciality']       = 'candidate_speciality';
        $columns['candidate_experience_years'] = 'candidate_experience_years';
        $columns['candidate_highest_diploma']  = 'candidate_highest_diploma';
        return $columns;
    }
    add_filter('manage_edit-job_application_sortable_columns', 'bralico_job_applications_sortable_columns');

    // Modifier la requête pour permettre le tri sur les méta-champs
    function bralico_job_applications_orderby($query)
    {
        if (! is_admin() || ! $query->is_main_query() || $query->get('post_type') !== 'job_application') {
            return;
        }

        $orderby = $query->get('orderby');

        $meta_keys = [
            'candidate_email'            => '_candidate_email',
            'candidate_phone'            => '_candidate_phone',
            'candidate_speciality'       => '_candidate_speciality',
            'candidate_experience_years' => '_candidate_experience_years',
            'candidate_highest_diploma'  => '_candidate_highest_diploma',
        ];

        if (isset($meta_keys[$orderby])) {
            $query->set('meta_key', $meta_keys[$orderby]);
            $query->set('orderby', $orderby === 'candidate_experience_years' ? 'meta_value_num' : 'meta_value');
        }
    }
    add_action('pre_get_posts', 'bralico_job_applications_orderby');

    // Ajouter du JavaScript pour le toggle du message complet et les styles CSS
    function bralico_admin_applications_scripts()
    {
        $screen = get_current_screen();
        if ($screen && $screen->post_type === 'job_application') {
        ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.toggle-full-message').on('click', function(e) {
        e.preventDefault();
        var postId = $(this).data('post-id');
        $('#full-message-' + postId).toggle();
        var text = $(this).text();
        $(this).text(text === '[Voir plus]' ? '[Voir moins]' : '[Voir plus]');
    });
});
</script>
<style>
.application-message-preview {
    margin-bottom: 8px;
}
.full-message {
    background: #f9f9f9;
    padding: 10px;
    border-left: 3px solid #0a6535;
    margin-top: 5px;
    max-height: 200px;
    overflow-y: auto;
}
.application-documents .button {
    margin-right: 5px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.application-documents .dashicons {
    font-size: 16px;
    width: 16px;
    height: 16px;
}
.no-cv {
    color: #999;
    font-style: italic;
}
/* Styles pour la page de détail */
.candidate-details {
    padding: 15px;
    background: #fff;
    border: 1px solid #e5e5e5;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
    margin: 10px 0;
}
.candidate-details h3 {
    margin-top: 0;
    padding-bottom: 8px;
    border-bottom: 1px solid #eee;
}
.candidate-field {
    margin-bottom: 10px;
    display: flex;
}
.candidate-field label {
    font-weight: bold;
    min-width: 180px;
}
.candidate-field .field-value {
    flex-grow: 1;
}
.candidate-documents {
    margin-top: 20px;
}
.candidate-documents .button {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-right: 10px;
    padding: 5px 15px;
}
</style>
<?php
    }
    }
    add_action('admin_footer', 'bralico_admin_applications_scripts');

    // Ajouter une méta-box pour afficher tous les détails de la candidature
    function bralico_add_application_details_metabox()
    {
        add_meta_box(
            'application_details_metabox',
            __('Détails de la candidature', 'bralico'),
            'bralico_render_application_details_metabox',
            'job_application',
            'normal',
            'high'
        );
    }
    add_action('add_meta_boxes', 'bralico_add_application_details_metabox');

    // Fonction pour afficher le contenu de la méta-box de détails
    function bralico_render_application_details_metabox($post)
    {
        // Liste des champs à afficher avec leurs labels
        $fields = [
            '_candidate_name'             => 'Nom du candidat',
            '_candidate_email'            => 'Email',
            '_candidate_phone'            => 'Téléphone',
            '_candidate_speciality'       => 'Spécialité',
            '_candidate_experience_years' => 'Années d\'expérience',
            '_candidate_highest_diploma'  => 'Diplôme le plus élevé',
            '_candidate_nationality'      => 'Nationalité',
            '_candidate_date_of_birth'    => 'Date de naissance',
            '_job_category'               => 'Catégorie d\'emploi',
        ];

        // Récupérer l'ID du CV associé
        $resume_id         = get_post_meta($post->ID, '_resume_id', true);
        $job_id            = get_post_meta($post->ID, '_job_id', true);
        $cv_path           = get_post_meta($post->ID, '_cv_path', true);
        $motivation_letter = get_post_meta($post->ID, '_motivation_letter', true);
        $portfolio         = get_post_meta($post->ID, '_portfolio', true);

        echo '<div class="candidate-details">';

        // Section des informations de base
        echo '<h3>Informations personnelles</h3>';

        foreach ($fields as $key => $label) {
            $value = get_post_meta($post->ID, $key, true);
            if (! empty($value)) {
                echo '<div class="candidate-field">';
                echo '<label>' . esc_html($label) . ':</label>';
                echo '<div class="field-value">' . esc_html($value) . '</div>';
                echo '</div>';
            }
        }

        // Section de l'offre d'emploi
        if (! empty($job_id)) {
            echo '<h3>Offre d\'emploi</h3>';
            echo '<div class="candidate-field">';
            echo '<label>Poste visé:</label>';
            echo '<div class="field-value"><a href="' . get_edit_post_link($job_id) . '" target="_blank">' . get_the_title($job_id) . '</a></div>';
            echo '</div>';
        }

        // Section du message
        echo '<h3>Message du candidat</h3>';
        echo '<div class="candidate-field">';
        echo '<div class="field-value">' . nl2br(esc_html($post->post_content)) . '</div>';
        echo '</div>';

        // Section des documents
        echo '<h3>Documents</h3>';
        echo '<div class="candidate-documents">';

        // Lien vers le CV
        if (! empty($cv_path)) {
            echo '<a href="' . esc_url($cv_path) . '" class="button" target="_blank">';
            echo '<span class="dashicons dashicons-pdf"></span> Télécharger le CV</a>';
        } elseif (! empty($resume_id)) {
            echo '<a href="' . get_edit_post_link($resume_id) . '" class="button" target="_blank">';
            echo '<span class="dashicons dashicons-visibility"></span> Voir le CV</a>';
        }

        // Lien vers la lettre de motivation
        if (! empty($motivation_letter)) {
            echo '<a href="' . esc_url($motivation_letter) . '" class="button" target="_blank">';
            echo '<span class="dashicons dashicons-media-document"></span> Télécharger la lettre de motivation</a>';
        }

        // Lien vers le portfolio si disponible
        if (! empty($portfolio)) {
            echo '<a href="' . esc_url($portfolio) . '" class="button" target="_blank">';
            echo '<span class="dashicons dashicons-portfolio"></span> Télécharger le portfolio</a>';
        }

        echo '</div>'; // Fin des documents

        // Informations supplémentaires du CV
        if (! empty($resume_id)) {
            $resume = get_post($resume_id);
            if ($resume) {
                // Expérience profess
                // Expérience professionnelle
                echo '<h3>Informations du CV</h3>';

                // Afficher un lien vers le CV complet
                echo '<div class="candidate-field">';
                echo '<label>CV complet:</label>';
                echo '<div class="field-value"><a href="' . get_edit_post_link($resume_id) . '" target="_blank">Voir le CV complet dans l\'administration</a></div>';
                echo '</div>';

                // Récupérer et afficher l'expérience professionnelle
                $experience = get_post_meta($resume_id, '_candidate_experience', true);
                if (! empty($experience) && is_array($experience)) {
                    echo '<div class="candidate-field">';
                    echo '<label>Expérience professionnelle:</label>';
                    echo '<div class="field-value">';
                    foreach ($experience as $exp) {
                        if (! empty($exp['employer']) || ! empty($exp['job_title'])) {
                            echo '<div class="experience-item">';
                            echo '<strong>' . esc_html($exp['job_title']) . '</strong>';
                            if (! empty($exp['employer'])) {
                                echo ' chez ' . esc_html($exp['employer']);
                            }
                            echo '<br>';
                            if (! empty($exp['date_start']) && ! empty($exp['date_end'])) {
                                echo 'De ' . esc_html($exp['date_start']) . ' à ' . esc_html($exp['date_end']) . '<br>';
                            }
                            if (! empty($exp['notes'])) {
                                echo esc_html($exp['notes']);
                            }
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                }

                // Récupérer et afficher l'éducation/formation
                $education = get_post_meta($resume_id, '_candidate_education', true);
                if (! empty($education) && is_array($education)) {
                    echo '<div class="candidate-field">';
                    echo '<label>Formation:</label>';
                    echo '<div class="field-value">';
                    foreach ($education as $edu) {
                        if (! empty($edu['location']) || ! empty($edu['qualification'])) {
                            echo '<div class="education-item">';
                            echo '<strong>' . esc_html($edu['qualification']) . '</strong>';
                            if (! empty($edu['location'])) {
                                echo ' à ' . esc_html($edu['location']);
                            }
                            echo '<br>';
                            if (! empty($edu['date_start']) && ! empty($edu['date_end'])) {
                                echo 'De ' . esc_html($edu['date_start']) . ' à ' . esc_html($edu['date_end']) . '<br>';
                            }
                            if (! empty($edu['notes'])) {
                                echo esc_html($edu['notes']);
                            }
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                }

                // Autres métadonnées du CV
                $resume_fields = [
                    '_candidate_location'         => 'Lieu',
                    '_candidate_date_of_birth'    => 'Date de naissance',
                    '_candidate_nationality'      => 'Nationalité',
                    '_candidate_phone'            => 'Téléphone',
                    '_candidate_experience_years' => 'Années d\'expérience',
                    '_candidate_highest_diploma'  => 'Diplôme le plus élevé',
                    '_candidate_speciality'       => 'Spécialité',
                ];

                foreach ($resume_fields as $meta_key => $label) {
                    $value = get_post_meta($resume_id, $meta_key, true);
                    if (! empty($value) && ! array_key_exists('_' . substr($meta_key, 1), $fields)) {
                        echo '<div class="candidate-field">';
                        echo '<label>' . esc_html($label) . ':</label>';
                        echo '<div class="field-value">' . esc_html($value) . '</div>';
                        echo '</div>';
                    }
                }
            }
        }

        echo '</div>'; // Fin de .candidate-details
    }

    // Enregistrer les données du CV lors de la soumission d'une candidature
    function bralico_save_application_form($application_id, $resume_id)
    {
        if (! $application_id || ! $resume_id) {
            return;
        }

        // Récupérer les métadonnées du CV
        $resume_fields = [
            '_candidate_location',
            '_candidate_date_of_birth',
            '_candidate_nationality',
            '_candidate_phone',
            '_candidate_experience_years',
            '_candidate_highest_diploma',
            '_candidate_speciality',
        ];

        // Copier les métadonnées du CV vers la candidature
        foreach ($resume_fields as $field) {
            $value = get_post_meta($resume_id, $field, true);
            if (! empty($value)) {
                update_post_meta($application_id, $field, $value);
            }
        }

        // Récupérer l'URL du CV
        $cv_path = get_post_meta($resume_id, '_resume_file', true);

        // Si _resume_file est vide, essayer d'autres méthodes
        if (empty($cv_path)) {
            // Essayer avec le permalien du CV
            $cv_path = get_the_permalink($resume_id);

            // Chercher dans les pièces jointes
            if (empty($cv_path) || $cv_path == get_permalink(0)) {
                $attachments = get_posts([
                    'post_type'      => 'attachment',
                    'posts_per_page' => 1,
                    'post_parent'    => $resume_id,
                    'post_mime_type' => 'application/pdf',
                ]);

                if (! empty($attachments)) {
                    $cv_path = wp_get_attachment_url($attachments[0]->ID);
                }
            }
        }

        // Enregistrer les métadonnées
        if (! empty($cv_path)) {
            update_post_meta($application_id, '_cv_path', $cv_path);
        }
        update_post_meta($application_id, '_resume_id', $resume_id);
}

// Gestion des nationalités 

add_action('wp_footer', 'fix_nationality_field_visibility');
function fix_nationality_field_visibility() {
    ?>
    <script type="text/javascript">
    (function($) {
        // Fonction pour exécuter le code une fois que jQuery est chargé
        function initNationalityToggle() {
            console.log("Initialisation du script de nationalité");
            
            // Fonction pour vérifier et ajuster la visibilité
            function updateNationalityFieldVisibility() {
                // Ciblez spécifiquement le fieldset complet
                var nationalityFieldset = $('.fieldset-candidate_nationality');
                var radioValue = $('input[name="candidate_nationality_type"]:checked').val();
                
                console.log("Fieldset de nationalité trouvé:", nationalityFieldset.length);
                console.log("Valeur du bouton radio:", radioValue);
                
                if (radioValue === 'autres') {
                    nationalityFieldset.show();
                } else {
                    nationalityFieldset.hide();
                }
            }
            
            // Attacher les gestionnaires d'événements
            $(document).on('change', 'input[type="radio"][name="candidate_nationality_type"]', updateNationalityFieldVisibility);
            
            // Exécuter immédiatement et après un court délai
            updateNationalityFieldVisibility();
            setTimeout(updateNationalityFieldVisibility, 500);
            
            // Vérifier aussi après chaque requête AJAX
            $(document).ajaxComplete(updateNationalityFieldVisibility);
        }
        
        // S'assurer que jQuery est chargé
        $(document).ready(initNationalityToggle);
        
    })(jQuery);
    </script>
    <?php
}


// Ajouter des colonnes personnalisées à la liste des candidatures
function bralico_add_job_application_columns($columns)
    {
        $new_columns = array();
        
        // Conserver les colonnes existantes jusqu'à 'title'
        foreach ($columns as $key => $value) {
            $new_columns[$key] = $value;
            if ($key === 'title') {
                // Ajouter nos nouvelles colonnes après le titre
                $new_columns['candidate_diploma'] = 'Diplôme';
                $new_columns['candidate_speciality'] = 'Spécialité';
                $new_columns['candidate_experience'] = 'Expérience';
            }
        }
        
        return $new_columns;
    }
add_filter('manage_job_application_posts_columns', 'bralico_add_job_application_columns');

// Remplir les données dans les colonnes personnalisées
function bralico_display_job_application_columns($column, $post_id) {
    switch ($column) {
        case 'candidate_highest_diploma':
            // Récupérer le CV associé à la candidature
            $resume_id = get_post_meta($post_id, '_resume_id', true);
            if ($resume_id) {
                echo esc_html(get_post_meta($resume_id, '_candidate_highest_diploma', true));
            }
            break;
            
        case 'candidate_speciality':
            $resume_id = get_post_meta($post_id, '_resume_id', true);
            if ($resume_id) {
                echo esc_html(get_post_meta($resume_id, '_candidate_speciality', true));
            }
            break;
            
        case 'candidate_experience_years':
            $resume_id = get_post_meta($post_id, '_resume_id', true);
            if ($resume_id) {
                echo esc_html(get_post_meta($resume_id, '_candidate_experience_years', true));
            }
            break;
    }
}
add_action('manage_job_application_posts_custom_column', 'bralico_display_job_application_columns', 10, 2);
// Ajouter des filtres déroulants à la page des candidatures

// Ajouter les filtres pour les candidatures
function bralico_add_job_application_filters() {
    global $typenow;
    
    if ($typenow != 'job_application') return;
    
    // Créer un conteneur pour nos filtres et compteur
    echo '<div id="bralico-dynamic-filters" class="alignleft actions" style="padding: 8px 0;">';
    
    // Créer les sélecteurs vides
    echo '<select id="filter-diploma" class="job-application-filter">
            <option value="">Tous les diplômes</option>
          </select>';
    
    echo '<select id="filter-speciality" class="job-application-filter">
            <option value="">Toutes les spécialités</option>
          </select>';
    
    echo '<select id="filter-experience" class="job-application-filter">
            <option value="">Toutes les expériences</option>
          </select>';
    
    // Compteur de résultats
    echo '<span id="filter-count" style="margin-left: 15px; padding: 3px 8px; background: #f0f0f0; border-radius: 3px;">
            <span id="matched-count">0</span> sur <span id="total-count">0</span> candidatures
          </span>';
    
    // Bouton de réinitialisation
    echo '<button type="button" id="reset-filters" class="button" style="margin-left: 10px;">Réinitialiser</button>';
    
    echo '</div>';
}
add_action('restrict_manage_posts', 'bralico_add_job_application_filters', 20);

// Script de filtrage amélioré
function bralico_add_dynamic_filter_script() {
    global $typenow;
    
    if ($typenow != 'job_application') return;
    
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Créer un conteneur sticky pour les filtres
        $('.tablenav.top').after('<div id="sticky-filter-container"></div>');
        
        // Créer la barre de filtrage
        $('<div id="bralico-filter-bar">' +
            '<div class="filter-section">' +
                '<label><strong>Diplôme:</strong></label>' +
                '<select id="filter-diploma" class="job-application-filter">' +
                    '<option value="">Tous les diplômes</option>' +
                '</select>' +
            '</div>' +
            '<div class="filter-section">' +
                '<label><strong>Spécialité:</strong></label>' +
                '<select id="filter-speciality" class="job-application-filter">' +
                    '<option value="">Toutes les spécialités</option>' +
                '</select>' +
            '</div>' +
            '<div class="filter-section">' +
                '<label><strong>Expérience:</strong></label>' +
                '<select id="filter-experience" class="job-application-filter">' +
                    '<option value="">Toutes les expériences</option>' +
                '</select>' +
            '</div>' +
            '<div class="filter-section">' +
                '<button type="button" id="reset-filters" class="button">Réinitialiser</button>' +
                '<span id="filter-count"><span id="matched-count">0</span> sur <span id="total-count">0</span> candidatures</span>' +
            '</div>' +
        '</div>').appendTo('#sticky-filter-container');
        
        console.log("Script de filtrage dynamique chargé");
        
        // Ajouter des attributs data aux colonnes pour identifier leur type
        $('.wp-list-table thead th').each(function(index) {
            var headerText = $(this).text().trim().toLowerCase();
            if (headerText.indexOf('diplôme') !== -1) {
                $(this).attr('data-column-type', 'diploma');
                console.log("Colonne diplôme trouvée à l'index", index);
            } else if (headerText.indexOf('spécialité') !== -1) {
                $(this).attr('data-column-type', 'speciality');
                console.log("Colonne spécialité trouvée à l'index", index);
            } else if (headerText.indexOf('expérience') !== -1) {
                $(this).attr('data-column-type', 'experience');
                console.log("Colonne expérience trouvée à l'index", index);
            }
        });
        
        // Initialiser les tableaux pour stocker les valeurs uniques
        var diplomas = [];
        var specialities = [];
        var experiences = [];
        var totalRows = 0;
        
        // Parcourir chaque ligne du tableau
        $('.wp-list-table tbody tr').each(function() {
            var $row = $(this);
            totalRows++;
            
            // Pour chaque type de colonne, trouver l'index et extraire la valeur
            $('.wp-list-table thead th[data-column-type]').each(function(index) {
                var columnType = $(this).attr('data-column-type');
                var headerIndex = $(this).index();
                var cellValue = $row.find('td').eq(headerIndex).text().trim();
                
                if (columnType === 'diploma') {
                    $row.attr('data-diploma', cellValue);
                    if (cellValue && diplomas.indexOf(cellValue) === -1) {
                        diplomas.push(cellValue);
                    }
                } else if (columnType === 'speciality') {
                    $row.attr('data-speciality', cellValue);
                    if (cellValue && specialities.indexOf(cellValue) === -1) {
                        specialities.push(cellValue);
                    }
                } else if (columnType === 'experience') {
                    // Nettoyer l'expérience (enlever "ans" etc.)
                    var cleanExp = cellValue.replace(/\s*ans\s*/i, '').trim();
                    $row.attr('data-experience', cleanExp);
                    if (cleanExp && experiences.indexOf(cleanExp) === -1) {
                        experiences.push(cleanExp);
                    }
                }
            });
        });
        
        console.log("Valeurs trouvées:", {
            diplomas: diplomas,
            specialities: specialities,
            experiences: experiences,
            totalRows: totalRows
        });
        
        // Mettre à jour le compteur total
        $('#total-count').text(totalRows);
        $('#matched-count').text(totalRows);
        
        // Trier les arrays
        diplomas.sort();
        specialities.sort();
        experiences.sort(function(a, b) {
            return parseInt(a) - parseInt(b);
        });
        
        // Remplir les sélecteurs
        $.each(diplomas, function(i, diploma) {
            $('#filter-diploma').append($('<option>', {
                value: diploma,
                text: diploma
            }));
        });
        
        $.each(specialities, function(i, speciality) {
            $('#filter-speciality').append($('<option>', {
                value: speciality,
                text: speciality
            }));
        });
        
        $.each(experiences, function(i, experience) {
            $('#filter-experience').append($('<option>', {
                value: experience,
                text: experience + ' ans'
            }));
        });
        
        // Fonction pour appliquer les filtres
        function applyFilters() {
            var diplomaFilter = $('#filter-diploma').val();
            var specialityFilter = $('#filter-speciality').val();
            var experienceFilter = $('#filter-experience').val();
            
            console.log("Filtres appliqués:", {
                diploma: diplomaFilter,
                speciality: specialityFilter,
                experience: experienceFilter
            });
            
            var matchedCount = 0;
            
            // Filtrer les lignes
            $('.wp-list-table tbody tr').each(function() {
                var $row = $(this);
                var rowDiploma = $row.attr('data-diploma') || '';
                var rowSpeciality = $row.attr('data-speciality') || '';
                var rowExperience = $row.attr('data-experience') || '';
                
                var showRow = true;
                
                if (diplomaFilter && rowDiploma !== diplomaFilter) {
                    showRow = false;
                }
                
                if (specialityFilter && rowSpeciality !== specialityFilter) {
                    showRow = false;
                }
                
                if (experienceFilter && rowExperience !== experienceFilter) {
                    showRow = false;
                }
                
                if (showRow) {
                    $row.show();
                    matchedCount++;
                } else {
                    $row.hide();
                }
            });
            
            // Mettre à jour le compteur
            $('#matched-count').text(matchedCount);
            
            // Afficher un message si aucun résultat
            if (matchedCount === 0) {
                if ($('.no-items-found').length === 0) {
                    $('.wp-list-table tbody').append(
                        '<tr class="no-items-found"><td colspan="' + 
                        $('.wp-list-table th').length + 
                        '" style="text-align:center;padding:20px;"><em>Aucune candidature ne correspond à ces critères</em></td></tr>'
                    );
                }
            } else {
                $('.no-items-found').remove();
            }
        }
        
        // Gérer le changement dans les filtres
        $('.job-application-filter').on('change', applyFilters);
        
        // Réinitialiser les filtres
        $('#reset-filters').on('click', function() {
            $('.job-application-filter').val('');
            $('.wp-list-table tbody tr').show();
            $('.no-items-found').remove();
            $('#matched-count').text(totalRows);
        });
        
        // Détecter quand la barre devient sticky
        var observer = new IntersectionObserver(
            ([e]) => {
                // Ajouter ou supprimer la classe is-sticky
                $('#sticky-filter-container').toggleClass('is-sticky', e.intersectionRatio < 1);
            }, 
            { threshold: [1] }
        );
        
        // Observer le conteneur
        observer.observe(document.querySelector('#sticky-filter-container'));
    });
    </script>
    <style>
    /* Styles pour la barre de filtre sticky */
    #sticky-filter-container {
        position: sticky;
        top: 32px; /* Hauteur de la barre d'admin de WordPress */
        z-index: 99;
        background: #f0f7fa;
        border-bottom: 1px solid #c3c4c7;
        padding: 12px 15px;
        margin: 0 -15px 15px -15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    /* Ajouter une ombre lorsque la barre est sticky */
    #sticky-filter-container.is-sticky {
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        background: #f8fdff;
    }
    
    /* Styles pour le conteneur de filtre */
    #bralico-filter-bar {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .filter-section {
        display: flex;
        align-items: center;
    }
    
    .filter-section label {
        margin-right: 8px;
    }
    
    /* Adaptation pour les écrans d'admin fixes */
    body.wp-admin #sticky-filter-container {
        width: calc(100% - 30px);
        left: 0;
    }
    
    /* Style des menus déroulants */
    .job-application-filter {
        min-width: 150px;
        padding: 4px 10px;
        border: 1px solid #8c8f94;
        border-radius: 4px;
    }
    
    /* Style du compteur */
    #filter-count {
        display: inline-block;
        font-weight: 500;
        margin-left: 15px;
        padding: 5px 10px;
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    #matched-count, #total-count {
        font-weight: bold;
        color: #2271b1;
    }
    
    /* Style du bouton reset */
    #reset-filters {
        margin-right: 10px;
    }
    
    /* Espacement en dessous de la barre de filtre */
    #sticky-filter-container + * {
        margin-top: 15px;
    }
    
    /* Responsive pour petits écrans */
    @media screen and (max-width: 782px) {
        #bralico-filter-bar {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .filter-section {
            width: 100%;
        }
        
        .job-application-filter {
            flex-grow: 1;
        }
        
        #filter-count {
            margin-left: 0;
            margin-top: 10px;
        }
    }
    </style>
    <?php
}
add_action('admin_footer', 'bralico_add_dynamic_filter_script');



```
```

Follow these instructions to make the following change to my code document.

Instruction: Correction de l'inclusion du fichier de widget des dernières candidatures et suppression du code incorrect

Code Edit:
```
{{ ... }}
add_action('admin_footer', 'bralico_add_dynamic_filter_script');

// Inclure le fichier de widget des dernières candidatures
require_once get_template_directory() . '/inc/recent-applications-widget.php';
{{ ... }}
