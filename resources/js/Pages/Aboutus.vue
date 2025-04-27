<template>
    <div class="min-h-screen bg-gray-50">
        <NavigationHeader />
  
      <!-- Main Content -->
      <main class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">About Us</h2>
        <div class="bg-white border rounded shadow p-4">
          <p class="mb-4">
            Kami adalah perusahaan teknologi yang menyediakan solusi POS inovatif untuk mempermudah operasional bisnis Anda. Dengan pengalaman bertahun-tahun, kami berkomitmen memberikan layanan dan dukungan terbaik.
          </p>
          <h3 class="font-semibold mb-2">Visi Kami</h3>
          <p class="mb-4">
            Menjadi penyedia solusi POS terdepan yang membantu bisnis tumbuh secara efisien dan efektif.
          </p>
          <h3 class="font-semibold mb-2">Misi Kami</h3>
          <ul class="list-disc list-inside">
            <li>Inovasi berkelanjutan untuk fitur-fitur terbaru.</li>
            <li>Peningkatan layanan pelanggan 24/7.</li>
            <li>Keamanan data dan integritas transaksi yang tinggi.</li>
            <li>Integrasi mudah dengan sistem lainnya.</li>
          </ul>
        </div>
      </main>
  
      <!-- Footer -->
      <footer class="bg-white shadow p-4 mt-8">
        <div class="container mx-auto text-center text-sm text-gray-600">
          &copy; 2023 Aplikasi Kasir. All rights reserved.
        </div>
      </footer>
    </div>
  </template>
  
  <script setup>
 import NavigationHeader from "../Components/NavigationHeader.vue";
  </script>
  