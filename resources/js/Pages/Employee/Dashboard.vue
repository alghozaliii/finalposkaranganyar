<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    owner: Object
});
</script>

<template>
    <Head title="Employee Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employee Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    <h3 class="font-medium text-lg mb-4">Welcome to your dashboard!</h3>
                    <p class="mb-4">You are an employee of: <span class="font-semibold">{{ owner?.name || 'Unknown Owner' }}</span></p>
                    
                    <div class="space-x-4">
                        <Link href="/employee/cashier" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Go to Cashier</Link>
                        <Link href="/employee/stock" class="px-4 py-2 bg-green-500 text-white rounded-lg">Go to Stock Management</Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
