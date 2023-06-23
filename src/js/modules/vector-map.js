export default () => {
  const buttons = document.querySelectorAll('.js-vector-map button');
  const firstPin = document.querySelector('.js-vector-map button:first-of-type');
  const key = firstPin.dataset.mapKey;

  document.querySelector(`.map-pin-group#${key}`).classList.add('active');

  // Loop through buttons
  buttons.forEach(el => {
    ['mouseenter', 'click'].forEach(e => {
      el.addEventListener(e, () => {

        // Hide all pins in the SVG map
        document.querySelectorAll('.map-pin-group, button[data-map-key]').forEach(x => x.classList.remove('active'));

        // Hide all the CTA Links
        document.querySelectorAll('.js-map-cta[data-map-key]').forEach(x => x.classList.add('hidden'));

        // Get key of clicked button
        const key = el.dataset.mapKey;

        // Show correct pins on map
        document.querySelector(`.map-pin-group#${key}`).classList.add('active');
        
        // Add active class to button
        document.querySelector(`button[data-map-key='${key}']`).classList.add('active');

        // Show correct CTA Link
        document.querySelector(`.js-map-cta[data-map-key="${key}"]`).classList.remove('hidden');
      });
    });
  });
};
