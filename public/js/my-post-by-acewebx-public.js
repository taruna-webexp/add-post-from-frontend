(function ($) {
    "use strict";

    // When the document is ready
    $(document).ready(function () {
        
        // Toggle form visibility on add post button click
        $("#addpost").on("click", function () {
            $("#form-container").toggle();
        });

        // Handle delete button click
        $('.delete_button').on("click", function () {
            var postId = this.getAttribute('data-post-id'); // Get the post ID from data attribute
            
            // Show confirmation dialog using SweetAlert
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to delete this post?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) { // If user confirms deletion
                    $.ajax({
                        url: ajax_object.ajax_url, // AJAX endpoint URL
                        type: 'POST', // HTTP method
                        data: {
                            action: 'delete_post', // Action to perform on server
                            post_id: postId, // Post ID to delete
                            security: ajax_object.nonce // Nonce for security
                        },
                        success: function (response) {
                            // Show success message using SweetAlert
                            Swal.fire({
                                title: "Success!",
                                text: "Post has been deleted successfully!",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(function () {
                                // Reload the page to reflect changes (alternative: refresh only the affected part)
                                location.reload();
                            });
                        },
                        error: function (response) {
                            // Show error message if there's an issue with AJAX request
                            Swal.fire({
                                title: "Error!",
                                text: "There was an error deleting the post.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    });
                }
            });
        });
    });

})(jQuery);
