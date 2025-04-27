<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

// Props untuk daftar karyawan
const props = defineProps({
    employees: Array
});

// Form register karyawan
const form = useForm({
    name: '',
    email: '',
    password: '',
    employees_role: 'cashier' // default cashier
});

// Submit form register
const submitForm = () => {
    form.post(route('employees.store'), {
        onSuccess: () => form.reset()
    });
};

// Navigasi ke FAQ
const goToFAQ = () => {
    router.get(route('verificator.helpdesk.faq'));
};

// Navigasi ke Riwayat Penjualan
const goToSales = () => {
    router.get(route('owner.sales'));
};
// Navigasi ke Rekomendasi Penjualan
const goToRecommendation = () => {
    router.get(route('owner.sales.recommendation'));
};

</script>

<template>
    <Head title="Owner Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Owner Dashboard</h2>
        </template>

        <!-- Tombol Navigasi -->
<div class="mt-6 text-center flex justify-center gap-4">
    <button 
        @click="goToFAQ"
        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
        FAQ
    </button>

    <button 
        @click="goToSales"
        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        Penjualan
    </button>

    <button 
        @click="goToRecommendation"
        class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
        Rekomendasi Penjualan
    </button>
</div>

        <!-- Form Tambah Employee -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Karyawan</h3>

                        <form @submit.prevent="submitForm">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input 
                                        id="name"
                                        v-model="form.name" 
                                        type="text" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    >
                                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input 
                                        id="email"
                                        v-model="form.email" 
                                        type="email" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    >
                                    <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                    <input 
                                        id="password"
                                        v-model="form.password" 
                                        type="password" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    >
                                    <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</div>
                                </div>

                                <div>
                                    <label for="employees_role" class="block text-sm font-medium text-gray-700">Role</label>
                                    <select 
                                        id="employees_role"
                                        v-model="form.employees_role"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                        <option value="cashier">Cashier</option>
                                        <option value="stock">Stock Admin</option>
                                    </select>
                                    <div v-if="form.errors.employees_role" class="text-red-500 text-sm mt-1">{{ form.errors.employees_role }}</div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button 
                                    type="submit" 
                                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :disabled="form.processing"
                                >
                                    Tambah Karyawan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Karyawan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Karyawan</h3>

                        <div v-if="employees && employees.length > 0">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="employee in employees" :key="employee.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ employee.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ employee.email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap capitalize">{{ employee.employees_role }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ employee.created_at }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button 
                                                @click="$inertia.delete(route('employees.destroy', employee.id))"
                                                class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Yakin ingin menghapus karyawan ini?')"
                                            >
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else class="text-gray-500">
                            Belum ada karyawan terdaftar.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
