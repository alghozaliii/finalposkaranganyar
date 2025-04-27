<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Ambil props dari backend
defineProps({
    addProductRoute: String,
    listProductsRoute: String // Tambahkan props baru untuk route daftar produk
});
</script>

<template>
    <Head title="Stock Management" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock Management</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    <h3 class="font-medium text-lg">Manage Stock</h3>
                    <p>Manage your stock items here.</p>

                    <!-- Debug: Cek apakah props diterima -->
                    <p v-if="addProductRoute" class="text-green-500">Route: {{ addProductRoute }}</p>
                    <p v-else class="text-red-500">Route belum diterima!</p>

                    <div class="flex space-x-4 mt-4">
                        <!-- Tombol Tambah Produk -->
                        <Link 
                            v-if="addProductRoute"
                            :href="addProductRoute"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700"
                        >
                            Tambah Produkoto
                        </Link>

                        <!-- Tombol Lihat Produk -->
                        <Link 
                            v-if="listProductsRoute"
                            :href="listProductsRoute"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-700"
                        >
                            Lihat Produk
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>