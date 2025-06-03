<template>
  <div class="min-h-screen bg-gray-50">
    <NavigationHeader />

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-purple-600 to-indigo-700 text-white py-16 md:py-24">
      <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
          <h1 class="text-3xl md:text-5xl font-bold mb-4">Solusi POS Modern untuk Bisnis Anda</h1>
          <p class="text-lg md:text-xl text-purple-100">Membantu bisnis Anda berkembang dengan sistem manajemen yang efisien dan mudah digunakan</p>
        </div>
      </div>
      <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-gray-50"></div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
      <!-- Vision & Mission Cards -->
      <div class="grid md:grid-cols-2 gap-8 mb-16">
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
          <div class="flex items-center mb-4">
            <div class="p-2 bg-purple-100 rounded-lg">
              <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold ml-4">Visi Kami</h3>
          </div>
          <p class="text-gray-600 leading-relaxed">
            Menjadi penyedia solusi POS terdepan yang membantu bisnis tumbuh secara efisien dan efektif, menciptakan ekosistem retail yang terintegrasi dan modern.
          </p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
          <div class="flex items-center mb-4">
            <div class="p-2 bg-purple-100 rounded-lg">
              <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <h3 class="text-xl font-bold ml-4">Misi Kami</h3>
          </div>
          <ul class="text-gray-600 space-y-2">
            <li class="flex items-center">
              <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Inovasi berkelanjutan untuk fitur-fitur terbaru
            </li>
            <li class="flex items-center">
              <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Peningkatan layanan pelanggan 24/7
            </li>
            <li class="flex items-center">
              <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Keamanan data dan integritas transaksi yang tinggi
            </li>
          </ul>
        </div>
      </div>

      <!-- Values Section -->
      <div class="mb-16">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-12">Nilai-Nilai Kami</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="text-center">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
              </svg>
            </div>
            <h3 class="font-semibold mb-2">Komunikasi</h3>
            <p class="text-gray-600">Komunikasi yang jelas dan transparan dengan pelanggan</p>
          </div>
          <div class="text-center">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
              </svg>
            </div>
            <h3 class="font-semibold mb-2">Inovasi</h3>
            <p class="text-gray-600">Selalu menghadirkan solusi terbaru dan terbaik untuk pelanggan</p>
          </div>
          <div class="text-center">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
              </svg>
            </div>
            <h3 class="font-semibold mb-2">Keamanan</h3>
            <p class="text-gray-600">Menjaga keamanan data dan transaksi pelanggan dengan standar tertinggi</p>
          </div>
          <div class="text-center">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
              </svg>
            </div>
            <h3 class="font-semibold mb-2">Kolaborasi</h3>
            <p class="text-gray-600">Bekerja sama dengan pelanggan dan mitra untuk mencapai tujuan bersama</p>
          </div>
        </div>
      </div>

      <!-- Stats Section -->
      <div class="bg-white rounded-xl shadow-md p-8 mb-16">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
          <div>
            <div class="text-4xl font-bold text-purple-600 mb-2">500+</div>
            <div class="text-gray-600">Pelanggan Aktif</div>
          </div>
          <div>
            <div class="text-4xl font-bold text-purple-600 mb-2">24/7</div>
            <div class="text-gray-600">Dukungan Teknis</div>
          </div>
          <div>
            <div class="text-4xl font-bold text-purple-600 mb-2">99.9%</div>
            <div class="text-gray-600">Uptime</div>
          </div>
          <div>
            <div class="text-4xl font-bold text-purple-600 mb-2">5★</div>
            <div class="text-gray-600">Rating Pelanggan</div>
          </div>
        </div>
      </div>
    </main>

    <!-- Contact Section -->
    <div class="bg-gray-100 py-12">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-8">Hubungi Kami</h2>
        <div class="inline-flex space-x-4">
          <a href="#" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">
            Mulai Sekarang
          </a>
          <a href="#" class="bg-white text-purple-600 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors">
            Pelajari Lebih Lanjut
          </a>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white shadow py-8">
      <div class="container mx-auto px-4">
        <div class="text-center text-gray-600">
          <p>&copy; 2023 Aplikasi Kasir. All rights reserved.</p>
          <div class="mt-4 space-x-4">
            <a href="#" class="text-gray-400 hover:text-gray-600">Privacy Policy</a>
            <a href="#" class="text-gray-400 hover:text-gray-600">Terms of Service</a>
            <a href="#" class="text-gray-400 hover:text-gray-600">Contact</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import NavigationHeader from "../Components/NavigationHeader.vue";
</script>

<style scoped>
.gradient-mask {
  mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
  -webkit-mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
}
</style>
