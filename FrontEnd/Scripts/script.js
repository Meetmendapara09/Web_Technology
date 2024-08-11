document.addEventListener('DOMContentLoaded', function () {
    // Smooth Scrolling for Anchor Links
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

    // Mobile Menu Toggle
    const mobileMenuButton = document.querySelector('.md:hidden button');
    const mobileMenu = document.querySelector('.md:hidden + div');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function () {
            const isVisible = mobileMenu.style.display === 'block';
            if (isVisible) {
                gsap.to(mobileMenu, {
                    duration: 0.3,
                    opacity: 0,
                    display: 'none'
                });
            } else {
                gsap.to(mobileMenu, {
                    duration: 0.3,
                    opacity: 1,
                    display: 'block'
                });
            }
        });
    }

    // Handle Form Submission (Example: Contact Form)
    const contactForm = document.querySelector('#contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (event) {
            event.preventDefault();

            // Example form validation
            const name = this.querySelector('input[name="name"]').value;
            const email = this.querySelector('input[name="email"]').value;
            const message = this.querySelector('textarea[name="message"]').value;

            if (name && email && message) {
                // Simulate form submission
                alert('Thank you for contacting us! We will get back to you soon.');
                this.reset(); // Reset form fields
            } else {
                alert('Please fill in all required fields.');
            }
        });
    }

    // Handling Scroll-to-Top Button
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
});
