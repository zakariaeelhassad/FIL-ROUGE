document.addEventListener('click', function(e) {
    if (!e.target.closest('.reaction-button') && !e.target.closest('.reaction-container')) {
        document.querySelectorAll('.reaction-container').forEach(container => {
            container.classList.add('hidden');
        });
    }
    
    if (e.target.closest('.reaction-button')) {
        const button = e.target.closest('.reaction-button');
        const container = button.closest('.relative').querySelector('.reaction-container');
        
        document.querySelectorAll('.reaction-container').forEach(otherContainer => {
            if (otherContainer !== container) {
                otherContainer.classList.add('hidden');
            }
        });
        
        container.classList.toggle('hidden');
    }
});

        document.querySelectorAll('.comment-button').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                const commentSection = document.getElementById('comment-section-' + postId);
                commentSection.classList.toggle('hidden');
            });
        });

        document.querySelectorAll('.reply-button').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const replyForm = document.getElementById('reply-form-' + commentId);
                replyForm.classList.toggle('hidden');
            });
        });


        document.body.addEventListener('clearCommentForm', function(event) {
            const input = document.querySelector('#comment-input-' + event.detail.postId);
            if (input) {
                input.value = '';
            }
        });
        

    document.addEventListener('htmx:afterRequest', function(event) {
        if (event.detail.target && event.detail.target.id === 'comments-container-{{ $post->id }}') {
            const input = document.querySelector('#comment-input-{{ $post->id }}');
            if (input) {
                input.value = '';  
            }
        }
    });

    document.addEventListener('htmx:afterRequest', function(event) {
        const replyInputs = document.querySelectorAll('[id^="reply-input-"]');
    
        replyInputs.forEach(input => {
            const commentId = input.id.replace('reply-input-', '');
            const repliesContainerId = 'replies-container-' + commentId;
    
            if (event.detail.target && event.detail.target.id === repliesContainerId) {
                input.value = '';
            }
        });
    });
    
    
    