document.addEventListener('DOMContentLoaded', () => {
    const player = new Plyr('#player', {
        controls: [
            'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'fullscreen',
            'pip', 'airplay'
        ],
        settings: ['quality', 'speed', 'loop'],
        tooltips: { controls: true, seek: true },
        captions: { active: true, update: true, language: 'en' },
        autoplay: false,
        clickToPlay: true,
        hideControls: false,
        ratio: '16:9',
        language: 'en',
        previewThumbnails: { enabled: true, src: 'thumbnails.jpg' },
        debug: false
    });

    
    const addCommentButton = document.getElementById('add-comment');
    const commentTextArea = document.getElementById('new-comment');

    addCommentButton?.addEventListener('click', () => {
        const commentText = commentTextArea?.value.trim();
        if (commentText) {
            addComment(commentText);
            commentTextArea.value = ''; // Clear textarea
        }
    });

    function addComment(text) {
        const commentsSection = document.getElementById('comments');
        const commentDiv = document.createElement('div');
        commentDiv.className = 'comment bg-white p-4 rounded-lg shadow-md mb-4';
        const username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Anonymous'; ?>";


        commentDiv.innerHTML = `
        <p class="text-gray-700 mt-1 font-semibold">You</p>
            <p class="text-gray-700 mt-1">${text}</p>
            <div class="comment-actions flex space-x-4 mt-2">
                <button class="text-blue-500 hover:text-blue-700 focus:outline-none like-comment flex items-center">
                    <i class="fas fa-thumbs-up text-sm"></i>
                    <span class="ml-1">Like</span>
                </button>
                <button class="text-blue-500 hover:text-blue-700 focus:outline-none reply-button flex items-center">
                    <i class="fas fa-reply text-sm"></i>
                    <span class="ml-1">Reply</span>
                </button>
            </div>
            <div class="reply-form mt-4 hidden">
                <textarea class="w-full p-2 border border-gray-300 rounded-md" placeholder="Write a reply..."></textarea>
                <button class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">Submit</button>
            </div>
        `;
        commentsSection.appendChild(commentDiv);
    }

    const commentsSection = document.getElementById('comments');

    commentsSection?.addEventListener('click', (event) => {
        const target = event.target.closest('button');
        if (!target) return;

        if (target.classList.contains('like-comment')) {
            handleLike(target);
        } else if (target.classList.contains('reply-button')) {
            toggleReplyForm(target);
        }
    });


    function toggleReplyForm(button) {
        const replyForm = button.closest('.comment').querySelector('.reply-form');
        replyForm.classList.toggle('hidden');

        if (!replyForm.classList.contains('hidden')) {
            replyForm.querySelector('textarea').focus();
        }
    }

    commentsSection?.addEventListener('click', (event) => {
        const target = event.target.closest('button');
        if (target && target.textContent.trim() === 'Submit') {
            const replyForm = target.closest('.reply-form');
            const replyText = replyForm.querySelector('textarea').value.trim();
            if (replyText) {
                addReply(replyForm.closest('.comment'), replyText);
                replyForm.querySelector('textarea').value = '';
                replyForm.classList.add('hidden'); 
            }
        }
    });

    function addReply(commentElement, text) {
        const replyDiv = document.createElement('div');
        replyDiv.className = 'reply bg-gray-100 p-3 rounded-lg shadow-sm mt-2';

        replyDiv.innerHTML = `
            <p class="font-semibold">You</p>
            <p class="text-gray-600 mt-1">${text}</p>
        `;

        commentElement.appendChild(replyDiv);
    }
});
