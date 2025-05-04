<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    products: Array
});
</script>

<template>
    <Head title="Daftar Produk" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Produk</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    <h3 class="font-medium text-lg">Daftar Stok Produk</h3>
                    <p class="mb-4">Berikut adalah daftar semua produk yang tersedia.</p>

                    <!-- Link kembali ke stock management -->
                    <Link 
                        :href="route('employee.stock')"
                        class="mb-4 inline-block px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700"
                    >
                        Kembali
                    </Link>

                    <!-- Tabel Produk -->
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead>
    <tr>
        <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Nama Produk</th>
        <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Stok</th>
        <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Harga Rata-rata</th>
        <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Markup (%)</th>
        <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Harga Jual</th>
        <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Kategori</th>
        <th class="py-2 px-4 border-b bg-gray-100 text-left text-sm font-semibold text-gray-700">Unit</th>
    </tr>
</thead>

<tbody>
    <tr v-if="products.length === 0">
        <td colspan="7" class="py-4 px-4 border-b text-center">Tidak ada produk tersedia</td>
    </tr>
    <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50">
        <td class="py-2 px-4 border-b">{{ product.name }}</td>
        <td class="py-2 px-4 border-b">{{ product.stock }}</td>
        <td class="py-2 px-4 border-b">Rp {{ Number(product.average_price).toLocaleString() }}</td>
        <td class="py-2 px-4 border-b">{{ product.markup }}%</td>
        <td class="py-2 px-4 border-b">Rp {{ Number(product.selling_price).toLocaleString() }}</td>
        <td class="py-2 px-4 border-b">{{ product.category || '-' }}</td>
        <td class="py-2 px-4 border-b">{{ product.unit || '-' }}</td>
    </tr>
</tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>