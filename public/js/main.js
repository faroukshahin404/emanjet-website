

//navbar scroll
window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar");
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


// active links
document.addEventListener("DOMContentLoaded", function () {
    const currentPage = window.location.pathname.split("/").pop() || "index.html";
    const navLinks = document.querySelectorAll(".navbar-nav .nav-link");
    navLinks.forEach(link => {
        const linkHref = link.getAttribute("href").split("/").pop();
        if (linkHref === currentPage) {
            link.classList.add("active");
        }
    });
});

// heart btn
document.addEventListener("DOMContentLoaded", function () {
    const heartButtons = document.querySelectorAll(".heart-btn");

    heartButtons.forEach(button => {
        const heartIcon = button.querySelector("i");

        button.addEventListener("click", function () {
            if (heartIcon.classList.contains("fa-regular")) {
                heartIcon.classList.remove("fa-regular", "fa-heart");
                heartIcon.classList.add("fa-solid", "fa-heart");
                heartIcon.style.color = "#F3B12B";
            } else {
                heartIcon.classList.remove("fa-solid", "fa-heart");
                heartIcon.classList.add("fa-regular", "fa-heart");
                heartIcon.style.color = "black";
            }
        });
    });
});


