<?php
/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wordpress.web-xperts.xyz
 * @since      1.0.0
 *
 * @package    my-post_by_acewebx
 * @subpackage my-post_by_acewebx/admin/partials
 */

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   if (isset($_POST['post_display'])) {
        $categories = isset($_POST['categories']) ? array_map('intval', $_POST['categories']) : array();
       update_option('post_display_no', sanitize_text_field($_POST['post_display']));
       update_option('layout_display', sanitize_text_field($_POST['layout_no']));
       update_option('post_category', serialize($categories));  
   }
}

$number = get_option('post_display_no');
$display_layout = get_option('layout_display');
$serialized_categories = get_option('post_category');
if($serialized_categories){
$categories_id = unserialize($serialized_categories);
}else{
    $categories_id =array();
}

?>
<!-- <div class="my-post_wrap">
   <div class="my-post_setting-title-bar">
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-6">
               <div class="user_post left-side-content">
                   Display an image for the settings page 
                  <img src="<?php //echo plugin_dir_url(dirname(__FILE__)).'/assets/image/settings(1).png'; ?>" alt="">
                  <h1>Post Settings</h1>
               </div>
            </div>
            <div class="col-sm-6">
             
            </div>
         </div>
      </div>
   </div> -->
   <div class="container-fluid">
    <div class="user-post-tab-container">
        <!-- Tab buttons for Google and Facebook -->
        <button class="user-post-tab" id="General_setting" onclick="openTab(event, 'General')">General</button>
        <button class="user-post-tab" id="layout_setting" onclick="openTab(event, 'layout')">layout</button>
    </div>
   
   <form method="post" action="">
   <div id="General" class="user-post-tab-content"> 
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="currentuserpost">Add Post Shortcode:</label>
                </th>
                <td class="display">
                    <p>[currentuserpost]</p>
                    <button type="button" class="shortcode-copy-btn" data-shortcode="[currentuserpost]">Copy</button>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="Customer_post">Display All Post Shortcode:</label>
                </th>
                <td class="display">
                    <p>[Customer_post]</p>
                    <button type="button" class="shortcode-copy-btn" data-shortcode="[Customer_post]">Copy</button>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="post_display">Post Display:</label>
                </th>
                <td>
                    <?php 
                        $count_posts = wp_count_posts('post');
                        $total_posts = $count_posts->publish;
                    ?>
                    <select name="post_display" id="post_display">
                        <option value="-1" <?= $number == -1 ? 'selected' : '' ?>>All</option>
                        <?php 
                            // Create options for each number up to the total number of posts
                            for ($i = 1; $i <= $total_posts; $i++) { 
                        ?>
                            <option value="<?= $i ?>" <?= $number == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php } 
                        ?>
                    </select>

                </td>
            </tr>
            <tr>
                <td scope="row">
                <label class="post_display_category"for="post_display_category">Post Display category:</label>
                </td>
            <td>
                <?php 
                $categories = get_categories(array(
                    'post_type' => 'post',
                    'hide_empty' => false
                ));

                if ($categories) {
                   
                    foreach ($categories as $category) {
                  
               $checked = in_array($category->term_id, $categories_id) ? 'checked' : '';
                        echo '<input type="checkbox" name="categories[]" value="' . esc_attr($category->term_id) . '" ' . $checked . '> ' . esc_html($category->name) . '<br>';
                    }
                    
                }
                ?>
                
                </td>
            </tr>
        </table>
        </div>
        <div id="layout" class="user-post-tab-content"> 
            <div class="container">
                <div class="row">
                    <?php 
                    $image_src= array(
                        plugin_dir_url(dirname(__FILE__)).'assets/image/layout.png',
                        plugin_dir_url(dirname(__FILE__)).'assets/image/layout2.png',
                        plugin_dir_url(dirname(__FILE__)).'assets/image/layout3.png',
                    
                    );
                    $image_alt = array(
                        'layout1',
                        'layout2',
                        'layout3',
                    );

                    for ($i = 0; $i < count( $image_src); $i++) {
                       
                        ?>
                        <div class="col-sm-4">
                            <div class="layout-image-outer"data-value="<?php echo isset($image_alt[$i]) ? $image_alt[$i]: 'layout' . ($i + 1);?>">
                            <img class="layout-image" src="<?php echo $image_src[$i]; ?>" alt="<?php echo  $image_alt[$i]; ?>">
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
            <input type="text"class="layout_no"id="layout_no"name="layout_no"value="<?=$display_layout?>"hidden>
        </div>
        <?php submit_button('Save Settings'); ?>	
    </form>
</div>