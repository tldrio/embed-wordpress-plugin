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
function tldrio_embed () {
  echo "Hello world";
}
?>


<?php
// add more buttons to the html editor
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
