<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const invoiceData = ref({
    items: [],
    totalPrice: 0,
    receivedAmount: 0,
    change: 0,
    paymentMethod: 'cash',
    date: new Date().toLocaleString('id-ID'),
    invoiceNumber: `INV-${Date.now().toString().slice(-8)}`,
});

// Load invoice data from localStorage on component mount
onMounted(() => {
    const storedInvoiceData = localStorage.getItem('invoiceData');
    if (storedInvoiceData) {
        invoiceData.value = JSON.parse(storedInvoiceData);
    }
});

// Function to print the invoice
const printInvoice = () => {
    window.print();
};

// Function to return to cashier page
const returnToCashier = () => {
    localStorage.removeItem('invoiceData');
    
    // Check if the user is an owner or employee and redirect accordingly
    const user = document.querySelector('meta[name="user-role"]')?.getAttribute('content');
    if (user === '2') { // Role ID 2 is owner
        window.location.href = '/owner/cashier';
    } else {
        window.location.href = '/employee/cashier';
    }
};
</script>

<template>
    <Head title="Invoice Pembayaran" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoice Pembayaran</h2>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen flex justify-center">
            <div class="w-full max-w-3xl bg-white shadow-md rounded-lg p-6" id="invoice-content">
                <!-- Header Invoice -->
                <div class="text-center mb-6 border-b pb-4">
                    <h2 class="text-2xl font-bold">TOKO POS SYSTEM</h2>
                    <p class="text-gray-600">Jl. Contoh No. 123, Kota Malang</p>
                    <p class="text-gray-600">Telp: 0812-3456-7890</p>
                </div>

                <!-- Detail Invoice -->
                <div class="mb-4 flex justify-between text-sm">
                    <div>
                        <p><span class="font-semibold">No. Invoice:</span> {{ invoiceData.invoiceNumber }}</p>
                        <p><span class="font-semibold">Kasir:</span> {{ $page.props.auth.user.name }}</p>
                    </div>
                    <div class="text-right">
                        <p><span class="font-semibold">Tanggal:</span> {{ invoiceData.date }}</p>
                        <p><span class="font-semibold">Metode Pembayaran:</span> 
                            {{ invoiceData.paymentMethod === 'cash' ? 'Tunai' : 
                               invoiceData.paymentMethod === 'card' ? 'Kartu Debit/Kredit' : 
                               invoiceData.paymentMethod === 'transfer' ? 'Transfer Bank' : 'QRIS' }}
                        </p>
                    </div>
                </div>

                <!-- Tabel Barang -->
                <div class="mb-6">
                    <h3 class="font-semibold text-lg border-b-2 border-gray-800 pb-2 mb-2">Daftar Barang</h3>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">Produk</th>
                                <th class="text-center py-2">Qty</th>
                                <th class="text-right py-2">Harga</th>
                                <th class="text-right py-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in invoiceData.items" :key="item.id" class="border-b">
                                <td class="py-2">{{ item.name }}</td>
                                <td class="text-center py-2">{{ item.quantity }}</td>
                                <td class="text-right py-2">Rp {{ Number(item.selling_price).toLocaleString('id-ID') }}</td>
                                <td class="text-right py-2">Rp {{ Number(item.quantity * item.selling_price).toLocaleString('id-ID') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Ringkasan Pembayaran -->
                <div class="mb-6 border-t pt-2">
                    <div class="flex justify-between text-md mb-1">
                        <span class="font-semibold">Total Belanja:</span>
                        <span>Rp {{ Number(invoiceData.totalPrice).toLocaleString('id-ID') }}</span>
                    </div>
                    <div v-if="invoiceData.paymentMethod === 'cash'" class="flex justify-between text-md mb-1">
                        <span class="font-semibold">Uang Diterima:</span>
                        <span>Rp {{ Number(invoiceData.receivedAmount).toLocaleString('id-ID') }}</span>
                    </div>
                    <div v-if="invoiceData.paymentMethod === 'cash'" class="flex justify-between text-md mb-1">
                        <span class="font-semibold">Kembalian:</span>
                        <span>Rp {{ Number(invoiceData.change).toLocaleString('id-ID') }}</span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center text-sm mt-8">
                    <p class="font-semibold">Terima Kasih Atas Kunjungan Anda</p>
                    <p class="text-gray-600">Barang yang sudah dibeli tidak dapat dikembalikan</p>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-center mt-8 space-x-4 print:hidden">
                    <button 
                        @click="printInvoice"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition"
                    >
                        Cetak Invoice
                    </button>
                    <button 
                        @click="returnToCashier"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition"
                    >
                        Kembali ke Kasir
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #invoice-content, #invoice-content * {
        visibility: visible;
    }
    #invoice-content {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>