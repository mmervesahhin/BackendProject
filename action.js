
        function toggleNotifications() {
            var container = document.getElementById('notificationsContainer');
            if (container.style.display === 'block') {
                container.style.display = 'none';
            } else {
                container.style.display = 'block';
            }
        }


    document.addEventListener('DOMContentLoaded', function() {
        var acceptButtons = document.getElementsByClassName('accept-btn');

        for (var i = 0; i < acceptButtons.length; i++) {
            acceptButtons[i].addEventListener('click', handleAcceptButtonClick);
        }

        function handleAcceptButtonClick(event) {
            // Get the notification ID associated with the clicked button
            var notificationId = event.target.id;
            
            // Perform any further actions you want with the notification ID
            // For example, you can make an AJAX request to update the database
            
            // Output the notification ID to the console for testing
            console.log('Accept button clicked for notification ID:', notificationId);
        }
    });

