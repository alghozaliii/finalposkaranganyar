<template>
  <div class="h-screen bg-purple-50 flex flex-col overflow-hidden">
    <AuthenticatedLayout/>
    
    <!-- Main Container -->
    <div class="flex h-screen overflow-hidden">
      
      <!-- Sidebar -->
      <aside
        :class="[
          'bg-white shadow-lg flex flex-col items-center pt-6 fixed inset-y-0 left-0 h-screen transition-transform z-30',
          showSidebar ? 'translate-x-0' : '-translate-x-full',
          'md:translate-x-0 md:static md:w-24 w-64'
        ]"
      >        
        <nav class="flex flex-col items-center gap-10 mt-8 flex-1">  
          <!-- Dashboard -->
          <button @click="goToDashboard" class="flex flex-col items-center">
            <div class="p-3 rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
              </svg>
            </div>
            <span class="text-xs mt-2">Dashboard</span>
          </button>

          <!-- Helpdesk -->
          <button @click="goToFAQ" class="flex flex-col items-center">
            <div class="p-3 rounded-md" :class="activeSection==='helpdesk' ? 'bg-purple-100 text-purple-700' : 'text-gray-500'">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="activeSection==='helpdesk' ? 'text-purple-500' : ''">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <span class="text-xs mt-2">Helpdesk</span>
          </button>
        </nav>
        
        <button @click="logout" class="flex flex-col items-center mt-auto mb-20">
          <div class="p-3 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
          </div>
          <span class="text-xs">Logout</span>
        </button>
      </aside>

      <!-- Overlay mobile -->
      <div
        v-if="showSidebar"
        @click="showSidebar = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden"
      ></div>

      <!-- Main Content Area -->
      <div class="w-full flex flex-col transition-all duration-300" :class="{'lg:ml-0': true, 'ml-0': !showSidebar}">
        <!-- Fixed Header Area -->
        <div class="px-6 py-4 bg-purple-50 shadow-sm">
          <div class="flex items-center justify-between">
            <div>
              <button @click="toggleSidebar" class="lg:hidden text-black">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button>
              <h1 class="text-2xl font-bold text-black inline-block ml-2">F.A.Q. </h1>
            </div>
            
            <!-- Tambah Button -->
            <button 
              @click="redirectToCreateFAQ" 
              class="bg-white text-purple-600 px-4 py-2 rounded-md flex items-center font-medium hover:bg-gray-100 transition"
            >
              <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Tambah
            </button>
          </div>
          
          <!-- Search Box -->
          <div class="relative mt-4">
            <input 
              type="text" 
              v-model="searchQuery"
              class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-purple-400"
              placeholder="Search" 
            />
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
          </div>
          
          <!-- Last Updated Info -->
          <div class="flex items-center text-black mt-4">
            <span>Last updated: {{ lastUpdated }}</span>
            <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
            </svg>
          </div>
        </div>
        
        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-hidden flex">
          <!-- Main scrollable content -->
          <div class="flex-1 overflow-auto px-6 pb-6">
            <!-- FAQ Categories -->
            <div class="mt-4">
              <h2 class="text-xl font-semibold text-black mb-2">{{ selectedCategory }}</h2>
              
              <!-- FAQ Items table -->
              <div class="w-full bg-white rounded-lg overflow-hidden shadow">
                <table class="min-w-full">
                  <thead>
                    <tr class="bg-gray-50 border-b">
                      <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Question</th>
                      <th class="py-3 px-4 text-right w-16">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <template v-for="(faq, index) in filteredFaqs" :key="index">
                      <tr class="border-b hover:bg-purple-50">
                        <td class="py-3 px-4 text-sm text-gray-800">{{ faq.question }}</td>
                        <td class="py-3 px-4 text-right">
                          <button @click="toggleFaq(index)" class="text-purple-600">
                            <svg
                              :class="{'transform rotate-180': faq.open, 'transform rotate-0': !faq.open}"
                              class="w-5 h-5 transition-transform duration-200 inline-block"
                              xmlns="http://www.w3.org/2000/svg" 
                              fill="none" 
                              viewBox="0 0 24 24" 
                              stroke="currentColor"
                            >
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                          </button>
                        </td>
                      </tr>
                      <tr v-if="faq.open" class="bg-purple-200">
                        <td colspan="2" class="py-3 px-4 text-sm text-gray-700 border-b">
                          <p>{{ faq.answer }}</p>
                        </td>
                      </tr>
                    </template>
                  </tbody>
                </table>
              </div>
            </div>
            
            <!-- Transaction Category Section -->
            <div v-if="selectedCategory === 'General Question'" class="mt-6">
              <h2 class="text-xl font-semibold text-black mb-2">Transaction Question</h2>
              
              <div class="w-full bg-white rounded-lg overflow-hidden shadow">
                <table class="min-w-full">
                  <thead>
                    <tr class="bg-gray-50 border-b">
                      <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Question</th>
                      <th class="py-3 px-4 text-right w-16">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <template v-for="(faq, index) in transactionFaqs" :key="`transaction-${index}`">
                      <tr class="border-b hover:bg-purple-50">
                        <td class="py-3 px-4 text-sm text-gray-800">{{ faq.question }}</td>
                        <td class="py-3 px-4 text-right">
                          <button @click="toggleTransactionFaq(index)" class="text-purple-600">
                            <svg
                              :class="{'transform rotate-180': faq.open, 'transform rotate-0': !faq.open}"
                              class="w-5 h-5 transition-transform duration-200 inline-block"
                              xmlns="http://www.w3.org/2000/svg" 
                              fill="none" 
                              viewBox="0 0 24 24" 
                              stroke="currentColor"
                            >
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                          </button>
                        </td>
                      </tr>
                      <tr v-if="faq.open" class="bg-purple-200">
                        <td colspan="2" class="py-3 px-4 text-sm text-gray-700 border-b">
                          <p>{{ faq.answer }}</p>
                        </td>
                      </tr>
                    </template>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
          <!-- Right sidebar for admin profile, hidden on mobile -->
          <!-- <div class="hidden lg:block w-64 p-4 bg-white border-l">
            <div class="text-center">
              <img
                src="/images/profile.png"
                class="w-20 h-20 rounded-full mx-auto border-4 border-white mb-3"
                alt="Profile Petugas"
              />
              <h3 class="font-bold text-lg">{{ userName }}</h3>
              <p class="text-gray-600">Verifikator</p>
            </div>
          </div> -->
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
    const activeSection = ref('helpdesk');
    
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

    const goToDashboard = () => {
      router.get(route('dashboard'));
    };

    const goToFAQ = () => {
      router.get(route('verificator.helpdesk.faq'));
      activeSection.value = 'helpdesk';
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
      goToDashboard,
      goToFAQ,
      logout,
      userName,
      activeSection
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
  background: #f1f1f1;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: #9ca3af;
}
</style>