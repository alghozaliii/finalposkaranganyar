<template>
    <Head title="Data Penjualan" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Penjualan</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-bold mb-4">Riwayat Transaksi</h3>

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
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Pembayaran</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(item, index) in sales" :key="item.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ item.product_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ item.quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ parseInt(item.total_price).toLocaleString('id-ID') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap capitalize">{{ item.payment_method }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ item.created_at }}</td>
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

// Ambil query string saat komponen dimount
onMounted(() => {
    const url = new URL(window.location.href);
    const currentMonth = url.searchParams.get('month');
    const currentYear = url.searchParams.get('year');
    if (currentMonth) month.value = currentMonth;
    if (currentYear) year.value = currentYear;
});

// Filter Data berdasarkan bulan dan tahun
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

// Fungsi untuk mengunduh CSV berdasarkan bulan dan tahun yang dipilih
const downloadCSV = () => {
    const url = new URL('/sales/export', window.location.origin);
    if (month.value) url.searchParams.append('month', month.value);
    if (year.value) url.searchParams.append('year', year.value);

    // Redirect untuk mengunduh file CSV
    window.location.href = url.toString();
};
</script>
