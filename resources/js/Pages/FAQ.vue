<template>
  <div class="min-h-screen bg-gray-30">
    <NavigationHeader />
    <!-- Main Content -->
    <main class="container mx-auto p-4 pt-40">
      <h2 class="text-2xl font-bold mb-4">FAQs</h2>
      <div class="space-y-4">
        <div
          v-for="(faq, index) in faqs"
          :key="index"
          class="p-4 border rounded cursor-pointer"
          @click="toggleFaq(index)"
        >
          <h3 class="font-semibold flex justify-between items-center">
            {{ faq.question }}
            <svg
              :class="{'transform rotate-180': faq.open, 'transform rotate-0': !faq.open}"
              class="w-5 h-5 transition-transform duration-200"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
            </svg>
          </h3>
          <transition name="fade">
            <p v-if="faq.open" class="mt-2 text-gray-700">
              {{ faq.answer }}
            </p>
          </transition>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-inner py-4">
      <div class="container mx-auto text-center text-sm text-gray-600">
        &copy; 2025 Kasir GWL. All rights reserved.
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from "vue";
import NavigationHeader from "../Components/NavigationHeader.vue";

const faqs = ref([
  {
    question: "Apa itu Aplikasi Kasir?",
    answer:
      "Aplikasi kasir adalah sistem untuk memproses transaksi penjualan, mengelola stok barang, dan membuat laporan penjualan secara otomatis.",
    open: false,
  },
  {
    question: "Bagaimana Cara Kerja Aplikasi Kasir?",
    answer:
      "Sistem kami mengintegrasikan perangkat keras dengan perangkat lunak untuk memproses transaksi secara real-time.",
    open: false,
  },
  {
    question: "Apa Saja Fitur Unggulan dari Aplikasi Kami?",
    answer:
      "Fitur unggulan meliputi manajemen inventaris, laporan penjualan, integrasi berbagai metode pembayaran, dan antarmuka yang user-friendly.",
    open: false,
  },
  {
    question: "Bagaimana Keamanan Data Transaksi Dijaga?",
    answer:
      "Kami menggunakan enkripsi data dan backup berkala untuk menjaga keamanan serta integritas data transaksi.",
    open: false,
  },
]);

const toggleFaq = (index) => {
  faqs.value[index].open = !faqs.value[index].open;
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
