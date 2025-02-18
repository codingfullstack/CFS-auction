<?php
/**
 * Plugin Name:       CFS-auction
 * Plugin URI:        https://github.com/codingfullstack/CFS-auction
 * Description:       Auction plugin
 * Version:           1.0.0
 * Requires at least: 5.9
 * Requires PHP:      7.2
 * Author:            CodingFullStack
 * Author URI:        https://github.com/codingfullstack
 * Text Domain:       auction-plugin
 * Domain Path:       /languages
 */

if (!function_exists('add_action')) {
  echo 'Seems like you stumbled here by accident. 😛';
  exit;
}
define('PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PLUGIN_FILE', __FILE__);
function auction_enqueue_styles() {
  wp_enqueue_style('auction-form-style', plugin_dir_url(__FILE__) . 'assets/css/shortcodes/auction-form.css');
  wp_enqueue_script('auction-form-script', plugin_dir_url(__FILE__) . 'assets/js/shortcodes/auction.js', array('jquery'), null, true);

    wp_localize_script('auction-form-script', 'auctionFormData', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('auction_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'auction_enqueue_styles');


// Dinamiškai įkelkite visus PHP failus iš includes/ katalogo
$rootFiles = glob(PLUGIN_DIR . 'includes/*.php');
$subdirectoryFiles = glob(PLUGIN_DIR . 'includes/**/*.php');
$shortcodeFiles = glob(PLUGIN_DIR . 'shortcodes/*.php'); // ✅ Pridėtas shortcodes katalogas

$allFiles = array_merge($rootFiles, $subdirectoryFiles, $shortcodeFiles);

foreach ($allFiles as $filename) {
    include_once($filename);
}
// ShortCode add
function register_auction_shortcodes() {
  add_shortcode('auction_form', 'auction_form_shortcode');
}
add_action('init', 'register_auction_shortcodes');
// Action
register_activation_hook(__FILE__, 'create_wp_auctions_table');
add_action('admin_enqueue_scripts', 'auction_admin_enqueue');
add_action('init', 'register_blocks');
add_action('init', 'auction_register_cpt');  
add_action('add_meta_boxes', 'auction_add_meta_boxes');
add_action('save_post', 'auction_save_custom_meta'); 
add_action('init', 'auction_register_assets');
add_action('after_setup_theme', 'myplugin_register_templates');
function set_default_template_for_auction( $post_ID, $post, $update ) {
  if ( $update ) {
      return; // Jei įrašas atnaujinamas, nekeiskime šablono
  }

  $default_template = 'cfs-auction//auction'; // Čia turi būti jūsų tikslus šablono registracijos ID

  if ( get_post_type( $post_ID ) === 'auction' && empty( get_page_template_slug( $post_ID ) ) ) {
      update_post_meta( $post_ID, '_wp_page_template', $default_template );
  }
}
add_action( 'save_post', 'set_default_template_for_auction', 10, 3 );
function set_default_template_dropdown_for_auction() {
  global $post;

  if ( $post && get_post_type( $post ) === 'auction' ) {
      $default_template = 'cfs-auction//auction'; // Jūsų šablono registracijos ID
      ?>
      <script>
          document.addEventListener("DOMContentLoaded", function() {
              let templateDropdown = document.querySelector("#page_template");
              if (templateDropdown && !templateDropdown.value) {
                  templateDropdown.value = "<?php echo esc_js($default_template); ?>";
              }
          });
      </script>
      <?php
  }
}
add_action( 'edit_form_after_title', 'set_default_template_dropdown_for_auction' );


