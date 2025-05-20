<template>
  <div class="min-h-screen bg-purple-50">
    <AuthenticatedLayout>
      <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside
          :class="[
            'bg-white shadow-lg flex flex-col items-center pt-6 fixed inset-y-0 left-0 transition-transform z-30',
            mobileMenuOpen ? 'translate-x-0' : '-translate-x-full',
            'md:translate-x-0 md:static md:w-24 w-64'
          ]"
        >        
          <nav class="flex flex-col items-center gap-10 mt-8 flex-1">
            <!-- Dashboard -->
            <button @click="goToDashboard" class="flex flex-col items-center">
              <div class="p-3 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
              </div>
              <span class="text-xs mt-2">Dashboard</span>
            </button>
            
            <!-- Transaksi -->
            <button @click="goToCashier" class="flex flex-col items-center">
              <div class="p-3 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
              </div>
              <span class="text-xs mt-2">Transaksi</span>
            </button>
            
            <!-- Stok barang -->
            <button @click="goToStock" class="flex flex-col items-center">
              <div class="p-3 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
              </div>
              <span class="text-xs mt-2">Stok barang</span>
            </button>

            <!-- Karyawan -->
            <button @click="goToEmployees" class="flex flex-col items-center">
              <div class="p-3 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
              </div>
              <span class="text-xs mt-2">Karyawan</span>
            </button>
            
            <!-- Helpdesk -->
            <button @click="goToFAQ" class="flex flex-col items-center">
              <div class="p-3 rounded-md bg-purple-100 text-purple-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <span class="text-xs mt-2">Helpdesk</span>
            </button>
            
            <!-- Laporan -->
            <button @click="goToLaporan" class="flex flex-col items-center">
              <div class="p-3 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
              <span class="text-xs mt-2">Laporan</span>
            </button>
          </nav>
          
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
          v-if="mobileMenuOpen"
          @click="toggleMobileMenu(false)"
          class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden"
        ></div>

        <!-- Main content -->
        <div class="flex-1 md:ml-24">
          <!-- Mobile header -->
          <header class="flex items-center justify-between bg-white p-4 shadow md:hidden">
            <button @click="toggleMobileMenu()">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
            <h1 class="text-lg font-semibold">Helpdesk</h1>
            <div class="w-8 h-8 rounded-full bg-gray-300"></div>
          </header>

          <!-- Main Container -->
          <div class="container mx-auto px-4 py-16 mt-16">
            <!-- Header Area -->
            <div class="text-center mb-12">
              <h1 class="text-4xl font-bold text-gray-800 mb-4">Frequently Asked Questions</h1>
              <p class="text-gray-600">Find answers to common questions about our POS system</p>
            </div>

            <!-- Search Box -->
            <div class="max-w-2xl mx-auto mb-8">
              <div class="relative">
                <input 
                  type="text" 
                  v-model="searchQuery"
                  class="w-full py-3 pl-12 pr-4 text-gray-700 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-400"
                  placeholder="Search questions..." 
                />
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                  <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- FAQ Categories -->
            <div class="max-w-4xl mx-auto">
              <!-- General Questions -->
              <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">General Questions</h2>
                <div class="space-y-4">
                  <div
                    v-for="(faq, index) in filteredGeneralFaqs"
                    :key="'general-'+index"
                    class="bg-white rounded-lg shadow-sm overflow-hidden"
                  >
                    <div 
                      class="p-4 flex justify-between items-center cursor-pointer hover:bg-purple-50 transition-colors"
                      @click="toggleFaq(index, 'general')"
                    >
                      <h3 class="font-medium text-gray-800">{{ faq.question }}</h3>
                      <svg
                        :class="{'transform rotate-180': faq.open, 'transform rotate-0': !faq.open}"
                        class="w-5 h-5 text-purple-600 transition-transform duration-200"
                        xmlns="http://www.w3.org/2000/svg" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke="currentColor"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                    </div>
                    <div 
                      v-show="faq.open" 
                      class="p-4 pt-0 bg-white text-gray-700 border-t border-gray-100"
                    >
                      <p>{{ faq.answer }}</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Transaction Questions -->
              <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Transaction Questions</h2>
                <div class="space-y-4">
                  <div
                    v-for="(faq, index) in filteredTransactionFaqs"
                    :key="'transaction-'+index"
                    class="bg-white rounded-lg shadow-sm overflow-hidden"
                  >
                    <div 
                      class="p-4 flex justify-between items-center cursor-pointer hover:bg-purple-50 transition-colors"
                      @click="toggleFaq(index, 'transaction')"
                    >
                      <h3 class="font-medium text-gray-800">{{ faq.question }}</h3>
                      <svg
                        :class="{'transform rotate-180': faq.open, 'transform rotate-0': !faq.open}"
                        class="w-5 h-5 text-purple-600 transition-transform duration-200"
                        xmlns="http://www.w3.org/2000/svg" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke="currentColor"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                    </div>
                    <div 
                      v-show="faq.open" 
                      class="p-4 pt-0 bg-white text-gray-700 border-t border-gray-100"
                    >
                      <p>{{ faq.answer }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>

<script>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

export default {
  components: {
    AuthenticatedLayout,
  },
  
  props: {
    faqs: {
      type: Array,
      default: () => []
    }
  },
  
  setup(props) {
    const searchQuery = ref('');
    const mobileMenuOpen = ref(false);
    
    // Menggunakan data dari props jika tersedia, jika tidak gunakan data sampel
    const faqData = ref(props.faqs.length > 0 ? props.faqs.map(faq => ({...faq, open: false})) : [
      {
        category: "Umum",
        question: "Apa itu sistem POS",
        answer: "Sistem POS (Point of Sale) adalah perangkat lunak dan perangkat keras yang digunakan untuk memproses transaksi penjualan.",
        open: false
      },
      {
        category: "Umum",
        question: "Cara kerja sistem POS",
        answer: "Sistem kami mengintegrasikan perangkat keras dengan perangkat lunak untuk memproses transaksi secara real-time.",
        open: false
      },
      {
        category: "Umum",
        question: "Bisakah saya melacak stok barang melalui sistem POS?",
        answer: "Ya, sistem POS kami dilengkapi dengan fitur manajemen inventaris yang memungkinkan pelacakan stok secara real-time.",
        open: false
      },
      {
        category: "Umum",
        question: "Apakah data transaksi aman di sistem POS?",
        answer: "Kami menggunakan enkripsi data dan backup berkala untuk menjaga keamanan serta integritas data transaksi.",
        open: false
      }
    ]);
    
    const transactionFaqs = ref([
      {
        category: "Transaksi",
        question: "Apakah metode pembayaran dapat ditambah?",
        answer: "Ya, sistem kami mendukung berbagai metode pembayaran dan dapat disesuaikan dengan kebutuhan bisnis Anda.",
        open: false
      },
      {
        category: "Transaksi",
        question: "Bagaimana cara menangani refund?",
        answer: "Proses refund dapat dilakukan melalui menu transaksi dengan memilih transaksi yang ingin direfund dan mengikuti langkah-langkah yang tersedia.",
        open: false
      }
    ]);
    
    const filteredGeneralFaqs = computed(() => {
      if (!searchQuery.value) {
        return faqData.value;
      }
      
      return faqData.value.filter(faq => 
        faq.question.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
        faq.answer.toLowerCase().includes(searchQuery.value.toLowerCase())
      );
    });
    
    const filteredTransactionFaqs = computed(() => {
      if (!searchQuery.value) {
        return transactionFaqs.value;
      }
      
      return transactionFaqs.value.filter(faq => 
        faq.question.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
        faq.answer.toLowerCase().includes(searchQuery.value.toLowerCase())
      );
    });
    
    const toggleFaq = (index, type) => {
      if (type === 'general') {
        faqData.value[index].open = !faqData.value[index].open;
      } else {
        transactionFaqs.value[index].open = !transactionFaqs.value[index].open;
      }
    };

    // Navigation functions
    const goToDashboard = () => router.get(route('owner.dashboard'));
    const goToCashier = () => router.get(route('owner.cashier'));
    const goToStock = () => router.get(route('owner.stock'));
    const goToEmployees = () => router.get(route('owner.employees'));
    const goToFAQ = () => router.get(route('owner.faq'));
    const goToLaporan = () => router.get(route('owner.laporan'));
    const logout = () => router.post(route('logout'));
    
    // Toggle mobile menu
    const toggleMobileMenu = (force) => {
      mobileMenuOpen.value = force === false ? false : !mobileMenuOpen.value;
    };
    
    return {
      searchQuery,
      faqData,
      transactionFaqs,
      filteredGeneralFaqs,
      filteredTransactionFaqs,
      toggleFaq,
      mobileMenuOpen,
      toggleMobileMenu,
      goToDashboard,
      goToCashier,
      goToStock,
      goToEmployees,
      goToFAQ,
      goToLaporan,
      logout
    };
  }
};
</script>

<style scoped>
/* Customize scrollbar */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.3);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.5);
}
</style> 