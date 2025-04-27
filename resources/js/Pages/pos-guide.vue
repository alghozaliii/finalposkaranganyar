<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-200 p-4 md:p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden">
      <!-- Header -->
      <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 md:p-8">
        <h1 class="text-3xl md:text-4xl font-bold text-center text-white mb-2">
          Panduan Penggunaan Aplikasi POS
        </h1>
        <p class="text-indigo-100 text-center">
          Sistem point-of-sale yang mudah digunakan untuk mengelola bisnis Anda
        </p>
      </div>

      <!-- Content -->
      <div class="p-4 md:p-8">
        <div class="space-y-4">
          <div
            v-for="(step, index) in steps"
            :key="index"
            :class="['step-container', `step-container-${index}`]"
          >
            <div class="rounded-xl shadow-md overflow-hidden cursor-pointer hover-effect">
              <!-- Header step -->
              <div 
                :class="['step-header', step.colorClass]"
                @click="toggleStep(index)"
              >
                <div class="flex items-center space-x-3">
                  <div class="icon-container">
                    <!-- Emojis instead of icons -->
                    <span v-if="index === 0" class="emoji">🔵</span>
                    <span v-if="index === 1" class="emoji">🟢</span>
                    <span v-if="index === 2" class="emoji">🟡</span>
                    <span v-if="index === 3" class="emoji">🔴</span>
                  </div>
                  <h2 class="text-xl font-semibold">Alur {{ index + 1 }}: {{ step.title }}</h2>
                </div>
                <div class="arrow" :class="activeStep === index ? 'arrow-up' : 'arrow-down'">
                  {{ activeStep === index ? '▲' : '▼' }}
                </div>
              </div>
              
              <!-- Content step -->
              <div 
                class="step-content"
                :class="activeStep === index ? 'step-content-active' : ''"
              >
                <ul class="step-items">
                  <li 
                    v-for="(item, itemIndex) in step.items"
                    :key="itemIndex"
                    :class="['step-item', `step-item-${itemIndex}`, activeStep === index ? 'step-item-active' : '']"
                  >
                    <div :class="['step-dot', step.colorClass]"></div>
                    <span class="text-gray-700">{{ item }}</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Footer -->
      <div class="bg-gray-50 p-4 text-center text-gray-500 text-sm border-t">
        Klik setiap alur untuk melihat detail langkah-langkahnya
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AlurPenggunaanPOS',
  data() {
    return {
      activeStep: null,
      steps: [
        {
          title: "Setup Awal",
          colorClass: "bg-blue-500",
          items: [
            "Daftar akun sebagai Pemilik Usaha.",
            "Data diverifikasi oleh Verifikator.",
            "Buat profil Usaha/Toko (bisa lebih dari satu).",
            "Tambah pekerja (Kasir & Admin Stok).",
            "Buat kategori produk atau jasa.",
            "Input produk/jasa lengkap dengan detailnya."
          ]
        },
        {
          title: "Proses Penjualan",
          colorClass: "bg-green-500",
          items: [
            "Admin Stok input persediaan barang.",
            "Barang ready tampil di Dashboard Kasir.",
            "Pelanggan pilih barang/jasa dari katalog atau menu.",
            "Kasir input pesanan pelanggan ke sistem.",
            "Nota pembelian dicetak dan diberikan ke pelanggan.",
            "Stok otomatis berkurang setelah pembayaran."
          ]
        },
        {
          title: "Monitoring Usaha",
          colorClass: "bg-yellow-500",
          items: [
            "Lihat rekap transaksi harian/mingguan/bulanan.",
            "Monitor stok barang secara real-time.",
            "Analisa produk terlaris dan tren penjualan."
          ]
        },
        {
          title: "Bantuan & Perbaikan",
          colorClass: "bg-red-500",
          items: [
            "Hubungi Helpdesk jika ada masalah.",
            "Admin Sistem siap bantu perbaikan data & fitur."
          ]
        }
      ]
    };
  },
  methods: {
    toggleStep(stepIndex) {
      this.activeStep = this.activeStep === stepIndex ? null : stepIndex;
    }
  }
};
</script>

<style scoped>
/* Base Styles */
.bg-blue-500 { background-color: #3b82f6; }
.bg-green-500 { background-color: #10b981; }
.bg-yellow-500 { background-color: #f59e0b; }
.bg-red-500 { background-color: #ef4444; }
.text-gray-700 { color: #374151; }
.text-white { color: white; }
.text-indigo-100 { color: #e0e7ff; }

/* Animation & Transitions */
.step-container {
  transform: translateX(80px);
  opacity: 0;
  animation: slideIn 0.5s forwards;
}

.step-container-0 { animation-delay: 0s; }
.step-container-1 { animation-delay: 0.3s; }
.step-container-2 { animation-delay: 0.6s; }
.step-container-3 { animation-delay: 0.9s; }

@keyframes slideIn {
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

.hover-effect {
  transition: transform 0.3s, box-shadow 0.3s;
}

.hover-effect:hover {
  transform: scale(1.01);
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Step Header */
.step-header {
  color: white;
  padding: 1rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.icon-container {
  background-color: rgba(255, 255, 255, 0.2);
  padding: 0.5rem;
  border-radius: 9999px;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.emoji {
  font-size: 18px;
}

.arrow {
  transition: transform 0.3s;
}

.arrow-up {
  transform: rotate(0deg);
}

.arrow-down {
  transform: rotate(0deg);
}

/* Step Content */
.step-content {
  background-color: white;
  padding: 0;
  max-height: 0;
  overflow: hidden;
  transition: all 0.5s;
}

.step-content-active {
  padding: 1rem;
  max-height: 24rem;
}

.step-items {
  margin: 0;
  padding: 0;
  list-style-type: none;
}

.step-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.75rem;
  opacity: 0;
  transform: translateX(2rem);
  transition: opacity 0.3s, transform 0.3s;
}

.step-item-active {
  opacity: 1;
  transform: translateX(0);
}

.step-item-0 { transition-delay: 0ms; }
.step-item-1 { transition-delay: 100ms; }
.step-item-2 { transition-delay: 200ms; }
.step-item-3 { transition-delay: 300ms; }
.step-item-4 { transition-delay: 400ms; }
.step-item-5 { transition-delay: 500ms; }

.step-dot {
  width: 0.5rem;
  height: 0.5rem;
  border-radius: 9999px;
}

/* Responsive Design */
@media (max-width: 768px) {
  .text-3xl { font-size: 1.875rem; }
  .text-4xl { font-size: 2.25rem; }
  .p-8 { padding: 1rem; }
}
</style>