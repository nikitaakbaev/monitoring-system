
import { initCreateUserForm } from './createUserAJAX.js';

document.addEventListener('DOMContentLoaded', () => {
    const containerSelector = 'main.container';
    const navbarCollapse = document.querySelector('.navbar-collapse');

    function closeNavbar() {
        if (navbarCollapse && navbarCollapse.classList.contains('show')) {
            const instance = bootstrap.Collapse.getInstance(navbarCollapse) || new bootstrap.Collapse(navbarCollapse, { toggle: false });
            instance.hide();
        }
    }

    async function loadPage(url, replaceState = false) {
        try {
            const res = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!res.ok) {
                window.location.href = url;
                return;
            }
            const text = await res.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(text, 'text/html');
            const newContent = doc.querySelector(containerSelector);
            const currentContent = document.querySelector(containerSelector);
            if (newContent && currentContent) {
                currentContent.innerHTML = newContent.innerHTML;
                initCreateUserForm();
                window.scrollTo(0, 0);
            }
            const newTitle = doc.querySelector('title');
            if (newTitle) {
                document.title = newTitle.innerText;
            }
            if (replaceState) {
                history.replaceState(null, '', url);
            } else {
                history.pushState(null, '', url);
            }
        } catch (e) {
            console.error(e);
            window.location.href = url;
        }
    }

    function handleLink(e) {
        const link = e.target.closest('a');
        if (!link || link.target === '_blank' || link.hasAttribute('download') || link.href.startsWith('mailto:') || link.href.startsWith('tel:')) {
            return;
        }
        if (link.origin === window.location.origin) {
            e.preventDefault();
            closeNavbar();
            loadPage(link.href);
        }
    }

    document.addEventListener('click', handleLink);
    document.addEventListener('touchstart', handleLink);

    window.addEventListener('popstate', () => {
        loadPage(location.href, true);
    });
});

