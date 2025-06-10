<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    stockHistories: {
        type: Array,
        default: () => []
    },
    products: { // Pass products data for display names
        type: Array,
        default: () => []
    }
});

const itemsPerPage = ref(10);
const currentPage = ref(1);

const productMap = computed(() => {
    return props.products.reduce((map, product) => {
        map[product.id] = product.name;
        return map;
    }, {});
});

const displayedHistories = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return props.stockHistories.slice(start, end);
});

const totalPages = computed(() => Math.ceil(props.stockHistories.length / itemsPerPage.value));

const paginationNumbers = computed(() => {
    const pages = [];
    const maxVisiblePages = 5;
    
    if (totalPages.value <= maxVisiblePages) {
        for (let i = 1; i <= totalPages.value; i++) {
            pages.push(i);
        }
    } else {
        let startPage = Math.max(1, currentPage.value - 2);
        let endPage = Math.min(totalPages.value, startPage + maxVisiblePages - 1);
        
        if (endPage - startPage < maxVisiblePages - 1) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        for (let i = startPage; i <= endPage; i++) {
            pages.push(i);
        }
    }
    return pages;
});

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const formatDateTime = (datetime) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(datetime).toLocaleDateString('id-ID', options);
};

const getTypeName = (type) => {
    switch (type) {
        case 'initial': return 'Stok Awal';
        case 'add': return 'Penambahan Stok';
        case 'deduct': return 'Pengurangan Stok';
        case 'edit': return 'Penyesuaian Stok';
        default: return type;
    }
};

const getAmountClass = (amount) => {
    if (amount > 0) return 'text-green-600 font-semibold';
    if (amount < 0) return 'text-red-600 font-semibold';
    return '';
};
</script>

<template>
    <Head title="Riwayat Stok Produk" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Stok Produk</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <Link :href="route('employee.stock')" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">
                            Kembali ke Manajemen Stok
                        </Link>
                        <div class="showing flex items-center gap-2">
                            Menampilkan
                            <select v-model="itemsPerPage" class="page-select border rounded-md p-1">
                                <option :value="5">5</option>
                                <option :value="10">10</option>
                                <option :value="25">25</option>
                                <option :value="50">50</option>
                            </select>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Tanggal & Waktu</th>
                                    <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Nama Produk</th>
                                    <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Stok Lama</th>
                                    <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Stok Baru</th>
                                    <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Perubahan</th>
                                    <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Jenis Perubahan</th>
                                    <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="displayedHistories.length === 0">
                                    <td colspan="7" class="py-4 px-4 border-b text-center">Tidak ada riwayat stok tersedia</td>
                                </tr>
                                <tr v-for="history in displayedHistories" :key="history.id" class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">{{ formatDateTime(history.created_at) }}</td>
                                    <td class="py-2 px-4 border-b">{{ productMap[history.product_id] || 'Produk Tidak Ditemukan' }}</td>
                                    <td class="py-2 px-4 border-b">{{ history.old_stock }}</td>
                                    <td class="py-2 px-4 border-b">{{ history.new_stock }}</td>
                                    <td class="py-2 px-4 border-b" :class="getAmountClass(history.change_amount)">
                                        {{ history.change_amount > 0 ? '+' : '' }}{{ history.change_amount }}
                                    </td>
                                    <td class="py-2 px-4 border-b">{{ getTypeName(history.type) }}</td>
                                    <td class="py-2 px-4 border-b">{{ history.notes || '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination flex justify-between items-center mt-4">
                        <div class="pagination-info text-gray-600">
                            {{ currentPage }} dari {{ totalPages }}
                        </div>
                        <div class="pagination-controls flex gap-1">
                            <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" class="px-3 py-1 border rounded-md bg-white hover:bg-gray-100">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button 
                                v-for="page in paginationNumbers" 
                                :key="page" 
                                @click="goToPage(page)"
                                :class="{ 'bg-blue-500 text-white': currentPage === page, 'bg-white hover:bg-gray-100': currentPage !== page }"
                                class="px-3 py-1 border rounded-md"
                            >
                                {{ page }}
                            </button>
                            <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" class="px-3 py-1 border rounded-md bg-white hover:bg-gray-100">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

.pagination-controls button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.page-select {
    min-width: 60px;
}
</style> 