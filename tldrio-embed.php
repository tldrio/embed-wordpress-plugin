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
// add more buttons to the html editor
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

add_action( 'admin_print_footer_scripts', 'appthemes_add_quicktags' );
?>



<?php
function tldrio_embed_code($options, $content) {
  $display = ' style="display: none;"';

  if (strlen($content) > 0) {
    $display = '';
  }

  return '<blockquote ' . $options . ' class="tldr-embed-widget"' . $display . '>' . $content .
    '</blockquote><script async src="//tldr.io/embed/widget-embed.j" charset="utf-8"></script>';
}

function tldrio_auto_embed() {
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
