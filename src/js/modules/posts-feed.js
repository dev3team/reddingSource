export default () => {
  const buttons = document.querySelectorAll('.js-crowdriff-tag');

  // Loop through buttons
  buttons.forEach(el => {
    // Add event listener
    el.addEventListener('click', () => {

      // Hide all post grids
      document.querySelectorAll('.js-crowdriff-grid').forEach(x => x.classList.add('hidden'));

      // Get index of clicked button
      const index = el.dataset.id;

      // Show post grid with index
      document.querySelector(`.js-crowdriff-grid[data-id="${index}"]`).classList.remove('hidden');

      // Tags - Clear all active classes
      document.querySelectorAll('.js-crowdriff-tag').forEach(x => x.classList.remove('js-active-tag'));

      // Tags - Add active class to active tag
      document.querySelector(`.js-crowdriff-tag[data-id="${index}"]`).classList.add('js-active-tag');
    });
  });
};
