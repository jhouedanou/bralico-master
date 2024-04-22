<?php
/**
* Bralico functions and definitions
*
* @link https://developer.wordpress.org/themes/basics/theme-functions/
*
* @package Bralico
*/

if ( ! defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( '_S_VERSION', '1.0.0' );
}

/**
* Sets up theme defaults and registers support for various WordPress features.
*
* Note that this function is hooked into the after_setup_theme hook, which
* runs before the init hook. The init hook is too late for some features, such
* as indicating support for post thumbnails.
*/

function bralico_setup() {
    /*
    * Make theme available for translation.
    * Translations can be filed in the /languages/ directory.
    * If you're building a theme based on Bralico, use a find and replace
		* to change 'bralico' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'bralico', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'bralico' ),
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
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'bralico_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
    *
    * Priority 0 to make it available to lower priority callbacks.
    *
    * @global int $content_width
    */

    function bralico_content_width() {
        $GLOBALS[ 'content_width' ] = apply_filters( 'bralico_content_width', 640 );
    }
    add_action( 'after_setup_theme', 'bralico_content_width', 0 );

    /**
    * Register widget area.
    *
    * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
    */

    function bralico_widgets_init() {
        register_sidebar(
            array(
                'name'          => esc_html__( 'Sidebar', 'bralico' ),
                'id'            => 'sidebar-1',
                'description'   => esc_html__( 'Add widgets here.', 'bralico' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            )
        );
    }
    add_action( 'widgets_init', 'bralico_widgets_init' );

    /**
    * Enqueue scripts and styles.
    */

    function bralico_scripts() {
        wp_enqueue_style( 'bralico-style', get_stylesheet_uri(), array(), _S_VERSION );
        wp_style_add_data( 'bralico-style', 'rtl', 'replace' );

        wp_enqueue_script( 'bralico-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
    add_action( 'wp_enqueue_scripts', 'bralico_scripts' );

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
    if ( defined( 'JETPACK__VERSION' ) ) {
        require get_template_directory() . '/inc/jetpack.php';
    }

    //ajouter une fonction pour créer un template personnalisé pour chaque page, basé sur le slug de la page

    function page_template_slug( $template ) {
        global $post;
        if ( $post ) {
            $page_template_slug = get_post_meta( $post->ID, '_wp_page_template', true );
            if ( $page_template_slug ) {
                $template = get_stylesheet_directory() . '/page-' . $page_template_slug;
            }
        }
        return $template;
    }
    //fonction pour créer un template personnalisé pour chaque page, basé sur l'id de la page

function page_template_id( $template ) {
    global $post;
    if ( $post ) {
        $page_template_id = get_post_meta( $post->ID, '_wp_page_template', true );
        if ( $page_template_id ) {
            $template = get_stylesheet_directory() . '/page-' . $page_template_id;
        }
    }
    return $template;
}

//add id to body 
function add_page_id_to_body_class( $classes ) {
    if ( is_page() ) {
        $page_id = get_the_ID();
        $classes[] = 'page-id-' . $page_id;
    }
    return $classes;
}
add_filter( 'body_class', 'add_page_id_to_body_class' );


//inclure les cdn de bootstrap css et js

function bootstrap_css() {
	wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );
}
add_action('wp_enqueue_scripts', 'bootstrap_css');



function enqueue_scripts() {
    // Enqueue jQuery
    wp_enqueue_script( 'jquery-slim', 'https://code.jquery.com/jquery-3.5.1.slim.min.js', array(), '3.5.1', true );

    // Enqueue Popper.js
    wp_enqueue_script( 'popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', array('jquery-slim'), '1.16.0', true );

    // Enqueue Bootstrap JS
    wp_enqueue_script( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery-slim', 'popper'), '4.5.2', true );
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');

register_nav_menus( array(
		'Socialmenu' => 'Navigation du haut pour les réseaux sociaux',
	) );

	//permettre la mise en ligne de fichiers svg

function custom_upload_mimes( $existing_mimes ) { 
	// Ajoute webm comme type MIME autorisé
	$existing_mimes['svg'] = 'image/svg+xml';
	
	return $existing_mimes;
	}
	add_filter( 'upload_mimes', 'custom_upload_mimes' );

//permettre d'ajouter des images ou des icônes aux menus
    // Ajoute un champ personnalisé à chaque élément de menu

    function add_custom_nav_fields( $menu_item ) {
        $menu_item->image_url = get_post_meta( $menu_item->ID, '_menu_item_image_url', true );
        return $menu_item;
    }
    add_filter( 'wp_setup_nav_menu_item', 'add_custom_nav_fields' );

    // Affiche le champ personnalisé dans l'interface d'administration

    function display_custom_nav_fields( $id, $item, $depth, $args ) {
        ?>
<p class='field-image-url description description-wide'>
    <label for="edit-menu-item-image-url-<?php echo $item->ID; ?>">
        <?php _e( 'Image URL', 'text_domain' );
        ?><br />
        <input type='text' id="edit-menu-item-image-url-<?php echo $item->ID; ?>"
            class='widefat code edit-menu-item-image-url' name="menu-item-image-url[<?php echo $item->ID; ?>]"
            value="<?php echo esc_attr( $item->image_url ); ?>" />
    </label>
</p>
<?php
    }
    add_action( 'wp_nav_menu_item_custom_fields', 'display_custom_nav_fields', 10, 4 );

    // Enregistre la valeur du champ personnalisé

    function update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
        if ( isset( $_POST[ 'menu-item-image-url' ][ $menu_item_db_id ] ) ) {
            $image_url = $_POST[ 'menu-item-image-url' ][ $menu_item_db_id ];
            update_post_meta( $menu_item_db_id, '_menu_item_image_url', $image_url );
        }
    }
    add_action( 'wp_update_nav_menu_item', 'update_custom_nav_fields', 10, 3 );

    //contenu personnalisé nommé 'diapositives' pour les diapositives de la page d'accueil

    function diapositives_register_post_type() {
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
            'menu_name' => 'Diapositives'
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'diapositives' ),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );
        register_post_type( 'diapositives', $args );
    }
    add_action( 'init', 'diapositives_register_post_type' );

    // commande pour dupliquer un post
    function rd_duplicate_post_as_draft(){
        global $wpdb;
        if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
          wp_die('No post to duplicate has been supplied!');
        }
      
        if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
          return;
      
        $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
        $post = get_post( $post_id );
      
        $current_user = wp_get_current_user();
        $new_post_author = $current_user->ID;
      
        if (isset( $post ) && $post != null) {
      
          $args = array(
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
            'menu_order'     => $post->menu_order
          );
      
          $new_post_id = wp_insert_post( $args );
      
          $taxonomies = get_object_taxonomies($post->post_type);
          if(!empty($taxonomies) && is_array($taxonomies)):
            foreach ($taxonomies as $taxonomy) {
              $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
              wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
            }
          endif;
      
          $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
          if (count($post_meta_infos)!=0) {
            $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
            foreach ($post_meta_infos as $meta_info) {
              $meta_key = $meta_info->meta_key;
              $meta_value = addslashes($meta_info->meta_value);
              $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
            }
            $sql_query.= implode(" UNION ALL ", $sql_query_sel);
            $wpdb->query($sql_query);
          }
      
          wp_redirect( admin_url( 'post.php?action = edit&post = ' . $new_post_id ) );
          wp_redirect( $_SERVER['HTTP_REFERER'] );

          exit;
        } else {
          wp_die('Post creation failed, could not find original post: ' . $post_id);
        }
      }
      add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
      
      function rd_duplicate_post_link( $actions, $post ) {
        if (current_user_can('edit_posts')) {
        $actions['duplicate'] = '<a href = "' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce') . '"  rel = "permalink">Duplicate</a>';
        }
        return $actions;
      }

      
      add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );
      add_filter( 'page_row_actions', 'rd_duplicate_post_link', 10, 2 );

      function rd_edit_featured_image_link( $actions, $post ) {
        if (current_user_can('edit_posts')) {
            $featured_image_id = get_post_thumbnail_id($post->ID);
            if($featured_image_id) {
                $edit_link = get_edit_post_link($featured_image_id);
                $actions['edit_featured_image'] = '<a href="' . $edit_link . '" title="" rel="permalink">Edit Featured Image</a>';
            }
        }
        return $actions;
    }
    
    add_filter( 'post_row_actions', 'rd_edit_featured_image_link', 10, 2 );
    add_filter( 'page_row_actions', 'rd_edit_featured_image_link', 10, 2 );

    //widget pour les chiffres clés
    function arphabet_widgets_init() {
    
        register_sidebar( array(
            'name'          => 'Chiffre clé 1',
            'id'            => 'chiffre-cle-1',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ) );
    // register 3 other widgets 

    register_sidebar( array(
        'name'          => 'Chiffre clé 2',
        'id'            => 'chiffre-cle-2',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => 'Chiffre clé 3',
        'id'            => 'chiffre-cle-3',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );
        
    register_sidebar( array(
        'name'          => 'Chiffre clé 4',
        'id'            => 'chiffre-cle-4',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ));
    }
    add_action( 'widgets_init', 'arphabet_widgets_init' );
    ?>