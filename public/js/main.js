

//navbar scroll
window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar");
    if (!navbar) {
        return;
    }
    if (window.scrollY > 0) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});

// hero section
window.addEventListener('load', function () {
    const navbar = document.querySelector('.navbar');
    const heroSection = document.querySelector('.hero-section');

    if (!navbar || !heroSection) return;

    const navbarHeight = navbar.offsetHeight;
    heroSection.style.paddingTop = `${navbarHeight}px`;
});


// Active nav links: match current URL path to link href (Laravel routes)
document.addEventListener("DOMContentLoaded", function () {
    const currentPath = window.location.pathname.replace(/\/$/, "") || "/";
    const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

    navLinks.forEach(link => {
        if (link.classList.contains("active")) {
            return;
        }

        const href = link.getAttribute("href");
        if (!href || href === "#" || href.startsWith("javascript:")) {
            return;
        }

        let linkPath;
        try {
            const url = new URL(href, window.location.origin);
            linkPath = url.pathname.replace(/\/$/, "") || "/";
        } catch (e) {
            return;
        }

        if (linkPath === currentPath) {
            link.classList.add("active");
        }
    });
});

// heart btn — state via .is-liked class (colors in style.css)
document.addEventListener("DOMContentLoaded", function () {
    const heartButtons = document.querySelectorAll(".heart-btn");

    heartButtons.forEach(button => {
        const heartIcon = button.querySelector("i");
        if (!heartIcon) {
            return;
        }

        button.addEventListener("click", function () {
            if (heartIcon.classList.contains('fa-regular')) {
                heartIcon.classList.remove('fa-regular', 'fa-heart');
                heartIcon.classList.add('fa-solid', 'fa-heart');
                button.classList.add('is-liked');
            } else {
                heartIcon.classList.remove('fa-solid', 'fa-heart');
                heartIcon.classList.add('fa-regular', 'fa-heart');
                button.classList.remove('is-liked');
            }
        });
    });
});

