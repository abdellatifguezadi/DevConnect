
function toggleShareDropdown(postId) {
    const dropdown = document.getElementById(`share-dropdown-${postId}`);
    

    document.querySelectorAll('.dropdown-container div[id^="share-dropdown-"]').forEach(el => {
        if (el.id !== `share-dropdown-${postId}`) {
            el.classList.add('hidden');
        }
    });

    dropdown.classList.toggle('hidden');
}

document.addEventListener('click', function(event) {
    const target = event.target;

    if (target.closest('button[onclick^="toggleShareDropdown"]') || 
        target.closest('div[id^="share-dropdown-"]')) {
        return;
    }

    document.querySelectorAll('div[id^="share-dropdown-"]').forEach(dropdown => {
        dropdown.classList.add('hidden');
    });
});

window.toggleShareDropdown = toggleShareDropdown; 