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

document.addEventListener('DOMContentLoaded', () => {
    const isLoggedIn = true;
    if (isLoggedIn) {
        document.getElementById('login-link').style.display = 'none';
        document.getElementById('signup-link').style.display = 'none';
        document.getElementById('profile-icon').style.display = 'block';
    }
});

function toggleMobileDropdown() {
    var dropdown = document.getElementById('mobile-courses-dropdown');
    if (dropdown.classList.contains('open')) {
        dropdown.classList.remove('open');
    } else {
        dropdown.classList.add('open');
    }
}

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

document.addEventListener('DOMContentLoaded', () => {
    fetch('header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header').innerHTML = data;
        })
        .catch(error => console.error('Error loading header:', error));
});

document.addEventListener('DOMContentLoaded', () => {
    fetch('footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer').innerHTML = data;
        })
        .catch(error => console.error('Error loading footer:', error));
});


document.addEventListener('DOMContentLoaded', () => {
    fetch('../header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('pages-header').innerHTML = data;
        })
        .catch(error => console.error('Error loading header:', error));
});

document.addEventListener('DOMContentLoaded', () => {
    fetch('../footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('pages-footer').innerHTML = data;
        })
        .catch(error => console.error('Error loading footer:', error));
});

document.addEventListener('DOMContentLoaded', () => {
    fetch('../../header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header2').innerHTML = data;
        })
        .catch(error => console.error('Error loading header:', error));
});

document.addEventListener('DOMContentLoaded', () => {
    fetch('../../footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer2').innerHTML = data;
        })
        .catch(error => console.error('Error loading footer:', error));
});

function initPathValidation() {
    const validPaths = [
        '/Web_Technology/FrontEnd/index.html',
        '/FrontEnd/index.html',
        '/Web_Technology/FrontEnd/',
        '/Web_Technology/FrontEnd/Pages/about-us.html',
        '/Web_Technology/FrontEnd/Pages/apply.html',
        '/Web_Technology/FrontEnd/Pages/careers.html',
        '/Web_Technology/FrontEnd/Pages/contact-us.html',
        '/Web_Technology/FrontEnd/Pages/dashboard.html',
        '/Web_Technology/BackEnd/dashboard.php',
        '/FrontEnd/Pages/dashboard.html',
        '/Web_Technology/FrontEnd/Pages/Support-FAQ/FAQ.html',
        '/Web_Technology/FrontEnd/Pages/Support-FAQ/Support.html',
        '/Web_Technology/FrontEnd/Pages/Forgot-Password.html',
        '/Web_Technology/FrontEnd/Pages/Free-Courses.html',
        '/Web_Technology/FrontEnd/Pages/Help-Center.html',
        '/Web_Technology/FrontEnd/Pages/Job-Details.html',
        '/Web_Technology/FrontEnd/Pages/Know-Us.html',
        '/Web_Technology/FrontEnd/Pages/login.html',
        '/Web_Technology/FrontEnd/Pages/Paid-Course.html',
        '/Web_Technology/FrontEnd/Pages/Press.html',
        '/Web_Technology/FrontEnd/Pages/Privacy-Policy.html',
        '/Web_Technology/FrontEnd/Pages/Auth/SignUp.html',
        '/Web_Technology/FrontEnd/Pages/Submit-A-Ticket.html',
        '/Web_Technology/FrontEnd/Pages/Support.html',
        '/Web_Technology/FrontEnd/Pages/terms-and-conditions.html',
        '/Web_Technology/FrontEnd/Pages/Testimonial.html',
        '/Web_Technology/FrontEnd/Pages/Tutorials.html',
        '/Web_Technology/FrontEnd/Pages/Admin-Panel',
        '/Web_Technology/FrontEnd/Pages/Auth/Login.html',
        '/Web_Technology/FrontEnd/Pages/Blogs/Blog-Post1.html',
        '/Web_Technology/FrontEnd/Pages/Blogs/Blog-Post2.html',
        '/Web_Technology/FrontEnd/Pages/Blogs/Blog-Post3.html',
        '/Web_Technology/FrontEnd/Pages/Courses',
        '/Web_Technology/FrontEnd/Pages/Payment',
        '/Web_Technology/FrontEnd/Pages/Progress-Tracking',
        '/Web_Technology/FrontEnd/Pages/Support-FAQ/',
        '/Web_Technology/FrontEnd/Pages/dashboard',
        '/Web_Technology/FrontEnd/Pages/Video-Player/Video-Player.html',
    ];
    const currentPath = window.location.pathname;
    const fullPath = currentPath.startsWith('/') ? currentPath : '/' + currentPath;
    if (!validPaths.includes(fullPath) && fullPath !== '/Web_Technology/FrontEnd/404.html') {
        window.location.href = '/Web_Technology/FrontEnd/404.html';
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
