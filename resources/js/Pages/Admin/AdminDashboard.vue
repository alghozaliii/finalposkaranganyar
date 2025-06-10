<template>
  <Head title="Admin Dashboard" />

  <AuthenticatedLayout>
    <div class="flex flex-col min-h-screen bg-gray-100">
      <!-- Sidebar - Made collapsible on mobile -->
      <aside
        :class="[
          'bg-white shadow-lg flex flex-col items-center pt-6 transition-all duration-300 ease-in-out z-30',
          mobileMenuOpen ? 'fixed inset-y-0 left-0 w-64' : '-translate-x-full fixed inset-y-0 left-0 w-64',
          'md:translate-x-0 md:static md:w-20 lg:w-24'
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

      <!-- Main content wrapper -->
      <div class="flex-1 w-full md:pl-20 lg:pl-24">
        <!-- Mobile header - Updated styling -->
        <header class="sticky top-0 bg-white p-4 shadow flex items-center justify-between md:hidden">
          <button 
            @click="toggleMobileMenu()"
            class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-lg font-semibold">Dashboard</h1>
          <div class="w-6"></div>
        </header>

        <!-- Main content area - Updated padding and spacing -->
        <main class="p-4 md:p-6 space-y-6">
          <!-- Stats Cards - Updated responsive grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            <!-- Total Owners Card -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-4 md:p-6 text-white">
              <h3 class="text-base md:text-lg mb-2 md:mb-4">Total Owners</h3>
              <div class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2 md:mb-4">{{ totalOwners }}</div>
              <div class="flex items-center text-sm md:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>Total registered owners</span>
              </div>
            </div>

            <!-- Active Stores Card -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-4 md:p-6 text-white">
              <h3 class="text-base md:text-lg mb-2 md:mb-4">Active Stores</h3>
              <div class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2 md:mb-4">0</div>
              <div class="flex items-center text-sm md:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>0% from last month</span>
              </div>
            </div>

            <!-- Total Sales Card -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-4 md:p-6 text-white">
              <h3 class="text-base md:text-lg mb-2 md:mb-4">Total Sales</h3>
              <div class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2 md:mb-4">Rp 0</div>
              <div class="flex items-center text-sm md:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>0% from last month</span>
              </div>
            </div>
          </div>

          <!-- Store Information Table - Made scrollable on mobile -->
          <div class="bg-white rounded-lg border overflow-hidden">
            <div class="p-4 md:p-6">
              <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-4">Store Information</h2>
              <div class="overflow-x-auto -mx-4 md:mx-0">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Store Name
                      </th>
                      <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Owner Email
                      </th>
                      <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Employees
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="!owners.length">
                      <td colspan="3" class="px-3 md:px-6 py-4 text-center text-gray-500">No stores registered</td>
                    </tr>
                    <tr v-for="owner in owners" :key="owner.id" class="hover:bg-gray-50">
                      <td class="px-3 md:px-6 py-4 text-sm">
                        <div class="break-words">{{ owner.store_name || '-' }}</div>
                      </td>
                      <td class="px-3 md:px-6 py-4 text-sm">
                        <div class="break-words">{{ owner.email }}</div>
                      </td>
                      <td class="px-3 md:px-6 py-4 text-sm">
                        <div v-if="owner.employees && owner.employees.length" class="space-y-1">
                          <div v-for="emp in owner.employees" :key="emp.id" class="break-words">
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
/* Add touch-friendly scrolling for mobile */
.overflow-x-auto {
  -webkit-overflow-scrolling: touch;
}

/* Custom scrollbar styling */
::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}

::-webkit-scrollbar-track {
  background: rgba(39, 39, 42, 0.1);
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: rgba(139, 92, 246, 0.3);
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(139, 92, 246, 0.5);
}

/* Add smooth transitions */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}
</style>