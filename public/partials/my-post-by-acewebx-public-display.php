<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://https://wordpress.web-xperts.xyz
 * @since      1.0.0
 *
 * @package    my-post_by_acewebx
 * @subpackage my-post_by_acewebx/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="container">
    <div class="form-group">
        <div class="row post-item">
            <?php
            // Loop through each post in $user_posts
            while ($user_posts->have_posts()) {
    
                $user_posts->the_post();
                $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
                $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                echo' <div class="col-sm-4 imagetitledis">';
                echo "<a href='" . get_permalink() . "'><img src='" . esc_url($post_thumbnail_url) . "' class='img-thumbnail'><strong>" . esc_html(get_the_title()) . "</strong></a>";
                echo "<p>" . esc_html(get_the_content()) . "</p>";
                // Delete button with post ID as data attribute
                echo "<div class='post_button_outer' data-post-id='" . get_the_ID() . "'><a class='view_button' href='" . get_permalink() . "'>View</a><a href='javascript:void(0)' data-post-id='" . get_the_ID() . "' class='delete_button'>Delete</a></div>";
                echo "</div>";
            }
            // Pagination section
            echo '<div class="pagination">';
            echo paginate_links(array(
                'total' => $user_posts->max_num_pages,
                'current' => max(1, get_query_var('paged')),
                'prev_text' => __('« Previous'),
                'next_text' => __('Next »'),
                'type' => 'list',
                'prev_next' => true,
                'prev_next' => false, // Pagination settings
                'end_size' => 1,
                'mid_size' => 2,
            ));
            echo '</div>';
            ?>
        </div>
    </div>
</div>
<!-- Hidden inputs for admin API key and URL -->
<input type="hidden" name="adminapikey" id="adminapikey" value="<?=  $apikey ?>">
<input type="hidden" name="url" id="url" value="<?=  $url ?>">
<nav class="userpost_navbar navbar-expand-lg navbar-light bg-light navbar-custom" >
    <div class="collapse navbar-collapse container" id="navbarSupportedContent">
        <button id="addpost" class=" btn btn-primary">Add post</button>
   
<div id="form-container" style="display:none;">
    <div class="custom-form-container">
        <form id="custom-form" method="POST" enctype="multipart/form-data">
            <h2>Add Post</h2>
            <div class="form-outline mb-4">
                <!-- Title input field -->
                <input type="text" id="form2Example1" class="form-control" placeholder="Enter title" name="post_title" required />
            </div>
            <div class="form-outline mb-4">
                <!-- Content textarea -->
                <textarea class="form-control" id="Content" rows="4" placeholder="Content" name="content"></textarea>
                <div>
                    <!-- Additional content -->
                </div>
            </div>
            <div class="form-outline mb-4">
                    <?php $categories = get_categories(array(
                        'post_type' => 'post',
                        'hide_empty' => false
                        ));
                    if ($categories) {
                        foreach ($categories as $category) {
                        echo '<input type="checkbox" name="categories[]" value="' . esc_attr($category->term_id) . '"> ' . esc_html($category->name) . '<br>';
                        }
                    }?>
            </div>
            <div class="input-group mb-4">
                <!-- File input -->
                <input type="file" class="form-control d-none" id="inputGroupFile02" name="featureimage" accept="image/*">
                <label class="input-group-text form-control custom-file-label" for="inputGroupFile02">
                    <!-- File upload icon -->
                    <img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/upload-file-outline-icon-design-260nw-1666246474.png'; ?>" alt="Upload Icon"/>
                    Choose file
                </label>
            </div>
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4" name="submit">Submit</button>
        </form>
    </div>
</div>
</div>
</nav>

<?php

if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    // Handle form submission
    if (isset($_POST['submit'])) {
        $post_title = sanitize_text_field($_POST['post_title']);
        $post_content = wp_kses_post($_POST['content']);
        $feature_image = $_FILES['featureimage'];
        $categories = isset($_POST['categories']) ? array_map('intval', $_POST['categories']) : array();
        
        $existing_post = get_page_by_title($post_title, OBJECT, 'post');
        
        if (!$existing_post) { // If post doesn't exist, create a new one
            $upload_dir = wp_upload_dir();
            $image_file = $upload_dir['path'] . '/' . basename($feature_image['name']);
            move_uploaded_file($feature_image['tmp_name'], $image_file);
            
            // Insert image attachment
            $attachment = array(
                'post_mime_type' => $feature_image['type'],
                'post_title' => sanitize_file_name($feature_image['name']),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attach_id = wp_insert_attachment($attachment, $image_file);
            
            // Insert new post
            $new_post = array(
                'post_title' => $post_title,
                'post_content' => $post_content,
                'post_status' => 'publish',
                'post_author' => $current_user->ID,
                'post_type' => 'post',
                '_thumbnail_id' => $attach_id,
            );
            $post_id = wp_insert_post($new_post);
            if (!empty($categories)) {
                wp_set_post_categories($post_id, $categories);
            }
            if ($post_id) {
                
                // Display success message using SweetAlert
                echo '<script>
                    Swal.fire({
                        title: "Success!",
                        text: "Post has been added successfully!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = window.location.href; // Refresh the page
                    });
                </script>';
            } else {
                // Handle the case where post insertion failed
                echo '<script>
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to add the post.",
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = window.location.href; // Refresh the page
                    });
                </script>';
            }
        } else {
            // Handle the case where a post with the same title already exists
            echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "A post with the same title already exists.",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location.href = window.location.href; // Refresh the page
                });
            </script>';
        }
    }
    return;
};
?>