$(document).ready(function() {
    $('.issue-btn').on('click', function() {
        var orderId = $(this).data('order-id');
        $.ajax({
            url: 'php_action/issueOrder.php', // Ensure this path is correct
            type: 'POST',
            data: { orderId: orderId },
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error: ' + status + ' - ' + error);
                alert('An error occurred while issuing the order. Please try again.');
            }
        });
    });
});