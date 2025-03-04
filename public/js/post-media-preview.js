/**
 * Post Media Preview JavaScript
 * Handles image and video preview functionality for post creation/editing
 */

document.addEventListener('DOMContentLoaded', function() {
    // Images preview
    setupMediaPreview('media', 'media-preview', 'image');
    
    // Videos preview
    const videoInput = document.querySelector('input[name="videos[]"]');
    if (videoInput) {
        videoInput.id = 'videos';
        setupMediaPreview('videos', 'video-preview', 'video');
    }
    
    function setupMediaPreview(inputId, previewId, mediaType) {
        const mediaInput = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewId);
        
        // Only proceed if both elements exist on the page
        if (mediaInput && previewContainer) {
            console.log(`Setting up ${mediaType} preview for #${inputId} -> #${previewId}`);
            
            // Listen for file selection
            mediaInput.addEventListener('change', function() {
                // Clear previous previews
                previewContainer.innerHTML = '';
                
                // Check if files were selected
                if (this.files && this.files.length > 0) {
                    // Show the preview container
                    previewContainer.classList.remove('hidden');
                    
                    // Loop through each file and create a preview
                    Array.from(this.files).forEach(file => {
                        const isImage = file.type.startsWith('image/');
                        const isVideo = file.type.startsWith('video/');
                        
                        if ((mediaType === 'image' && isImage) || (mediaType === 'video' && isVideo)) {
                            const preview = document.createElement('div');
                            preview.className = 'relative';
                            
                            if (isImage) {
                                // Create image preview
                                const reader = new FileReader();
                                
                                reader.onload = function(e) {
                                    const img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.className = 'h-32 w-auto rounded-lg object-cover';
                                    preview.appendChild(img);
                                    
                                    // Add remove button
                                    addRemoveButton(preview, previewContainer, mediaInput);
                                    
                                    previewContainer.appendChild(preview);
                                };
                                
                                reader.readAsDataURL(file);
                            } else if (isVideo) {
                                // Create video preview
                                const video = document.createElement('video');
                                video.controls = true;
                                video.className = 'h-32 w-auto rounded-lg';
                                
                                const source = document.createElement('source');
                                source.src = URL.createObjectURL(file);
                                source.type = file.type;
                                
                                video.appendChild(source);
                                preview.appendChild(video);
                                
                                // Add remove button
                                addRemoveButton(preview, previewContainer, mediaInput);
                                
                                previewContainer.appendChild(preview);
                            }
                        }
                    });
                } else {
                    // Hide the preview container if no files selected
                    previewContainer.classList.add('hidden');
                }
            });
        }
    }
    
    function addRemoveButton(preview, previewContainer, mediaInput) {
        // Add remove button
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full p-1';
        removeBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
        removeBtn.addEventListener('click', function() {
            preview.remove();
            // If no more previews, hide the container
            if (previewContainer.children.length === 0) {
                previewContainer.classList.add('hidden');
                // We can't reset the file input directly when it's a multi-file input
                // User will need to reselect all files if they want to change selection
            }
        });
        preview.appendChild(removeBtn);
    }
}); 