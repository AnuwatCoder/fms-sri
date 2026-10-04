import './bootstrap';
import 'bootstrap';
import '../css/app.css';

let pageProgress = 0;
let pageProgressTimer;

const getPageProgress = () => document.querySelector('[data-page-progress]');

const renderPageProgress = (value) => {
    const progressElement = getPageProgress();

    if (! progressElement) {
        return;
    }

    pageProgress = Math.min(value, 1);
    progressElement.style.transform = `scaleX(${pageProgress})`;
    progressElement.setAttribute('aria-valuenow', Math.round(pageProgress * 100));
};

const startPageProgress = () => {
    const progressElement = getPageProgress();

    if (! progressElement || progressElement.classList.contains('is-loading')) {
        return;
    }

    window.clearInterval(pageProgressTimer);
    progressElement.classList.remove('is-complete');
    progressElement.classList.add('is-loading');
    progressElement.setAttribute('aria-hidden', 'false');
    renderPageProgress(.08);

    pageProgressTimer = window.setInterval(() => {
        const remaining = .92 - pageProgress;

        if (remaining > 0) {
            renderPageProgress(pageProgress + Math.max(remaining * .12, .01));
        }
    }, 180);
};

const finishPageProgress = () => {
    const progressElement = getPageProgress();

    if (! progressElement?.classList.contains('is-loading')) {
        return;
    }

    window.clearInterval(pageProgressTimer);
    renderPageProgress(1);
    progressElement.classList.add('is-complete');

    window.setTimeout(() => {
        progressElement.classList.remove('is-loading', 'is-complete');
        progressElement.setAttribute('aria-hidden', 'true');
        renderPageProgress(0);
    }, 360);
};

document.addEventListener('livewire:navigate', startPageProgress);
document.addEventListener('livewire:navigated', finishPageProgress);
window.addEventListener('beforeunload', startPageProgress);

document.addEventListener('click', (event) => {
    const searchButton = event.target.closest('[data-focus-search]');

    if (! searchButton) {
        return;
    }

    const searchInput = document.querySelector('[data-system-search]');

    if (searchInput) {
        searchInput.focus({ preventScroll: false });

        return;
    }

    window.location.href = searchButton.dataset.searchUrl;
});

const initializeRichTextEditors = () => {
    document.querySelectorAll('[data-rich-text]').forEach((container) => {
        if (container.dataset.initialized === 'true') {
            return;
        }

        const editor = container.querySelector('[data-rich-editor]');
        const input = container.querySelector('[data-rich-input]');

        if (! editor || ! input) {
            return;
        }

        const syncInput = () => {
            input.value = editor.innerHTML;
        };

        const updateToolbar = () => {
            container.querySelectorAll('[data-rich-command]').forEach((button) => {
                button.classList.toggle('is-active', document.queryCommandState(button.dataset.richCommand));
            });
        };

        container.querySelectorAll('[data-rich-command]').forEach((button) => {
            button.addEventListener('mousedown', (event) => event.preventDefault());
            button.addEventListener('click', () => {
                editor.focus();
                document.execCommand(button.dataset.richCommand, false);
                syncInput();
                updateToolbar();
            });
        });

        editor.addEventListener('input', syncInput);
        editor.addEventListener('keyup', updateToolbar);
        editor.addEventListener('mouseup', updateToolbar);
        editor.addEventListener('paste', (event) => {
            event.preventDefault();
            document.execCommand('insertText', false, event.clipboardData.getData('text/plain'));
        });
        editor.closest('form')?.addEventListener('submit', syncInput);

        container.dataset.initialized = 'true';
        syncInput();
    });
};

document.addEventListener('DOMContentLoaded', initializeRichTextEditors);
document.addEventListener('livewire:navigated', initializeRichTextEditors);
