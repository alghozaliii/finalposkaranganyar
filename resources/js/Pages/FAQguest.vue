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

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6288225210672" 
       target="_blank"
       class="fixed bottom-8 right-8 bg-green-500 p-4 rounded-full shadow-lg hover:bg-green-600 transition-colors z-50">
      <svg xmlns="http://www.w3.org/2000/svg" 
           class="h-8 w-8 text-white"
           viewBox="0 0 24 24" 
           fill="currentColor">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
      </svg>
    </a>
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