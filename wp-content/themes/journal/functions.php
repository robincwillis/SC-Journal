<?php
// Timber
if (!class_exists('Timber'))
{
  add_action( 'admin_notices', function()
  {
    echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . admin_url('plugins.php#timber') . '">' . admin_url('plugins.php') . '</a></p></div>';
  });
  return;
}


class Colvard extends TimberSite 
{

  function __construct()
  {
    add_theme_support('post-thumbnails');
    add_theme_support('thumbnail');
      add_image_size( 'sc-3-2-sm', 800, 533, true );
      add_image_size( 'sc-sm', 800 );
      add_image_size( 'sc-md', 1000 );
      add_image_size( 'sc-5-3-md', 1000, 600, true );
      add_image_size( 'sc-3-2-lg', 1200, 800, true );
      add_image_size( 'sc-5-3-xlg', 2000, 1200, true );
      add_image_size( 'sc-xlg', 2000 );
    add_filter('timber_context', array($this, 'add_to_context'));
    add_filter('get_twig', array($this, 'add_to_twig'));
    parent::__construct();
  }

  function add_to_context($context)
  {
    $context['header_menu'] = new TimberMenu('header-menu');
    $context['footer_menu'] = new TimberMenu('footer-menu');

    $context['site'] = $this;
    // $context['td'] = get_template_directory_uri();
    $context['options'] = get_fields('options');
    $context['request'] = $_REQUEST;
    $context['globals'] = array(
      'path' => '.',
      'siteTitle' => 'Sailing Collective Journal',
      'generalEmail' => 'info@thesailingcollective.com',
      'phone' => '718 352 7989',
      'streetAddress' => '123 Explorer Avenue',
      'cityStateZip' => 'Work, New York 11201',
      'instagramUrl' => 'http://instagram.com/',
      'facebookUrl' => 'http://facebook.com/',
      'twitterUrl' => 'http://twitter.com/',
      'pinterestUrl' => 'http://pinterest.com/'
    );
    return $context;
  }

  function add_to_twig($twig)
  {
    $twig->addGlobal('td', get_template_directory_uri());
    $twig->addGlobal('footer_menu' , new TimberMenu('footer-menu'));
    $get_field = new Twig_SimpleFunction('get_field', 
      function ($field_name, $page_name = false) 
      {
        if ($page_name != 'options')
        {
          $page = get_page_by_path( $page_name );
          $result = get_field($field_name, $page->ID);
        }elseif ($page_name == 'options')
        {
          $result = get_field($field_name, $page_name);
        }else
        {
          $result = get_field($field_name);
        }
        return $result;
      }
    );

    $twig->addFunction($get_field);
    
    $get_fields = new Twig_SimpleFunction('get_fields', 
      function ($page_name_id) 
      {
        $page = get_page_by_path( $page_name_id );
        return get_fields($page);
      }
    );
    $twig->addFunction($get_fields);

    $alt = new Twig_SimpleFilter('alt', 
      function ($image_id)
      {
        $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        if (!$alt_text){
          $alt_text = get_the_title($image_id);
        }
        
        return $alt_text;
      }
    );
    $twig->addFilter($alt);

    $format_date = new Twig_SimpleFilter('format_date', 
      function ($date,$string) 
      {
        return date($string, strtotime($date));
      }
    );
    $twig->addFilter($format_date);

    $format_price = new Twig_SimpleFunction('format_price', 
      function ($price) 
      {
        return number_format($price,2);
      }
    );
    $twig->addFunction($format_price);
    

    $twig->addExtension(new Twig_Extension_Debug());

    $get_instagrams = new Twig_SimpleFunction('get_instagrams', function () {
      $access_token = '1499179435.5e1fa4e.1b034f321fcf46379aa7dd18eb563e83';
      $user_id = '1499179435';
      $count = 4;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://api.instagram.com/v1/users/$user_id/media/recent?access_token=$access_token&count=$count");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $data = curl_exec($ch);
      curl_close($ch);
      return json_decode($data)->data;
    // Getting Access Token
    // instagram.com/developer. Manage Clients > Register a New Client
    // OAuth redirect_uri : http://localhost
    // uncheck Disable implicit OAuth
    // go to: https://instagram.com/oauth/authorize/?client_id=[CLIENT_ID_HERE]&redirect_uri=http://localhost&response_type=token
    });
    $twig->addFunction($get_instagrams);

    return $twig;
    
  }

}
  
