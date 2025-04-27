<template>
    <div class="flex overflow-hidden flex-col items-center px-20 pt-7 pb-32 bg-white max-md:px-5 max-md:pb-24">
      <NavigationHeader />
      <HeroSection />
      <FeaturesSection />
    </div>
  </template>
  
  <script>
  import NavigationHeader from "../Components/NavigationHeader.vue";
  import HeroSection from "../Components/HeroSection.vue";
  import FeaturesSection from "../Components/FeaturesSection.vue";
  
  export default {
    name: "Welcome",
    components: {
      NavigationHeader,
      HeroSection,
      FeaturesSection,
    },
  };
  </script>
  