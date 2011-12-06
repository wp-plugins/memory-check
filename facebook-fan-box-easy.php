<?php
/*
Plugin Name: Facebook Fan and Like widget
Plugin URI:  
Description: Display Facebook Like widget as widget in your WordPress blog.
Author: podz
Version: 1.1
Author URI:  

Copyright 2011

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


add_action('widget_work', 'fan_box_in');


global $fan_box;
function fan_box_in() {
   $fan_box = new fb_fan_widget();
}


class fb_fan_widget {

   protected $_name = "Facebook Like widget";
   protected $_folder;
   protected $_path;
   protected $_width = 400;
   protected $_height = 300;
     protected $_facebook_fan_box_api = 'http://www.facebook.com/connect/connect.php';
   

   function __conuct() {
      $path = __FILE__;
      if (!$path) { $path = $_SERVER['PHP_SELF']; }
         $directory = dirname($path);
      $directory = str_replace('\\', '/', $directory);
      $directory = explode('/', $directory);
      $directory = end($directory);
      if (empty($directory) || !$directory)
         $directory = 'recent-gravatar';
      $this->_folder = $directory;
      $this->_path = '/wp-content/plugins/' . $this->_folder . '/';

      $this->bring();
   }
   

   function bring() {
      add_filter("plugin_action_links_$plugin", array(&$this, 'link'));
      load_plugin_textdomain($this->_folder, false, $this->_folder);      
      
      if (!function_exists('register_widget') || !function_exists('register_widget_control'))
         return;
      register_widget($this->_name, array(&$this, "widget"));
      register_widget_control($this->_name, array(&$this, "control"), $this->_width, $this->_height);
   }


   function validate_options(&$text_bring) {
      if (!is_array($text_bring)) {
         $text_bring = array(
            'width' => '350',
            'height' => '280',
            'profile_id' => '',
            'connections' => '10',
            'stream' => '',
            'header' => '',
            'locale' => '',
            'link_to_us' => 'checked');
      }
      

      if (intval($text_bring['width']) == 0) $text_bring['width'] = '280';
      if (intval($text_bring['height']) == 0) $text_bring['height'] = '250';
      if (intval($text_bring['connections']) == 0) $text_bring['connections'] = '10';
   }
   

   function widget($args) {
      extract($args);

      $text_bring = get_option($this->_folder);
      $this->validate_options($text_bring);
      

      echo '<iframe scrolling="no" frameborder="0" width="' . $text_bring['width']. '" height="' . $text_bring['height'] . '" src="' . $this->_facebook_fan_box_api . '?id=' . $text_bring['profile_id'] . '&amp;connections=' . $text_bring['connections'] . '&amp;stream=' . ($text_bring['stream'] == 'checked' ? 'true' : 'false') . '&amp;header=' . ($text_bring['header'] == 'checked' ? 'true' : 'false') . '&amp;locale=' . $text_bring['locale'] . '"></iframe>';
      if ($text_bring['link_to_us'] == 'checked') {
      echo '<div style="display: none;"><div class="wffb-link"><a href="' . $this->_link . '" target="_blank">'. __('Get this widget for your own blog free!', $this->_folder) . '</a></div></div>';
      }
   }


   function control() {
      $text_bring = get_option($this->_folder);
      $this->validate_options($text_bring);
      if ($_POST[$this->_folder . '-submit']) {
         $text_bring['width'] = htmlspecialchars(stripslashes($_POST[$this->_folder . '-width']));
         $text_bring['height'] = htmlspecialchars($_POST[$this->_folder . '-height']);
         $text_bring['profile_id'] = htmlspecialchars(stripslashes($_POST[$this->_folder . '-profile_id']));
         $text_bring['connections'] = htmlspecialchars(stripslashes($_POST[$this->_folder . '-connections']));
         $text_bring['stream'] = htmlspecialchars(stripslashes($_POST[$this->_folder . '-stream']));
         $text_bring['header'] = htmlspecialchars($_POST[$this->_folder . '-header']);
         $text_bring['locale'] = htmlspecialchars(stripslashes($_POST[$this->_folder . '-locale']));

         update_option($this->_folder, $text_bring);
      }
?>
      <p>
         <label for="<?php echo($this->_folder) ?>-width"><?php _e('Width: ', $this->_folder); ?></label>
         <input type="text" id="<?php echo($this->_folder) ?>-width" name="<?php echo($this->_folder) ?>-width" value="<?php echo $text_bring['width']; ?>" size="2"></input> (<a href="<?php echo $this->_link?>#width" target="_blank">?</a>)
      </p>
      <p>
         <label for="<?php echo($this->_folder) ?>-title"><?php _e('Height: ', $this->_folder); ?></label>
         <input type="text" id="<?php echo($this->_folder) ?>-height" name="<?php echo($this->_folder) ?>-height" value="<?php echo $text_bring['height']; ?>" size="2"></input> (<a href="<?php echo $this->_link?>#height" target="_blank">?</a>)
      </p>
      <p>
         <label for="<?php echo($this->_folder) ?>-title"><?php _e('Profile Id: ', $this->_folder); ?></label>
         <input type="text" id="<?php echo($this->_folder) ?>-profile_id" name="<?php echo($this->_folder) ?>-profile_id" value="<?php echo $text_bring['profile_id']; ?>" size="20"></input> (<a href="<?php echo $this->_link?>#profile-id" target="_blank">?</a>)
      </p>
      <p>
         <label for="<?php echo($this->_folder) ?>-connections"><?php _e('Connections: ', $this->_folder); ?></label>
         <input type="text" id="<?php echo($this->_folder) ?>-connections" name="<?php echo($this->_folder) ?>-connections" value="<?php echo $text_bring['connections']; ?>" size="2"></input> (<a href="<?php echo $this->_link?>#connections" target="_blank">?</a>)
      </p>
      <p>
          <input type="checkbox" id="<?php echo($this->_folder) ?>-stream" name="<?php echo($this->_folder) ?>-stream" value="checked" <?php echo $text_bring['stream'];?> /> <?php _e('Stream', $this->_folder) ?> (<a href="<?php echo $this->_link?>#stream" target="_blank">?</a>)       
      </p>
      <p>
          <input type="checkbox" id="<?php echo($this->_folder) ?>-stream" name="<?php echo($this->_folder) ?>-header" value="checked" <?php echo $text_bring['header'];?> /> <?php _e('Header', $this->_folder) ?> (<a href="<?php echo $this->_link?>#wg-header" target="_blank">?</a>)
      </p>


      <input type="hidden" id="<?php echo($this->_folder) ?>-submit" name="<?php echo($this->_folder) ?>-submit" value="1" />
<?php
   }




}
