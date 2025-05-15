<template>
  <AuthenticatedLayout/>
  <div class="min-h-screen bg-gray-50">
    
    
    <!-- Main Container -->
    <div class="flex pt-4">
      
      <!-- Sidebar -->
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

          <button @click="goToFAQ">
            <div
              :class="[
                'bg-purple-400 p-4 rounded-lg flex flex-col items-center cursor-pointer hover:bg-purple-300 transition-all duration-300',
                showSidebar ? 'transform-none' : 'transform -translate-x-full lg:transform-none',
                'transition-transform delay-100'
              ]"
            >
              <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <span class="font-bold text-sm mt-2">Helpdesk</span>
            </div>
         </button>

          <!-- <a href="/Setting">
            <div
              :class="[
                'bg-purple-400 p-4 rounded-lg flex flex-col items-center cursor-pointer hover:bg-purple-300 transition-all duration-300',
                showSidebar ? 'transform-none' : 'transform -translate-x-full lg:transform-none',
                'transition-transform delay-100'
              ]"
            >
            <img src="/images/sett.png" alt="Pengaturan" class="w-11 h-11" />
              <span class="font-bold text-sm mt-1">Pengaturan</span>
            </div>
          </a> -->
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

      <!-- Konten Utama -->
      <div class="w-full transition-all duration-300" :class="{'lg:ml-48': true, 'ml-0': !showSidebar}">

        <div class="pt-1 pb-6 px-8 flex-1 overflow-auto">
          <div class="pt-4 ">
            
            <div v-if="$page.props.flash && $page.props.flash.message" 
                 class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
              {{ $page.props.flash.message }}
            </div>

            <!-- Tombol Helpdesk dan FAQ -->
            <!-- <div class="mb-4 flex space-x-2">
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
            </div> -->
          </div>

          <!-- Tab Navigation -->
          <div class="sticky top-10 bg-white py-4 z-10 flex gap-2 overflow-x-auto border-b mb-6">
            <button
              @click="selectedTab = 'request'"
              :class="[
                'px-3 py-2 rounded-md font-bold whitespace-nowrap',
                selectedTab === 'request' ? 'bg-purple-700 text-white' : 'bg-gray-200'
              ]"
            >
              Request
            </button>
            <button
              @click="selectedTab = 'accepted'"
              :class="[
                'px-3 py-2 rounded-md font-bold whitespace-nowrap',
                selectedTab === 'accepted' ? 'bg-purple-700 text-white' : 'bg-gray-200'
              ]"
            >
              Accepted
            </button>
            <button
              @click="selectedTab = 'rejected'"
              :class="[
                'px-3 py-2 rounded-md font-bold whitespace-nowrap',
                selectedTab === 'rejected' ? 'bg-purple-700 text-white' : 'bg-gray-200'
              ]"
            >
              Rejected
            </button>
          </div>

          <!-- Daftar Biodata -->
          <div class="bg-white p-4 rounded-lg shadow max-h-[calc(100vh-180px)] overflow-y-auto">
            <div v-if="selectedTab === 'request' && filteredUsers.length === 0" class="text-center py-8">
              <svg class="w-16 h-16 mx-auto text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <p class="text-gray-500 mt-4">Tidak ada permintaan pendaftaran yang menunggu persetujuan.</p>
            </div>

            <div v-else-if="selectedTab === 'request'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div
                v-for="user in filteredUsers"
                :key="user.id"
                class="bg-gray-100 p-4 rounded-lg shadow text-center transition-all duration-200 hover:shadow-md"
              >
                <!-- Preview Selfie kecil -->
                <div class="mb-3 flex justify-center">
                  <img 
                    :src="getImageUrl(user.selfie_photo)" 
                    class="w-12 h-12 rounded-full object-cover border-2 border-purple-400" 
                    alt="Profile" 
                    @error="handleImageError"
                  />
                </div>
                <h3 class="font-bold">{{ user.name }}</h3>
                <p class="text-sm"><strong>NIK:</strong> {{ user.nik }}</p>
                <p class="text-sm">
                  <strong>Email:</strong>
                  <a :href="'mailto:' + user.email" class="text-blue-500">{{ user.email }}</a>
                </p>
                <p class="text-sm"><strong>Nomor HP:</strong> {{ user.phone }}</p>
                <p class="text-sm text-gray-700 truncate" :title="user.address">
                  <strong>Alamat:</strong> {{ user.address }}
                </p>
                
                <!-- Preview dokumen KTP kecil -->
                <!-- <div class="mt-2 mb-2">
                  <p class="text-xs text-gray-500 mb-1">KTP:</p>
                  <div class="bg-gray-200 rounded overflow-hidden h-16 flex items-center justify-center">
                    <img 
                      :src="getImageUrl(user.ktp_photo)" 
                      class="h-full object-contain" 
                      alt="KTP Preview"
                      @error="handleImageError"
                    />
                  </div>
                </div> -->
                
                <div class="flex gap-2 justify-center mt-3">
                  <button
                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm transition-colors"
                    @click="showDetails(user)"
                  >
                    🔍 Detail
                  </button>
                  <button
                    class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm transition-colors"
                    @click="approveUser(user.id)"
                  >
                    ✅ Accept
                  </button>
                  <button
                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm transition-colors"
                    @click="rejectUser(user.id)"
                  >
                    ❌ Reject
                  </button>
                </div>
              </div>
            </div>

            <div v-else-if="selectedTab === 'accepted' || selectedTab === 'rejected'" class="text-center py-8">
              <svg class="w-16 h-16 mx-auto text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <p class="text-gray-500 mt-4">No items to display in this category</p>
            </div>
          </div>
        </div>

        <!-- Modal Profil Mobile -->
        <div
          :class="[
            'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center transition-opacity duration-300',
            showProfile ? 'opacity-100' : 'opacity-0 pointer-events-none'
          ]"
          @click="showProfile = false"
        >
          <div 
            class="bg-white p-6 rounded-lg w-64 text-center transform transition-transform duration-300"
            :class="[showProfile ? 'scale-100' : 'scale-90']"
            @click.stop
          >
            <img
              src="/images/profile.png"
              class="w-24 h-24 rounded-full mx-auto border-4 border-purple-200 mb-4"
              alt="Profile Petugas"
            />
            <h3 class="font-bold text-xl">{{ $page.props.auth.user.name }}</h3>
            <p class="text-gray-600 mb-4">Verifikator</p>
            <button @click="showProfile = false" class="bg-purple-600 text-white px-4 py-2 rounded-lg w-full">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Detail -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md max-h-[80vh] overflow-y-auto mx-4">
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
              class="w-full max-h-60 object-contain rounded-lg border border-gray-300"
              @error="handleImageError">
          <!-- Link untuk melihat/download gambar -->
          <a :href="getImageUrl(selectedUser.ktp_photo)" target="_blank" class="text-blue-500 text-sm mt-1 inline-block">
            Lihat Gambar Asli
          </a>
        </div>

        <div class="mt-4">
          <h3 class="font-semibold">Foto Selfie:</h3>
          <img :src="getImageUrl(selectedUser.selfie_photo)" 
              alt="Foto Selfie" 
              class="w-full max-h-60 object-contain rounded-lg border border-gray-300"
              @error="handleImageError">
          <!-- Link untuk melihat/download gambar -->
          <a :href="getImageUrl(selectedUser.selfie_photo)" target="_blank" class="text-blue-500 text-sm mt-1 inline-block">
            Lihat Gambar Asli
          </a>
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
  </div>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';

