<script type="text/javascript">
$(document).ready(function() {
    // Issue button click event
    $('.issue-btn').on('click', function() {
        var orderId = $(this).data('order-id');
        var row = $(this).closest('tr'); // Get the table row of the clicked button
        $.ajax({
            url: 'issueOrder.php',
            type: 'POST',
            data: { orderId: orderId },
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {
                    // Remove issued order from the table without reloading
                    row.remove();
                    alert(response.message);
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