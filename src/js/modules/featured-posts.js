// core version + navigation, pagination modules:
import SwiperCore from "swiper/core";

export default () => {
  const swiper = new SwiperCore(".featured-posts-swiper-js", {
    slidesPerView: 'auto',
    breakpoints: {
      1280: {
        enabled: false,
      },
    },
  });
};