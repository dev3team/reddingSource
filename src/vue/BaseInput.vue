<template>
  <label
    v-if="label"
    class="sr-only"
    :for="uuid"
  >
    {{ label }}
  </label>
  <input
    class="w-full px-4 py-2.5 rounded-lg transition-colors text-green-800 duration-300 ease-in-out border border-gray-100 outline-none placeholder-green-800 focus:outline-none focus:border-green-500 focus:ring-transparent autofill:text-fill-green-800 autofill:shadow-fill-white field"
    v-bind="{
      ...$attrs,
      onInput: updateValue
    }"
    :id="uuid"
    :name="uuid"
    :value="modelValue"
    :placeholder="label"
    :aria-describedby="error ? `${uuid}-error` : null"
    :aria-invalid="error ? true : false"
    :class="{ 'text-orange-500 border-orange-500 !placeholder-orange-500 focus:border-orange-500' : error }"
  >

  <p v-if="error" 
    aria-live="assertive"
    class="absolute left-0 text-xs text-orange-500 errorMessage -bottom-5"
    :id="`${uuid}-error`"
  >
   {{ error }}
  </p>
</template>

<script>
import SetupFormComponent from '../js/modules/SetupFormComponent'
import UniqueID from '../js/modules/UniqueID'
export default {
  props: {
    label: {
      type: String,
      default: ''
    },
    error: {
      type: String,
      default: ''
    },
    modelValue: {
      type: [String, Number],
      default: ''
    }
  },
  setup (props, context) {
    const { updateValue } = SetupFormComponent(props, context)
    const uuid = UniqueID().getID()
    return {
      updateValue,
      uuid
    }
  }
}
</script>