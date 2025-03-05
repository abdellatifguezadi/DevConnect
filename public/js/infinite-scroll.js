document.addEventListener("DOMContentLoaded", function () {
    let currentPage = 1;
    let isLoading = false;
    let hasMorePages = true;
    const initializedElements = new Set();
    
    const postsContainer = document.getElementById('posts-container');
    const loadingIndicator = document.getElementById('loading-indicator');
    const noMorePosts = document.getElementById('no-more-posts');
    
    if (!postsContainer || !loadingIndicator || !noMorePosts) return;
s
    initializeExistingElements();
    
    function initializeExistingElements() {

        document.querySelectorAll('.like-button').forEach(button => {
            const postId = button.dataset.postId;
            initializedElements.add(`like-${postId}`);
        });

        document.querySelectorAll('.comment-form').forEach(form => {
            const postId = form.dataset.postId;
            initializedElements.add(`comment-form-${postId}`);
        });

        document.querySelectorAll('.comment').forEach(comment => {
            const commentId = comment.id?.replace('comment-', '');
            if (commentId) {
                initializedElements.add(`comment-${commentId}`);
            }
        });
    }
    
    function loadMorePosts() {
        if (isLoading || !hasMorePages) return;
        
        isLoading = true;
        loadingIndicator.classList.remove('hidden');
        
        fetch(`/load-more-posts?page=${currentPage + 1}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.html && data.html.trim() !== '') {

                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data.html;
                
                let addedPosts = 0;

                while (tempDiv.firstChild) {
                    postsContainer.appendChild(tempDiv.firstChild);
                    addedPosts++;
                }

                attachEventListenersToNewPosts();
                
                currentPage = data.currentPage;
            } else {
                hasMorePages = false;
            }
            
            hasMorePages = data.hasMorePages;
            
            if (!hasMorePages) {
                noMorePosts.classList.remove('hidden');
            }
        })
        .catch(() => {

            hasMorePages = false;
        })
        .finally(() => {
            isLoading = false;
            loadingIndicator.classList.add('hidden');
        });
    }
    
    function attachEventListenersToNewPosts() {

        const newLikeButtons = postsContainer.querySelectorAll('.like-button');
        newLikeButtons.forEach(button => {
            const postId = button.dataset.postId;
            const elementId = `like-${postId}`;

            if (!initializedElements.has(elementId)) {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    handleLike(button);
                });
                initializedElements.add(elementId);
            }
        });
        
        const newCommentForms = postsContainer.querySelectorAll('.comment-form');
        newCommentForms.forEach(form => {
            const postId = form.dataset.postId;
            const elementId = `comment-form-${postId}`;

            if (!initializedElements.has(elementId)) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    handleComment(form);
                });
                initializedElements.add(elementId);
            }
        });

        const newComments = postsContainer.querySelectorAll('.comment');
        newComments.forEach(comment => {
            const commentId = comment.id?.replace('comment-', '');
            if (commentId && !initializedElements.has(`comment-${commentId}`)) {
                attachCommentEvents(comment);
                initializedElements.add(`comment-${commentId}`);
            }
        });
    }

    function checkScroll() {
        if (isLoading || !hasMorePages) return;
        
        const scrollPosition = window.innerHeight + window.scrollY;
        const bodyHeight = document.body.offsetHeight;
        const scrollThreshold = bodyHeight - (window.innerHeight * 1.5);
        
        if (scrollPosition >= scrollThreshold) {
            loadMorePosts();
        }
    }

    window.addEventListener('scroll', checkScroll);

    setTimeout(checkScroll, 500);
    

    function handleLike(button) {
        if (typeof window.handleLike === 'function') {
            window.handleLike(button);
        } else {

            const postId = button.dataset.postId;
            fetch(`/posts/${postId}/toggle-like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const likeCount = button.querySelector(".like-count");
                    const likeIcon = button.querySelector("svg");
                    
                    if (likeCount) likeCount.textContent = data.likes_count;
                    
                    if (likeIcon) {
                        likeIcon.classList.toggle('text-blue-500', data.isLiked);
                        likeIcon.setAttribute('fill', data.isLiked ? 'currentColor' : 'none');
                    }
                }
            });
        }
    }
    
    function handleComment(form) {
        if (typeof window.handleComment === 'function') {
            window.handleComment(form);
        } else {

            const postId = form.dataset.postId;
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const commentsList = document.querySelector(`#comments-${postId} .comments-list`);
                    if (commentsList) {
                        commentsList.insertAdjacentHTML('afterbegin', data.html);
                        form.reset();
                        
                        const commentCount = document.querySelector(`.comment-count[data-post-id="${postId}"]`);
                        if (commentCount) {
                            commentCount.textContent = parseInt(commentCount.textContent || '0') + 1;
                        }

                        const newComment = commentsList.firstElementChild;
                        if (newComment) {
                            const commentId = newComment.id?.replace('comment-', '');
                            if (commentId && !initializedElements.has(`comment-${commentId}`)) {
                                attachCommentEvents(newComment);
                                initializedElements.add(`comment-${commentId}`);
                            }
                        }
                    }
                }
            });
        }
    }
    
    function attachCommentEvents(commentElement) {
        if (!commentElement) return;
        
        const commentId = commentElement.id?.replace('comment-', '');
        if (!commentId) return;
        
        const editForm = commentElement.querySelector('.edit-comment-form');
        if (editForm && !initializedElements.has(`edit-form-${commentId}`)) {
            editForm.addEventListener('submit', (e) => {
                e.preventDefault();
                e.stopPropagation();
                handleEditComment(editForm);
            });
            initializedElements.add(`edit-form-${commentId}`);
        }
        
        const deleteButton = commentElement.querySelector('.delete-comment');
        if (deleteButton && !initializedElements.has(`delete-button-${commentId}`)) {
            deleteButton.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                handleDeleteComment(deleteButton);
            });
            initializedElements.add(`delete-button-${commentId}`);
        }
    }

    function handleEditComment(form) {
        if (typeof window.handleEditComment === 'function') {
            window.handleEditComment(form);
        }
    }
    
    function handleDeleteComment(button) {
        if (typeof window.handleDeleteComment === 'function') {
            window.handleDeleteComment(button);
        }
    }
}); 