document.addEventListener("DOMContentLoaded", function () {
    const textareas = document.querySelectorAll('.auto-expand-textarea');

    textareas.forEach(textarea => {
        const charCount = textarea.nextElementSibling;

        function autoResize() {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';

            const remaining = textarea.value.length;
            charCount.textContent = `${remaining}/500`;

            if (remaining > 400) {
                charCount.classList.add('warn');
            } else {
                charCount.classList.remove('warn');
            }

            if (textarea.scrollHeight > 300) {
                textarea.style.overflowY = 'auto';
            } else {
                textarea.style.overflowY = 'hidden';
            }
        }

        textarea.addEventListener('input', autoResize);
        textarea.addEventListener('focus', autoResize);
        autoResize();
    });
});
