export default () => {
  const buttons = document.querySelectorAll('.js-toggle-team-bio');

  // Loop through buttons
  buttons.forEach(el => {
    // Add event listeners
    
    // Get team bio tile element
    const teamTile = el.closest('.js-team-tile');

    ['mouseenter', 'mouseleave'].forEach(function(e) {
      el.addEventListener(e, () => {
        if (!el.classList.contains('active')) {
           teamTile.classList.toggle('show-frame');
        } else {
          teamTile.classList.add('show-frame');
        }
      });
    });

    el.addEventListener('click', () => {
      // Add active class to button
      el.classList.toggle('active');

      if (el.classList.contains('active')) {
        teamTile.classList.add('show-frame');
      } else {
        teamTile.classList.remove('show-frame');
      }

      // Find the bio in the team tile
      const bio = teamTile.querySelector('.js-team-bio');

      // Toggle hidden state on bio element
      bio.classList.toggle('hidden');
    });
  });
};
