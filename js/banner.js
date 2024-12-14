document.addEventListener("DOMContentLoaded", () => {
    const bannerImages = [
        './image/image1.jpg',
        './image/image2.jpg',
        './image/image3.jpg',
        './image/image4.jpg',
    ];

    let currentIndex = 0;
    const banner = document.querySelector('.banner');
    let slideTimeout;

    const preloadImages = (images) => {
        images.forEach(src => {
            const img = new Image();
            img.src = src;
        });
    };

    preloadImages(bannerImages);

    const changeBannerImage = () => {
        banner.style.opacity = 0;
        setTimeout(() => {
            banner.style.backgroundImage = `url(${bannerImages[currentIndex]})`;
            banner.style.opacity = 1;
            slideTimeout = setTimeout(nextImage, 3000);
        }, 1000);
    };

    const nextImage = () => {
        currentIndex = (currentIndex + 1) % bannerImages.length;
        changeBannerImage();
    };

    const startSlideShow = () => {
        slideTimeout = setTimeout(nextImage, 3000);
    };

    const stopSlideShow = () => {
        clearTimeout(slideTimeout);
    };

    banner.style.backgroundImage = `url(${bannerImages[currentIndex]})`;
    startSlideShow();
});
