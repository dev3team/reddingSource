<!-- Contact Form -->
<section id="js-newsletter-form" class="md:relative">

  <!-- Container -->
  <div class="container w-10/12 max-w-xl pt-5 pb-16 md:py-24">

    <?php $url = htmlspecialchars($_SERVER['HTTP_REFERER']); ?>

    <!-- Back -->
    <a href="<?php echo $url; ?>" class="flex items-center py-3 text-sm font-bold tracking-wider uppercase md:absolute md:top-4 lg:top-8 md:left-7 lg:left-36 mb-7 md:mb-0 text-beige-800">
      <span class="w-3.5 h-3.5 mr-2 rotate-180">
        <?php echo svg(['sprite' => 'icon-carrot', 'class' => 'w-full h-full fill-current']); ?>
      </span>
      Back
    </a>

    <!-- Success Message -->
    <div v-if="success" class="py-32 text-center"><?php
      $newsletter_success_title = get_field('newsletter_success_title', 'option');
      $newsletter_success_copy = get_field('newsletter_success_copy', 'option');

      if ($newsletter_success_title) : ?>
      <p class="mb-3 font-black uppercase text-green-800 leading-none text-2 font-poppins tracking-wide md:text-4xl md:leading-none md:mb-1 xl:text-2.75">
        <?php echo $newsletter_success_title; ?>
      </p><?php
      endif;

      if ($newsletter_success_copy) : ?>
      <p>
        <?php echo $newsletter_success_copy; ?>
      </p><?php
      endif; ?>
    </div>
    <!-- Close Success Message -->

    <!-- Form -->
    <v-form
      @submit="onSubmit"
      v-slot="{ submitForm, values, meta }"
      class="grid gap-8 md:grid-cols-3"
      v-if="!success"
      ref="newsletterForm"
      >

      <!-- Name -->
      <div class="relative md:col-span-3">
        <v-field name="name" 
          v-slot="{ value, field, errors, meta }"
          v-model="user.name"
          type="text"
          label="Name"
          rules="required"
          >
          <label for="name" class="sr-only">Name</label>
          <input id="name"
            aria-required="true"
            :aria-invalid="!meta.valid ? true : false"
            placeholder="Name*"
            v-bind="field"
            class="w-full px-4 py-2.5 rounded-lg transition-colors text-green-800 duration-300 ease-in-out border outline-none focus:outline-none focus:border-green-500 autofill:text-fill-green-800 autofill:shadow-fill-white focus:ring-transparent"
            :class="meta.validated && !meta.valid ? 'text-orange-500 border-orange-500 focus:border-orange-500 placeholder-orange-500' : 'border-gray-100 placeholder-green-800'"
          />
          <error-message name="name">
            <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Name is required</p>
          </error-message>
        </v-field>
      </div>
      <!-- Close Name -->

      <!-- Email -->
      <div class="relative md:col-span-2">
        <v-field name="email" 
          v-slot="{ value, field, errors, meta }"
          v-model="user.email"
          type="email"
          label="Email address"
          rules="required|email"
          >
          <label for="email" class="sr-only">Email</label>
          <input id="email"
            aria-required="true"
            :aria-invalid="!meta.valid ? true : false"
            placeholder="Email*"
            v-bind="field"
            class="w-full px-4 py-2.5 rounded-lg transition-colors text-green-800 duration-300 ease-in-out border outline-none focus:outline-none focus:border-green-500 autofill:text-fill-green-800 autofill:shadow-fill-white focus:ring-transparent"
            :class="meta.validated && !meta.valid ? 'text-orange-500 border-orange-500 focus:border-orange-500 placeholder-orange-500' : 'border-gray-100 placeholder-green-800'"
          />
          <error-message name="email">
            <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Email address is not valid.</p>
          </error-message>
        </v-field>
      </div>
      <!-- Close Email -->

      <!-- Zip -->
      <div class="md:col-span-1">
        <v-field name="zip" 
          v-model="user.zip"
          type="text"
          label="Zip Code"
          >
          <label for="zip" class="sr-only">Zip Code</label>
          <input id="zip"
            aria-required="false"
            placeholder="Zip Code"
            class="w-full px-4 py-2.5 rounded-lg transition-colors text-green-800 border-gray-100 placeholder-green-800 duration-300 ease-in-out border outline-none focus:outline-none focus:border-green-500 autofill:text-fill-green-800 autofill:shadow-fill-white focus:ring-transparent"
          />
        </v-field>
      </div>
      <!-- Close Zip -->

        <!-- Phone -->
        <div class="relative md:col-span-3">
            <v-field name="phone" label="Phone number" v-slot="{ value, field, errors, meta }" v-model="user.phone" type="text"
                     rules="required" >
                <label for="phone" class="sr-only" >Phone number</label>
                <input id="phone" aria-required="true" :aria-invalid="!meta.valid ? true : false" placeholder="Phone number*"
                       v-bind="field"
                       class="w-full px-4 py-2.5 rounded-lg transition-colors text-green-800 border-gray-100 placeholder-green-800 duration-300 ease-in-out border outline-none focus:outline-none focus:border-green-500 autofill:text-fill-green-800 autofill:shadow-fill-white focus:ring-transparent"
                       :class="meta.validated && !meta.valid ? 'text-orange-500 border-orange-500 focus:border-orange-500 placeholder-orange-500' : 'border-gray-100 placeholder-green-800'" />
                <error-message name="phone">
                    <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Phone number is not valid.</p>
                </error-message>
            </v-field>
        </div>
        <!-- Close Phone -->

      <!-- Categories -->
      <div class="grid mb-10 md:mb-0 md:col-span-3 md:grid-cols-3 md:gap-7">

        <div class="mb-4 text-gray-500 md:col-span-1">
          <p id="id-group-label">I'm Interested in:</p>
          <p class="text-sm italic">(Select all that apply)</p>
        </div>
        
        <!-- Category -->
        <fieldset class="relative grid md:grid-cols-2 md:gap-x-7 gap-y-5 md:col-span-2"
        role="group"
        aria-labelledby="id-group-label"
          ><?php
          // Get the categories from taxonomy
          $categories = get_terms([
            'taxonomy' => 'categories_of_interest',
            'hide_empty' => false,
          ]);

          // Loop through categories
          foreach ($categories as $category) : ?>
            <div>
              <!-- Create the v-field -->
              <v-field v-model="user.interestedIn"
                v-slot="{ value, field, errors, meta }"
                name="interestedIn" 
                type="checkbox" 
                value="<?php echo $category->term_id; ?>" 
                :unchecked-value="false"
                :rules="isRequired"
                label="Interested In"
                >

                <!-- Checkbox Input -->
                <input id="category-<?php echo $category->slug; ?>"
                  type="checkbox" 
                  name="interestedIn"
                  v-bind="field" 
                  value="<?php echo $category->term_id; ?>" 
                  :unchecked-value="false" 
                  :class="clicked && !meta.valid ? 'before:border-orange-500' : 'before:border-beige-800'"
                />

                <!-- Checkbox Label -->
                <label for="category-<?php echo $category->slug; ?>"
                  class="select-none whitespace-nowrap"
                  :class="clicked && !meta.valid ? 'text-orange-500' : 'text-gray-500'"
                  role="checkbox"
                  :aria-checked="value.includes('<?php echo $category->term_id; ?>')"
                  >
                  <?php echo $category->name; ?>
                </label>
              </v-field>
            </div><?php 
          endforeach; ?>

          <error-message name="interestedIn">
            <p class="absolute left-0 text-xs text-orange-500 -bottom-7">Please select one or more categories.</p>
          </error-message>

        </fieldset>
        <!-- Close Category -->

      </div>
      <!-- Close Categories -->
      
      <!-- Opt-in -->
      <div class="flex mb-10 md:col-span-3">
        <v-field v-model="user.optIn"
          v-slot="{ value, field, errors, meta }" 
          name="optIn" 
          type="checkbox"
          value="true"
          :unchecked-value="false"
          rules="required"
          label="Opt-in">
            <input id="optIn"
              type="checkbox" 
              name="optIn" 
              v-bind="field" 
              value="true" 
              :unchecked-value="false" 
              :class="meta.validated && !meta.valid ? 'before:border-orange-500' : 'before:border-beige-800'"
            />

            <label for="optIn"
              class="select-none md:!pt-1"
              :class="meta.validated && !meta.valid ? 'text-orange-500' : 'text-gray-500'"
              :aria-checked="value"
              >
                Sign me up to receive updates from Visit Redding!
            </label>
          </v-field>
        </div>
        <!-- Opt-in -->
        
        <!-- Submit -->
        <div class="md:col-span-3">
          <button type="submit" @click="clicked = true" class="relative flex items-center justify-center w-full py-3 pr-5 text-sm font-bold tracking-wider text-white uppercase transition duration-500 rounded-lg md:w-auto md:self-start pl-7 group button-green">
            <span class="pl-1 duration-500 ease-in-out translate-x-1.5 group-hover:translate-x-0">
              Sign Up
            </span>
            <?php echo svg(['file' => 'button-arrow']); ?>
            <span v-if="clicked && !meta.valid" class="absolute text-center text-orange-500 md:left-0 md:text-left whitespace-nowrap -bottom-8">Please fill in the required field(s).</span>
          </button>
        </div>
        <!-- Submit -->

  
      

    </v-form>
    <!-- Close Form -->

  </div>
  <!-- Close Container -->

  <!-- WP Nonce -->
  <input type="hidden" :value="security" name="security" />

</section>
<!-- Close Contact Form -->
