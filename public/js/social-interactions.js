document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
   

  
    async function fetchWithAuth(url, options = {}) {
        
        const defaultHeaders = {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };

        const response = await fetch(url, {
            ...options,
            headers: {
                ...defaultHeaders,
                ...options.headers
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return response.json();
    }

    async function handleLike(button) {
        try {
            const postId = button.dataset.postId;
            const data = await fetchWithAuth(`/posts/${postId}/toggle-like`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            });

            if (data.success) {
                const likeCount = button.querySelector('.like-count');
                const likeIcon = button.querySelector('svg');
                
                if (likeCount) likeCount.textContent = data.likes_count;
                
                if (likeIcon) {
                    likeIcon.classList.toggle('text-blue-500', data.isLiked);
                    likeIcon.setAttribute('fill', data.isLiked ? 'currentColor' : 'none');
                }
            }
        } catch (error) {
            alert('Une erreur est survenue lors du like');
        }
    }

    async function handleComment(form) {
        try {
            const postId = form.dataset.postId;
            const formData = new FormData(form);

            const data = await fetchWithAuth(form.action, {
                method: 'POST',
                body: formData
            });

            if (data.success) {
                const commentsList = document.querySelector(`#comments-${postId} .comments-list`);
                if (commentsList) {
                    commentsList.insertAdjacentHTML('beforeend', data.html);
                    form.reset();
                    
                    const commentCount = document.querySelector(`.comment-count[data-post-id="${postId}"]`);
                    if (commentCount) {
                        commentCount.textContent = parseInt(commentCount.textContent || '0') + 1;
                    }

                    attachCommentEvents(commentsList.lastElementChild);
                }
            }
        } catch (error) {
            alert('Une erreur est survenue lors de l\'ajout du commentaire');
        }
    }

    async function handleEditComment(form) {
        try {
            
            const commentId = form.dataset.commentId;
            const formData = new FormData(form);
         

            const data = await fetchWithAuth(form.action, {
                method: 'POST',
                body: formData
            });

          

            if (data.success) {
                
                const commentElement = document.querySelector(`#comment-${commentId}`);
                if (commentElement) {
                    
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data.html, 'text/html');
                    const newComment = doc.body.firstElementChild;
                   

                    commentElement.replaceWith(newComment);
                    

                    attachCommentEvents(newComment);
                    
                } 
            }
        } catch (error) {
           
            alert('Une erreur est survenue lors de la modification du commentaire');
        }
    }

    async function handleDeleteComment(button) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
            return;
        }

        try {
            const commentId = button.dataset.commentId;
            const postId = button.dataset.postId;

            const data = await fetchWithAuth(button.dataset.url, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' }
            });

            if (data.success) {
                const comment = document.querySelector(`#comment-${commentId}`);
                if (comment) {
                    comment.remove();
                    
                    const commentCount = document.querySelector(`.comment-count[data-post-id="${postId}"]`);
                    if (commentCount) {
                        commentCount.textContent = Math.max(0, parseInt(commentCount.textContent || '0') - 1);
                    }
                }
            }
        } catch (error) {
            alert('Une erreur est survenue lors de la suppression du commentaire');
        }
    }

    function attachCommentEvents(commentElement) {
        if (!commentElement) return;

        const editForm = commentElement.querySelector('.edit-comment-form');
        if (editForm) {
            editForm.addEventListener('submit', (e) => {
                e.preventDefault();
                handleEditComment(editForm);
            });
        }

        const deleteButton = commentElement.querySelector('.delete-comment');
        if (deleteButton) {
            deleteButton.addEventListener('click', (e) => {
                e.preventDefault();
                handleDeleteComment(deleteButton);
            });
        }
    }

    window.toggleEditComment = function(commentId) {
        const editForm = document.querySelector(`#edit-comment-${commentId}`);
        const content = document.querySelector(`#comment-${commentId}-content`);
        
        if (editForm && content) {
            const isFormVisible = editForm.style.display === 'block';
            editForm.style.display = isFormVisible ? 'none' : 'block';
            content.style.display = isFormVisible ? 'block' : 'none';
            
            if (!isFormVisible) {
                const textarea = editForm.querySelector('textarea');
                if (textarea) {
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = textarea.value.length;
                }
            }
        }
    };

    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            handleLike(button);
        });
    });

    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            handleComment(form);
        });
    });

    document.querySelectorAll('.comment').forEach(comment => {
        attachCommentEvents(comment);
    });
});
