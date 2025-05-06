<template>
  <Head title="Owner Dashboard" />

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
          
          <!-- Transaksi -->
          <button @click="goToSales" class="flex flex-col items-center">
            <div class="p-3 rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
            </div>
            <span class="text-xs mt-2">Transaksi</span>
          </button>
          
          <!-- Stok barang -->
          <div className="w-full flex flex-col items-center py-4 text-gray-600">
              <div className="mb-1 text-lg">📦</div>
              <span className="text-xs">Stok barang</span>
            </div>

          <!-- Karyawan -->
          <button @click="activateSection('employees')" class="flex flex-col items-center">
            <div class="p-3 rounded-md" :class="activeSection==='employees' ? 'bg-purple-100 text-purple-700' : 'text-gray-500'">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="activeSection==='employees' ? 'text-purple-700' : 'text-gray-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
            </div>
            <span class="text-xs mt-2">Karyawan</span>
          </button>
          
          <!-- Helpdesk -->
          <button @click="goToFAQ" class="flex flex-col items-center">
            <div class="p-3 rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <span class="text-xs mt-2">Helpdesk</span>
          </button>
          
          <!-- Rekomendasi -->
          <button @click="goToRecommendation" class="flex flex-col items-center">
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
          <h1 class="text-lg font-semibold">Dashboard</h1>
          <div class="w-8 h-8 rounded-full bg-gray-300"></div>
        </header>

        <main class="p-6 space-y-8">
          <!-- Dashboard Section -->
          <div v-if="activeSection==='dashboard'">
            <!-- HEADER desktop & Search -->
            <div class="hidden md:flex justify-between items-center mb-6">
              <div><h1 class="text-xl">Dashboard /Owner</h1></div>
              <div class="flex items-center gap-4">
                
              </div>
            </div>

            <!-- Welcome Row -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
              <h2 class="text-xl font-semibold text-gray-700">Welcome, Toko Semangat!</h2>
              <div class="flex flex-col sm:flex-row gap-2">
                <div class="flex">
                  <button @click="setActiveTab('Day')" :class="activeTab==='Day'? tabActive:tabInactive" class="px-4 py-1 rounded-l-md">Day</button>
                  <button @click="setActiveTab('Week')" :class="activeTab==='Week'? tabActive:tabInactive" class="px-4 py-1">Week</button>
                  <button @click="setActiveTab('Month')" :class="activeTab==='Month'? tabActive:tabInactive" class="px-4 py-1">Month</button>
                  <button @click="setActiveTab('Year')" :class="activeTab==='Year'? tabActive:tabInactive" class="px-4 py-1 rounded-r-md">Year</button>
                </div>
                <div class="bg-white rounded-lg border px-4 py-1 flex items-center gap-2">
                  <span class="text-sm text-gray-600">{{ startDate }} - {{ endDate }}</span>
                </div>
              </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
              <!-- Total Revenue Card --> 
              <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-6 text-white">
                <h3 class="text-lg mb-4">Total Revenue</h3>
                <div class="text-3xl sm:text-4xl font-bold mb-4">Rp {{ formatCurrency(totalRevenue) }}</div>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                  </svg>
                  <span>{{ revenueGrowth }}% from last month</span>
                </div>
              </div>
              <!-- Total Sales Card -->
              <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-6 text-white">
                <h3 class="text-lg mb-4">Total Sales</h3>
                <div class="text-3xl sm:text-4xl font-bold mb-4">{{ totalSales }}</div>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                  </svg>
                  <span>{{ salesGrowth }}% from last month</span>
                </div>
              </div>
              <!-- Customer Card -->
              <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-6 text-white">
                <h3 class="text-lg mb-4">Customer</h3>
                <div class="text-3xl sm:text-4xl font-bold mb-4">{{ totalCustomers }}</div>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                  </svg>
                  <span>{{ customerGrowth }}% from last Month</span>
                </div>
              </div>
            </div>
            
            <!-- Revenue Chart and Top Products -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
              <!-- Revenue Chart -->
              <div class="lg:col-span-2 bg-white rounded-lg border p-6">
                <div class="flex justify-between items-center mb-4">
                  <h3 class="text-lg font-medium">Total Revenue</h3>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/>
                  </svg>
                </div>
                <div class="h-64 flex items-end justify-between gap-2">
                  <div class="h-1/2 w-16 bg-purple-200 rounded-t-lg"></div>
                  <div class="h-2/3 w-16 bg-purple-200 rounded-t-lg"></div>
                  <div class="h-1/3 w-16 bg-purple-200 rounded-t-lg"></div>
                  <div class="h-5/6 w-16 bg-purple-200 rounded-t-lg"></div>
                  <div class="h-2/5 w-16 bg-purple-200 rounded-t-lg"></div>
                  <div class="h-3/4 w-16 bg-purple-200 rounded-t-lg"></div>
                  <div class="h-4/5 w-16 bg-purple-700 rounded-t-lg"></div>
                </div>
                <div class="flex justify-between mt-2 text-sm text-gray-500">
                  <div>Feb</div><div>March</div><div>April</div><div>May</div><div>June</div><div>July</div><div>August</div>
                </div>
              </div>
              <!-- Top Products -->
              <div class="bg-white rounded-lg border p-6">
                <h3 class="text-lg font-medium mb-4">Top Products</h3>
                <div class="space-y-4">
                  <div v-for="(product, index) in recommendedProducts" :key="index" class="border-b pb-3 last:border-0">
                    <div class="flex justify-between items-center">
                      <div class="text-sm">
                        <span class="text-gray-500">{{ String(index+1).padStart(2,'0') }}</span>
                        <span class="ml-2">{{ product.name }}</span>
                      </div>
                      <div class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs">{{ product.sales }}%</div>
                    </div>
                  </div>
                </div>
                <div v-if="recommendedProducts && recommendedProducts.length > 0" class="mt-6 bg-blue-100 rounded-lg p-4 flex items-center justify-center">
                  <div class="text-center">
                    <div class="text-yellow-500 text-2xl mb-2">👑</div>
                    <div class="font-bold">Top 1</div>
                    <div class="text-blue-700 font-semibold">{{ recommendedProducts[0]?.name }}</div>
                  </div>
                </div>
                <div v-else class="mt-6 bg-gray-100 rounded-lg p-4 flex items-center justify-center">
                  <div class="text-center text-gray-500">
                    No product data available
                  </div>
                </div>
              </div>
            </div>

            <!-- Transaction History -->
            <div class="bg-white rounded-lg border p-6 overflow-x-auto">
              <h3 class="text-lg font-medium mb-4">History</h3>
              <table class="w-full min-w-full">
                <thead>
                  <tr class="text-left text-gray-500 text-sm">
                    <th class="pb-3">ID</th><th class="pb-3">Date</th><th class="pb-3">Cashier</th><th class="pb-3">Total Item</th><th class="pb-3">Total Price</th><th class="pb-3">Status</th><th class="pb-3"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="transaction in transactionHistory" :key="transaction.id" class="border-t">
                    <td class="py-3">{{ transaction.id }}</td>
                    <td class="py-3">{{ transaction.date }}</td>
                    <td class="py-3">{{ transaction.cashier }}</td>
                    <td class="py-3">{{ transaction.totalItem }}</td>
                    <td class="py-3">Rp {{ formatCurrency(transaction.totalPrice) }}</td>
                    <td class="py-3">
                      <span class="px-3 py-1 rounded-full text-xs" :class="transaction.status==='Success'? 'bg-green-100 text-green-600':'bg-red-100 text-red-600'">
                        {{ transaction.status }}
                      </span>
                    </td>
                    <td class="py-3 text-center">
                      <button class="text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>


          <!-- Stok barang Section -->

          <!-- Laporan Section -->



          <!-- Employees Section -->
          <div v-if="activeSection==='employees'" class="space-y-6">
            <!-- Form Tambah Employee -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Karyawan</h3>
              <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                  <input id="name" v-model="form.name" type="text" required
                         class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"/>
                  <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                </div>

                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                  <input id="email" v-model="form.email" type="email" required
                         class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"/>
                  <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                </div>

                <div>
                  <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                  <input id="password" v-model="form.password" type="password" required
                         class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"/>
                  <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</div>
                </div>

                <div>
                  <label for="employees_role" class="block text-sm font-medium text-gray-700">Role</label>
                  <select id="employees_role" v-model="form.employees_role"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="cashier">Cashier</option>
                    <option value="stock">Stock Admin</option>
                  </select>
                  <div v-if="form.errors.employees_role" class="text-red-500 text-sm mt-1">{{ form.errors.employees_role }}</div>
                </div>

                <div class="md:col-span-4">
                  <button type="submit" :disabled="form.processing"
                          class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Tambah Karyawan
                  </button>
                </div>
              </form>
            </div>

            <!-- Tabel Daftar Karyawan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Karyawan</h3>
              <div v-if="employees.length" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="employees.length===0">
                      <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada karyawan terdaftar.</td>
                    </tr>
                    <tr v-for="(emp, idx) in employees" :key="emp.id">
                      <td class="px-6 py-4 whitespace-nowrap">{{ idx+1 }}</td>
                      <td class="px-6 py-4 whitespace-nowrap">{{ emp.name }}</td>
                      <td class="px-6 py-4 whitespace-nowrap">{{ emp.email }}</td>
                      <td class="px-6 py-4 whitespace-nowrap capitalize">{{ emp.employees_role }}</td>
                      <td class="px-6 py-4 whitespace-nowrap">{{ emp.created_at }}</td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                          Aktif
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <button @click="deleteEmployee(emp.id)" class="text-red-600 hover:text-red-900">
                          Hapus
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, onMounted, computed, watch } from 'vue';
import axios from 'axios';

