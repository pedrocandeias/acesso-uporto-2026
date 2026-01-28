/**
 * Acesso U.Porto Theme - Main JavaScript
 *
 * @package AcessoUPorto
 */

(function() {
    'use strict';

    /**
     * DOM Ready
     */
    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenu();
        initStickyHeader();
        initCourseAccordion();
        initTestimonialsSlider();
        initVideoPlayers();
        initRotatingText();
        initCounterAnimation();
    });

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navigation = document.querySelector('.main-navigation');

        if (!menuToggle || !navigation) return;

        menuToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            navigation.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });

        // Close menu on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navigation.classList.contains('active')) {
                menuToggle.setAttribute('aria-expanded', 'false');
                navigation.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });

        // Close menu on link click
        const menuLinks = navigation.querySelectorAll('a');
        menuLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                navigation.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('menu-open');
            });
        });
    }

    /**
     * Sticky Header
     */
    function initStickyHeader() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            lastScroll = currentScroll;
        }, { passive: true });
    }

    /**
     * Course Accordion
     */
    function initCourseAccordion() {
        const accordions = document.querySelectorAll('.course-accordion');

        accordions.forEach(function(accordion) {
            const items = accordion.querySelectorAll('.course-item');

            items.forEach(function(item) {
                const header = item.querySelector('.course-header');

                header.addEventListener('click', function() {
                    const isActive = item.classList.contains('active');

                    // Close all items in this accordion
                    items.forEach(function(otherItem) {
                        otherItem.classList.remove('active');
                        otherItem.querySelector('.course-header').setAttribute('aria-expanded', 'false');
                    });

                    // Open clicked item if it wasn't active
                    if (!isActive) {
                        item.classList.add('active');
                        header.setAttribute('aria-expanded', 'true');
                    }
                });

                // Keyboard support
                header.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        header.click();
                    }
                });
            });
        });
    }

    /**
     * Testimonials Slider
     */
    function initTestimonialsSlider() {
        const sliders = document.querySelectorAll('.testimonials-wrapper');

        sliders.forEach(function(wrapper) {
            const slider = wrapper.querySelector('.testimonials-slider');
            const prevBtn = wrapper.querySelector('.testimonials-nav-btn.prev');
            const nextBtn = wrapper.querySelector('.testimonials-nav-btn.next');

            if (!slider || !prevBtn || !nextBtn) return;

            const cardWidth = 350 + 32; // Card width + gap

            prevBtn.addEventListener('click', function() {
                slider.scrollBy({
                    left: -cardWidth,
                    behavior: 'smooth'
                });
            });

            nextBtn.addEventListener('click', function() {
                slider.scrollBy({
                    left: cardWidth,
                    behavior: 'smooth'
                });
            });

            // Touch/swipe support is handled by native scroll
        });
    }

    /**
     * Video Players
     */
    function initVideoPlayers() {
        const videoContainers = document.querySelectorAll('.video-container');

        videoContainers.forEach(function(container) {
            const playBtn = container.querySelector('.video-play-btn');
            const poster = container.querySelector('.video-poster');
            const videoId = container.dataset.videoId;
            const videoType = container.dataset.videoType;

            if (!playBtn || !videoId) return;

            function playVideo() {
                let iframe;

                if (videoType === 'youtube') {
                    iframe = document.createElement('iframe');
                    iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
                    iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                    iframe.allowFullscreen = true;
                } else if (videoType === 'vimeo') {
                    iframe = document.createElement('iframe');
                    iframe.src = `https://player.vimeo.com/video/${videoId}?autoplay=1`;
                    iframe.allow = 'autoplay; fullscreen';
                    iframe.allowFullscreen = true;
                }

                if (iframe) {
                    container.appendChild(iframe);
                    container.classList.add('playing');
                }
            }

            playBtn.addEventListener('click', playVideo);

            if (poster) {
                poster.addEventListener('click', playVideo);
            }
        });
    }

    /**
     * Rotating Text Animation
     */
    function initRotatingText() {
        const rotatingElements = document.querySelectorAll('.hero-rotating-text');

        rotatingElements.forEach(function(element) {
            const wordsData = element.dataset.words;
            if (!wordsData) return;

            const words = JSON.parse(wordsData);
            if (words.length <= 1) return;

            const wordSpan = element.querySelector('.rotating-word');
            if (!wordSpan) return;

            let currentIndex = 0;

            setInterval(function() {
                currentIndex = (currentIndex + 1) % words.length;

                wordSpan.style.animation = 'none';
                wordSpan.offsetHeight; // Trigger reflow
                wordSpan.textContent = words[currentIndex];
                wordSpan.style.animation = 'wordRotate 0.5s ease';
            }, 3000);
        });
    }

    /**
     * Counter Animation (Intersection Observer)
     */
    function initCounterAnimation() {
        const counters = document.querySelectorAll('.stat-number');

        if (!counters.length) return;

        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const countSpan = counter.querySelector('.count');
                    const target = parseInt(counter.dataset.count, 10);

                    if (countSpan && target && !counter.classList.contains('counted')) {
                        counter.classList.add('counted');
                        animateCounter(countSpan, target);
                    }
                }
            });
        }, observerOptions);

        counters.forEach(function(counter) {
            observer.observe(counter);
        });
    }

    /**
     * Animate Counter
     */
    function animateCounter(element, target) {
        const duration = 2000;
        const start = 0;
        const startTime = performance.now();

        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);

            // Easing function (ease-out)
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const current = Math.floor(start + (target - start) * easeOut);

            element.textContent = current;

            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target;
            }
        }

        requestAnimationFrame(updateCounter);
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                const headerHeight = document.querySelector('.site-header')?.offsetHeight || 0;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

})();
