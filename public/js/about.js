// මෙම JavaScript කේතය CSS හි animation keyframes ක්‍රියාත්මක කිරීමට අවශ්‍ය විය හැකිය.
// දැනට ඔබට animations අවශ්‍ය නැතිනම්, මෙය හිස්ව තැබිය හැක.
// කෙසේ වෙතත්, CSS හි ඇති animate-fade-in වැනි class names ක්‍රියාත්මක වීමට
// මෙවැනි JavaScript එකක් අවශ්‍ය විය හැක.

document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.animate-fade-in, .hero-content h1, .hero-content p, .contact-info.page-specific, .contact-form-container.page-specific, .info-item img');

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    animatedElements.forEach(element => {
        observer.observe(element);
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const sliderTrack = document.querySelector('.slider-track');
    const slides = document.querySelectorAll('.slide');
    const prevButton = document.querySelector('.prev-slide');
    const nextButton = document.querySelector('.next-slide');

    let currentIndex = 0;
    const totalSlides = slides.length;
    const slideWidth = slides[0].clientWidth; // එක් slide එකක පළල

    // Initialize the slider position
    updateSliderPosition();

    // Event Listeners for buttons
    if (prevButton) {
        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex === 0) ? totalSlides - 1 : currentIndex - 1;
            updateSliderPosition();
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex === totalSlides - 1) ? 0 : currentIndex + 1;
            updateSliderPosition();
        });
    }

    // Function to update the slider's position
    function updateSliderPosition() {
        const offset = -currentIndex * slideWidth;
        sliderTrack.style.transform = `translateX(${offset}px)`;
    }

    // Optional: Auto-slide functionality (uncomment if needed)
    // let autoSlideInterval;
    // function startAutoSlide() {
    //     autoSlideInterval = setInterval(() => {
    //         currentIndex = (currentIndex === totalSlides - 1) ? 0 : currentIndex + 1;
    //         updateSliderPosition();
    //     }, 5000); // Change slide every 5 seconds
    // }

    // function stopAutoSlide() {
    //     clearInterval(autoSlideInterval);
    // }

    // // Start auto-slide when page loads
    // startAutoSlide();

    // // Stop auto-slide on hover
    // sliderTrack.addEventListener('mouseenter', stopAutoSlide);
    // sliderTrack.addEventListener('mouseleave', startAutoSlide);

    // Handle window resize to re-calculate slide width
    window.addEventListener('resize', () => {
        // Recalculate slideWidth on resize to ensure correct positioning
        const newSlideWidth = slides[0].clientWidth;
        // If the width has changed, update the transform
        if (newSlideWidth !== slideWidth) {
            slideWidth = newSlideWidth; // Update the stored slideWidth
            updateSliderPosition();
        }
    });

});