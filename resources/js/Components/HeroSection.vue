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
    
    <!-- GWL Kasir Promotional Section -->
    <div class="mt-24 bg-purple-50 rounded-lg p-8">
      <div class="grid md:grid-cols-2 gap-8 items-center mb-12">
        <div class="order-2 md:order-1">
          <img 
            src="/images/asset.avif" 
            alt="Mengelola usaha dengan Aplikasi Kasir GWL" 
            class="rounded-3xl shadow-lg w-full max-w-md"
            loading="lazy"
          />
        </div>
        <div class="order-1 md:order-2">
          <h3 class="text-3xl font-bold text-stone-900 mb-4">Mengelola usaha lebih mudah dengan Aplikasi Kasir GWL</h3>
          <p class="text-base mb-6">Kami membantu Anda menyajikan data-data penting dari transaksi Anda sehingga Anda bisa membuat keputusan terbaik.</p>
          <a 
            href="/register" 
            class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors duration-200"
          >
            Mulai →
          </a>
        </div>
      </div>
      
      <h3 class="text-3xl font-bold text-center mb-12">GWL Hadir dengan solusi</h3>
      
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div class="space-y-8">
          <!-- Manajemen Pesanan -->
          <div class="flex gap-6 items-start">
            <div class="bg-teal-100 p-4 rounded-full w-16 h-16 flex items-center justify-center flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
              </svg>
            </div>
            <div>
              <h4 class="font-bold text-xl mb-2">Manajemen Pesanan</h4>
              <p class="text-gray-700">Kelola pesanan dengan mudah dan terorganisir. Pantau setiap transaksi, perbarui status pesanan secara real-time.</p>
            </div>
          </div>
          
          <!-- Pembayaran Digital -->
          <div class="flex gap-6 items-start">
            <div class="bg-amber-100 p-4 rounded-full w-16 h-16 flex items-center justify-center flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M12 9v6"></path>
                <path d="M9 12h6"></path>
              </svg>
            </div>
            <div>
              <h4 class="font-bold text-xl mb-2">Pembayaran Digital</h4>
              <p class="text-gray-700">Dukung transaksi tanpa tunai dengan e-wallet dan transfer bank. Proses pembayaran jadi lebih cepat, aman, dan praktis.</p>
            </div>
          </div>
          
          <!-- E-Receipt -->
          <div class="flex gap-6 items-start">
            <div class="bg-pink-100 p-4 rounded-full w-16 h-16 flex items-center justify-center flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2"></path>
                <path d="M1 10h22"></path>
                <path d="M6 14h2"></path>
                <path d="M16 14h2"></path>
                <path d="M10 14h4"></path>
              </svg>
            </div>
            <div>
              <h4 class="font-bold text-xl mb-2">E-Receipt</h4>
              <p class="text-gray-700">Kirim struk digital langsung ke pelanggan melalui email atau WhatsApp.</p>
            </div>
          </div>
        </div>
        
        <!-- Image Section -->
        <div class="flex justify-center">
          <img 
            src="/images/asset2.avif" 
            alt="Staff menggunakan aplikasi Kasir GWL" 
            class="rounded-3xl shadow-lg w-full max-w-md"
            loading="lazy"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "HeroSection",
};
</script>