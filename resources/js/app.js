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
