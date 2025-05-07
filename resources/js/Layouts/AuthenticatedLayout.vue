<script setup>
import { ref, computed } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const page = usePage();

const storeName = computed(() => {
  const user = page.props.auth.user;

  if (user.role_id === 2 && user.store_name) {
    return user.store_name;
  }

  if (user.role_id === 3 && user.store_name) {
    return user.store_name;
  }

  if (page.props.store_name) {
    return page.props.store_name;
  }

  return 'Dashboard';
});
</script>

<template>
  <div>
    <div class="bg-gray-100">
      <!-- Navigation Bar -->
      <nav class="border-b border-black bg-black">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-16 justify-between">
            <div class="flex">
              <!-- Logo -->
              <div class="flex shrink-0 items-center">
                <Link :href="route('dashboard')" class="block">
                  <div class="shrink-0 h-10 w-24 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/30 via-purple-600/30 to-violet-600/30 rounded-lg blur-xl animate-pulse"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-10 h-10 bg-gradient-to-br from-violet-700/40 to-indigo-600/40 rounded-full blur-md"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
                      <span class="text-3xl font-extrabold tracking-widest inline-block bg-clip-text text-transparent bg-gradient-to-r from-violet-400 via-gray-700 to-purple-500 drop-shadow-lg">
                        GWL
                      </span>
                    </div>
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-14 h-0.5 bg-gradient-to-r from-violet-500 to-indigo-500"></div>
                    <div class="absolute top-0 left-0 w-full h-full">
                      <div class="absolute top-1 left-2 w-1 h-1 rounded-full bg-purple-300 animate-ping"></div>
                      <div class="absolute top-2 right-3 w-1 h-1 rounded-full bg-indigo-300 animate-ping" style="animation-delay: 0.5s"></div>
                      <div class="absolute bottom-1 left-4 w-1 h-1 rounded-full bg-violet-300 animate-ping" style="animation-delay: 1s"></div>
                    </div>
                  </div>
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex text-white">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                  {{ storeName }}
                </NavLink>
              </div>
            </div>

            <div class="hidden sm:ms-6 sm:flex sm:items-center">
              <!-- Settings Dropdown -->
              <div class="relative ms-3">
                <Dropdown align="right" width="48">
                  <template #trigger>
                    <span class="inline-flex items-center rounded-md">
                      <button
                        type="button"
                        class="inline-flex items-center rounded-md border border-transparent bg-black px-3 py-2 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out hover:text-gray-300 focus:outline-none"

                      >
                        <span class="mr-2">{{ $page.props.auth.user.name }}</span>
                        <div class="h-8 w-8 rounded-full overflow-hidden border-2 border-indigo-200 flex-shrink-0">
                          <img src="/images/profile.png" alt="Profile" class="h-full w-full object-cover" />
                        </div>
                        <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                      </button>
                    </span>
                  </template>
                  <template #content>
                    <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                    <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                  </template>
                </Dropdown>
              </div>
            </div>

            <!-- Hamburger (mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
              <button
                @click="showingNavigationDropdown = !showingNavigationDropdown"
                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
              >
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                  <path :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  <path :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
          <div class="space-y-1 pb-3 pt-2">
            <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
              {{ storeName }}
            </ResponsiveNavLink>
          </div>
          <div class="border-t border-gray-200 pb-1 pt-4">
            <div class="px-4 flex items-center">
              <div class="h-10 w-10 rounded-full overflow-hidden border-2 border-indigo-200 mr-3">
                <img src="/profile.png" alt="Profile" class="h-full w-full object-cover" />
              </div>
              <div>
                <div class="text-base font-medium text-gray-800">{{ $page.props.auth.user.name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ $page.props.auth.user.email }}</div>
              </div>
            </div>
            <div class="mt-3 space-y-1">
              <ResponsiveNavLink :href="route('profile.edit')">Profile</ResponsiveNavLink>
              <ResponsiveNavLink :href="route('logout')" method="post" as="button">Log Out</ResponsiveNavLink>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header class="bg-white shadow" v-if="$slots.header">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
