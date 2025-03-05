document.addEventListener("DOMContentLoaded", function () {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    window.initializedElements = window.initializedElements || new Set();

    async function fetchWithAuth(url, options = {}) {
        const defaultHeaders = {
            "X-CSRF-TOKEN": csrfToken,
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        };

        const response = await fetch(url, {
            ...options,
            headers: {
                ...defaultHeaders,
                ...options.headers,
            },
            credentials: "same-origin",
        });

        if (!response.ok) {
            return { success: false };
        }

        return response.json();
    }

    window.handleLike = async function(button) {
        if (button.dataset.processing === "true") {
            return;
        }
        
        button.dataset.processing = "true";
        
        const postId = button.dataset.postId;
        
        const data = await fetchWithAuth(`/posts/${postId}/toggle-like`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
        });

        if (data.success) {
            const likeCount = button.querySelector(".like-count");
            const likeIcon = button.querySelector("svg");

            if (likeCount) likeCount.textContent = data.likes_count;

            if (likeIcon) {
                likeIcon.classList.toggle("text-blue-500", data.isLiked);
                likeIcon.setAttribute(
                    "fill",
                    data.isLiked ? "currentColor" : "none"
                );
            }
        }
        
        setTimeout(() => {
            button.dataset.processing = "false";
        }, 300);
    };

    window.handleComment = async function(form) {
        if (form.dataset.processing === "true") {
            return;
        }
        
        form.dataset.processing = "true";
        
        const postId = form.dataset.postId;
        const formData = new FormData(form);

        const data = await fetchWithAuth(form.action, {
            method: "POST",
            body: formData,
        });

        if (data.success) {
            const commentsList = document.querySelector(
                `#comments-${postId} .comments-list`
            );
            if (commentsList) {
                commentsList.insertAdjacentHTML("afterbegin", data.html);
                form.reset();

                const commentCount = document.querySelector(
                    `button[data-post-id="${postId}"] .comment-count`
                );
                if (commentCount) {
                    commentCount.textContent =
                        parseInt(commentCount.textContent || "0") + 1;
                }

                const newComment = commentsList.firstElementChild;
                if (newComment) {
                    const commentId = newComment.id?.replace('comment-', '');
                    if (commentId) {
                        window.initializedElements.add(`comment-${commentId}`);
                        window.attachCommentEvents(newComment);
                    }
                }
            }
        }
        
        setTimeout(() => {
            form.dataset.processing = "false";
        }, 300);
    };

    window.handleEditComment = async function(form) {
        const commentId = form.dataset.commentId;
        const formData = new FormData(form);

        const data = await fetchWithAuth(form.action, {
            method: "POST",
            body: formData,
        });

        if (data.success) {
            const commentElement = document.querySelector(
                `#comment-${commentId}`
            );
            if (commentElement) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data.html, "text/html");
                const newComment = doc.body.firstElementChild;

                commentElement.replaceWith(newComment);

                window.attachCommentEvents(newComment);
            }
        }
    };

    window.handleDeleteComment = async function(button) {
        if (!confirm("Êtes-vous sûr de vouloir supprimer ce commentaire ?")) {
            return;
        }

        const commentId = button.dataset.commentId;
        const postId = button.dataset.postId;

        const data = await fetchWithAuth(button.dataset.url, {
            method: "DELETE",
            headers: { "Content-Type": "application/json" },
        });

        if (data.success) {
            const comment = document.querySelector(`#comment-${commentId}`);
            if (comment) {
                comment.remove();

                const commentCount = document.querySelector(
                    `.comment-count[data-post-id="${postId}"]`
                );
                if (commentCount) {
                    commentCount.textContent = Math.max(
                        0,
                        parseInt(commentCount.textContent || "0") - 1
                    );
                }
            }
        }
    };

    window.attachCommentEvents = function(commentElement) {
        if (!commentElement) return;

        const commentId = commentElement.id?.replace('comment-', '');
        if (!commentId) return;

        const editForm = commentElement.querySelector(".edit-comment-form");
        if (editForm) {
            editForm.addEventListener("submit", (e) => {
                e.preventDefault();
                window.handleEditComment(editForm);
            });
        }

        const deleteButton = commentElement.querySelector(".delete-comment");
        if (deleteButton) {
            deleteButton.addEventListener("click", (e) => {
                e.preventDefault();
                window.handleDeleteComment(deleteButton);
            });
        }
    };

    window.toggleEditComment = function (commentId) {
        const editForm = document.querySelector(`#edit-comment-${commentId}`);
        const content = document.querySelector(`#comment-${commentId}-content`);

        if (editForm && content) {
            const isFormVisible = editForm.style.display === "block";
            editForm.style.display = isFormVisible ? "none" : "block";
            content.style.display = isFormVisible ? "block" : "none";

            if (!isFormVisible) {
                const textarea = editForm.querySelector("textarea");
                if (textarea) {
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd =
                        textarea.value.length;
                }
            }
        }
    };

    document.querySelectorAll(".like-button").forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            window.handleLike(button);
        });
    });

    document.querySelectorAll(".comment-form").forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            window.handleComment(form);
        });
    });

    document.querySelectorAll(".comment").forEach((comment) => {
        window.attachCommentEvents(comment);
    });
});
