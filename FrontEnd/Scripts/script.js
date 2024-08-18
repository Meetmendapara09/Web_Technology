document.addEventListener('DOMContentLoaded', () => {
    initPathValidation();
    initSmoothScroll();
    initMobileMenuToggle();
    initFormHandling();
    initScrollToTop();
    initAnimations();
    initTooltips();
    initDynamicContentLoading();
    initImageCarousel();
});



function toggleDropdown() {
    var dropdown = document.getElementById('courses-dropdown');
    if (dropdown.classList.contains('open')) {
        dropdown.classList.remove('open');
    } else {
        dropdown.classList.add('open');
    }
}

// Toogle menu
function toggleMenu() {
    var mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu.classList.contains('open')) {
            mobileMenu.classList.remove('open');
        } else {
            mobileMenu.classList.add('open');
        }
}

function initPathValidation() {
    const validPaths = [
        '/FrontEnd/index.html',
        '/FrontEnd/Pages/About-Us.html',
        '/FrontEnd/Pages/Apply.html',
        '/FrontEnd/Pages/Careers.html',
        '/FrontEnd/Pages/Contact-Us.html',
        '/FrontEnd/Pages/Dashboard.html',
        '/FrontEnd/Pages/FAQ.html',
        '/FrontEnd/Pages/Forgot-Password.html',
        '/FrontEnd/Pages/Free-Courses.html',
        '/FrontEnd/Pages/Help-Center.html',
        '/FrontEnd/Pages/Job-Details.html',
        '/FrontEnd/Pages/Know-Us.html',
        '/FrontEnd/Pages/login.html',
        '/FrontEnd/Pages/Paid-Course.html',
        '/FrontEnd/Pages/Press.html',
        '/FrontEnd/Pages/Privacy-Policy.html',
        '/FrontEnd/Pages/Register.html',
        '/FrontEnd/Pages/Submit-A-Ticket.html',
        '/FrontEnd/Pages/Support.html',
        '/FrontEnd/Pages/Terms-And-Conditions.html',
        '/FrontEnd/Pages/Testimonial.html',
        '/FrontEnd/Pages/Tutorials.html',
        '/FrontEnd/Pages/Admin-Panel',
        '/FrontEnd/Pages/Auth/Login.html',
        '/FrontEnd/Pages/Blogs/Blog-Post1.html',
        '/FrontEnd/Pages/Blogs/Blog-Post2.html',
        '/FrontEnd/Pages/Blogs/Blog-Post3.html',
        '/FrontEnd/Pages/Courses',
        '/FrontEnd/Pages/Payment',
        '/FrontEnd/Pages/Progress-Tracking',
        '/FrontEnd/Pages/Support-FAQ/',
        '/FrontEnd/Pages/USer-Dashboard',
        '/FrontEnd/Pages/Video-Player/Video-Player.html',
    ];
    const currentPath = window.location.pathname;
    const fullPath = currentPath.startsWith('/') ? currentPath : '/' + currentPath;
    if (!validPaths.includes(fullPath) && fullPath !== '/FrontEnd/404.html') {
        window.location.href = '/FrontEnd/404.html';
    }
}

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            const targetId = link.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}




function initFormHandling() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', event => {
            event.preventDefault();
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => { data[key] = value });

            let isValid = true;
            form.querySelectorAll('[required]').forEach(field => {
                const isFieldValid = field.value.trim();
                field.classList.toggle('error', !isFieldValid);
                const errorMsg = field.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('error-message')) {
                    errorMsg.textContent = isFieldValid ? "" : "This field is required.";
                }
                isValid = isValid && isFieldValid;
            });

            if (isValid) {
                alert('Form submitted successfully!');
                form.reset();
            } else {
                alert('Please fill in all required fields.');
            }
        });
    });
}

function initScrollToTop() {
    const scrollToTopButton = document.querySelector('#scroll-to-top');
    if (scrollToTopButton) {
        window.addEventListener('scroll', () => {
            scrollToTopButton.classList.toggle('visible', window.scrollY > 300);
        });

        scrollToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

function initAnimations() {
    const animatedElements = document.querySelectorAll('.animate');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            entry.target.classList.toggle('in-view', entry.isIntersecting);
        });
    }, {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    });

    animatedElements.forEach(el => observer.observe(el));
}

function initTooltips() {
    document.querySelectorAll('[data-tooltip]').forEach(element => {
        element.addEventListener('mouseover', () => {
            const tooltipText = element.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = tooltipText;
            document.body.appendChild(tooltip);

            const rect = element.getBoundingClientRect();
            tooltip.style.left = `${rect.left + window.scrollX}px`;
            tooltip.style.top = `${rect.bottom + window.scrollY}px`;
        });

        element.addEventListener('mouseout', () => {
            const tooltip = document.querySelector('.tooltip');
            if (tooltip) tooltip.remove();
        });
    });
}

function initDynamicContentLoading() {
    const loadMoreButton = document.querySelector('#load-more');
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', () => {
            setTimeout(() => {
                const newContent = `
                    <article class="blog-post">
                        <h2>New Blog Post Title</h2>
                        <p>New blog post content...</p>
                    </article>
                `;
                document.querySelector('.blog-posts').insertAdjacentHTML('beforeend', newContent);
            }, 1000);
        });
    }
}

function initImageCarousel() {
    const carousel = document.querySelector('.carousel');
    if (carousel) {
        const slides = carousel.querySelectorAll('.carousel-slide');
        let index = 0;

        function showSlide(n) {
            slides.forEach((slide, i) => {
                slide.style.display = i === n ? 'block' : 'none';
            });
        }

        function nextSlide() {
            index = (index + 1) % slides.length;
            showSlide(index);
        }

        function prevSlide() {
            index = (index - 1 + slides.length) % slides.length;
            showSlide(index);
        }

        carousel.querySelector('.carousel-next').addEventListener('click', nextSlide);
        carousel.querySelector('.carousel-prev').addEventListener('click', prevSlide);

        showSlide(index);
        setInterval(nextSlide, 5000);
    }
}
