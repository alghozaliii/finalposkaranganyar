<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

// Get user information
const page = usePage();
const user = computed(() => page.props.auth.user);

// Get the return route if provided
const props = defineProps({
  returnRoute: {
    type: String,
    default: null
  }
});

// Ambil data pesanan dari localStorage
const order = ref([]);
const paymentMethod = ref('cash');
const receivedAmount = ref(0);
const receivedFormatted = ref('');

// Hitung subtotal saja (tanpa PPN & diskon)
const subtotal = computed(() =>
  order.value.reduce((t, i) => t + i.quantity * i.selling_price, 0)
);
const totalPrice = subtotal;

// Kalkulasi kembalian
const change = computed(() => receivedAmount.value - totalPrice.value);

// Format rupiah input & output
const formatRupiah = (val) => {
  const num = parseInt(val.toString().replace(/[^\d]/g, '')) || 0;
  return 'Rp ' + num.toLocaleString('id-ID');
};
const handleReceivedInput = (e) => {
  const raw = e.target.value.replace(/[^\d]/g, '');
  receivedAmount.value = parseInt(raw) || 0;
  receivedFormatted.value = formatRupiah(raw);
};

// Load order
onMounted(() => {
  const data = localStorage.getItem('order');
  if (data) order.value = JSON.parse(data);
});

// Pilih metode
function selectMethod(m) {
  paymentMethod.value = m;
  if (m !== 'cash') {
    receivedAmount.value = 0;
    receivedFormatted.value = '';
  }
}

// Determine the correct invoice route based on user role
const getInvoiceRoute = () => {
  if (user.value.role_id === 2) {
    return route('owner.invoice');
  } else {
    return route('employee.invoice');
  }
};

// Checkout
const confirmPayment = async () => {
  if (!order.value.length) {
    return alert('Tidak ada pesanan.');
  }
  if (paymentMethod.value === 'cash' && change.value < 0) {
    return alert('Uang diterima kurang.');
  }
  try {
    const invoiceNumber = `INV-${Date.now().toString().slice(-8)}`;
    await axios.post('/cashier/checkout', {
      order: order.value,
      payment_method: paymentMethod.value,
      invoice_number: invoiceNumber,
    });
    const invoiceData = {
      items: order.value,
      totalPrice: totalPrice.value,
      receivedAmount: receivedAmount.value,
      change: change.value,
      paymentMethod: paymentMethod.value,
      date: new Date().toLocaleString('id-ID'),
      invoiceNumber: invoiceNumber,
    };
    localStorage.setItem('invoiceData', JSON.stringify(invoiceData));
    localStorage.removeItem('order');
    
    // Redirect using the appropriate route
    router.get(getInvoiceRoute());
  } catch (e) {
    console.error(e);
    alert('Gagal memproses pembayaran.');
  }
};
</script>

<template>
  <Head title="Pembayaran" />
  <AuthenticatedLayout>
    <div class="py-12 bg-gray-50 min-h-screen flex flex-col items-center">
      <div class="w-full max-w-3xl bg-white shadow-md rounded-lg p-6">
        <h3 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h3>

        <div v-if="order.length === 0" class="text-gray-500 text-center py-4">
          Tidak ada pesanan.
        </div>

        <div v-else>
          <!-- Item list -->
          <div
            v-for="item in order"
            :key="item.id"
            class="flex items-center bg-gray-100 rounded-lg mb-3 overflow-hidden"
          >
            
            <div class="flex-1 px-4">
              <h4 class="font-semibold">{{ item.name }}</h4>
              <p class="text-gray-600 text-sm">
                {{ item.quantity }} x Rp {{ Number(item.selling_price).toLocaleString() }}
              </p>
            </div>
            <div class="pr-4">
              <p class="font-semibold">
                {{ formatRupiah(item.quantity * item.selling_price) }}
              </p>
            </div>
          </div>

          <!-- Hanya tampilkan Total (subtotal) -->
          <div class="mt-4 flex justify-between font-semibold text-lg">
            <span>Total</span>
            <span>{{ formatRupiah(totalPrice) }}</span>
          </div>

          <!-- Metode pembayaran -->
          <h3 class="mt-6 mb-2 text-lg font-semibold">Metode Pembayaran</h3>
          <div class="grid grid-cols-2 gap-3">
            <button
              @click="selectMethod('cash')"
              :class="paymentMethod==='cash'
                ? 'bg-purple-600 text-white'
                : 'bg-white text-gray-700 hover:bg-gray-100'"
              class="flex items-center justify-center p-4 rounded-lg shadow"
            >
              Tunai
            </button>
            <button
              @click="selectMethod('qris')"
              :class="paymentMethod==='qris'
                ? 'bg-purple-600 text-white'
                : 'bg-white text-gray-700 hover:bg-gray-100'"
              class="flex items-center justify-center p-4 rounded-lg shadow"
            >
              QRIS
            </button>
            
          </div>

          <!-- Kalkulator Tunai -->
          <div v-if="paymentMethod==='cash'" class="mt-6 bg-gray-100 p-4 rounded-lg">
            <h4 class="font-medium mb-2">Kalkulator Tunai</h4>
            <p class="text-gray-600">Total: {{ formatRupiah(totalPrice) }}</p>
            <input
              type="text"
              :value="receivedFormatted"
              @input="handleReceivedInput"
              placeholder="Masukkan uang diterima"
              class="mt-2 w-full border rounded-lg p-2"
            />
            <p
              class="mt-2 font-semibold"
              :class="change<0 ? 'text-red-600' : 'text-green-600'"
            >
              Kembalian: {{ formatRupiah(change) }}
            </p>
          </div>

          <!-- QRIS -->
          <div v-if="paymentMethod==='qris'" class="mt-6 text-center">
            <img
              src="/images/Qris.jpg"
              alt="QRIS Code"
              class="mx-auto w-60 rounded-lg shadow"
            />
          </div>

          <!-- Bottom bar -->
      <div
        class=" left-0 w-full bg-white shadow-inner p-4 flex justify-between items-center max-w-3xl mx-auto"
      >
        <span class="text-lg font-semibold">{{ formatRupiah(totalPrice) }}</span>
        <button
          @click="confirmPayment"
          class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition"
        >
          Konfirmasi Pembayaran
        </button>
      </div>
        </div>
      </div>

      
    </div>
  </AuthenticatedLayout>
</template>
