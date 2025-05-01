<template>
  <section class="container mx-auto mt-28 px-4 max-w-[1216px] md:mt-20">
    <div class="grid md:grid-cols-2 gap-8 items-center">
      <!-- Konten Teks & Gambar Dekoratif -->
      <article class="flex flex-col">
        <h2 class="text-7xl font-bold text-stone-900 leading-[90px] md:text-7xl md:leading-[90px] max-md:text-4xl max-md:leading-[50px]">
          Kelola Usaha dengan Mudah &amp; Efisien
        </h2>
        <img
          src="https://cdn.builder.io/api/v1/image/assets/TEMP/76128d35b475ba2ffa1cd2ab383f61891b58e89390c400f91ff878e5bdf7b644?placeholderIfAbsent=true"
          alt="Elemen dekoratif"
          class="mt-7 object-contain w-full max-w-[487px] mx-auto"
          loading="lazy"
        />
        <p class="mt-12 text-lg font-medium leading-8 text-black md:mr-10 max-md:mr-0">
          Optimalkan penjualan, kelola stok, dan pantau transaksi kapan saja,
          di mana saja dengan sistem POS (Point of Sale) berbasis cloud yang
          canggih dan mudah digunakan.
        </p>
      </article>

      <!-- Ilustrasi Hero -->
      <div>
        <img
          src="https://cdn.builder.io/api/v1/image/assets/TEMP/72d3bde6ce7bcc7b6ca9d727484cce51c0ac55fb0ccebfd9cd92b423be77622c?placeholderIfAbsent=true"
          alt="Ilustrasi Hero"
          class="object-contain w-full"
          loading="lazy"
        />
      </div>
    </div>

    <!-- Tombol CTA -->
    <div class="mt-8">
      <a 
        href="/pos-guide" 
        class="flex items-center gap-3.5 text-lg font-medium text-stone-900 bg-transparent border border-stone-900 px-4 py-2 rounded hover:bg-stone-900 hover:text-white transition-colors duration-200 inline-block"
      >
        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-stone-900 text-white">
          ▶
        </span>
        <span>View Demo</span>
      </a>
    </div>
  </section>
</template>

<script>
export default {
  name: "HeroSection",
};
</script>