export default {
  components: {
    AuthenticatedLayout
  },
  
  props: {
    pendingUsers: Array,
  },

  data() {
    return {
      selectedTab: "request",
      showSidebar: window.innerWidth >= 1024,
      showProfile: false,
      showModal: false,
      selectedUser: {},
      acceptedUsers: [],
      rejectedUsers: [],
      fallbackImage: '/images/profile.png'
    };
  },
  
  computed: {
    filteredUsers() {
      if (this.selectedTab === 'request') {
        return this.pendingUsers || [];
      } else if (this.selectedTab === 'accepted') {
        return this.acceptedUsers;
      } else if (this.selectedTab === 'rejected') {
        return this.rejectedUsers;
      }
      return [];
    }
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
      if (!photoPath) return '/images/default.png';
      
      // Handle full URLs (in case they're already absolute)
      if (photoPath.startsWith('http')) {
        return photoPath;
      }
      
      // Ensure path starts with /storage/ for Laravel public storage
      if (!photoPath.startsWith('/storage/')) {
        return `/storage/${photoPath}`;
      }
      
      return photoPath;
    },
    
    // Handle image loading errors
    handleImageError(e) {
      e.target.src = this.fallbackImage;
    },

    goToHelpdesk() {
      router.get(route('verificator.helpdesk.create'));
    },

    goToFAQ() {
      router.get(route('verificator.helpdesk.faq'));
    },
    
    handleResize() {
      if (window.innerWidth < 1024) {
        this.showSidebar = false;
      } else {
        this.showSidebar = true;
      }
    },
    
    logout() {
      router.post(route('logout'));
    }
  },
  
  mounted() {
    window.addEventListener("resize", this.handleResize);
  },
  
  beforeUnmount() {
    window.removeEventListener("resize", this.handleResize);
  }
};
</script>

<style scoped>
/* Improved styles for image display */
img.rounded-full {
  object-fit: cover;
  border: 2px solid #a78bfa;
}

/* Hover effect for images */
.bg-gray-200 img:hover {
  transform: scale(1.05);
  transition: transform 0.3s ease;
}

/* Additional animation for loading images */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

img {
  animation: fadeIn 0.3s ease;
}
</style>