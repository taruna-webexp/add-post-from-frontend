
<div class="container">
    <div class="row">
        <div class="display_all_post_outer">
        <?php 
            $display_layout= get_option('layout_display');
            if($display_layout=='layout1'){
                while ($Display_post->have_posts()) {
                    $Display_post->the_post();
                    $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
                    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                    echo '<div class="col-sm-4 imagetitledis">';
                    echo "<a href='" . get_permalink() . "'><img src='" . esc_url($post_thumbnail_url) . "' class='img-thumbnail'><strong>" . esc_html(get_the_title()) . "</strong></a>";
                    echo "<p>" . esc_html(get_the_content()) . "</p>";
                    echo "</div>";   

                }    
            };
            if ($display_layout == 'layout2') {
                while ($Display_post->have_posts()) {
                    $Display_post->the_post();
                    $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
                    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                    echo '<div class="col-sm-6 imagetitledis layout2">';
                    echo "<a href='" . get_permalink() . "'><img src='" . esc_url($post_thumbnail_url) . "' class='img-thumbnail'><strong>" . esc_html(get_the_title()) . "</strong></a>";
                    echo "<p>" . esc_html(get_the_content()) . "</p>";
                    echo "</div>";
                }
                wp_reset_postdata();
            }
            if ($display_layout == 'layout3') {
                while ($Display_post->have_posts()) {
                    $Display_post->the_post();
                    $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
                    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                    echo '<div class="col-sm-12 imagetitledis layout3">';
                    echo "<a href='" . get_permalink() . "'><img src='" . esc_url($post_thumbnail_url) . "' class='img-thumbnail'><p class='layout3_text'>" . esc_html(get_the_title()) . "</br>" . esc_html(get_the_content()) . "</p></a>";
                    echo "</div>";
                }
                wp_reset_postdata();
            }
       
        ?>
        </div>
    </div>
</div>