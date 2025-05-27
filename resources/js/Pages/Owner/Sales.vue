<template>
    <Head title="Data Penjualan" />
    <AuthenticatedLayout>
        <div class="flex min-h-screen bg-gray-100">
            <!-- Sidebar -->
            <aside
                :class="[
                    'bg-white shadow-lg flex flex-col items-center pt-6 fixed inset-y-0 left-0 transition-transform z-30',
                    mobileMenuOpen ? 'translate-x-0' : '-translate-x-full',
                    'md:translate-x-0 md:static md:w-24 w-64'
                ]"
            >        
                <nav class="flex flex-col items-center gap-10 mt-8 flex-1">
                    <!-- Dashboard -->
                    <button @click="goToDashboard" class="flex flex-col items-center">
                        <div class="p-3 rounded-md" :class="activeSection==='dashboard' ? 'bg-purple-100 text-purple-700' : 'text-gray-500'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="activeSection==='dashboard' ? 'text-purple-700' : ''">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <span class="text-xs mt-2">Dashboard</span>
                    </button>
                    
                    <!-- Transaksi -->
                    <button @click="goToCashier" class="flex flex-col items-center">
                        <div class="p-3 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <span class="text-xs mt-2">Transaksi</span>
                    </button>
                    
                    <!-- Stok barang -->
                    <button @click="goToStock" class="flex flex-col items-center">
                        <div class="p-3 rounded-md" :class="activeSection==='stock' ? 'bg-purple-100 text-purple-700' : 'text-gray-500'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="activeSection==='stock' ? 'text-purple-700' : 'text-gray-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="text-xs mt-2">Stok barang</span>
                    </button>

                    <!-- Karyawan -->
                    <button @click="goToEmployees" class="flex flex-col items-center">
                        <div class="p-3 rounded-md" :class="activeSection==='employees' ? 'bg-purple-100 text-purple-700' : 'text-gray-500'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="activeSection==='employees' ? 'text-purple-700' : 'text-gray-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <span class="text-xs mt-2">Karyawan</span>
                    </button>
                    
                    <!-- Helpdesk -->
                    <button @click="goToFAQ" class="flex flex-col items-center">
                        <div class="p-3 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-xs mt-2">Helpdesk</span>
                    </button>
                    
                    <!-- Laporan -->
                    <button @click="goToLaporan" class="flex flex-col items-center">
                        <div class="p-3 rounded-md" :class="activeSection==='laporan' ? 'bg-purple-100 text-purple-700' : 'text-gray-500'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="activeSection==='laporan' ? 'text-purple-700' : 'text-gray-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="text-xs mt-2">Laporan</span>
                    </button>
                </nav>
                
                <button @click="logout" class="flex flex-col items-center mt-auto mb-6">
                    <div class="p-3 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <span class="text-xs mt-2">Logout</span>
                </button>
            </aside>

            <!-- Overlay mobile -->
            <div
                v-if="mobileMenuOpen"
                @click="toggleMobileMenu(false)"
                class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden"
            ></div>

            <!-- Main content -->
            <div class="flex-1 md:ml-24">
                <!-- Mobile header -->
                <header class="flex items-center justify-between bg-white p-4 shadow md:hidden">
                    <button @click="toggleMobileMenu()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold">Data Penjualan</h1>
                    <div class="w-8 h-8 rounded-full bg-gray-300"></div>
                </header>

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
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Invoice</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Pembayaran</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Item</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <template v-for="(invoice, index) in sales" :key="invoice.invoice_number">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ invoice.invoice_number }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ invoice.date }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap capitalize">{{ invoice.payment_method }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ invoice.total_items }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ parseInt(invoice.total_amount).toLocaleString('id-ID') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <button 
                                                            @click="toggleInvoiceDetails(invoice.invoice_number)"
                                                            class="text-purple-600 hover:text-purple-900 mr-2"
                                                        >
                                                            {{ expandedInvoices.includes(invoice.invoice_number) ? 'Sembunyikan' : 'Lihat' }}
                                                        </button>
                                                        <button 
                                                            @click="printInvoice(invoice)"
                                                            class="text-blue-600 hover:text-blue-900"
                                                        >
                                                            Cetak
                                                        </button>
                                                    </td>
                                                </tr>
                                                <!-- Expanded Details -->
                                                <tr v-if="expandedInvoices.includes(invoice.invoice_number)">
                                                    <td colspan="7" class="px-6 py-4 bg-gray-50">
                                                        <div class="space-y-2">
                                                            <h4 class="font-semibold">Detail Item:</h4>
                                                            <table class="min-w-full divide-y divide-gray-200">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Produk</th>
                                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Jumlah</th>
                                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Harga</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="item in invoice.items" :key="item.product_name">
                                                                        <td class="px-4 py-2">{{ item.product_name }}</td>
                                                                        <td class="px-4 py-2">{{ item.quantity }}</td>
                                                                        <td class="px-4 py-2">Rp {{ parseInt(item.total_price).toLocaleString('id-ID') }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
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
            </div>
        </div>
    </AuthenticatedLayout>

    <!-- Print Invoice Modal -->
    <div v-if="showPrintModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg max-w-3xl w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Cetak Invoice</h3>
                <button @click="showPrintModal = false" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <InvoicePrint :invoice="selectedInvoice" />
            <div class="mt-4 flex justify-end">
                <button 
                    @click="printSelectedInvoice"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    Cetak
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import InvoicePrint from '@/Pages/Employee/InvoicePrint.vue';

defineProps({
    sales: Array,
    months: Array,
    years: Array
});

const month = ref('');
const year = ref('');
const mobileMenuOpen = ref(false);
const activeSection = ref('laporan');
const expandedInvoices = ref([]);
const showPrintModal = ref(false);
const selectedInvoice = ref(null);

// Navigation functions
const goToDashboard = () => router.get(route('owner.dashboard'));
const goToCashier = () => router.get(route('owner.cashier'));
const goToStock = () => router.get(route('owner.stock'));
const goToEmployees = () => router.get(route('owner.employees'));
const goToFAQ = () => router.get('/helpdeskowner');
const goToLaporan = () => router.get(route('owner.sales'));
const logout = () => router.post(route('logout'));

// Toggle mobile menu
const toggleMobileMenu = (force) => {
    mobileMenuOpen.value = force === false ? false : !mobileMenuOpen.value;
};

// Toggle invoice details
const toggleInvoiceDetails = (invoiceNumber) => {
    const index = expandedInvoices.value.indexOf(invoiceNumber);
    if (index === -1) {
        expandedInvoices.value.push(invoiceNumber);
    } else {
        expandedInvoices.value.splice(index, 1);
    }
};

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

// Print invoice functions
const printInvoice = (invoice) => {
    selectedInvoice.value = {
        ...invoice,
        cashier_name: 'Kasir', // You might want to get this from the backend
        received_amount: invoice.total_amount, // You might want to get this from the backend
        change: 0 // You might want to get this from the backend
    };
    showPrintModal.value = true;
};

const printSelectedInvoice = () => {
    window.print();
};
</script>