// Props awal (fallback)
const props = defineProps({
  employees: { type: Array, default: () => [] },
  totalRevenue: { type: Number, default: 0 },
  totalSales: { type: Number, default: 0 },
  totalCustomers: { type: Number, default: 0 },
  revenueGrowth: { type: Number, default: 0 },
  salesGrowth: { type: Number, default: 0 },
  customerGrowth: { type: Number, default: 0 },
  topProducts: { type: Array, default: () => [] },
  transactionHistory: { type: Array, default: () => [] },
  startDate: { type: String, default: '' },
  endDate: { type: String, default: '' },
  activeTab: { type: String, default: 'Month' },
  salesrecommendation: { type: Array, default: () => [] }
});



// Debugging - log props
console.log('Props received:', {
  employees: props.employees,
  topProducts: props.topProducts,
  salesrecommendation: props.salesrecommendation
});

// Reactive data
const employees = ref(props.employees);
const totalRevenue = ref(props.totalRevenue);
const totalSales = ref(props.totalSales);
const totalCustomers = ref(props.totalCustomers);
const revenueGrowth = ref(props.revenueGrowth);
const salesGrowth = ref(props.salesGrowth);
const customerGrowth = ref(props.customerGrowth);
const topProducts = ref(props.topProducts || []);
const salesrecommendation = ref(props.salesrecommendation || []);
const transactionHistory = ref(props.transactionHistory);
const startDate = ref(props.startDate);
const endDate = ref(props.endDate);
const activeTab = ref(props.activeTab);

