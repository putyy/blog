const message = (function () {
    function generateId() {
        return 'msg-' + Math.random().toString(36).substr(2, 9);
    }

    function createMessage(content, type, duration = 2000) {
        const id = generateId();
        const typeStyles = {
            info: 'bg-blue-100 border-blue-500 text-blue-700',
            success: 'bg-green-100 border-green-500 text-green-700',
            warning: 'bg-yellow-100 border-yellow-500 text-yellow-700',
            error: 'bg-red-100 border-red-500 text-red-700'
        };

        const container = document.getElementById('message-container');
        if (!container) return;

        const wrapper = document.createElement('div');
        wrapper.id = id;
        wrapper.className = `message flex items-center justify-between p-4 mb-2 border-l-4 rounded shadow-md transition-all duration-300 ${typeStyles[type]}`;
        wrapper.style.opacity = 0;
        wrapper.style.transform = 'translateY(-20px)';
        wrapper.style.transition = 'all 0.3s';

        const textSpan = document.createElement('span');
        textSpan.textContent = content;

        const button = document.createElement('button');
        button.className = 'close-btn text-gray-500 hover:text-gray-700 ml-4 focus:outline-none';
        button.innerHTML = `
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        `;

        wrapper.appendChild(textSpan);
        wrapper.appendChild(button);
        container.appendChild(wrapper);

        requestAnimationFrame(() => {
            wrapper.style.opacity = 1;
            wrapper.style.transform = 'translateY(0)';
        });

        if (duration > 0) {
            setTimeout(() => removeMessage(id), duration);
        }

        button.addEventListener('click', () => removeMessage(id));
    }

    function removeMessage(id) {
        const el = document.getElementById(id);
        if (el) {
            el.style.opacity = 0;
            el.style.transform = 'translateY(-20px)';
            el.addEventListener('transitionend', () => {
                if (el.parentNode) {
                    el.parentNode.removeChild(el);
                }
            }, { once: true });
        }
    }

    return {
        info: (content, duration) => createMessage(content, 'info', duration),
        success: (content, duration) => createMessage(content, 'success', duration),
        warning: (content, duration) => createMessage(content, 'warning', duration),
        error: (content, duration) => createMessage(content, 'error', duration)
    };
})();

document.addEventListener('DOMContentLoaded', function () {
    const messageContainer = document.createElement('div');
    messageContainer.id = 'message-container';
    messageContainer.className = 'fixed top-10 left-1/2 transform -translate-x-1/2 w-full max-w-md z-50';
    document.body.appendChild(messageContainer);
});
