<template>
  <section class="container mx-auto px-4 py-16">
    <h2 class="mb-12 text-4xl font-bold text-center text-stone-900">
      Dengan fitur unggulan
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div
        v-for="feature in features"
        :key="feature.title"
        class="flex flex-col items-center p-6 border rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200"
      >
        <img
          :src="feature.icon"
          :alt="feature.title + ' icon'"
          class="w-16 h-16 mb-4 object-contain"
          loading="lazy"
        />
        <p class="text-lg font-semibold text-neutral-700 text-center">
          {{ feature.title }}
        </p>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "FeaturesSection",
  data() {
    return {
      features: [
        {
          title: "Multi toko",
          icon:
            "https://cdn.builder.io/api/v1/image/assets/TEMP/6b3bb5086b44ceb3501b71d377a74734e5490583e32d9b7a73c2c9f545b7f38e?placeholderIfAbsent=true",
        },
        {
          title: "Promo & diskon otomatis",
          icon:
            "images/discount.png", 
        },
        {
          title: "Pemantauan stok real-time",
          icon:
            "images/real-time.png", // Ganti dengan URL icon yang sesuai
        },
      ],
    };
  },
};
</script>