// Computed property for products to display
const recommendedProducts = computed(() => {
  console.log('Computing recommendedProducts', {
    salesrecommendation: salesrecommendation.value,
    topProducts: topProducts.value
  });
  
  if (salesrecommendation.value && salesrecommendation.value.length > 0) {
    return salesrecommendation.value;
  }
  return topProducts.value || [];
});

// UI state
const mobileMenuOpen = ref(false);
const activeSection = ref('dashboard'); // 'dashboard' or 'employees'

// Tab classes
const tabActive = 'bg-blue-100 text-blue-700';
const tabInactive = 'bg-gray-100 text-gray-500';

// Form karyawan
const form = useForm({
  name: '',
  email: '',
  password: '',
  employees_role: 'cashier'
});

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
const goToFAQ = () => router.get(route('verificator.helpdesk.faq'));
const goToSales = () => router.get(route('owner.sales'));
const goToRecommendation = () => router.get(route('owner.sales.recommendation'));
const logout = () => router.post(route('logout'));
const setActiveTab = t => activeTab.value = t;
const formatCurrency = v => new Intl.NumberFormat('id-ID').format(v);

// Submit tambah karyawan
const submitForm = () => {
  form.post(route('employees.store'), {
    onSuccess: () => form.reset()
  });
};

// Hapus karyawan
const deleteEmployee = async (id) => {
  if (!confirm('Yakin ingin menghapus karyawan ini?')) return;
  await axios.delete(route('employees.destroy', id));
  employees.value = employees.value.filter(e => e.id !== id);
};

  // Sinkronisasi data saat mounted
  onMounted(async () => {
    try {
      // Mendapatkan data sales
      const { data } = await axios.get('/owner/sales');
      totalRevenue.value       = data.totalRevenue       ?? totalRevenue.value;
      totalSales.value         = data.totalSales         ?? totalSales.value;
      totalCustomers.value     = data.totalCustomers     ?? totalCustomers.value;
      revenueGrowth.value      = data.revenueGrowth      ?? revenueGrowth.value;
      salesGrowth.value        = data.salesGrowth        ?? salesGrowth.value;
      customerGrowth.value     = data.customerGrowth     ?? customerGrowth.value;
      topProducts.value        = data.topProducts        ?? topProducts.value;
      salesrecommendation.value = data.salesrecommendation ?? salesrecommendation.value;
      transactionHistory.value = data.transactionHistory ?? transactionHistory.value;
      employees.value          = data.employees          ?? employees.value;
      if (data.startDate)   startDate.value = data.startDate;
      if (data.endDate)     endDate.value   = data.endDate;
      if (data.activeTab)   activeTab.value = data.activeTab;
    } catch (e) {
      console.error('Gagal sinkronisasi data sales:', e);
    }
  });
  </script>
