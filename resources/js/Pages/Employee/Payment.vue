<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

// Ambil data pesanan dari localStorage
const order = ref([]);
const paymentMethod = ref('cash');

// Total harga pesanan
const totalPrice = computed(() => {
    return order.value.reduce((total, item) => total + item.quantity * item.selling_price, 0);
});

// Ambil data pesanan saat komponen dimuat
onMounted(() => {
    const storedOrder = localStorage.getItem('order');
    if (storedOrder) {
        order.value = JSON.parse(storedOrder);
    }
});


const receivedAmount = ref(0);
const receivedFormatted = ref('');

const formatRupiah = (value) => {
    const numberString = value.replace(/[^\d]/g, '');
    const number = parseInt(numberString) || 0;
    return 'Rp ' + number.toLocaleString('id-ID');
};

const handleReceivedInput = (e) => {
    const input = e.target.value;
    const numberOnly = input.replace(/[^\d]/g, '');
    receivedAmount.value = parseInt(numberOnly) || 0;
    receivedFormatted.value = formatRupiah(input);
};

const change = computed(() => {
    return receivedAmount.value - totalPrice.value;
});



// Konfirmasi pembayaran
const confirmPayment = async () => {
    if (order.value.length === 0) {
        alert('Tidak ada pesanan.');
        return;
    }

    try {
        await axios.post('/cashier/checkout', {
            order: order.value,
            payment_method: paymentMethod.value
        });

        // Simpan data invoice ke localStorage untuk diakses oleh halaman invoice
        const invoiceData = {
            items: order.value,
            totalPrice: totalPrice.value,
            receivedAmount: receivedAmount.value,
            change: change.value,
            paymentMethod: paymentMethod.value,
            date: new Date().toLocaleString('id-ID'),
            invoiceNumber: `INV-${Date.now().toString().slice(-8)}`,
        };
        
        localStorage.setItem('invoiceData', JSON.stringify(invoiceData));
        localStorage.removeItem('order');
        
        // Redirect ke halaman invoice
        window.location.href = '/employee/invoice';
    } catch (error) {
        console.error('Gagal memproses pembayaran:', error);
        alert('Terjadi kesalahan saat memproses pembayaran.');
    }
};
</script>

<template>
    <Head title="Pembayaran" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pembayaran</h2>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen flex justify-center">
            <div class="w-full max-w-3xl bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h3>

                <div v-if="order.length === 0" class="text-gray-500 text-center py-4">
                    Tidak ada pesanan.
                </div>

                <div v-else>
                    <div 
                        v-for="item in order" 
                        :key="item.id" 
                        class="flex justify-between items-center border-b py-3"
                    >
                        <div>
                            <h4 class="font-semibold">{{ item.name }}</h4>
                            <p class="text-gray-600 text-sm">
                                {{ item.quantity }} x Rp {{ Number(item.selling_price).toLocaleString() }}
                            </p>
                        </div>
                        <p class="text-lg font-semibold">
                            Rp {{ Number(item.selling_price * item.quantity).toLocaleString() }}
                        </p>
                    </div>

                    <div class="mt-4 flex justify-between font-semibold text-lg">
                        <span>Total</span>
                        <span>Rp {{ Number(totalPrice).toLocaleString() }}</span>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-2">Metode Pembayaran</h3>
                        <select v-model="paymentMethod" class="w-full border p-2 rounded-lg">
                            <option value="cash">Tunai</option>
                            <option value="card">Kartu Kredit/Debit</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
<!-- Kalkulator Uang Diterima & Kembalian untuk pembayaran tunai -->
<div v-if="paymentMethod === 'cash'" class="mt-6 bg-gray-100 p-4 rounded">
  <h4 class="text-md font-medium mb-2">Kalkulator Pembayaran Tunai</h4>

  <div class="mb-3">
    <label class="block mb-1 font-medium">Total Belanja:</label>
    <p class="text-lg">Rp {{ Number(totalPrice).toLocaleString('id-ID') }}</p>
  </div>

  <div class="mb-3">
  <label class="block mb-1 font-medium">Uang Diterima:</label>
  <input
    type="text"
    :value="receivedFormatted"
    @input="handleReceivedInput"
    class="w-full border p-2 rounded"
    placeholder="Masukkan uang dari pembeli"
  />
</div>
  <div>
    <label class="block mb-1 font-medium">Kembalian:</label>
    <p class="text-lg font-semibold text-green-600">
      Rp {{ Number(change).toLocaleString('id-ID') }}
    </p>
  </div>
</div>

                    <!-- Tampilkan QR Code jika pilih QRIS -->
                    <div v-if="paymentMethod === 'qris'" class="mt-4 text-center">
                        <h4 class="text-md font-medium mb-2">Silakan scan QRIS berikut:</h4>
                        <img 
                            src="/images/Qris.jpg" 
                            alt="QRIS Code" 
                            class="mx-auto w-60 h-auto border rounded shadow-md"
                        />
                    </div>

                    <button 
                        @click="confirmPayment"
                        class="mt-6 w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition text-lg"
                    >
                        Konfirmasi Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>