import { createApp, ref } from 'vue';

import BaseInput from '../../vue/BaseInput.vue';
import BaseTextArea from '../../vue/BaseTextArea.vue';

import { useField, useForm } from 'vee-validate'
import { object, string } from 'yup'

export default () => {
  const elements = document.querySelectorAll('.js-contact-form');

  elements.forEach(el => {
    createApp({
      components: {
        BaseInput,
        BaseTextArea
      },
      setup() {
        const success = ref(null);
        const responseMessage = ref('');

        const validationSchema = object({
          name: string().required(),
          email: string().required(),
          phone: string(),
          message: string().required()
        })

        const { handleSubmit, errors } = useForm({
          validationSchema,
        })

        const { value: name } = useField('name')
        const { value: email } = useField('email')
        const { value: phone } = useField('phone')
        const { value: message } = useField('message')

        // Submit Handler
        const submit = handleSubmit(values => {
          fetch(tofinoJS.ajaxUrl, {
            method: "post",
            body: new URLSearchParams({
              action: "ajax-contact",
              data: JSON.stringify(values)
            })
          }).then(async (response) => {
              const data = await response.json();

              success.value = true;
              
              responseMessage.value = data.message;
            })
            .catch((error) => {
              success.value = false;

              console.error(error);

              responseMessage.value = "A system error has occured. Please try again later.";
            });
        })

        return {
          success,
          responseMessage,
          name,
          email,
          phone,
          message,
          submit,
          errors
        }
      }
    }).mount(el, true);
  });
};