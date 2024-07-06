<script type="text/javascript">
$(document).ready(function() {
    // Issue button click event
    $('.issue-btn').on('click', function() {
        var orderId = $(this).data('order-id');
        $.ajax({
            url: 'issueOrder.php',
            type: 'POST',
            data: { orderId: orderId },
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {
                    // Remove issued order from the table
                    alert(response.message);
                    location.reload(); // Refresh the page to reflect changes
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle the error case
                console.error('AJAX error: ' + status + ' - ' + error);
                alert('An error occurred while issuing the order. Please try again.');
            }
        });
    });
});
</script>
