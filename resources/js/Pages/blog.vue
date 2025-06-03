<template>
    <div class="min-h-screen bg-gray-50">
        <NavigationHeader />
  
        <!-- Hero Section -->
        <div class="bg-blue-600 text-white py-12 px-4 sm:px-6 lg:px-8 mt-16">
            <div class="container mx-auto max-w-7xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Blog & Artikel</h1>
                <p class="text-xl md:text-2xl text-blue-100">Temukan informasi terbaru seputar aplikasi kasir dan tips bisnis</p>
            </div>
        </div>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8 max-w-7xl">
            <!-- Filter Categories -->
            <div class="flex flex-wrap gap-2 mb-8">
                <button class="px-4 py-2 rounded-full bg-blue-500 text-white hover:bg-blue-600 transition">Semua</button>
                <button class="px-4 py-2 rounded-full bg-gray-200 hover:bg-gray-300 transition">Tips Bisnis</button>
                <button class="px-4 py-2 rounded-full bg-gray-200 hover:bg-gray-300 transition">Aplikasi Kasir</button>
                <button class="px-4 py-2 rounded-full bg-gray-200 hover:bg-gray-300 transition">UMKM</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                <article class="bg-white border rounded-lg shadow-sm hover:shadow-md transition duration-300 overflow-hidden group">
                    <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                        <img src="https://source.unsplash.com/random/800x600/?shop" alt="Blog thumbnail" 
                            class="w-full h-[240px] object-cover group-hover:scale-105 transition duration-300"/>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">Tips Bisnis</span>
                            <span class="text-gray-500 text-sm">20 Maret 2023</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 group-hover:text-blue-600 transition">
                            Manfaat Aplikasi Kasir untuk UMKM
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-3 text-base">
                            Aplikasi kasir dapat meningkatkan efisiensi transaksi serta membantu mengelola inventaris dengan lebih baik. Pelajari lebih lanjut mengenai manfaatnya untuk mengembangkan bisnis UMKM Anda ke level yang lebih tinggi...
                        </p>
                        <div class="flex items-center justify-between mt-4">
                            <a href="#" class="inline-flex items-center text-blue-500 hover:text-blue-700 font-medium">
                                Baca Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Admin" class="w-6 h-6 rounded-full" />
                                <span class="text-gray-600 text-sm">By Admin</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Duplicate article for second post with different content -->
                <article class="bg-white border rounded-lg shadow-sm hover:shadow-md transition duration-300 overflow-hidden group">
                    <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                        <img src="https://source.unsplash.com/random/800x600/?pos" alt="Blog thumbnail" 
                            class="w-full h-[240px] object-cover group-hover:scale-105 transition duration-300"/>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">Aplikasi Kasir</span>
                            <span class="text-gray-500 text-sm">15 Maret 2023</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 group-hover:text-blue-600 transition">
                            Tips Memaksimalkan Penjualan dengan POS Modern
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-3 text-base">
                            POS modern memberikan solusi terintegrasi untuk penjualan dan inventaris. Berikut beberapa tips untuk memaksimalkan penggunaan sistem POS dalam bisnis Anda...
                        </p>
                        <div class="flex items-center justify-between mt-4">
                            <a href="#" class="inline-flex items-center text-blue-500 hover:text-blue-700 font-medium">
                                Baca Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Admin" class="w-6 h-6 rounded-full" />
                                <span class="text-gray-600 text-sm">By Admin</span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                <nav class="flex justify-center gap-2" aria-label="Pagination">
                    <button class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border rounded-lg hover:bg-gray-50">
                        Previous
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg">
                        1
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border rounded-lg hover:bg-gray-50">
                        2
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border rounded-lg hover:bg-gray-50">
                        3
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border rounded-lg hover:bg-gray-50">
                        Next
                    </button>
                </nav>
            </div>
        </main>
  
        <footer class="bg-white shadow p-6 mt-8">
            <div class="container mx-auto text-center text-sm text-gray-600">
                &copy; 2023 Aplikasi Kasir. All rights reserved.
            </div>
        </footer>
    </div>
</template>

<script setup>
import NavigationHeader from "../Components/NavigationHeader.vue";
</script>
