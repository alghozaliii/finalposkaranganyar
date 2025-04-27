<template>
    <div class="min-h-screen bg-gray-50">
        <NavigationHeader />
  
      <!-- Main Content -->
      <main class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Blog</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <article class="bg-white border rounded shadow p-4">
            <h3 class="text-xl font-semibold mb-2">Manfaat Aplikasi Kasir untuk UMKM</h3>
            <p class="text-sm text-gray-600 mb-2">By Admin | 20 Maret 2023</p>
            <p class="text-gray-700">
              Aplikasi kasir dapat meningkatkan efisiensi transaksi serta membantu mengelola inventaris dengan lebih baik. Pelajari lebih lanjut mengenai manfaatnya...
            </p>
            <a href="#" class="text-blue-500 hover:underline text-sm">Baca Selengkapnya</a>
          </article>
          <article class="bg-white border rounded shadow p-4">
            <h3 class="text-xl font-semibold mb-2">Tips Memaksimalkan Penjualan dengan POS Modern</h3>
            <p class="text-sm text-gray-600 mb-2">By Admin | 15 Maret 2023</p>
            <p class="text-gray-700">
              POS modern memberikan solusi terintegrasi untuk penjualan dan inventaris. Berikut beberapa tips untuk memaksimalkan penggunaan sistem POS dalam bisnis Anda...
            </p>
            <a href="#" class="text-blue-500 hover:underline text-sm">Baca Selengkapnya</a>
          </article>
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
  