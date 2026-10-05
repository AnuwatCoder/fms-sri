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

const formatFileSize = (bytes) => {
    if (bytes >= 1048576) {
        return `${Math.round((bytes / 1048576) * 10) / 10} MB`;
    }

    return `${Math.round((bytes / 1024) * 10) / 10} KB`;
};

const currentLocalDateTime = () => {
    const now = new Date();
    const localTime = new Date(now.getTime() - (now.getTimezoneOffset() * 60000));

    return localTime.toISOString().slice(0, 16);
};

const initializeDocumentForms = () => {
    document.querySelectorAll('[data-document-form]').forEach((form) => {
        if (form.dataset.documentFormInitialized === 'true') {
            return;
        }

        const fileInput = form.querySelector('[data-document-file]');
        const fileTypeInput = form.querySelector('[data-document-file-type]');
        const fileSizeInput = form.querySelector('[data-document-file-size]');
        const iconInput = form.querySelector('[data-document-icon]');
        const colorInput = form.querySelector('[data-document-color]');
        const publishedAtInput = form.querySelector('[data-document-published-at]');

        if (publishedAtInput?.hasAttribute('data-default-now') && ! publishedAtInput.value) {
            publishedAtInput.value = currentLocalDateTime();
        }

        if (! fileInput || ! fileTypeInput || ! fileSizeInput || ! iconInput || ! colorInput) {
            return;
        }

        const presentations = JSON.parse(form.dataset.filePresentations || '{}');

        fileInput.addEventListener('change', () => {
            const file = fileInput.files?.[0];

            if (! file) {
                return;
            }

            const extension = file.name.includes('.') ? file.name.split('.').pop().toLowerCase() : '';
            const presentation = presentations[extension] || {
                file_type: extension.toUpperCase(),
                icon: 'bi-file-earmark-text',
                color: 'blue',
            };

            fileTypeInput.value = presentation.file_type;
            fileSizeInput.value = formatFileSize(file.size);
            iconInput.value = presentation.icon;
            colorInput.value = presentation.color;
        });

        form.dataset.documentFormInitialized = 'true';
    });
};

document.addEventListener('DOMContentLoaded', initializeRichTextEditors);
document.addEventListener('livewire:navigated', initializeRichTextEditors);
document.addEventListener('DOMContentLoaded', initializeDocumentForms);
document.addEventListener('livewire:navigated', initializeDocumentForms);
