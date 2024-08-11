document.addEventListener('DOMContentLoaded', function () {

    // Smooth Scrolling for Anchor Links
    function initSmoothScroll() {
        const scrollLinks = document.querySelectorAll('a[href^="#"]');
        scrollLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
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

    // Mobile Menu Toggle
    function initMobileMenuToggle() {
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function () {
                const isVisible = mobileMenu.classList.contains('visible');
                if (isVisible) {
                    mobileMenu.classList.remove('visible');
                    mobileMenu.style.opacity = '0';
                } else {
                    mobileMenu.classList.add('visible');
                    mobileMenu.style.opacity = '1';
                }
            });
        }
    }

    // Handle Form Submissions and Validation
    function initFormHandling() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(this);
                const data = {};
                formData.forEach((value, key) => { data[key] = value });

                // Example validation: Check if required fields are filled
                const requiredFields = this.querySelectorAll('[required]');
                let isValid = true;
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('error');
                        const errorMsg = field.nextElementSibling;
                        if (errorMsg && errorMsg.classList.contains('error-message')) {
                            errorMsg.textContent = "This field is required.";
                        }
                    } else {
                        field.classList.remove('error');
                        const errorMsg = field.nextElementSibling;
                        if (errorMsg && errorMsg.classList.contains('error-message')) {
                            errorMsg.textContent = "";
                        }
                    }
                });

                if (isValid) {
                    // Simulate form submission
                    alert('Form submitted successfully!');
                    this.reset(); // Reset form fields
                } else {
                    alert('Please fill in all required fields.');
                }
            });
        });
    }

    // Scroll-to-Top Button
    function initScrollToTop() {
        const scrollToTopButton = document.querySelector('#scroll-to-top');
        if (scrollToTopButton) {
            window.addEventListener('scroll', function () {
                if (window.scrollY > 300) {
                    scrollToTopButton.classList.add('visible');
                } else {
                    scrollToTopButton.classList.remove('visible');
                }
            });

            scrollToTopButton.addEventListener('click', function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    }

    // Intersection Observer for Animations
    function initAnimations() {
        const animatedElements = document.querySelectorAll('.animate');
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                } else {
                    entry.target.classList.remove('in-view');
                }
            });
        }, observerOptions);

        animatedElements.forEach(el => {
            observer.observe(el);
        });
    }

    // Tooltips
    function initTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        tooltipElements.forEach(element => {
            element.addEventListener('mouseover', function () {
                const tooltipText = this.getAttribute('data-tooltip');
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.textContent = tooltipText;
                document.body.appendChild(tooltip);

                const rect = this.getBoundingClientRect();
                tooltip.style.left = `${rect.left + window.scrollX}px`;
                tooltip.style.top = `${rect.bottom + window.scrollY}px`;
            });

            element.addEventListener('mouseout', function () {
                const tooltip = document.querySelector('.tooltip');
                if (tooltip) {
                    tooltip.remove();
                }
            });
        });
    }

    // Dynamic Content Loading (Example: Blog Posts)
    function initDynamicContentLoading() {
        const loadMoreButton = document.querySelector('#load-more');
        if (loadMoreButton) {
            loadMoreButton.addEventListener('click', function () {
                // Simulate AJAX request to load more content
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

    // Image Carousel/Slider (Basic Implementation)
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
            setInterval(nextSlide, 5000); // Auto-slide every 5 seconds
        }
    }

    // Initialize all components
    initSmoothScroll();
    initMobileMenuToggle();
    initFormHandling();
    initScrollToTop();
    initAnimations();
    initTooltips();
    initDynamicContentLoading();
    initImageCarousel();
});
