document.addEventListener('DOMContentLoaded', function() {
    window.toggleEditComment = function(commentId) {
        const isReply = commentId.startsWith('reply-');
        const actualId = isReply ? commentId.replace('reply-', '') : commentId;
        const editFormId = isReply ? `#edit-reply-${actualId}` : `#edit-comment-${actualId}`;
        const contentId = isReply ? `#reply-${actualId}-content` : `#comment-${actualId}-content`;
        
        const editForm = document.querySelector(editFormId);
        const content = document.querySelector(contentId);
        
        if (editForm && content) {
            const isFormVisible = editForm.style.display === 'block';
            editForm.style.display = isFormVisible ? 'none' : 'block';
            content.style.display = isFormVisible ? 'block' : 'none';
            
            if (!isFormVisible) {
                const textarea = editForm.querySelector('textarea');
                if (textarea) {
                    textarea.focus();
                }
            }
        }
    };

    window.toggleReplyInput = function(commentId) {
        const replyForm = document.querySelector(`#reply-input-${commentId}`);
        
        if (replyForm) {
            const isVisible = replyForm.style.display === 'block';
            document.querySelectorAll('[id^="reply-input-"]').forEach(form => {
                form.style.display = 'none';
            });
            replyForm.style.display = isVisible ? 'none' : 'block';
            
            if (!isVisible) {
                const textarea = replyForm.querySelector('textarea');
                if (textarea) {
                    textarea.focus();
                }
            }
        }
    };
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const likeButtons = document.querySelectorAll('.like-button');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const url = `/posts/${postId}/toggle-like`;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const likeCount = this.querySelector('.like-count');
                    if (likeCount) {
                        likeCount.textContent = data.likes_count;
                    }
                    
                    const likeIcon = this.querySelector('svg');
                    if (likeIcon) {
                        if (data.isLiked) {
                            likeIcon.classList.add('text-blue-500');
                            likeIcon.setAttribute('fill', 'currentColor');
                        } else {
                            likeIcon.classList.remove('text-blue-500');
                            likeIcon.setAttribute('fill', 'none');
                        }
                    }
                }
            });
        });
    });

    const commentForms = document.querySelectorAll('.comment-form');
    
    commentForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new TypeError("La réponse n'est pas du JSON!");
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const commentsList = document.querySelector(`#comments-${postId} .comments-list`);
                    if (commentsList) {
                        commentsList.insertAdjacentHTML('beforeend', data.html);
                        this.reset();
                        updateCommentCounts(postId);
                    }
                }
            });
        });
    });

    document.querySelectorAll('.reply-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const commentId = this.dataset.commentId;
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const repliesList = document.querySelector(`#comment-${commentId} .replies-list`);
                    repliesList.insertAdjacentHTML('beforeend', data.html);
                    this.reset();
                    this.closest('.reply-input').style.display = 'none';
                    updateCommentCounts(this.closest('.comment').dataset.postId);
                }
            });
        });
    });

    document.querySelectorAll('.edit-comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const commentId = this.dataset.commentId;
            const formData = new FormData(this);
            const isReply = this.closest('[id^="reply-"]') !== null;
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const contentId = isReply ? `reply-${commentId}-content` : `comment-${commentId}-content`;
                    const formId = isReply ? `edit-reply-${commentId}` : `edit-comment-${commentId}`;
                    
                    const contentElement = document.querySelector(`#${contentId}`);
                    const formElement = document.querySelector(`#${formId}`);
                    
                    if (contentElement) {
                        contentElement.textContent = formData.get('content');
                        contentElement.style.display = 'block';
                    }
                    
                    if (formElement) {
                        formElement.style.display = 'none';
                    }
                }
            });
        });
    });

    document.querySelectorAll('.delete-comment').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (!confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
                return;
            }
            
            const commentId = this.dataset.commentId;
            const postId = this.dataset.postId;
            const url = this.dataset.url;
            const isReply = this.closest('[id^="reply-"]') !== null;
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const elementToRemove = isReply 
                        ? document.querySelector(`#reply-${commentId}`)
                        : document.querySelector(`#comment-${commentId}`);
                    
                    if (elementToRemove) {
                        elementToRemove.remove();
                        if (!isReply) {
                            updateCommentCounts(postId, false);
                        }
                    }
                }
            });
        });
    });

    function updateCommentCounts(postId, increment = true) {
        const commentCounters = document.querySelectorAll(`.comment-count[data-post-id="${postId}"]`);
        
        commentCounters.forEach(counter => {
            const currentCount = parseInt(counter.textContent || '0');
            counter.textContent = Math.max(0, currentCount + (increment ? 1 : -1));
        });
    }
}); 