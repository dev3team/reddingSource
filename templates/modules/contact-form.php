<?php
$contact_address = get_theme_mod('address');
$contact_phone = get_theme_mod('telephone_number'); ?>

<section class="contact-form js-contact-form">
  <div class="container">
    <div class="flex flex-col w-10/12 mx-auto lg:w-[62%] xl:w-1/2 2xl:w-[43%]">

      <!-- Response Message -->
      <div v-if="responseMessage"
        class="pb-12 text-xl text-center md:text-2xl md:pb-20"
      >
        {{ responseMessage }}
      </div>
      <!-- Close Response Message -->

      <!-- Form -->
      <form
        @submit.prevent="submit"
        class="flex flex-col w-full pb-20 md:flex-row md:flex-wrap md:pb-28"
        :class="{ hidden : responseMessage}"
      >
        <!-- Name -->
        <div class="relative w-full mb-7">
          <base-input
            label="Name"
            type="text"
            v-model="name"
            :error="errors.name"
          ></base-input>
        </div>

        <!-- Email -->
        <div class="relative w-full mb-7 md:w-2/3 md:mr-6">
          <base-input
            label="Email"
            type="email"
            v-model="email"
            :error="errors.email"
          ></base-input>
        </div>

        <!-- Phone -->
        <div class="relative w-full mb-7 md:w-auto md:flex-1">
          <base-input
            label="Phone"
            type="tel"
            v-model="phone"
            :error="errors.phone"
          ></base-input>
        </div>

        <!-- Message -->
        <div class="relative w-full mb-7">
          <base-text-area
            label="Message"
            v-model="message"
            :error="errors.message"
          ></base-text-area>
        </div>

        <!-- Send -->
        <button type="submit" class="flex items-center justify-center w-full px-8 py-3 text-sm font-bold tracking-wider text-white uppercase transition duration-500 rounded-lg md:w-auto md:self-start group button-green">
          <span class="pl-1 duration-500 ease-in-out translate-x-1.5 group-hover:translate-x-0">
            Send
          </span>
          <?php echo svg(['file' => 'button-arrow']); ?>
        </button>
      </form>
      <!-- Close Form -->

      <!-- Address -->
      <div class="flex flex-col items-center pb-20 xl:pb-28"><?php
        if ($contact_address) : ?>
          <address class="not-italic text-center">
            <?php echo $contact_address; ?>
          </address><?php
        endif;
        if ($contact_phone) : ?>
          <a href="tel:<?php echo $contact_phone; ?>" class="text-center hover:underline">
            <?php echo $contact_phone; ?>
          </a><?php
        endif; ?>
      </div>
      <!-- Close Address -->

    </div>
  </div>
</section>