// Pusher Notifications Setup
document.addEventListener('DOMContentLoaded', function() {
    Pusher.logToConsole = true;
    
    // Get the authenticated user ID from the meta tag
    var auth_user = document.querySelector('meta[name="user-id"]')?.getAttribute('content');

    var pusher = new Pusher(PUSHER_APP_KEY, {
        cluster: PUSHER_APP_CLUSTER,
        encrypted: true
    });

    var channel = pusher.subscribe('notification');
    
    // Listen for post notifications
    channel.bind('test.notification', function(data) {
        if (data.author && data.title) {
            toastr.info(
                `<div class="notification-content">
                    <i class="fas fa-user"></i> <span>${data.author}</span>
                    <i class="fas fa-book" style="margin-left: 20px;"></i> <span>${data.title}</span>
                </div>`,
                'New Post Notification', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 0,
                    extendedTimeOut: 0,
                    positionClass: 'toast-top-right',
                    enableHtml: true
                }
            );
        } else {
            console.error('Invalid data received:', data);
        }
    });

    // Listen for like notifications
    channel.bind('like.notification', function(data) {
        if (data.author && data.title) {
            if (auth_user && parseInt(auth_user) === parseInt(data.post_owner_id)) {
                toastr.info(
                    `<div class="notification-content">
                        <i class="fas fa-heart" style="color: red;"></i> 
                        <span>${data.author} a liké: ${data.title}</span>
                    </div>`,
                    'Like Notification', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000,
                        extendedTimeOut: 1000,
                        positionClass: 'toast-top-center',
                        enableHtml: true
                    }
                );
            }
        } 
    });

    // Listen for comment notifications
    channel.bind('comment.notification', function(data) {
        if (data.state && data.author && data.content) {
            if (auth_user && parseInt(auth_user) === parseInt(data.post_owner_id)) {
                toastr.info(
                    `<div class="notification-content">
                        <i class="fas fa-comment" style="color: blue;"></i> 
                        <span>${data.author}: ${data.content}</span>
                    </div>`,
                    'New Comment on your post', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000,
                        extendedTimeOut: 1000,
                        positionClass: 'toast-top-right',
                        enableHtml: true
                    }
                );
            }
        }
    });

    pusher.connection.bind('connected', function() {
        console.log('Pusher connected');
    });
}); 