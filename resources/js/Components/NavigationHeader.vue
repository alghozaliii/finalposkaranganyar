<template>
  <nav class="w-full bg-white shadow-md fixed top-0 left-0 z-50">
    <div class="max-w-[1180px] mx-auto px-4 py-4 flex items-center justify-between">
      <!-- Logo -->
      <h1 class="text-4xl font-bold text-stone-900">
        GWL
      </h1>

      <!-- Desktop Menu -->
      <div class="hidden md:flex gap-10 items-center text-base font-medium">
        <a href="/" class="text-lg text-black">Home</a>
        <a href="/faq" class="hover:text-black">FAQ</a>
        <a href="/blog" class="hover:text-black">Blog</a>
        <a href="/Aboutus" class="hover:text-black">About Us</a>
      </div>
      <div class="hidden md:flex gap-5 items-center">
        <a href="/login" class="text-neutral-400 hover:text-black">Login</a>
        <a href="/register" class="px-2.5 py-3 text-gray-50 bg-violet-400 rounded-xl hover:bg-violet-500">
          Sign Up
        </a>
      </div>

      <!-- Mobile Menu Toggle -->
      <button
        @click="toggleMobileMenu"
        class="md:hidden text-neutral-400 hover:text-black focus:outline-none"
      >
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <template v-if="!isMobileMenuOpen">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </template>
          <template v-else>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </template>
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div v-if="isMobileMenuOpen" class="md:hidden bg-white shadow-md">
      <div class="px-4 py-4 flex flex-col gap-4">
        <a href="/" class="text-lg text-black">Home</a>
        <a href="/FAQ" class="hover:text-black">FAQ</a>
        <a href="/blog" class="hover:text-black">Blog</a>
        <a href="/Aboutus" class="hover:text-black">About Us</a>
        <div class="flex flex-col gap-2">
          <a href="/login" class="text-neutral-400 hover:text-black text-left">Login</a>
          <a href="/register" class="px-2.5 py-3 text-gray-50 bg-violet-400 rounded-xl hover:bg-violet-500 text-left">
            Sign Up
          </a>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "NavigationHeader",
  data() {
    return {
      isMobileMenuOpen: false,
    };
  },
  methods: {
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen;
    },
  },
};
</script>