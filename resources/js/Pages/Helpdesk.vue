<template>
    <AuthenticatedLayout title="Helpdesk">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Helpdesk - Tambah FAQ</h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              <h3 class="text-lg font-medium mb-4">Tambah Pertanyaan FAQ</h3>
  
              <form @submit.prevent="submitFAQ">
                <!-- Kategori -->
                <div class="mb-4">
                  <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                  <select v-model="faq.category" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    <option disabled value="">Pilih Kategori</option>
                    <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
                  </select>
                </div>
  
                <!-- Pertanyaan -->
                <div class="mb-4">
                  <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                  <input
                    type="text"
                    id="question"
                    v-model="faq.question"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                    placeholder="Masukkan pertanyaan"
                  />
                </div>
  
                <!-- Jawaban -->
                <div class="mb-4">
                  <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban</label>
                  <textarea
                    id="answer"
                    v-model="faq.answer"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                    placeholder="Masukkan jawaban"
                    rows="4"
                  ></textarea>
                </div>
  
                <!-- Tombol Submit -->
                <div class="flex justify-end">
                  <button
                    type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 transition"
                  >
                    Simpan FAQ
                  </button>
                </div>
              </form>
  
              <!-- Pesan sukses -->
              <div v-if="successMessage" class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                {{ successMessage }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script>
  import { router } from "@inertiajs/vue3";
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  
  export default {
    components: {
      AuthenticatedLayout,
    },
    data() {
      return {
        faq: {
          category: "",
          question: "",
          answer: "",
        },
        categories: [
          "Umum",
          "Produk",
          "Transaksi",
          "Pelanggan",
          "Laporan",
          "Keamanan",
          "Integrasi",
          "Bantuan",
        ],
        successMessage: "",
      };
    },
    methods: {
      submitFAQ() {
  router.post("/verificator/helpdesk/store", this.faq, {
    onSuccess: () => {
      this.successMessage = "FAQ berhasil ditambahkan!";
      this.faq.category = "";
      this.faq.question = "";
      this.faq.answer = "";
    },
  });
},

    },
  };
  </script>
  