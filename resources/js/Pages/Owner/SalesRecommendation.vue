<template>
  <Head title="Rekomendasi Penjualan" />
  <AuthenticatedLayout>
      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rekomendasi Penjualan</h2>
      </template>

      <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 bg-white border-b border-gray-200">
                      <h3 class="text-lg font-bold mb-4">Produk Terlaris</h3>

                      <!-- Filter Form -->
                      <div class="mb-4 flex space-x-4">
                          <select v-model="month" @change="filterData" class="px-4 py-2 border rounded">
                              <option value="">Pilih Bulan</option>
                              <option v-for="m in months" :key="m" :value="m">{{ m }}</option>
                          </select>
                          <select v-model="year" @change="filterData" class="px-4 py-2 border rounded">
                              <option value="">Pilih Tahun</option>
                              <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
                          </select>
                          <button @click="downloadCSV" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Download CSV</button>
                      </div>

                      <!-- Data Table -->
                      <div v-if="sales.length > 0">
                          <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                  <tr>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Kuantitas</th>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Penjualan</th>
                                  </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                  <tr v-for="(item, index) in sales" :key="item.product_name">
                                      <td class="px-6 py-4">{{ index + 1 }}</td>
                                      <td class="px-6 py-4">{{ item.product_name }}</td>
                                      <td class="px-6 py-4">{{ item.total_quantity }}</td>
                                      <td class="px-6 py-4">Rp {{ parseInt(item.total_sales).toLocaleString('id-ID') }}</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                      <div v-else class="text-gray-500">
                          Tidak ada data penjualan.
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
  sales: Array,
  months: Array,
  years: Array
});

const month = ref('');
const year = ref('');

// Ambil query string saat mount
onMounted(() => {
  const url = new URL(window.location.href);
  const currentMonth = url.searchParams.get('month');
  const currentYear = url.searchParams.get('year');
  if (currentMonth) month.value = currentMonth;
  if (currentYear) year.value = currentYear;
});

// Filter data
const filterData = () => {
  const url = new URL(window.location.href);
  if (month.value) {
      url.searchParams.set('month', month.value);
  } else {
      url.searchParams.delete('month');
  }
  if (year.value) {
      url.searchParams.set('year', year.value);
  } else {
      url.searchParams.delete('year');
  }
  window.location.href = url.toString();
};

// Unduh CSV
const downloadCSV = () => {
  const url = new URL('/sales-recommendation/export', window.location.origin);
  if (month.value) url.searchParams.append('month', month.value);
  if (year.value) url.searchParams.append('year', year.value);
  window.location.href = url.toString();
};
</script>
