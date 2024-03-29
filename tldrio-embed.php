<?php
/*
Plugin Name: Embed tldr.io summaries
Plugin URI: http://tldr.io/embedded-tldrs
Description: Allows you to embed the summary of any webpage in your blogpost
Version: 0.0.1
Author: tldr.io
Author URI: http://tldr.io
License: GPL2
 */
?>

<?php
/*  Copyright 2013 tldr.io  (email : hello@tldr.io)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>

<?php
// Add the tldr.io button to the editor
// Works since version 3.3
function appthemes_add_quicktags() {
?>
<script type="text/javascript">
  if (QTags && QTags.addButton) {
    QTags.addButton( 'tldrio-embed', 'tldr.io', '[tldrio_embed]', '', null, 'Embed a summary in your post', 501 );
  }
</script>
<?php
}

$options = get_option('tldrio_embed_options');
if ($options['edit_button'] == 'yes') {
  add_action( 'admin_print_footer_scripts', 'appthemes_add_quicktags' );
}
?>



<?php
// Manage the embed shortcodes
function tldrio_embed_code($options, $content) {
  $display = ' style="display: none;"';

  if (strlen($content) > 0) {
    $display = '';
  }

  wp_enqueue_script('tldrio_embed_script', 'https://tldr.io/embed/widget-embed.js', NULL, NULL, true);

  return '<blockquote ' . $options . ' class="tldr-embed-widget"' . $display . '>' . $content .
    '</blockquote>';
}

function tldrio_auto_embed() {
  $options = get_option('tldrio_embed_options');
  $autolink = '';

  if ($options['default_link'] == 'yes') {
    // Default link to the summary page if the embed can't displayed
    // Useful for non compatible browsers such ad IE7 and older
    // Show it only if user has opted-in
    $autolink = '<a target="_blank" class="tldrio-auto-embed">Summary of this article</a> (via <a target="_blank" href="http://tldr.io">tldr.io</a>)
      <script>
        (function () {
          var links = document.getElementsByTagName("a"), i;
          for (i in links) {
            if ((" " + links[i].className + " ").indexOf(" tldrio-auto-embed ") !== -1) {
              links[i].href= "http://tldr.io/tldrs/search?url=" + window.location;
            }
          }
        })();
      </script>';
  }

  return tldrio_embed_code('data-use-own-tldr="true"', $autolink);
}

function tldrio_embed_with_url($url, $show_title) {
  return tldrio_embed_code('data-url="' . $url . '" data-show-title="' . $show_title . '"');
}

function tldrio_embed_with_id($tldr_id, $show_title) {
  return tldrio_embed_code('data-tldr-id="' . $tldr_id . '" data-show-title="' . $show_title . '"');
}

function tldrio_embed($atts) {
  extract( shortcode_atts( array(
    'url' => '',
    'tldr_id' => '',
    'show_title' => 'true',
    'custom_title' => '',
  ), $atts ) );

  if (strlen($tldr_id) != 0) {
    return tldrio_embed_with_id($tldr_id, $show_title);
  }

  if (strlen($url) != 0) {
    return tldrio_embed_with_url($url, $show_title);
  }

  if (substr($atts[0], 0, 4) == 'http') {
    return tldrio_embed_with_url($atts[0], true);
  }

  // By default: an auto embed
  return tldrio_auto_embed();
}

add_shortcode( 'tldrio_embed', 'tldrio_embed' );
add_shortcode( 'tldrio_auto_embed', 'tldrio_auto_embed' );
?>

<?php
// Manage options
if ( is_admin() ){
  add_action( 'admin_menu', 'tldrio_embed_plugin_menu' );
  add_action('admin_init', 'tldrio_embed_admin_init');
}

function tldrio_embed_admin_init() {
  register_setting( 'tldrio_embed_options_group', 'tldrio_embed_options', 'tldrio_embed_options_validate' );
  add_settings_section('tldrio_embed_options_main', 'Settings', 'tldrio_embed_main_text', 'tldrio_options_page');
  add_settings_field('tldrio_embed_all_settings', 'Display permalink to the tldr in Internet Explorer 7 and older (the only browser that doesn\'t support the full embed)', 'tldrio_embed_display_default_link', 'tldrio_options_page', 'tldrio_embed_options_main');
  add_settings_field('tldrio_embed_all_settings2', 'Display the tldr.io button in the post editor', 'tldrio_embed_display_edit_button', 'tldrio_options_page', 'tldrio_embed_options_main');
}

function tldrio_embed_main_text() {
}

function tldrio_embed_display_default_link() {
  $options = get_option('tldrio_embed_options');

  // Dont display the link by default
  if (strlen($options['default_link']) == 0) { $options['default_link'] = 'no'; }

  echo '<label><input name="tldrio_embed_options[default_link]" type="radio" value="yes"' . ($options['default_link'] == 'yes' ? ' checked="checked"' : '') . '> Yes</label>&nbsp;&nbsp;';
  echo '<label><input name="tldrio_embed_options[default_link]" type="radio" value="no"' . ($options['default_link'] == 'no' ? ' checked="checked"' : '') . '> No</label>';
}

function tldrio_embed_display_edit_button () {
  $options = get_option('tldrio_embed_options');

  // Use edit button by default
  if (strlen($options['edit_button']) == 0) { $options['edit_button'] = 'yes'; }

  echo '<label><input name="tldrio_embed_options[edit_button]" type="radio" value="yes"' . ($options['edit_button'] == 'yes' ? ' checked="checked"' : '') . '> Yes</label>&nbsp;&nbsp;';
  echo '<label><input name="tldrio_embed_options[edit_button]" type="radio" value="no"' . ($options['edit_button'] == 'no' ? ' checked="checked"' : '') . '> No</label>';
}

function tldrio_embed_options_validate($input) {
  return $input;
}

function tldrio_embed_plugin_menu() {
	add_options_page( 'Embed tldr.io summaries - options', 'Embed tldr.io summaries', 'manage_options', 'tldrio_embed_options_page', 'tldrio_embed_generate_options_page' );
}

function tldrio_embed_generate_options_page() {
?>
  <div class="wrap">
  <?php screen_icon(); ?>
  <h2>Embed tldr.io summaries</h2>
    <form action="options.php" method="post">
    <?php settings_fields('tldrio_embed_options_group'); ?>
    <?php do_settings_sections('tldrio_options_page'); ?>
    <br>
    <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
  </form>
  </div>
<?php
}

function tldrio_embed_deactivate() {
  delete_option('tldrio_embed_options');
}

register_deactivation_hook(__FILE__, 'tldrio_embed_deactivate');

// Upon activation, use Wordpress.org-compliant defaults (i.e. no showing a link to a tldr.io page
// If the user hasn't explicitely opted-in first
function tldrio_embed_activate() {
  update_option('tldrio_embed_options', array('edit_button' => 'yes', 'default_link' => 'no'));
}

register_activation_hook(__FILE__, 'tldrio_embed_activate');


?>
