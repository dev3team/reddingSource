import { createApp } from 'vue';
import { configure, Field, Form, ErrorMessage, defineRule } from 'vee-validate';
import { required, email } from '@vee-validate/rules';

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
      success: null,
      user: {
        name: '',
        email: '',
        zip: '',
        interestedIn: [],
        optIn: false,
      },
    }),
    components: {
      // Renamed to avoid conflicts of HTML form element without a vue compiler
      VForm: Form,
      VField: Field,
      ErrorMessage: ErrorMessage,
    },
    methods: {
      isRequired (value) {
        if (value.length > 0) {
          return true;
        } else {
          return false;
        }
      },
      onSubmit (values, actions) {
        fetch(tofinoJS.ajaxUrl, {
          method: 'post',
          body: new URLSearchParams({
            action: 'ajax_newsletter_form',
            security: this.security,
            data: JSON.stringify(this.user),
          }),
        })
          .then(async response => {
            const data = await response.json();
            console.log(data);
            if (!data.success) {
              this.success = false;
              // console.log('-----NOT SUCCESSFUL-----');
              // console.log(data);
              if (data.type === 'validation') {
                this.$refs.newsletterForm.setErrors(data.extra);
              }
              if (data.type === '') {
                this.success = true;
              }
            } else {
              this.success = true;
              // console.log('-----SUCCESSFUL!!-----');
              // console.log(data);
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

  App.mount('#js-newsletter-form');
};
