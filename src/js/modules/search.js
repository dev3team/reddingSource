export default () => {
  const buttons = document.querySelectorAll('.js-search-toggle')
  const searchBar = document.getElementById('js-search')

  // Loop through the Open elements
  for (const el of buttons) {
    el.addEventListener('click', () => {
      // Toggle the hide / search-active class
      searchBar.classList.toggle('hidden')
      document.body.classList.toggle('search-active')
      
      // Focus cursor on input
      document.getElementById('search-input').focus()
    })
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && document.body.classList.contains("search-active")) {
      e.stopImmediatePropagation();

      // Toggle the hide / search-active class
      searchBar.classList.toggle('hidden')
      document.body.classList.toggle("search-active");
    }
  });
}
