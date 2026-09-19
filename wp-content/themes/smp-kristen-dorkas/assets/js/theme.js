document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menuToggle');
    const nav = document.getElementById('nav');

    if (menuToggle && nav) {
        menuToggle.addEventListener('click', function () {
            nav.classList.toggle('active');
        });
    }

    const heroSlider = document.getElementById('heroSlider');
    if (!heroSlider) {
        return;
    }

    const slides = Array.from(heroSlider.querySelectorAll('.slide'));
    const dotsContainer = document.getElementById('heroDots');
    const prevButton = heroSlider.querySelector('.slider-prev');
    const nextButton = heroSlider.querySelector('.slider-next');

    let currentIndex = 0;

    function renderDots() {
        if (!dotsContainer) {
            return;
        }

        dotsContainer.innerHTML = '';
        slides.forEach(function (_, index) {
            const dot = document.createElement('button');
            dot.type = 'button';
            if (index === currentIndex) {
                dot.classList.add('active');
            }
            dot.setAttribute('aria-label', 'Go to slide ' + (index + 1));
            dot.addEventListener('click', function () {
                showSlide(index);
            });
            dotsContainer.appendChild(dot);
        });
    }

    function showSlide(index) {
        currentIndex = (index + slides.length) % slides.length;
        slides.forEach(function (slide, slideIndex) {
            slide.classList.toggle('active', slideIndex === currentIndex);
        });
        renderDots();
    }

    prevButton?.addEventListener('click', function () {
        showSlide(currentIndex - 1);
    });

    nextButton?.addEventListener('click', function () {
        showSlide(currentIndex + 1);
    });

    renderDots();
    setInterval(function () {
        showSlide(currentIndex + 1);
    }, 5000);
});
