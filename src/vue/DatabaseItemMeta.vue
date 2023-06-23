<script setup>
const props = defineProps({
  item: Object
});

const buttonText = () => {
  const override = props.item.database_button_text_override;

  if (override) {
    return override;
  } else {
    return 'Visit Website';
  }
}
</script>

<template>
  <!-- Address / Phone -->
  <div class="flex flex-col text-lg">

    <!-- Address -->
    <div>
      <a v-if="props.item.database_map_url && props.item.database_address"
        :href="props.item.database_map_url"
        target="_blank"
        rel="noopener"
        class="mb-1.5 flex items-start"
        >
        <svg viewBox="0 0 16 16" class="w-4 h-4 text-green-400 fill-current">
          <title>Pin Icon</title>
          <path d="M8 0C4.4 0 1.5 2.9 1.5 6.5 1.5 9 7.3 16 8 16c.4.1 6.5-7.1 6.5-9.5C14.5 2.9 11.6 0 8 0m0 9C6.6 9 5.5 7.9 5.5 6.5S6.6 4 8 4s2.5 1.1 2.5 2.5S9.4 9 8 9"/>
        </svg>
        <span class="flex flex-col pl-1.5 leading-none">
          <span v-html="props.item.database_address"></span>
        </span>
      </a>
      <div v-else-if="props.item.database_address" class="mb-1.5 flex items-start">
        <svg viewBox="0 0 16 16" class="w-4 h-4 text-green-400 fill-current">
          <title>Pin Icon</title>
          <path d="M8 0C4.4 0 1.5 2.9 1.5 6.5 1.5 9 7.3 16 8 16c.4.1 6.5-7.1 6.5-9.5C14.5 2.9 11.6 0 8 0m0 9C6.6 9 5.5 7.9 5.5 6.5S6.6 4 8 4s2.5 1.1 2.5 2.5S9.4 9 8 9"/>
        </svg>
        <span class="flex flex-col pl-1.5 leading-none">
          <span v-html="props.item.database_address"></span>
        </span>
      </div>
    </div>

    <!-- Phone -->
    <a v-if="props.item.database_phone"
      :href="'tel:' + props.item.database_phone"
      class="flex items-center"
      >
      <svg viewBox="0 0 16 16" class="w-4 h-4 text-green-400 fill-current">
        <title>Phone Icon</title>
        <path d="M11.7 9.6c-1.1 1.1-1.1 2.1-2.1 2.1s-2.1-1.1-3.2-2.1-2.1-2.1-2.1-3.2 1.1-1.1 2.1-2.1S4.3 0 3.2 0 0 3.2 0 3.2c0 2.1 2.2 6.5 4.3 8.5s6.4 4.3 8.5 4.3c0 0 3.2-2.1 3.2-3.2s-3.2-4.3-4.3-3.2z"/>
      </svg>
      <span class="pl-1.5">
        {{ props.item.database_phone }}
      </span>
    </a>
       
    <!-- CTA -->
    <div v-if="props.item.database_website_url" class="inline-flex mt-5">
      <a :href="props.item.database_website_url"
        target="_blank"
        class="flex items-center justify-center px-5 py-3 text-base font-bold tracking-wider text-white uppercase duration-500 ease-in-out rounded-lg group whitespace-nowrap md:w-auto button-green"
        >
        <span class="pl-1 duration-500 ease-in-out translate-x-1.5 group-hover:translate-x-0" v-html="buttonText()"></span>
        <svg class="h-3.5 ml-2.5 text-white duration-500 ease-in-out fill-current -translate-x-1.5 group-hover:translate-x-0" viewBox="0 0 33.31 22.02">
          <title>Button Arrow</title>
          <!-- Arrow Head -->
          <path d="M22.44 21.88 33.3 11.02 22.44.15a.489.489 0 0 0-.69 0c-.06.06-.1.13-.13.21-1.12 4.01.7 8.27 4.39 10.22.24.12.34.42.22.66-.05.09-.12.17-.22.22a8.857 8.857 0 0 0-4.39 10.22c.08.26.35.41.61.34.08-.04.16-.09.21-.14" />
          <!-- Arrow Body -->
          <path class="duration-500 ease-in-out opacity-0 group-hover:opacity-100" d="M27.3 12.2V9.82c0-.55-.45-1-1-1H.99c-.55 0-1 .45-1 1v2.39c0 .55.45 1 1 1H26.3c.55-.01 1-.45 1-1.01" />
        </svg>
      </a>
    </div>
  </div>
</template>
