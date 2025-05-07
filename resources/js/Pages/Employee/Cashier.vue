<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

// Data produk & keranjang
const products = ref([]);
const cartItems = ref([]);
const showSidebar = ref(true);
const searchQuery = ref('');
const activeCategory = ref('Semua');



// Kategori produk
const categories = [
  { name: 'Semua', active: true },
  { name: 'Chairs', active: false },
  { name: 'Desks', active: false },
  { name: 'Beds', active: false },
  { name: 'Furnitures', active: false }
];

// Ambil data produk dari backend saat komponen dimuat
const fetchProducts = async () => {
    try {
        const response = await axios.get('/cashier/products');
        products.value = response.data;
    } catch (error) {
        console.error('Gagal mengambil data produk:', error);
    }
};

// Filter produk berdasarkan kategori dan pencarian
const filteredProducts = computed(() => {
    let filtered = products.value;
    
    // Filter berdasarkan kategori
    if (activeCategory.value !== 'Semua') {
        filtered = filtered.filter(product => product.category === activeCategory.value);
    }
    
    // Filter berdasarkan pencarian
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(product => 
            product.name.toLowerCase().includes(query)
        );
    }
    
    return filtered;
});

// Set kategori aktif
const setActiveCategory = (category) => {
    activeCategory.value = category;
};

// Total harga pesanan
const cartTotal = computed(() => {
    return cartItems.value.reduce((total, item) => total + item.quantity * item.selling_price, 0);
});

// Menambahkan produk ke keranjang
const addToCart = (product) => {
    const existingItem = cartItems.value.find(item => item.id === product.id);
    
    if (existingItem) {
        if (existingItem.quantity < product.stock) {
            existingItem.quantity += 1;
        }
    } else {
        if (product.stock > 0) {
            cartItems.value.push({
                ...product,
                quantity: 1
            });
        }
    }
};

// Increment jumlah produk di keranjang
const incrementQuantity = (item) => {
    const product = products.value.find(p => p.id === item.id);
    if (item.quantity < product.stock) {
        item.quantity += 1;
    }
};

// Decrement jumlah produk di keranjang
const decrementQuantity = (item) => {
    if (item.quantity > 1) {
        item.quantity -= 1;
    }
};

// Update jumlah produk di keranjang
const updateQuantity = (item, newQuantity) => {
    const product = products.value.find(p => p.id === item.id);
    
    if (newQuantity > 0 && newQuantity <= product.stock) {
        item.quantity = newQuantity;
    }
};

// Hapus item dari keranjang
const removeFromCart = (itemId) => {
    cartItems.value = cartItems.value.filter(item => item.id !== itemId);
};

// Logout function
const logout = () => {
    router.post('/logout');
};

// Lanjut ke pembayaran
const proceedToPayment = () => {
    if (cartItems.value.length > 0) {
        localStorage.setItem('order', JSON.stringify(cartItems.value));
        window.location.href = '/payment';
    }
};

onMounted(fetchProducts);
</script>

