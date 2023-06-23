// core version + navigation, pagination modules:
import SwiperCore, { Navigation } from "swiper/core";

// configure Swiper to use modules
SwiperCore.use([Navigation]);

export default () => {
  const swiper = new SwiperCore(".content-carousel-swiper-js", {
    slidesPerView: 'auto',
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
};