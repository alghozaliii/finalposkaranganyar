<template>
  <AuthenticatedLayout title="Dashboard Verifikator">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard Verifikator
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div v-if="$page.props.flash && $page.props.flash.message" 
             class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
          {{ $page.props.flash.message }}
        </div>

        <!-- Tombol Helpdesk dan FAQ -->
        <div class="mb-4 flex space-x-2">
          <button 
            @click="goToHelpdesk"
            class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"
          >
            + Tambah FAQ
          </button>

          <button 
            @click="goToFAQ"
            class="px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600"
          >
            Lihat FAQ
          </button>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <h3 class="text-lg font-medium mb-4">Permintaan Pendaftaran Menunggu Persetujuan</h3>

            <div v-if="pendingUsers.length === 0" class="text-gray-500">
              Tidak ada permintaan pendaftaran yang menunggu persetujuan.
            </div>

            <table v-else class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="user in pendingUsers" :key="user.id">
                  <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(user.created_at) }}</td>
                  <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                    <button 
                      @click="showDetails(user)"
                      class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-semibold rounded-md hover:bg-yellow-600"
                    >
                      Detail
                    </button>

                    <form @submit.prevent="approveUser(user.id)">
                      <button 
                        type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600"
                      >
                        Setujui
                      </button>
                    </form>

                    <form @submit.prevent="rejectUser(user.id)">
                      <button 
                        type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600"
                      >
                        Tolak
                      </button>
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

<!-- Modal Detail -->
<div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 max-h-[80vh] overflow-y-auto">
    <h2 class="text-xl font-semibold mb-4">Detail Calon Owner</h2>

    <div class="mb-2"><strong>Nama:</strong> {{ selectedUser.name }}</div>
    <div class="mb-2"><strong>Email:</strong> {{ selectedUser.email }}</div>
    <div class="mb-2"><strong>Nomor HP (WA):</strong> {{ selectedUser.phone }}</div>
    <div class="mb-2"><strong>Alamat:</strong> {{ selectedUser.address }}</div>
    <div class="mb-2"><strong>NIK:</strong> {{ selectedUser.nik }}</div>

    <div class="mt-4">
      <h3 class="font-semibold">Foto KTP:</h3>
      <img :src="getImageUrl(selectedUser.ktp_photo)" 
           alt="Foto KTP" 
           class="w-full max-h-60 object-contain rounded-lg">
    </div>

    <div class="mt-4">
      <h3 class="font-semibold">Foto Selfie:</h3>
      <img :src="getImageUrl(selectedUser.selfie_photo)" 
           alt="Foto Selfie" 
           class="w-full max-h-60 object-contain rounded-lg">
    </div>

    <div class="mt-6 flex justify-end space-x-2">
      <button 
        @click="showModal = false"
        class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600"
      >
        Tutup
      </button>
    </div>
  </div>
</div>

  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';

export default {
  components: {
    AuthenticatedLayout,
  },
  
  props: {
    pendingUsers: Array,
  },

  data() {
    return {
      showModal: false,
      selectedUser: {},
    };
  },
  
  methods: {
    formatDate(dateString) {
      const date = new Date(dateString);
      return new Intl.DateTimeFormat('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      }).format(date);
    },
    
    approveUser(userId) {
      router.post(route('verificator.approve', userId));
    },
    
    rejectUser(userId) {
      if (confirm('Apakah Anda yakin ingin menolak pendaftaran ini? Tindakan ini tidak dapat dibatalkan.')) {
        router.post(route('verificator.reject', userId));
      }
    },

    showDetails(user) {
      this.selectedUser = user;
      this.showModal = true;
    },

    getImageUrl(photoPath) {
      return photoPath ? `/storage/${photoPath}` : '/images/default.png';
    },

    goToHelpdesk() {
      router.get(route('verificator.helpdesk.create'));
    },

    goToFAQ() {
      router.get(route('verificator.helpdesk.faq'));
    }
  }
};
</script>
