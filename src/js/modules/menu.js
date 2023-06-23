// Scroll lock
import { disableBodyScroll, enableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock';

const Menu = () => {
  // Menu Toggle
  const buttons = document.querySelectorAll('.js-menu-toggle'),
    menu = document.getElementById('main-menu');

  buttons.forEach(el => {
    el.addEventListener('click', () => {
      // Toggle the hide class
      menu.classList.toggle('hidden');

      if (menu.classList.contains('hidden')) {
        enableBodyScroll(menu);

        document.body.classList.remove('menu-open');
      } else {
        disableBodyScroll(menu);

        document.body.classList.add('menu-open');
      }
    });
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !menu.classList.contains('hidden')) {
      e.stopImmediatePropagation();

      // Toggle the hide / search-active class
      menu.classList.add('hidden');

      document.body.classList.remove('menu-open');

      clearAllBodyScrollLocks();
    }
  });
};

export default Menu;
