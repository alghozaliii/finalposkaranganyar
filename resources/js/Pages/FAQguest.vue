<template>
  <div class="min-h-screen bg-purple-50">
    <NavigationHeader />
    
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

    <NavigationFooter />
  </div>
</template>

<script>
import { ref, computed } from 'vue';
import NavigationHeader from '@/Components/NavigationHeader.vue';
import NavigationFooter from '@/Components/NavigationFooter.vue';

export default {
  components: {
    NavigationHeader,
    NavigationFooter
  },
  
  props: {
    faqs: {
      type: Array,
      default: () => []
    }
  },
  
  setup(props) {
    const searchQuery = ref('');
    
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
    
    return {
      searchQuery,
      faqData,
      transactionFaqs,
      filteredGeneralFaqs,
      filteredTransactionFaqs,
      toggleFaq
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