<template>
    
    <Head title="Kasir" />
    <AuthenticatedLayout>
       

      <!-- SIDEBAR -->
      <div
        :class="[
          'bg-gray-300 h-[calc(100vh-4rem)] flex flex-col items-center pt-5 fixed left-0 top-16 z-40 transition-all duration-300',
          showSidebar ? 'w-48' : 'w-0 lg:w-48',
          showSidebar ? 'opacity-100' : 'opacity-0 lg:opacity-100'
        ]"
      >
        <div class="w-full flex flex-col gap-4 px-4 overflow-hidden">
          <a href="/dashboard">
            <div
              :class="[
                'bg-purple-400 p-4 rounded-lg flex flex-col items-center cursor-pointer hover:bg-purple-300 transition-all duration-300',
                showSidebar ? 'transform-none' : 'transform -translate-x-full lg:transform-none'
              ]"
            >
              <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
              </svg>
              <span class="font-bold text-sm mt-2">Dashboard</span>
            </div>
          </a>

          <a href="">
            <div
              :class="[
                'bg-purple-400 p-4 rounded-lg flex flex-col items-center cursor-pointer hover:bg-purple-300 transition-all duration-300',
                showSidebar ? 'transform-none' : 'transform -translate-x-full lg:transform-none',
                'transition-transform delay-100'
              ]"
            >
              <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <span class="font-bold text-sm mt-2">Transaksi</span>
            </div>
          </a>

          <!-- <a href="/Setting">
            <div
              :class="[
                'bg-purple-400 p-4 rounded-lg flex flex-col items-center cursor-pointer hover:bg-purple-300 transition-all duration-300',
                showSidebar ? 'transform-none' : 'transform -translate-x-full lg:transform-none',
                'transition-transform delay-100'
              ]"
            >
            <img src="/images/sett.png" alt="Pengaturan" class="w-11 h-11" />
              <span class="font-bold text-sm mt-1">Pengaturan</span>
            </div>
          </a> -->
        </div>

        <!-- Tombol Logout -->
        <div 
          :class="[
            'mt-auto mb-20 bg-white p-4 rounded-lg flex flex-col items-center cursor-pointer hover:bg-gray-100 transition-all duration-300 mx-4',
            showSidebar ? 'transform-none' : 'transform -translate-x-full lg:transform-none',
            'transition-transform delay-200'
          ]"
          @click="logout"
        >
          <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          <span class="font-bold text-sm mt-1">Logout</span>
        </div>
      </div>

      <!-- KONTEN UTAMA -->
      <div class="pt-7 pl-40 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 flex flex-col gap-4">          
          <!-- Search & Filter Bar -->
          <div class="bg-white w-full p-4 rounded-lg shadow-sm flex justify-between">
            <div class="relative w-96">
              <input 
                v-model="searchQuery"
                type="text" 
                placeholder="Search" 
                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-300"
              />
              <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
            <div class="flex items-center">
              <button class="p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Category Filter -->
          <div class="flex space-x-2 overflow-x-auto py-2">
            <button 
              v-for="category in categories" 
              :key="category.name"
              @click="setActiveCategory(category.name)"
              :class="[
                'px-6 py-2 rounded-lg text-sm font-medium whitespace-nowrap',
                activeCategory === category.name ? 'bg-purple-400 text-white' : 'bg-white text-gray-800 hover:bg-gray-100'
              ]"
            >
              {{ category.name }}
            </button>
          </div>
          
          <div class="flex gap-6">
            <!-- List Produk -->
            <div class="w-2/3">
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div 
                  v-for="product in filteredProducts" 
                  :key="product.id" 
                  class="bg-purple-300 rounded-lg p-4 hover:shadow-lg transition cursor-pointer flex flex-col justify-between h-32"
                  @click="addToCart(product)"
                >
                  <h4 class="font-semibold">{{ product.name }}</h4>
                  <div>
                    <p class="text-xs text-gray-600">Stok: {{ product.stock }}</p>
                    <p class="font-bold">{{ Number(product.selling_price).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }) }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Bagian yang diubah hanya pada komponen Keranjang Belanja -->
<div class="w-1/3 bg-white shadow-md rounded-lg p-4 sticky top-20 max-h-[calc(100vh-8rem)] overflow-auto">
  <div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold">Pesanan baru</h3>
    <button 
      v-if="cartItems.length > 0" 
      class="text-gray-500 hover:text-red-500" 
      @click="cartItems = []"
    >
      <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
      </svg>
    </button>
  </div>
  <div v-if="cartItems.length === 0" class="text-gray-500 text-center py-8">
    Keranjang kosong
  </div>
  <div v-else class="space-y-4">
    <div 
      v-for="item in cartItems" 
      :key="item.id" 
      class="flex justify-between items-center border-b pb-3"
    >
      <div class="flex-grow pr-4">
        <h4 class="font-semibold">{{ item.name }}</h4>
        <p class="text-sm text-gray-600">{{ Number(item.selling_price).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }) }}</p>
      </div>
      <div class="flex items-center">
        <button 
          @click.stop="decrementQuantity(item)"
          class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700"
        >
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
          </svg>
        </button>
        <span class="w-8 text-center">{{ item.quantity }}</span>
        <button 
          @click.stop="incrementQuantity(item)"
          class="w-8 h-8 rounded-full bg-purple-300 flex items-center justify-center text-white"
        >
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
        </button>
        <button 
          @click.stop="removeFromCart(item.id)"
          class="ml-2 text-gray-400 hover:text-red-500"
        >
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </button>
      </div>
    </div>
    <!-- Total -->
    <div class="mt-4 pt-2 border-t">
      <div class="flex justify-between font-semibold text-lg">
        <span>Total</span>
        <span>Rp {{ Number(cartTotal).toLocaleString('id-ID') }}</span>
      </div>
      <button 
        @click="proceedToPayment"
        class="mt-4 w-full bg-purple-400 text-white py-3 rounded-lg hover:bg-purple-500 transition text-lg flex items-center justify-center"
      >
        <span>Bayar</span>
        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </div>
</div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
</template>