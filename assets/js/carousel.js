/**
 * QuickLoop Carousel JavaScript
 *
 * @package QuickLoop_Carousel
 */

(function () {
  "use strict";

  /**
   * Initialize all carousels on the page
   * Note: Individual carousel initialization is handled inline in the shortcode
   * This file can be used for additional global carousel enhancements
   */

  // Pause autoplay when user prefers reduced motion
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    document.addEventListener("DOMContentLoaded", function () {
      const carousels = document.querySelectorAll(
        ".qlc-carousel-container .swiper",
      );
      carousels.forEach(function (carousel) {
        if (carousel.swiper && carousel.swiper.autoplay) {
          carousel.swiper.autoplay.stop();
        }
      });
    });
  }

  // Add custom keyboard support enhancements
  document.addEventListener("DOMContentLoaded", function () {
    const carousels = document.querySelectorAll(".qlc-carousel-container");

    carousels.forEach(function (container) {
      container.addEventListener("keydown", function (e) {
        const swiper = container.querySelector(".swiper");
        if (!swiper || !swiper.swiper) return;

        // Space bar to pause/resume autoplay
        if (e.key === " " && swiper.swiper.autoplay) {
          e.preventDefault();
          if (swiper.swiper.autoplay.running) {
            swiper.swiper.autoplay.stop();
          } else {
            swiper.swiper.autoplay.start();
          }
        }
      });
    });
  });
})();
