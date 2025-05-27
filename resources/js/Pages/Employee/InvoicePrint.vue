<template>
    <div class="w-full max-w-3xl bg-white p-6" id="invoice-content">
        <!-- Header Invoice -->
        <div class="text-center mb-6 border-b pb-4">
            <h2 class="text-2xl font-bold">TOKO POS SYSTEM</h2>
            <p class="text-gray-600">Jl. Contoh No. 123, Kota Malang</p>
            <p class="text-gray-600">Telp: 0812-3456-7890</p>
        </div>

        <!-- Detail Invoice -->
        <div class="mb-4 flex justify-between text-sm">
            <div>
                <p><span class="font-semibold">No. Invoice:</span> {{ invoice.invoice_number }}</p>
                <p><span class="font-semibold">Kasir:</span> {{ invoice.cashier_name }}</p>
            </div>
            <div class="text-right">
                <p><span class="font-semibold">Tanggal:</span> {{ invoice.date }}</p>
                <p><span class="font-semibold">Metode Pembayaran:</span> 
                    {{ invoice.payment_method === 'cash' ? 'Tunai' : 
                       invoice.payment_method === 'card' ? 'Kartu Debit/Kredit' : 
                       invoice.payment_method === 'transfer' ? 'Transfer Bank' : 'QRIS' }}
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
                    <tr v-for="item in invoice.items" :key="item.product_name" class="border-b">
                        <td class="py-2">{{ item.product_name }}</td>
                        <td class="text-center py-2">{{ item.quantity }}</td>
                        <td class="text-right py-2">Rp {{ Number(item.total_price / item.quantity).toLocaleString('id-ID') }}</td>
                        <td class="text-right py-2">Rp {{ Number(item.total_price).toLocaleString('id-ID') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Ringkasan Pembayaran -->
        <div class="mb-6 border-t pt-2">
            <div class="flex justify-between text-md mb-1">
                <span class="font-semibold">Total Belanja:</span>
                <span>Rp {{ Number(invoice.total_amount).toLocaleString('id-ID') }}</span>
            </div>
            <div v-if="invoice.payment_method === 'cash'" class="flex justify-between text-md mb-1">
                <span class="font-semibold">Uang Diterima:</span>
                <span>Rp {{ Number(invoice.received_amount).toLocaleString('id-ID') }}</span>
            </div>
            <div v-if="invoice.payment_method === 'cash'" class="flex justify-between text-md mb-1">
                <span class="font-semibold">Kembalian:</span>
                <span>Rp {{ Number(invoice.change).toLocaleString('id-ID') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm mt-8">
            <p class="font-semibold">Terima Kasih Atas Kunjungan Anda</p>
            <p class="text-gray-600">Barang yang sudah dibeli tidak dapat dikembalikan</p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    invoice: {
        type: Object,
        required: true
    }
});
</script>

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