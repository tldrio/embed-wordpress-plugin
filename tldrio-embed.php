<?php
/*
Plugin Name: Embed summaries from tldr.io
Plugin URI: http://tldr.io/embedded-tldrs
Description: Allows you to embed the summary of any webpage in your blogpost
Version: 0.0.1
Author: tldr.io
Author URI: http://tldr.io
License: GPL2
 */
?>

<?php
/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)

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
// add more buttons to the html editor
// Works since version 3.3
function appthemes_add_quicktags() {
?>
  <script type="text/javascript">
  if (QTags) {
    QTags.addButton( 'eg_pre', 'caca', '<pre lang="php">', '</ pre>', null, 'DU CACA', 201 );
  }
  </script>
<?php
}
add_action( 'admin_print_footer_scripts', 'appthemes_add_quicktags' );
?>



<?php
function tldrio_auto_embed() {
  return '<blockquote data-use-own-tldr="true" class="tldr-embed-widget">
    </blockquote><script async src="//tldr.io/embed/widget-embed.js" charset="utf-8"></script>';
}

function tldrio_embed_with_url($url, $show_title) {
  return '<blockquote data-url="' . $url . '" data-show-title="' . $show_title . '" class="tldr-embed-widget">
    </blockquote><script async src="//tldr.io/embed/widget-embed.js" charset="utf-8"></script>';
}

function tldrio_embed_with_id($tldr_id, $show_title) {
  return '<blockquote data-tldr-id="' . $tldr_id . '" data-show-title="' . $show_title . '" class="tldr-embed-widget">
    </blockquote><script async src="//tldr.io/embed/widget-embed.js" charset="utf-8"></script>';
}

function tldrio_embed( $atts ) {
  extract( shortcode_atts( array(
    'url' => '',
    'tldr_id' => '',
    'show_title' => 'true',
  ), $atts ) );

  if (strlen($tldr_id) != 0) {
    return tldrio_embed_with_id($tldr_id, $show_title);
  }

  if (strlen($url) != 0) {
    return tldrio_embed_with_url($url, $show_title);
  }

  // Default is a simple embed with url
  return tldrio_embed_with_url($atts[0], true);
}

add_shortcode( 'tldrio_embed', 'tldrio_embed' );
add_shortcode( 'tldrio_auto_embed', 'tldrio_auto_embed' );
?>
