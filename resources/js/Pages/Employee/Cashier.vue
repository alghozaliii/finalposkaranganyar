<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

// Data produk & keranjang
const products = ref([]);
const cartItems = ref([]);

// Ambil data produk dari backend saat komponen dimuat
const fetchProducts = async () => {
    try {
        const response = await axios.get('/cashier/products');
        products.value = response.data;
    } catch (error) {
        console.error('Gagal mengambil data produk:', error);
    }
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
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kasir</h2>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-6">
                
                <!-- List Produk -->
                <div class="w-2/3 bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Daftar Produk</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <div 
                            v-for="product in products" 
                            :key="product.id" 
                            class="border rounded-lg p-4 hover:shadow-lg transition cursor-pointer"
                            @click="addToCart(product)"
                        >
                            <h4 class="font-semibold text-lg">{{ product.name }}</h4>
                            <p class="text-gray-600 text-sm">Stok: {{ product.stock }}</p>
                            <p class="text-blue-600 font-bold text-lg">Rp {{ Number(product.selling_price).toLocaleString() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Keranjang Belanja -->
                <div class="w-1/3 bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Keranjang</h3>
                    
                    <div v-if="cartItems.length === 0" class="text-gray-500 text-center py-4">
                        Keranjang kosong
                    </div>

                    <div v-else>
                        <div 
                            v-for="item in cartItems" 
                            :key="item.id" 
                            class="flex justify-between items-center border-b py-3"
                        >
                            <div>
                                <h4 class="font-semibold">{{ item.name }}</h4>
                                <div class="flex items-center">
                                    <button 
                                        @click="updateQuantity(item, item.quantity - 1)"
                                        class="px-3 py-1 bg-gray-200 rounded-l"
                                    >-</button>
                                    <input 
                                        type="number" 
                                        :value="item.quantity" 
                                        @input="updateQuantity(item, Number($event.target.value))"
                                        class="w-12 text-center border"
                                    />
                                    <button 
                                        @click="updateQuantity(item, item.quantity + 1)"
                                        class="px-3 py-1 bg-gray-200 rounded-r"
                                    >+</button>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg">Rp {{ Number(item.selling_price * item.quantity).toLocaleString() }}</p>
                                <button 
                                    @click="removeFromCart(item.id)"
                                    class="text-red-500 text-sm mt-1"
                                >Hapus</button>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="flex justify-between font-semibold text-lg">
                                <span>Total</span>
                                <span>Rp {{ Number(cartTotal).toLocaleString() }}</span>
                            </div>

                            <button 
                                @click="proceedToPayment"
                                class="mt-4 w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition text-lg"
                            >
                                Lanjut ke Pembayaran
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
