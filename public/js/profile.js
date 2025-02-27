function openEditProfile() {
    document.getElementById('editProfileModal').classList.remove('hidden');
}

function closeEditProfile() {
    document.getElementById('editProfileModal').classList.add('hidden');
}

function toggleComments(postId) {
    const commentsSection = document.getElementById(`comments-${postId}`);
    commentsSection.classList.toggle('hidden');
}

let currentPostId = null;

function openEditPost(postId, content) {
    currentPostId = postId;
    document.getElementById('editPostContent').value = content;
    document.getElementById('editPostForm').action = `/posts/${postId}`;
    document.getElementById('editPostModal').classList.remove('hidden');
}

function closeEditPost() {
    document.getElementById('editPostModal').classList.add('hidden');
    currentPostId = null;
}

window.onclick = function(event) {
    const editPostModal = document.getElementById('editPostModal');
    const editProfileModal = document.getElementById('editProfileModal');

    if (event.target == editPostModal) {
        closeEditPost();
    }
    if (event.target == editProfileModal) {
        closeEditProfile();
    }
}

function editReply(replyId, content) {
    document.getElementById(`reply-content-${replyId}`).classList.add('hidden');
    document.getElementById(`reply-edit-form-${replyId}`).classList.remove('hidden');
}

function cancelEditReply(replyId) {
    document.getElementById(`reply-content-${replyId}`).classList.remove('hidden');
    document.getElementById(`reply-edit-form-${replyId}`).classList.add('hidden');
}
