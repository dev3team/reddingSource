<?php 
$itinerary_id = get_sub_field('itinerary'); ?>

<div class="js-itineraries">
  <itineraries :itinerary-id="<?php echo $itinerary_id; ?>"></itineraries>
</div>
