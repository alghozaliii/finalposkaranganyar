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

// Barcode scan
const barcode = ref('');
const barcodeInput = ref(null);

const categories = [
  { name: 'Semua', active: true },
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

const filteredProducts = computed(() => {
    let filtered = products.value;
    if (activeCategory.value !== 'Semua') {
        filtered = filtered.filter(product => product.category === activeCategory.value);
    }
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(product => 
            product.name.toLowerCase().includes(query)
        );
    }
    return filtered;
});

const setActiveCategory = (category) => {
    activeCategory.value = category;
};

const cartTotal = computed(() => {
    return cartItems.value.reduce((total, item) => total + item.quantity * item.selling_price, 0);
});

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

const incrementQuantity = (item) => {
    const product = products.value.find(p => p.id === item.id);
    if (item.quantity < product.stock) {
        item.quantity += 1;
    }
};

const decrementQuantity = (item) => {
    if (item.quantity > 1) {
        item.quantity -= 1;
    }
};

const updateQuantity = (item, newQuantity) => {
    const product = products.value.find(p => p.id === item.id);
    if (newQuantity > 0 && newQuantity <= product.stock) {
        item.quantity = newQuantity;
    }
};

const removeFromCart = (itemId) => {
    cartItems.value = cartItems.value.filter(item => item.id !== itemId);
};

const logout = () => {
    router.post('/logout');
};

const proceedToPayment = () => {
    if (cartItems.value.length > 0) {
        localStorage.setItem('order', JSON.stringify(cartItems.value));
        window.location.href = '/payment';
    }
};

// Barcode scan handler
const handleBarcodeScan = () => {
    if (!barcode.value) return;
    const product = products.value.find(p => String(p.code) === barcode.value.trim());
    if (product) {
        addToCart(product);
    }
    barcode.value = '';
    barcodeInput.value && barcodeInput.value.focus();
};

// Tombol untuk fokus ke input barcode
const focusBarcodeInput = () => {
    barcodeInput.value && barcodeInput.value.focus();
};

onMounted(() => {
    fetchProducts();
    setTimeout(() => {
        barcodeInput.value && barcodeInput.value.focus();
    }, 300);
});
</script>

