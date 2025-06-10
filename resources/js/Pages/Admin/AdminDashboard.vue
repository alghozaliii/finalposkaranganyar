<template>
  <Head title="Admin Dashboard" />

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
          <button @click="activateSection('dashboard')" class="flex flex-col items-center">
            <div class="p-3 rounded-md" :class="activeSection==='dashboard' ? 'bg-purple-100 text-purple-700' : 'text-gray-500'">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="activeSection==='dashboard' ? 'text-purple-700' : ''">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
              </svg>
            </div>
            <span class="text-xs mt-2">Dashboard</span>
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
          <h1 class="text-lg font-semibold">Dashboard</h1>
          <div class="w-8 h-8 rounded-full bg-gray-300"></div>
        </header>

        <main class="p-6 space-y-8">
          <!-- Stats Cards -->
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Owners Card -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-6 text-white">
              <h3 class="text-lg mb-4">Total Owners</h3>
              <div class="text-3xl sm:text-4xl font-bold mb-4">{{ totalOwners }}</div>
              <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>Total registered owners</span>
              </div>
            </div>

            <!-- Active Stores Card -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-6 text-white">
              <h3 class="text-lg mb-4">Active Stores</h3>
              <div class="text-3xl sm:text-4xl font-bold mb-4">0</div>
              <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>0% from last month</span>
              </div>
            </div>

            <!-- Total Sales Card -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-6 text-white">
              <h3 class="text-lg mb-4">Total Sales</h3>
              <div class="text-3xl sm:text-4xl font-bold mb-4">Rp 0</div>
              <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>0% from last month</span>
              </div>
            </div>
          </div>

          <!-- Store Information Table -->
          <div class="bg-white rounded-lg border p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Store Information</h2>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Store Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employees</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-if="!owners.length">
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No stores registered</td>
                  </tr>
                  <tr v-for="owner in owners" :key="owner.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ owner.store_name || '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ owner.email }}</td>
                    <td class="px-6 py-4">
                      <div v-if="owner.employees && owner.employees.length" class="space-y-1">
                        <div v-for="emp in owner.employees" :key="emp.id" class="text-sm">
                          {{ emp.name }} ({{ emp.employees_role }})
                        </div>
                      </div>
                      <span v-else class="text-gray-500">No employees</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Recent Activity -->
          <div class="bg-white rounded-lg border p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Activity</h2>
            <div class="space-y-4">
              <p class="text-gray-500 text-center py-8">No recent activity</p>
            </div>
          </div>
        </main>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

// Props
const props = defineProps({
  totalOwners: {
    type: Number,
    default: 0
  },
  owners: {
    type: Array,
    default: () => []
  }
});

// UI state
const mobileMenuOpen = ref(false);
const activeSection = ref('dashboard');

// Toggle sidebar
const toggleMobileMenu = (force) => {
  mobileMenuOpen.value = force === false ? false : !mobileMenuOpen.value;
};

// Activate section
const activateSection = (section) => {
  activeSection.value = section;
  mobileMenuOpen.value = false;
};

// Navigation
const logout = () => router.post(route('logout'));
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: rgba(39, 39, 42, 0.5);
}

::-webkit-scrollbar-thumb {
  background: rgba(139, 92, 246, 0.5);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(139, 92, 246, 0.7);
}
</style>