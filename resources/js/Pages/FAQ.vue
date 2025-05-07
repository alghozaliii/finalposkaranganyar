<template>
  <div class="min-h-screen bg-indigo-700">
    <AuthenticatedLayout/>
    
    <!-- Main Container -->
    <div class="flex pt-4">
      
      <!-- Sidebar (menggunakan sidebar yang sudah ada) -->
      <div
        :class="[
          'bg-gray-300 h-screen flex flex-col items-center pt-5 fixed left-0 top-16 z-40 transition-all duration-300',
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

          <a href="/verificator/helpdesk">
            <div
              :class="[
                'bg-purple-500 p-4 rounded-lg flex flex-col items-center cursor-pointer hover:bg-purple-400 transition-all duration-300',
                showSidebar ? 'transform-none' : 'transform -translate-x-full lg:transform-none',
                'transition-transform delay-100'
              ]"
            >
              <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <span class="font-bold text-sm mt-2">Helpdesk</span>
            </div>
          </a>

          <a href="/Setting">
            <div
              :class="[
                'bg-purple-400 p-4 rounded-lg flex flex-col items-center cursor-pointer hover:bg-purple-300 transition-all duration-300',
                showSidebar ? 'transform-none' : 'transform -translate-x-full lg:transform-none',
                'transition-transform delay-100'
              ]"
            >
              <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="font-bold text-sm mt-1">Pengaturan</span>
            </div>
          </a>
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

      <!-- Main Content Area -->
      <div class="w-full transition-all duration-300" :class="{'lg:ml-48': true, 'ml-0': !showSidebar}">
        <div class="px-6 lg:mr-64 mt-1 pb-6 flex-1 overflow-auto">
          <div class="pt-16">
            <!-- Header Area -->
            <div class="flex items-center justify-between mb-6">
              <div>
                <button @click="toggleSidebar" class="lg:hidden text-white">
                  <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  </svg>
                </button>
                <h1 class="text-2xl font-bold text-white inline-block ml-2">F.A.Q.</h1>
              </div>
              
              <!-- Tambah Button -->
              <button 
                @click="redirectToCreateFAQ" 
                class="bg-white text-indigo-700 px-4 py-2 rounded-md flex items-center font-medium hover:bg-gray-100 transition"
              >
                <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah
              </button>
            </div>
            
            <!-- Search Box -->
            <div class="relative mb-6">
              <input 
                type="text" 
                v-model="searchQuery"
                class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400"
                placeholder="Search" 
              />
              <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
            
            <!-- Last Updated Info -->
            <div class="flex items-center text-white mb-6">
              <span>Last updated: {{ lastUpdated }}</span>
              <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
              </svg>
            </div>
            
            <!-- FAQ Categories -->
            <div class="mb-6">
              <h2 class="text-xl font-semibold text-white mb-2">{{ selectedCategory }}</h2>
              
              <!-- FAQ Items -->
              <div class="space-y-4">
                <div
                  v-for="(faq, index) in filteredFaqs"
                  :key="index"
                  class="bg-white bg-opacity-95 rounded-md overflow-hidden"
                >
                  <div 
                    class="p-4 flex justify-between items-center cursor-pointer hover:bg-indigo-50 transition-colors"
                    @click="toggleFaq(index)"
                  >
                    <h3 class="font-medium text-gray-800">{{ faq.question }}</h3>
                    <svg
                      :class="{'transform rotate-180': faq.open, 'transform rotate-0': !faq.open}"
                      class="w-5 h-5 text-indigo-600 transition-transform duration-200"
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
            
            <!-- Category Sections -->
            <div v-if="selectedCategory === 'General Question'" class="mb-8">
              <h2 class="text-xl font-semibold text-white mb-2">Transaction Question</h2>
              <div class="space-y-4">
                <div
                  v-for="(faq, index) in transactionFaqs"
                  :key="'transaction-'+index"
                  class="bg-white bg-opacity-95 rounded-md overflow-hidden"
                >
                  <div 
                    class="p-4 flex justify-between items-center cursor-pointer hover:bg-indigo-50 transition-colors"
                    @click="toggleTransactionFaq(index)"
                  >
                    <h3 class="font-medium text-gray-800">{{ faq.question }}</h3>
                    <svg
                      :class="{'transform rotate-180': faq.open, 'transform rotate-0': !faq.open}"
                      class="w-5 h-5 text-indigo-600 transition-transform duration-200"
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

        <!-- Profil Admin (untuk layar besar) -->
        <div class="hidden lg:block w-64 bg-gray-200 rounded-lg p-4 text-center fixed right-3 top-24">
          <img
            src="/images/profile.png"
            class="w-20 h-20 rounded-full mx-auto border-4 border-white mb-3"
            alt="Profile Petugas"
          />
          <h3 class="font-bold text-lg">{{ userName }}</h3>
          <p class="text-gray-600">Verifikator</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';

export default {
  components: {
    AuthenticatedLayout
  },
  
  props: {
    faqs: {
      type: Array,
      default: () => []
    },
    auth: {
      type: Object,
      default: () => ({})
    }
  },
  
  setup(props) {
    const showSidebar = ref(window.innerWidth >= 1024);
    const searchQuery = ref('');
    const lastUpdated = ref('11 Sep, 2024');
    const selectedCategory = ref('General Question');
    const userName = ref(props.auth?.user?.name || 'Verifikator');
    
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
    
    const filteredFaqs = computed(() => {
      if (!searchQuery.value) {
        return faqData.value.filter(faq => faq.category === 'Umum' || selectedCategory.value === 'General Question');
      }
      
      return faqData.value.filter(faq => 
        (faq.question.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
         faq.answer.toLowerCase().includes(searchQuery.value.toLowerCase())) &&
        (faq.category === 'Umum' || selectedCategory.value === 'General Question')
      );
    });
    
    const toggleFaq = (index) => {
      faqData.value[index].open = !faqData.value[index].open;
    };
    
    const toggleTransactionFaq = (index) => {
      transactionFaqs.value[index].open = !transactionFaqs.value[index].open;
    };
    
    const toggleSidebar = () => {
      showSidebar.value = !showSidebar.value;
    };
    
    const redirectToCreateFAQ = () => {
      router.get(route('verificator.helpdesk.create'));
    };
    
    const logout = () => {
      router.post(route('logout'));
    };
    
    const handleResize = () => {
      if (window.innerWidth < 1024) {
        showSidebar.value = false;
      } else {
        showSidebar.value = true;
      }
    };
    
    // Lifecycle hooks
    if (typeof window !== 'undefined') {
      window.addEventListener('resize', handleResize);
      window.onbeforeunload = () => {
        window.removeEventListener('resize', handleResize);
      };
    }
    
    return {
      showSidebar,
      searchQuery,
      lastUpdated,
      selectedCategory,
      faqData,
      transactionFaqs,
      filteredFaqs,
      toggleFaq,
      toggleTransactionFaq,
      toggleSidebar,
      redirectToCreateFAQ,
      logout,
      userName
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