new Colvard();

function register_menus() 
{
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'footer-menu' => __('Footer Menu')
    )
  );
}
add_action( 'init', 'register_menus' );


// function create_press() {
//   $labels = array(
//     'name'               => __( 'Press'),
//     'singular_name'      => __( 'Press Item'),
//     'menu_name'          => __( 'Press'),
//     'name_admin_bar'     => __( 'Press'),
//     'add_new'            => __( 'Add New'),
//     'add_new_item'       => __( 'Add New Press Item'),
//     'new_item'           => __( 'New Press Item'),
//     'edit_item'          => __( 'Edit Press Item'),
//     'view_item'          => __( 'View Press Item'),
//     'all_items'          => __( 'All Press Items'),
//     'search_items'       => __( 'Search Press Items'),
//     'parent_item_colon'  => __( 'Parent Press Item:'),
//     'not_found'          => __( 'No Press Items found.'),
//     'not_found_in_trash' => __( 'No Press Items found in Trash.')
//   );

//   $args = array(
//     'labels'             => $labels,
//     'public'             => true,
//     'publicly_queryable' => true,
//     'show_ui'            => true,
//     'query_var'          => true,
//     'menu_icon'          => 'dashicons-format-aside',
//     'menu_position'      => 2,
//     'rewrite'            => array( 'slug' => 'press'),
//     'capability_type'    => 'post',
//     'has_archive'        => true,
//     'hierarchical'       => true,
//     'supports'           => array('title','thumbnail')
//   );
//   register_post_type( 'press', $args );
// }
// add_action( 'init', 'create_press' );

//Remove needless Wordpress stuff
function remove_admin_bar_links() 
{
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
  $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
  $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
  $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
  $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
  $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
  $wp_admin_bar->remove_menu('updates');          // Remove the updates link
  $wp_admin_bar->remove_menu('comments');         // Remove the comments link
  $wp_admin_bar->remove_menu('new-content');      // Remove the content link
  $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );
add_filter('show_admin_bar', '__return_false'); // Remove admin bar

// Add Options Page
if (function_exists('acf_add_options_page')) 
{
  acf_add_options_page('Options');
}
// function rename_post_formats($translation, $text, $context, $domain) {
//     $names = array(
//         'Aside'  => 'Recipe',
//     );
//     if ($context == 'Post format') {
//         $translation = str_replace(array_keys($names), array_values($names), $text);
//     }
//     return $translation;
// }
// add_filter('gettext_with_context', 'rename_post_formats', 10, 4);

// add_action( 'after_setup_theme', 'add_posts_formats', 11 );
// function add_posts_formats(){
//  add_theme_support( 'post-formats', array(
//     'aside'
//     ) );
// }
function change_menus()
{
  remove_menu_page( 'index.php' );                  //Dashboard
  // remove_menu_page( 'edit.php' );                   //Posts
  // remove_menu_page( 'upload.php' );              //Media
  // remove_menu_page( 'edit.php?post_type=page' ); //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'themes.php' );                 //Appearance
  // remove_menu_page( 'plugins.php' );             //Plugins
  // remove_menu_page( 'users.php' );               //Users
  // remove_menu_page( 'tools.php' );                  //Tools
  // remove_menu_page( 'options-general.php' );     //Settings

  add_menu_page( 'Home', 'Home', 'edit_pages', 'post.php?post=4&action=edit', '', 'dashicons-admin-home', 1);
  add_menu_page( 'Site Menus', 'Site Menus', 'edit_pages', 'nav-menus.php', '', 'dashicons-list-view', 25 );
}
add_action( 'admin_menu', 'change_menus' );
add_filter( 'intermediate_image_sizes', '__return_empty_array', 999 );