<template>
    <Head title="Kasir" />
    <AuthenticatedLayout>
        <div class="flex min-h-screen bg-gray-100">
            <!-- Input untuk barcode scanner (hidden) -->
            <input
                ref="barcodeInput"
                v-model="barcode"
                @keyup.enter="handleBarcodeScan"
                type="text"
                class="absolute opacity-0 pointer-events-none"
                tabindex="-1"
                autocomplete="off"
            />

            <!-- Sidebar -->
            <aside
                :class="[
                    'bg-white shadow-lg flex flex-col items-center pt-6 fixed inset-y-0 left-0 transition-transform z-30',
                    showSidebar ? 'translate-x-0' : '-translate-x-full',
                    'md:translate-x-0 md:static md:w-24 w-64',
                    'safe-area-inset-left'
                ]"
            >
                <nav class="flex flex-col items-center gap-10 mt-8 flex-1">
                    <!-- Dashboard -->
                    <a href="/dashboard" class="flex flex-col items-center">
                        <div class="p-3 rounded-md text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <span class="text-xs mt-2">Dashboard</span>
                    </a>
                    <!-- Transaksi -->
                    <a href="" class="flex flex-col items-center">
                        <div class="p-3 rounded-md bg-purple-100 text-purple-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <span class="text-xs mt-2">Transaksi</span>
                    </a>
                </nav>
                <!-- Logout Button -->
                <button @click="logout" class="flex flex-col items-center mt-auto mb-6">
                    <div class="p-3 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <span class="text-xs mt-2">Logout</span>
                </button>
            </aside>

            <!-- Overlay mobile -->
            <div
                v-if="showSidebar"
                @click="showSidebar = false"
                class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden"
            ></div>

            <!-- Main content -->
            <div class="flex-1 md:ml-24 w-full overflow-x-hidden">
                <!-- Mobile header -->
                <header class="flex items-center justify-between bg-white p-4 shadow md:hidden safe-area-inset-top">
                    <button @click="showSidebar = !showSidebar" class="p-2 -m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold">Kasir</h1>
                    <div class="w-8 h-8 rounded-full bg-gray-300"></div>
                </header>

                <main class="p-3 md:p-6 space-y-4 md:space-y-6 safe-area-inset-bottom">
                    <!-- Tombol Scan Barcode -->
                    <button
                        @click="focusBarcodeInput"
                        class="mb-2 px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600"
                    >
                        Scan Barcode
                    </button>

                    <!-- Search & Filter Bar -->
                    <div class="bg-white w-full p-3 rounded-lg shadow-sm flex flex-col md:flex-row justify-between gap-3">
                        <div class="relative w-full">
                            <input 
                                v-model="searchQuery"
                                type="text" 
                                placeholder="Search" 
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-300 text-base"
                            />
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="flex space-x-2 overflow-x-auto py-2 -mx-3 px-3 md:mx-0 md:px-0">
                        <button 
                            v-for="category in categories" 
                            :key="category.name"
                            @click="setActiveCategory(category.name)"
                            :class="[
                                'px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap',
                                activeCategory === category.name ? 'bg-purple-400 text-white' : 'bg-white text-gray-800 hover:bg-gray-100 active:bg-gray-200'
                            ]"
                        >
                            {{ category.name }}
                        </button>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-4">
                        <!-- List Produk -->
                        <div class="w-full lg:w-2/3">
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
                                <div 
                                    v-for="product in filteredProducts" 
                                    :key="product.id" 
                                    class="bg-purple-300 rounded-lg p-2 md:p-4 hover:shadow-lg transition cursor-pointer flex flex-col justify-between h-24 md:h-32 active:bg-purple-400"
                                    @click="addToCart(product)"
                                >
                                    <h4 class="font-semibold text-xs md:text-base line-clamp-2">{{ product.name }}</h4>
                                    <div>
                                        <p class="text-xs text-gray-600">Stok: {{ product.stock }}</p>
                                        <p class="font-bold text-xs md:text-base">{{ Number(product.selling_price).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Keranjang Belanja -->
                        <div class="w-full lg:w-1/3 bg-white shadow-md rounded-lg p-3 sticky bottom-0 lg:top-20 max-h-[calc(100vh-4rem)] md:max-h-[calc(100vh-8rem)] overflow-auto">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-base font-semibold">Pesanan baru</h3>
                                <button 
                                    v-if="cartItems.length > 0" 
                                    class="text-gray-500 hover:text-red-500 active:text-red-600 p-2 -m-2" 
                                    @click="cartItems = []"
                                >
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <div v-if="cartItems.length === 0" class="text-gray-500 text-center py-6">
                                Keranjang kosong
                            </div>
                            <div v-else class="space-y-3">
                                <div 
                                    v-for="item in cartItems" 
                                    :key="item.id" 
                                    class="flex justify-between items-center border-b pb-3"
                                >
                                    <div class="flex-grow pr-2">
                                        <h4 class="font-semibold text-sm">{{ item.name }}</h4>
                                        <p class="text-xs text-gray-600">{{ Number(item.selling_price).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }) }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <button 
                                            @click.stop="decrementQuantity(item)"
                                            class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 active:bg-gray-300"
                                        >
                                            <svg class="w-3 h-3 md:w-4 md:h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <span class="w-6 text-center text-sm">{{ item.quantity }}</span>
                                        <button 
                                            @click.stop="incrementQuantity(item)"
                                            class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-purple-300 flex items-center justify-center text-white active:bg-purple-400"
                                        >
                                            <svg class="w-3 h-3 md:w-4 md:h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                        <button 
                                            @click.stop="removeFromCart(item.id)"
                                            class="ml-1 text-gray-400 hover:text-red-500 active:text-red-600 p-1 -m-1"
                                        >
                                            <svg class="w-3 h-3 md:w-4 md:h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <!-- Total -->
                                <div class="mt-3 pt-2 border-t">
                                    <div class="flex justify-between font-semibold text-base">
                                        <span>Total</span>
                                        <span>Rp {{ Number(cartTotal).toLocaleString('id-ID') }}</span>
                                    </div>
                                    <button 
                                        @click="proceedToPayment"
                                        class="mt-3 w-full bg-purple-400 text-white py-2.5 rounded-lg hover:bg-purple-500 active:bg-purple-600 transition text-base flex items-center justify-center"
                                    >
                                        <span>Bayar</span>
                                        <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.safe-area-inset-top {
    padding-top: env(safe-area-inset-top);
}
.safe-area-inset-bottom {
    padding-bottom: env(safe-area-inset-bottom);
}
.safe-area-inset-left {
    padding-left: env(safe-area-inset-left);
}
@media (max-width: 768px) {
    button, a { min-height: 44px; min-width: 44px; }
    input, select { font-size: 16px; }
}
body { overscroll-behavior-y: none; }
.overflow-auto { -webkit-overflow-scrolling: touch; }
.w-full { max-width: 100%; }
@media (max-width: 768px) {
    .w-full { width: 100vw; max-width: 100vw; overflow-x: hidden; }
}
</style>