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
        console.log('Notification test reçue via Pusher:', data);
        if (data.author && data.title) {
            // Afficher un toast
            // toastr.info(
            //     `<div class="notification-content">
            //         <i class="fas fa-user"></i> <span>${data.author}</span>
            //         <i class="fas fa-book" style="margin-left: 20px;"></i> <span>${data.title}</span>
            //     </div>`,
            //     'Notification en temps réel', {
            //         closeButton: true,
            //         progressBar: true,
            //         timeOut: 5000,
            //         extendedTimeOut: 1000,
            //         positionClass: 'toast-top-right',
            //         enableHtml: true
            //     }
            // );
            
            // Envoyer l'événement pour afficher dans la barre de navigation
            document.dispatchEvent(new CustomEvent('notification.received', { 
                detail: { type: 'post', data: data } 
            }));
        } else {
            console.error('Invalid data received from Pusher:', data);
        }
    });

    // Listen for like notifications
    channel.bind('like.notification', function(data) {
        console.log('Notification like reçue via Pusher:', data);
        if (data.author && data.title) {
            if (auth_user && parseInt(auth_user) === parseInt(data.post_owner_id)) {
                // toastr.info(
                //     `<div class="notification-content">
                //         <i class="fas fa-heart" style="color: red;"></i> 
                //         <span>${data.author} a liké: ${data.title}</span>
                //     </div>`,
                //     'Like Notification', {
                //         closeButton: true,
                //         progressBar: true,
                //         timeOut: 5000,
                //         extendedTimeOut: 1000,
                //         positionClass: 'toast-top-center',
                //         enableHtml: true
                //     }
                // );
                
                // Envoyer l'événement pour afficher dans la barre de navigation
                document.dispatchEvent(new CustomEvent('notification.received', { 
                    detail: { type: 'like', data: data } 
                }));
            }
        } 
    });

    // Listen for comment notifications
    channel.bind('comment.notification', function(data) {
        console.log('Notification comment reçue via Pusher:', data);
        if (data.state && data.author && data.content) {
            if (auth_user && parseInt(auth_user) === parseInt(data.post_owner_id)) {
                // toastr.info(
                //     `<div class="notification-content">
                //         <i class="fas fa-comment" style="color: blue;"></i> 
                //         <span>${data.author}: ${data.content}</span>
                //     </div>`,
                //     'New Comment on your post', {
                //         closeButton: true,
                //         progressBar: true,
                //         timeOut: 5000,
                //         extendedTimeOut: 1000,
                //         positionClass: 'toast-top-right',
                //         enableHtml: true
                //     }
                // );
                
                // Envoyer l'événement pour afficher dans la barre de navigation
                document.dispatchEvent(new CustomEvent('notification.received', { 
                    detail: { type: 'comment', data: data } 
                }));
            }
        }
    });

    pusher.connection.bind('connected', function() {
        console.log('Pusher connected - Notifications en temps réel activées');
    });
    
    // Ajouter un bouton de test dans la console pour déboguer
    // console.log('Pour tester les notifications, exécutez dans la console: testNotification()');
    // window.testNotification = function() {
    //     const testData = {
    //         author: 'Test Console',
    //         title: 'Test depuis la console',
    //         content: 'Notification de test depuis la console JavaScript',
    //         post_owner_id: auth_user,
    //         state: true
    //     };
        
    //     // Simuler une notification reçue
    //     document.dispatchEvent(new CustomEvent('notification.received', { 
    //         detail: { type: 'post', data: testData } 
    //     }));
        
    //     console.log('Notification de test envoyée depuis la console');
    // };
}); 