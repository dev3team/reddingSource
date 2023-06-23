import { createApp } from 'vue';
import { configure, Field, Form, ErrorMessage, defineRule } from 'vee-validate';
import { required, email } from '@vee-validate/rules';

import VCalendar from 'v-calendar';
import 'v-calendar/dist/style.css';

defineRule('required', required);
defineRule('email', email);

// Default values
configure({
  validateOnBlur: false, // controls if `blur` events should trigger validation with `handleChange` handler
  validateOnChange: false, // controls if `change` events should trigger validation with `handleChange` handler
  validateOnInput: true, // controls if `input` events should trigger validation with `handleChange` handler
  validateOnModelUpdate: false, // controls if `update:modelValue` events should trigger validation with `handleChange` handler
});

export default () => {
  const App = createApp({
    data: () => ({
      clicked: false,
      message: null,
      security: tofinoJS.nextNonce,
      success: false,
      showVenueForm: false,
      event: {
        title: '',
        description: '',
        categories: [],
        eventWebsite: '',
        eventCost: '',
        startDate: new Date().toISOString().split('T')[0],
        startTime: new Date().toLocaleTimeString(),
        endDate: new Date(new Date().setDate(new Date().getDate() + 1)).toISOString().split('T')[0],
        endTime: new Date().toLocaleTimeString(),
        allDay: null,
        image: {
          size: '',
          value: '',
          filename: '',
          imageLoaded: false,
        },
        venue: {
          // venuePostId: null,
          // venueName: '',
          // venueAddress: '',
          // venueCity: '',
          // venueCountry: '',
          // venueState: '', // Must be two letter state abbreviation.
          // venueZip: '',
          // venuePhone: '',
          // venueWebsite: '',
        },
        organizer: {
          // organizerName: '',
          // organizerPhone: '',
          // organizerEmail: '',
          // organizerWebsite: '',
        },
      },
    }),
    components: {
      // Renamed to avoid conflicts of HTML form element without a vue compiler
      VForm: Form,
      VField: Field,
      ErrorMessage: ErrorMessage,
    },
    methods: {
      onChangeVenue (event) {
        if (event.target.value === 'add-venue') {
          this.showVenueForm = true;
        } else {
          this.showVenueForm = false;
        }
      },
      loadFile (event) {
        const file = event.target.files[0];

        if (file) {
          this.event.image.size = file.size / 1024 / 1024; // in MiB
          this.event.image.size = Math.round((this.event.image.size + Number.EPSILON) * 100) / 100; // in MiB

          // Check file is an image
          if (!file || file.type.indexOf('image/') !== 0) {
            alert('File is not an image. Please upload a JPG or PNG only.');

            return;
          }
        }

        // Check file size
        if (this.event.image.size > 2) {
          alert(
            'Max file size is 2MB. The file you tried to upload is ' +
              Math.round((this.event.image.size + Number.EPSILON) * 100) / 100 +
              'MB.'
          );

          return;
        }

        // Read the file
        const reader = new FileReader();

        // Set the Base64 value
        this.event.image.value = reader.readAsDataURL(file);

        // Onload event function
        reader.onload = e => {
          // Create new image instance
          let img = new Image();

          // Onload image event function
          img.onload = () => {
            // console.log('Image loaded');
            // console.log(img.width);
            // console.log(img.height);

            if (img.width < 720 || img.height < 720) {
              alert(
                'Image is too small. Please upload a square image that is at least 720px by 720px.'
              );

              return;
            } else {
              // Set the image value
              this.event.image.value = e.target.result;

              // Set the filename
              this.event.image.filename = file.name;
            }
          };

          img.src = e.target.result;
        };
      },
      isRequired (value) {
        if (value.length > 0) {
          return true;
        }
      },
      scrollToTop () {
        const elm = document.querySelectorAll('.module')[1];
        const headerNav = document.getElementById('header-nav');
        const navHeight = headerNav.offsetHeight;

        elm.scrollIntoView(true);
        const scrolledY = window.scrollY; // Offset Nav

        if (scrolledY) {
          window.scroll({
            top: scrolledY - navHeight,
            behavior: 'smooth',
          });
        }
      },
      onSubmit (values, actions) {
        // console.log(values);

        fetch(tofinoJS.ajaxUrl, {
          method: 'post',
          body: new URLSearchParams({
            action: 'ajax_event_form',
            security: this.security,
            data: JSON.stringify(values),
          }),
        })
          .then(async response => {
            const data = await response.json();

            if (!data.success) {
              this.success = false;
              // console.log('-----NOT SUCCESSFUL-----');
              // console.log(data);

              if (data.type === 'validation') {
                this.$refs.eventForm.setErrors(data.extra);
              }
            } else {
              this.success = true;
              // console.log('-----SUCCESSFUL!!-----');
              // console.log(data);

              // Scroll to top of page
              this.scrollToTop();
            }

            this.message = data.message;
          })
          .catch(error => {
            console.error(error);
            this.message = 'A system error has occured. Please try again later.';
          });
      },
    },
  });

  App.use(VCalendar, {});

  App.mount('#js-event-form');
};
