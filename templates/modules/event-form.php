<!-- Add Event Form -->
<section id="js-event-form" class="md:relative">

  <!-- Container -->
  <div class="container w-10/12 max-w-2xl pt-5 pb-16 md:py-24">

    <!-- Success Message -->
    <div v-if="success" class="max-w-lg py-32 mx-auto text-center xl:max-w-2xl"><?php
      $event_success_title = get_field('event_success_title', 'option');
      $event_success_copy = get_field('event_success_copy', 'option');

      if ($event_success_title) : ?>
      <p class="mb-3 font-black uppercase text-green-800 leading-none text-2 font-poppins tracking-wide md:text-4xl md:leading-none md:mb-1 xl:text-2.75">
        <?php echo $event_success_title; ?>
      </p><?php
      endif;

      if ($event_success_copy) : ?>
      <p>
        <?php echo $event_success_copy; ?>
      </p><?php
      endif; ?>
    </div>
    <!-- Close Success Message -->

    <!-- Form -->
    <v-form
      @submit="onSubmit"
      v-slot="{ submitForm, values, meta }"
      v-if="!success"
      ref="eventForm"
      >
      
      <!-- Event Title -->
      <fieldset class="p-12 mb-8 border border-gray-100">
        <div class="relative">
          <v-field name="title" 
            v-slot="{ value, field, errors, meta }"
            v-model="event.title"
            type="text"
            label="title"
            rules="required"
            >
            <label for="title" class="fieldset-title">
              Event Title
            </label>
            <input id="title"
              aria-required="true"
              :aria-invalid="!meta.valid ? true : false"
              v-bind="field"
              class="text-input-style"
              :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
            />
            <error-message name="title">
              <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Event title is required.</p>
            </error-message>
          </v-field>
        </div>
      </fieldset>
      <!-- Close Event Title -->

      <!-- Event Description -->
      <fieldset class="p-12 mb-8 border border-gray-100">
        <div class="relative">
          <v-field name="description" 
            v-slot="{ value, field, errors, meta }"
            v-model="event.description"
            label="description"
            rules="required"
            >
            <label for="description" class="fieldset-title">
              Event Description
            </label>
            <textarea id="description"
              aria-required="true"
              :aria-invalid="!meta.valid ? true : false"
              v-bind="field"
              rows="8"
              class="text-input-style"
              :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
            ></textarea>

            <error-message name="description">
              <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Event description is required.</p>
            </error-message>
          </v-field>
        </div>
      </fieldset>
      <!-- Close Event Description -->

      <!-- Categories -->
      <fieldset class="grid p-12 mb-8 border border-gray-100"
        role="group"
        aria-labelledby="id-category-label"
        ><?php
        // Get the categories from taxonomy        
        $categories = get_terms([
          'taxonomy' => 'tribe_events_cat',
          'hide_empty' => false,
        ]); ?>

        <p id="id-category-label" class="fieldset-title">
          Choose Categories
        </p>
        
        <div class="relative grid md:grid-cols-2 md:gap-x-7 gap-y-5"><?php
          // Loop through categories
          foreach ($categories as $category) : ?>
            <div>
              <!-- Create the v-field -->
              <v-field v-model="event.categories"
                v-slot="{ value, field, errors, meta }"
                name="categories" 
                type="checkbox" 
                value="<?php echo $category->term_id; ?>" 
                :unchecked-value="false"
                :rules="isRequired"
                label="Interested In"
                >

                <!-- Checkbox Input -->
                <input id="category-<?php echo $category->slug; ?>"
                  type="checkbox" 
                  name="categories"
                  v-bind="field" 
                  value="<?php echo $category->term_id; ?>" 
                  :unchecked-value="false" 
                  :class="clicked && !meta.valid ? 'before:border-orange-500' : 'before:border-beige-800'"
                />

                <!-- Checkbox Label -->
                <label for="category-<?php echo $category->slug; ?>"
                  class="select-none"
                  :class="clicked && !meta.valid ? 'text-orange-500' : 'text-gray-500'"
                  role="checkbox"
                  :aria-checked="value.includes('<?php echo $category->term_id; ?>')"
                  >
                  <?php echo $category->name; ?>
                </label>
              </v-field>
            </div><?php 
          endforeach; ?>

          <error-message name="categories">
            <p class="absolute left-0 text-xs text-orange-500 -bottom-7">Please select one or more categories.</p>
          </error-message>
        </div>

      </fieldset>
      <!-- Close Categories -->

      <!-- Date / Time -->
      <fieldset class="p-12 mb-8 border border-gray-100">
        
        <p class="fieldset-title">
          Event time & Date
        </p>
        
        <!-- Grid Wrapper -->
        <div class="grid gap-3 md:grid-cols-2">
          
          <!-- Start -->
          <div class="grid gap-3 md:grid-cols-2">
            <p class="md:col-span-2">
              Start
            </p>

            <!-- Start Date -->
            <div class="relative" :class="{'md:col-span-2' : event.allDay}">
              <v-field name="startDate" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.startDate"
                label="startDate"
                rules="required"
                >
                <v-date-picker class="inline-block w-full h-full"
                  :model-config="{type: 'string', mask: 'YYYY-MM-DD'}" 
                  v-model="event.startDate">
                  <template v-slot="{ inputValue, togglePopover }">
                    <label for="startDate" class="sr-only">
                      Start Date
                    </label>
                    <input id="startDate"
                      @click="togglePopover()"
                      aria-required="true"
                      :aria-invalid="!meta.valid ? true : false"
                      v-bind="field"
                      min="<?php echo date('Y-m-d'); ?>"
                      :value="inputValue"
                      class="cursor-pointer text-input-style"
                      :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                    />
                  </template>
                </v-date-picker>
                <error-message name="startDate">
                  <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Start date is required.</p>
                </error-message>
              </v-field>
            </div>
            <!-- Close Start Date -->

            <!-- Start Time -->
            <div v-if="!event.allDay" class="relative">
              <v-field name="startTime" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.startTime"
                label="startTime"
                rules="required"
                >
                <v-date-picker class="inline-block w-full h-full" 
                  mode="time" 
                  :model-config="{type: 'string', mask: 'h:mm:ss A'}" 
                  :minute-increment="30" 
                  v-model="event.startTime">
                  <template v-slot="{ inputValue, togglePopover }">
                    <label for="startTime" class="sr-only">
                      Start Time
                    </label>
                    <input id="startTime"
                      @click="togglePopover()"
                      aria-required="true"
                      :aria-invalid="!meta.valid ? true : false"
                      v-bind="field"
                      :value="inputValue"
                      class="cursor-pointer text-input-style"
                      :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                    />
                    </template>
                </v-date-picker>
                <error-message name="startTime">
                  <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Start time is required.</p>
                </error-message>
              </v-field>
            </div>
            <!-- Close Start Time -->
          </div>
          <!-- Close Start -->
          
          <!-- End -->
          <div class="grid gap-3 md:grid-cols-2">
            <p class="md:col-span-2">
              End
            </p>
            
            <!-- End Date -->
            <div class="relative" :class="{'md:col-span-2' : event.allDay}">
              <v-field name="endDate" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.endDate"
                label="endDate"
                rules="required"
                >
                <v-date-picker class="inline-block w-full h-full"
                  :model-config="{type: 'string', mask: 'YYYY-MM-DD'}" 
                  v-model="event.endDate">
                  <template v-slot="{ inputValue, togglePopover }">
                    <label for="endDate" class="sr-only">
                      End Date
                    </label>
                    <input id="endDate"
                      @click="togglePopover()"
                      aria-required="true"
                      :aria-invalid="!meta.valid ? true : false"
                      v-bind="field"
                      min="<?php echo date('Y-m-d'); ?>"
                      :value="inputValue"
                      class="cursor-pointer text-input-style"
                      :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                    />
                  </template>
                </v-date-picker>
                <error-message name="endDate">
                  <p class="absolute left-0 text-xs text-orange-500 -bottom-5">End date is required.</p>
                </error-message>
              </v-field>
            </div>
            <!-- Close End Date -->

            <!-- End Time -->
            <div v-if="!event.allDay" class="relative">
              <v-field name="endTime" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.endTime"
                label="endTime"
                rules="required"
                >
                <v-date-picker class="inline-block w-full h-full" 
                  mode="time" 
                  :model-config="{type: 'string', mask: 'h:mm:ss A'}" 
                  :minute-increment="30" 
                  v-model="event.endTime">
                  <template v-slot="{ inputValue, togglePopover }">
                    <label for="endTime" class="sr-only">
                      Start Time
                    </label>
                    <input id="endTime"
                      @click="togglePopover()"
                      aria-required="true"
                      :aria-invalid="!meta.valid ? true : false"
                      v-bind="field"
                      :value="inputValue"
                      class="cursor-pointer text-input-style"
                      :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                    />
                  </template>
                </v-date-picker>
                <error-message name="endTime">
                  <p class="absolute left-0 text-xs text-orange-500 -bottom-5">End time is required.</p>
                </error-message>
              </v-field>
            </div>
            <!-- Close End Time -->
          </div>
          <!-- Close End -->

          <!-- All Day -->
          <div>
            <v-field v-model="event.allDay"
              name="allDay" 
              type="checkbox" 
              label="allDay"
              >

              <!-- Checkbox Input -->
              <input id="allDay"
                v-model="event.allDay"
                type="checkbox" 
                name="allDay"
                class="block before:border-beige-800"
              />

              <!-- Checkbox Label -->
              <label for="allDay"
                class="select-none"
                class="text-gray-500"
                role="checkbox"
                >
                All Day
              </label>
            </v-field>
          </div>

        </div>
        <!-- Close Grid Wrapper -->
        
      </fieldset>
      <!-- Close Date / Time -->
      
      <!-- Photo Upload -->
      <fieldset class="flex flex-col p-12 mb-8 border border-gray-100">
        <v-field name="image" 
          v-model="event.image.filename"
          label="image"
          rules="required"
          >
          <p class="fieldset-title">
            Event Image
          </p>
          <label for="image" class="cursor-pointer w-full px-4 py-2.5 mb-6 rounded-lg text-gray-500 border border-gray-100">
            <span v-if="event.image.filename">{{ event.image.filename }}</span>
            <span v-else>Min image size: 720 X 720 pixel (Sqaure, 1:1 ratio) .jpg or .png, max 2 MB.</span>
          </label>
          <label for="image" class="flex self-start py-3 text-sm font-bold tracking-wider text-white uppercase transition duration-500 rounded-lg cursor-pointer px-7 button-green">
            Choose Image
          </label>

          <input id="image"
            @change="loadFile"
            type="file"
            accept="image/*"
            aria-required="true"
            class="text-input-style"
          />

          <error-message name="image">
            <p class="text-xs text-orange-500">An image is required.</p>
          </error-message>
        </v-field>

        <v-field name="imageString" 
          v-slot="{ value, field, errors, meta }"
          v-model="event.image.value"
          rules="required">

          <input id="imageString"
            type="hidden"
            v-bind="field"
          />
        </v-field>
      </fieldset>
      <!-- Close Photo Upload -->

      <!-- Venue -->
      <fieldset class="p-12 mb-8 border border-gray-100">
          
        <!-- Venue -->
        <div class="relative">
          <p class="fieldset-title">
            Select Venue
          </p><?php

          // Get Venue CPT Args
          $args = [
            'post_type' => 'tribe_venue',
            'order'     => 'ASC',
          ];
          $query = new WP_Query($args);

          if ($query->have_posts()) : ?>
            <v-field name="venuePostId" 
              v-slot="{ value, field, errors, meta }"
              v-model.number="event.venue.venuePostId"
              type="text"
              label="venue"
              rules="required"
              >
              <label for="venue" class="sr-only">
                Select Venue
              </label>
              <select
                id="venue"
                aria-required="true"
                v-bind="field"
                @change="onChangeVenue($event)"
                class="uppercase text-input-style"
                :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                >
                <option selected value="">Select...</option>
                <option value="add-venue">Add Venue</option><?php

                // Loop Through Post Titles
                while ($query->have_posts()) : $query->the_post(); ?>
                  <option
                    value="<?php echo $query->post->ID; ?>">
                    <?php echo $query->post->post_title; ?>
                  </option><?php
                endwhile; ?>

              </select>
              <div v-if="meta.validated && !meta.valid ">
                <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Event venue is required.</p>
              </div>
            </v-field><?php
          endif; ?>
        </div>
        
        <!-- Close Grid Wrapper -->
        <div v-if="showVenueForm" class="grid grid-cols-2 gap-5 mt-7">

          <!-- Venue Name -->
          <div class="col-span-2">
            <p class="fieldset-title">
              Venue Location
            </p>
            <div class="relative">
              <v-field name="venueName" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.venue.venueName"
                type="text"
                label="venueName"
                rules="required"
                >
                <label for="venueName" class="block mb-1" :class="{'text-orange-500' : meta.validated && !meta.valid}">
                  Venue Name
                </label>
                <input id="venueName"
                  aria-required="true"
                  :aria-invalid="!meta.valid ? true : false"
                  v-model="event.venue.venueName"
                  class="text-input-style"
                  :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                />
                <error-message name="venueName">
                  <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Venue Name is required.</p>
                </error-message>
              </v-field>
            </div>
          </div>

          <!-- Venue Address -->
          <div class="col-span-2">
            <div class="relative">
              <v-field name="venueAddress" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.venue.venueAddress"
                type="text"
                label="venueAddress"
                rules="required"
                >
                <label for="venueAddress" class="block mb-1" :class="{'text-orange-500' : meta.validated && !meta.valid}">
                  Address
                </label>
                <input id="venueAddress"
                  aria-required="true"
                  :aria-invalid="!meta.valid ? true : false"
                  v-model="event.venue.venueAddress"
                  class="text-input-style"
                  :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                />
              </v-field>

              <error-message name="venueAddress">
                <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Venue Address is required.</p>
              </error-message>
            </div>
          </div>

          <!-- Venue City -->
          <div class="col-span-2 md:col-span-1">
            <div class="relative">
              <v-field name="venueCity" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.venue.venueCity"
                type="text"
                label="venueCity"
                rules="required"
                >
                <label for="venueCity" class="block mb-1" :class="{'text-orange-500' : meta.validated && !meta.valid}">
                  City
                </label>
                <input id="venueCity"
                  aria-required="true"
                  :aria-invalid="!meta.valid ? true : false"
                  v-model="event.venue.venueCity"
                  class="text-input-style"
                  :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                />

                <error-message name="venueCity">
                  <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Venue City is required.</p>
                </error-message>
              </v-field>
            </div>
          </div>

          <!-- Venue Country -->
          <div class="col-span-2 md:col-span-1">
            <div class="relative">
              <v-field name="venueCountry" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.venue.venueCountry"
                type="text"
                label="venueCountry"
                rules="required"
                >
                <label for="venueCountry" class="block mb-1" :class="{'text-orange-500' : meta.validated && !meta.valid}">
                  Country
                </label>
                <select
                  id="venueCountry"
                  aria-required="true"
                  v-bind="field"
                  v-model="event.venue.venueCountry"
                  class="text-input-style"
                  :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                  >
                  <option value="" selected disabled>Select...</option>
                  <option value="United States">United States</option>
                </select>

                <error-message name="venueCountry">
                  <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Venue Country is required.</p>
                </error-message>
              </v-field>
            </div>
          </div>

          <!-- Venue State -->
          <div class="col-span-2 md:col-span-1">
            <div class="relative">
              <v-field name="venueState" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.venue.venueState"
                type="text"
                label="venueState"
                rules="required"
                >
                <label for="venueState" class="block mb-1" :class="{'text-orange-500' : meta.validated && !meta.valid}">
                  State
                </label>
                <input id="venueState"
                  aria-required="true"
                  :aria-invalid="!meta.valid ? true : false"
                  v-model="event.venue.venueState"
                  class="text-input-style"
                  :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                />
              </v-field>
              <error-message name="venueName">
                <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Venue State is required.</p>
              </error-message>
            </div>
          </div>

          <!-- Venue Zip -->
          <div class="col-span-2 md:col-span-1">
            <div class="relative">
              <v-field name="venueZip" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.venue.venueZip"
                type="text"
                label="venueZip"
                rules="required"
                >
                <label for="venueZip" class="block mb-1" :class="{'text-orange-500' : meta.validated && !meta.valid}">
                  Zip Code or Postal Code
                </label>
                <input id="venueZip"
                  aria-required="true"
                  :aria-invalid="!meta.valid ? true : false"
                  v-model="event.venue.venueZip"
                  class="text-input-style"
                  :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                />
              </v-field>
              <error-message name="venueName">
                <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Venue Zip Code or Postal Code is required.</p>
              </error-message>
            </div>
          </div>

          <!-- Venue Phone -->
          <div class="col-span-2 md:col-span-1">
            <v-field name="venuePhone" 
              v-model="event.venue.venuePhone"
              type="text"
              label="venuePhone"
              >
              <label for="venuePhone" class="block mb-1">
                Phone
              </label>
              <input id="venuePhone"
                v-model="event.venue.venuePhone"
                class="text-input-style"
              />
            </v-field>
          </div>

          <!-- Venue Website -->
          <div class="col-span-2 md:col-span-1">
            <v-field name="venueWebsite" 
              v-model="event.venue.venueWebsite"
              type="text"
              label="venueWebsite"
              >
              <label for="venueWebsite" class="block mb-1">
                Website
              </label>
              <input id="venueWebsite"
                aria-required="false"
                v-model="event.venue.venueWebsite"
                class="text-input-style"
              />
            </v-field>
          </div>

        </div>
        <!-- Close Grid Wrapper -->

      </fieldset>
      <!-- Close Venue -->

      <!-- Organizer -->
      <fieldset class="p-12 mb-8 border border-gray-100">
        
        <p class="fieldset-title">
          Organizer Details
        </p>

        <!-- Grid Wrapper -->
        <div class="grid grid-cols-2 gap-5">
          
          <!-- Organizer Name -->
          <div class="col-span-2">
            <div class="relative">
              <v-field name="organizerName" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.organizer.organizerName"
                type="text"
                label="organizerName"
                rules="required"
                >
                <label for="organizerName" class="block mb-1" :class="{'text-orange-500' : meta.validated && !meta.valid}">
                  Name
                </label>
                <input id="organizerName"
                  aria-required="true"
                  :aria-invalid="!meta.valid ? true : false"
                  v-bind="field"
                  class="text-input-style"
                  :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                />
                <error-message name="organizerName">
                  <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Name is required.</p>
                </error-message>
              </v-field>
            </div>
          </div>

          <!-- Organizer Phone -->
          <div class="col-span-2 md:col-span-1">
            <div class="relative">
              <v-field name="organizerPhone" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.organizer.organizerPhone"
                type="text"
                label="organizerPhone"
                rules="required"
                >
                <label for="organizerPhone" class="block mb-1" :class="{'text-orange-500' : meta.validated && !meta.valid}">
                  Phone
                </label>
                <input id="organizerPhone"
                  aria-required="true"
                  :aria-invalid="!meta.valid ? true : false"
                  v-bind="field"
                  class="text-input-style"
                  :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                />
                <error-message name="organizerPhone">
                  <p class="absolute left-0 text-xs text-orange-500 -bottom-5">Phone is required.</p>
                </error-message>
              </v-field>
            </div>
          </div>

          <!-- Organizer Email -->
          <div class="col-span-2 md:col-span-1">
            <div class="relative">
              <v-field name="organizerEmail" 
                v-slot="{ value, field, errors, meta }"
                v-model="event.organizer.organizerEmail"
                type="text"
                label="organizerEmail"
                rules="required|email"
                >
                <label for="organizerEmail" class="block mb-1" :class="{'text-orange-500' : meta.validated && !meta.valid}">
                  Email
                </label>
                <input id="organizerEmail"
                  aria-required="true"
                  :aria-invalid="!meta.valid ? true : false"
                  v-bind="field"
                  class="text-input-style"
                  :class="meta.validated && !meta.valid ? 'text-input-invalid' : 'text-input-valid'"
                />
                <error-message name="organizerEmail">
                  <p class="absolute left-0 text-xs text-orange-500 -bottom-5">A valid email address is required.</p>
                </error-message>
              </v-field>
            </div>
          </div>

          <!-- Organizer Website -->
          <div class="col-span-2">
            <div class="relative">
              <v-field name="organizerWebsite" 
                v-model="event.organizer.organizerWebsite"
                type="text"
                label="organizerWebsite"
                >
                <label for="organizerWebsite" class="block mb-1">
                  Website
                </label>
                <input id="organizerWebsite"
                  aria-required="false"
                  v-model="event.organizer.organizerWebsite"
                  class="text-input-style"
                />
              </v-field>
            </div>
          </div>

        </div>
        <!-- Close Grid Wrapper -->

      </fieldset>
      <!-- Close Organizer -->

      <!-- Event Website -->
      <fieldset class="p-12 mb-8 border border-gray-100">
        <v-field name="eventWebsite" 
          type="text"
          label="eventWebsite"
          v-model="event.eventWebsite"
          >
          <label for="eventWebsite" class="fieldset-title">
            Event Website
          </label>
          <input id="eventWebsite"
            aria-required="false"
            v-model="event.eventWebsite"
            class="text-input-style text-input-valid"
          />
        </v-field>
      </fieldset>
      <!-- Close Event Website -->

      <!-- Event Cost -->
      <fieldset class="p-12 mb-8 border border-gray-100">
        <p class="fieldset-title">
          Event Cost
        </p>
        <v-field name="eventCost" 
          type="text"
          label="eventCost"
          v-model="event.eventCost"
          >
          <label for="eventCost">
            Leave blank to hide the field. Enter a 0 for events that are free.
          </label>
          <input id="eventCost"
            aria-required="false"
            v-model="event.eventCost"
            placeholder="$"
            class="text-input-style text-input-valid"
          />
        </v-field>
      </fieldset>
      <!-- Close Event Website -->

      <!-- Submit -->
      <button type="submit" @click="clicked = true" class="relative flex items-center justify-center w-full py-3 pr-5 text-sm font-bold tracking-wider text-white uppercase transition duration-500 rounded-lg md:w-auto md:self-start pl-7 group button-green">
        <span class="pl-1 duration-500 ease-in-out translate-x-1.5 group-hover:translate-x-0">
          Submit Event
        </span>
        <?php echo svg(['file' => 'button-arrow']); ?>
        <span v-if="clicked && !meta.valid" class="absolute text-center text-orange-500 md:left-0 md:text-left whitespace-nowrap -bottom-8">Please fill in the required field(s).</span>
      </button>
      <!-- Submit -->

    </v-form>
    <!-- Close Form -->

  </div>
  <!-- Close Container -->

  <!-- WP Nonce -->
  <input type="hidden" :value="security" name="security" />

</section>
<!-- Close Add Event Form -->
