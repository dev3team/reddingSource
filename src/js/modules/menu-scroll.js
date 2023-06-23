const MenuScroll = () => {
  const alert = document.querySelector('#tofino-notification.top');
  const nav = document.getElementById('header-nav');

  // Get offset position
  let top = 1;

  // Check for alert
  if (alert) {
    // Plus the alert height
    top += alert.offsetHeight;
  }

  // Observe the first module position from the top
  const observer = new IntersectionObserver(
    entries => {
      if (entries[0].intersectionRatio < 1) {
        nav.classList.add('nav-stuck');
      } else {
        nav.classList.remove('nav-stuck');
      }
    },
    {
      rootMargin: `${top}px 0px 0px 0px`,
      threshold: [1],
    }
  );

  observer.observe(document.body);
};

export default MenuScroll;
