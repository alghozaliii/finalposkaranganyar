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
          <button @click="goToCashier" class="flex flex-col items-center">
            <div class="p-3 rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
            </div>
            <span class="text-xs mt-2">Transaksi</span>
          </button>
          
          <!-- Stok barang -->
          <button @click="goToStock" class="flex flex-col items-center">
            <div class="p-3 rounded-md" :class="activeSection==='stock' ? 'bg-purple-100 text-purple-700' : 'text-gray-500'">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="activeSection==='stock' ? 'text-purple-700' : 'text-gray-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>
            <span class="text-xs mt-2">Stok barang</span>
          </button>

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
          
          <!-- Laporan -->
      
       <button @click="activateSection('laporan')" class="flex flex-col items-center">
            <div class="p-3 rounded-md" :class="activeSection==='laporan' ? 'bg-purple-100 text-purple-700' : 'text-gray-500'">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="activeSection==='laporan' ? 'text-purple-700' : 'text-gray-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
              <h2 class="text-xl font-semibold text-gray-700">Welcome!</h2>
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
          
          <!-- Laporan Penjualan Section -->
          <div v-if="activeSection === 'laporan'" class="bg-purple-50 rounded-2xl p-5">
            <h1 class="text-2xl text-gray-800 font-semibold mb-5">Laporan Penjualan</h1>
              
            <!-- Date Filter -->
            <div class="flex justify-end mb-5">
              <div class="bg-white px-4 py-2 rounded-full text-sm">
                {{ dateRange }}
              </div>
            </div>
              
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-5">
              <div class="bg-purple-600 text-white rounded-xl p-5">
                <div class="text-sm mb-2">Total Revenue</div>
                <div class="text-2xl font-bold mb-2">Rp {{ formatNumber(totalRevenue) }}</div>
                <div class="text-xs flex items-center text-green-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 19V5M5 12l7-7 7 7"/>
                  </svg>
                  {{ revenueGrowth }}% from last month
                </div>
              </div>
                
              <div class="bg-purple-600 text-white rounded-xl p-5">
                <div class="text-sm mb-2">Total Sales</div>
                <div class="text-2xl font-bold mb-2">{{ totalSales }}</div>
                <div class="text-xs flex items-center text-green-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 19V5M5 12l7-7 7 7"/>
                  </svg>
                  {{ salesGrowth }}% from last month
                </div>
              </div>
                
              <div class="bg-purple-600 text-white rounded-xl p-5">
                <div class="text-sm mb-2">Average Sales</div>
                <div class="text-2xl font-bold mb-2">Rp {{ formatNumber(averageSale) }}</div>
              </div>
                
              <div class="bg-purple-600 text-white rounded-xl p-5">
                <div class="text-sm mb-2">Top Items</div>
                <div class="text-2xl font-bold mb-2 flex items-center">
                  {{ topItem }} 
                  <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4 text-yellow-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                  </svg>
                </div>
                <div class="text-sm opacity-80">{{ topItemAmount }} kg sold</div>
              </div>
            </div>
              
            <!-- Charts & Reports -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
              <!-- Revenue Chart -->
              <div class="bg-white rounded-xl p-5 col-span-2">
                <div class="flex justify-between items-center mb-5">
                  <div class="font-bold">Total Revenue</div>
                  <div class="flex gap-2">
                    <select 
                      class="border border-gray-200 rounded px-3 py-1 text-sm"
                      v-model="chartPeriod"
                    >
                      <option>Week</option>
                      <option>Month</option>
                      <option>Year</option>
                    </select>
                    <button class="border border-gray-200 rounded px-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <rect x="7" y="7" width="3" height="10" />
                        <rect x="14" y="7" width="3" height="10" />
                      </svg>
                    </button>
                    <button class="border border-gray-200 rounded px-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="1" />
                        <circle cx="19" cy="12" r="1" />
                        <circle cx="5" cy="12" r="1" />
                      </svg>
                    </button>
                  </div>
                </div>
                  
                <div class="relative h-48">
                  <svg width="100%" height="200" viewBox="0 0 800 200">
                    <path
                      d="M0,180 Q80,100 150,150 T300,80 T450,40 T600,90 T800,50"
                      fill="none"
                      stroke="#A78BFA"
                      stroke-width="3"
                    />
                    <circle cx="150" cy="150" r="6" fill="white" stroke="#A78BFA" stroke-width="2" />
                    <circle cx="300" cy="80" r="6" fill="white" stroke="#A78BFA" stroke-width="2" />
                    <circle cx="450" cy="40" r="6" fill="white" stroke="#A78BFA" stroke-width="2" />
                    <circle cx="600" cy="90" r="6" fill="white" stroke="#A78BFA" stroke-width="2" />
                    <circle cx="800" cy="50" r="6" fill="white" stroke="#A78BFA" stroke-width="2" />
                  </svg>
                  <div class="flex justify-between mt-2">
                    <div class="text-xs text-gray-500" v-for="month in chartLabels" :key="month">{{ month }}</div>
                  </div>
                </div>
              </div>
                
              <!-- Payment Method -->
              <div class="bg-white rounded-xl p-5">
                <div class="font-bold mb-5">Payment Method</div>
                <div class="flex justify-center my-5">
                  <div class="relative w-24 h-24">
                    <div class="w-24 h-24 rounded-full bg-purple-600 border-8 border-purple-600 border-r-red-500 border-b-red-500"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 bg-white rounded-full flex flex-col justify-center items-center">
                      <div class="text-lg font-bold">{{ paymentMethodsData.qris }}%</div>
                      <div class="text-xs text-gray-500">QRIS</div>
                    </div>
                  </div>
                </div>
                  
                <div class="mt-5">
                  <div class="flex justify-between mb-2">
                    <div class="flex items-center gap-2">
                      <div class="w-3 h-3 bg-purple-600 rounded"></div>
                      <div>QRIS</div>
                    </div>
                    <div>{{ paymentMethodsData.qris }}</div>
                  </div>
                  <div class="flex justify-between">
                    <div class="flex items-center gap-2">
                      <div class="w-3 h-3 bg-red-500 rounded"></div>
                      <div>Cash</div>
                    </div>
                    <div>{{ paymentMethodsData.cash }}</div>
                  </div>
                </div>
              </div>
            </div>
              
            <!-- Category & Stock Changes -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
              <!-- Top Category -->
              <div class="bg-white rounded-xl p-5 col-span-2">
                <div class="flex justify-between items-center mb-5">
                  <div class="font-bold">TOP Category</div>
                  <button class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
                    </svg>
                  </button>
                </div>
                <div class="h-36 flex justify-center items-center text-gray-300">
                  <!-- Category chart placeholder -->
                  Chart Placeholder
                </div>
              </div>
                
              <!-- Stock Changes -->
              <div class="bg-white rounded-xl p-5">
                <div class="font-bold mb-5">Stock Changes</div>
                <div v-for="(item, index) in topStockChanges" :key="index" class="flex gap-2 p-2 bg-purple-600 text-white rounded-lg mb-2">
                  <div class="font-bold">{{ index + 1 }}.</div>
                  <div>{{ item.name }}</div>
                </div>
              </div>
            </div>
          </div>

<!-- Stok barang Section -->
<div v-if="activeSection === 'stock'" class="stock-management bg-white overflow-hidden shadow-sm sm:rounded-lg">
  <div class="header flex justify-between items-center px-6 py-4 border-b">
    <h2 class="title text-xl font-medium text-gray-700">Product</h2>
    <div class="actions flex items-center gap-3">
      <div class="showing flex items-center">
        Showing
        <select v-model="itemsPerPage" class="page-select mx-2 border rounded-md px-2 py-1 text-sm">
          <option>2</option>
          <option>5</option>
          <option>10</option>
          <option>25</option>
          <option>50</option>
        </select>
      </div>
      <button class="btn-filter flex items-center gap-1 px-3 py-1 border rounded-md text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
        </svg>
        Filter
      </button>
      <div class="export-dropdown relative">
        <button class="btn-export flex items-center gap-1 px-3 py-1 border rounded-md text-sm">
          Export 
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div class="export-menu hidden absolute right-0 mt-1 bg-white shadow-lg rounded-md py-1 z-10">
          <button @click="exportToPDF" class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-sm">Export to PDF</button>
          <button @click="exportToExcel" class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-sm">Export to Excel</button>
          <button @click="exportToCSV" class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-sm">Export to CSV</button>
        </div>
      </div>
      <button class="btn-add px-4 py-1 bg-indigo-600 text-white rounded-md text-sm" @click="openAddProductModal">Tambah</button>
    </div>
  </div>

  <div class="product-table px-6 py-4">
    <table class="w-full border-collapse">
      <thead>
        <tr class="text-left text-sm text-gray-600 border-b">
          <th class="pb-3 font-medium">
            <input type="checkbox" @change="selectAll" v-model="allSelected" class="rounded">
          </th>
          <th class="pb-3 font-medium">ID Barang</th>
          <th class="pb-3 font-medium">Nama Barang</th>
          <th class="pb-3 font-medium">Stock</th>
          <th class="pb-3 font-medium">Price</th>
          <th class="pb-3 font-medium">Category</th>
          <th class="pb-3 font-medium">Status</th>
          <th class="pb-3 font-medium"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(product, index) in displayedProducts" :key="index" class="border-b last:border-0">
          <td class="py-3">
            <input type="checkbox" v-model="product.selected" class="rounded">
          </td>
          <td class="py-3 text-sm text-gray-800">{{ product.id }}</td>
          <td class="py-3 text-sm text-gray-800">{{ product.name }}</td>
          <td class="py-3 text-sm text-gray-800">{{ product.stock }}</td>
          <td class="py-3 text-sm text-gray-800">Rp {{ formatPrice(product.price) }}</td>
          <td class="py-3 text-sm text-gray-800">{{ product.category }}</td>
          <td class="py-3">
            <span class="status-badge px-2 py-1 rounded-full text-xs font-medium" 
                  :class="product.status === 'Avail' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'">
              {{ product.status }}
            </span>
          </td>
          <td class="py-3 text-right">
            <button class="text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
              </svg>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="pagination flex justify-between items-center px-6 py-4 border-t">
    <div class="pagination-info text-sm text-gray-600">
      {{ currentPage }} of {{ totalPages }}
    </div>
    <div class="pagination-controls flex items-center gap-1">
      <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" 
              class="w-8 h-8 flex items-center justify-center rounded-md border" 
              :class="currentPage === 1 ? 'text-gray-300' : 'text-gray-600'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      
      <button v-for="page in paginationNumbers" :key="page" 
              @click="goToPage(page)"
              class="w-8 h-8 flex items-center justify-center rounded-md border text-sm"
              :class="currentPage === page ? 'bg-indigo-600 text-white' : 'text-gray-600'">
        {{ page }}
      </button>
      
      <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages"
              class="w-8 h-8 flex items-center justify-center rounded-md border"
              :class="currentPage === totalPages ? 'text-gray-300' : 'text-gray-600'">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </div>
  
  <!-- Add Product Modal -->
  <div class="modal fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" v-if="showAddProductModal">
    <div class="modal-content bg-white rounded-lg shadow-xl w-full max-w-md">
      <div class="modal-header flex justify-between items-center px-6 py-4 border-b">
        <h3 class="text-lg font-medium">Tambah Produk Baru</h3>
        <button class="close-btn text-gray-400 hover:text-gray-600 text-xl" @click="showAddProductModal = false">&times;</button>
      </div>
      <div class="modal-body px-6 py-4">
        <div class="form-group mb-4">
          <label for="productId" class="block text-sm font-medium text-gray-700 mb-1">ID Barang</label>
          <input type="text" id="productId" v-model="newProduct.id" placeholder="ID Barang"
                class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="form-group mb-4">
          <label for="productName" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
          <input type="text" id="productName" v-model="newProduct.name" placeholder="Nama Barang"
                class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="form-group mb-4">
          <label for="productStock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
          <input type="number" id="productStock" v-model="newProduct.stock" placeholder="Stock"
                class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="form-group mb-4">
          <label for="productPrice" class="block text-sm font-medium text-gray-700 mb-1">Price (Rp)</label>
          <input type="number" id="productPrice" v-model="newProduct.price" placeholder="Price"
                class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="form-group mb-4">
          <label for="productCategory" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
          <select id="productCategory" v-model="newProduct.category"
                  class="w-full px-3 py-2 border rounded-md">
            <option value="">Pilih Kategori</option>
            <option value="Sembako">Sembako</option>
            <option value="Minuman">Minuman</option>
            <option value="Makanan">Makanan</option>
            <option value="Lainnya">Lainnya</option>
          </select>
        </div>
        <div class="form-group mb-4">
          <label for="productStatus" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select id="productStatus" v-model="newProduct.status"
                  class="w-full px-3 py-2 border rounded-md">
            <option value="Avail">Avail</option>
            <option value="Out of Stock">Out of Stock</option>
          </select>
        </div>
      </div>
      <div class="modal-footer flex justify-end gap-3 px-6 py-4 border-t">
        <button class="btn-cancel px-4 py-2 border rounded-md text-sm" @click="showAddProductModal = false">Batal</button>
        <button class="btn-save px-4 py-2 bg-indigo-600 text-white rounded-md text-sm" @click="saveNewProduct">Simpan</button>
      </div>
    </div>
  </div>
</div>

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
import { utils, writeFile } from 'xlsx';
import Papa from 'papaparse';

// Props
const props = defineProps({
  employees: Array,
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

// Additional data for Laporan Penjualan section
const dateRange = ref('9 August 2025 - 15 August 2025');
const chartPeriod = ref('Week');
const averageSale = ref(50400);
const topItem = ref('Beras');
const topItemAmount = ref(51.2);
const chartLabels = ref(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']);
const paymentMethodsData = ref({
  qris: 50,
  cash: 50
});
const topStockChanges = ref([
  { name: 'Aqua 1500ml', amount: 120 },
  { name: 'Beras Premium', amount: 85 },
  { name: 'Minyak Goreng', amount: 64 }
]);

// Computed property for products to display
const recommendedProducts = computed(() => {
  if (salesrecommendation.value && salesrecommendation.value.length > 0) {
    return salesrecommendation.value;
  }
  return topProducts.value || [];
});

// UI state
const mobileMenuOpen = ref(false);
const activeSection = ref('dashboard'); // 'dashboard', 'laporan', or 'employees'

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
const goToCashier = () => router.get(route('owner.cashier'));
const goToStock = () => router.get(route('owner.stock'));
const goToRecommendation = () => router.get(route('owner.sales.recommendation'));
const logout = () => router.post(route('logout'));
const setActiveTab = t => activeTab.value = t;

// Formatting helpers
const formatCurrency = v => new Intl.NumberFormat('id-ID').format(v);
const formatNumber = number => number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

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

// Tambahkan variabel state untuk modal impor dan file
const showImportModal = ref(false);
const selectedFile = ref(null);
const importStatus = ref('');
const importErrors = ref([]);
const importResults = ref(null);

// Fungsi untuk membuka modal impor
const openImportModal = () => {
  showImportModal.value = true;
  selectedFile.value = null;
  importErrors.value = [];
  importStatus.value = '';
  importResults.value = null;
};

// Fungsi untuk memicu input file
const triggerFileInput = () => {
  document.getElementById('fileInput').click();
};

// Fungsi untuk menangani perubahan file
const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    selectedFile.value = file;
    importErrors.value = [];
    importStatus.value = '';
  }
};

// Fungsi untuk menangani drag and drop file
const handleFileDrop = (event) => {
  event.preventDefault();
  const file = event.dataTransfer.files[0];
  if (file && (file.name.endsWith('.xlsx') || file.name.endsWith('.csv') || file.name.endsWith('.xls'))) {
    selectedFile.value = file;
    importErrors.value = [];
    importStatus.value = '';
  } else {
    importErrors.value = ['File harus berformat Excel (.xlsx/.xls) atau CSV (.csv)'];
  }
};

// Fungsi untuk mengunduh template impor
const downloadTemplate = () => {
  // Dalam implementasi nyata, Anda akan mengarah ke endpoint yang menyediakan template
  // Untuk contoh ini, kita buat data dummy sebagai demo
  
  // Menggunakan library xlsx (pastikan untuk menginstalnya: npm install xlsx)

  
  const templateData = [
    {
      'ID Barang': 'PRD001',
      'Nama Barang': 'Contoh Produk',
      'Stock': 100,
      'Price': 15000,
      'Category': 'Sembako',
      'Status': 'Avail'
    }
  ];
  
  const worksheet = utils.json_to_sheet(templateData);
  const workbook = utils.book_new();
  utils.book_append_sheet(workbook, worksheet, 'Template Produk');
  
  writeFile(workbook, 'template-import-produk.xlsx');
};

// Fungsi untuk memproses impor data
const importData = async () => {
  if (!selectedFile.value) {
    importErrors.value = ['Silakan pilih file terlebih dahulu'];
    return;
  }
  
  importStatus.value = 'loading';
  importErrors.value = [];
  
  const formData = new FormData();
  formData.append('file', selectedFile.value);
  
  try {
    // Pada kasus nyata, kirim ke endpoint backend
    // const response = await axios.post('/api/products/import', formData);
    
    // Untuk demo, kita parse file di frontend
    if (selectedFile.value.name.endsWith('.csv')) {
      await importCSV(selectedFile.value);
    } else {
      await importExcel(selectedFile.value);
    }
    
    importStatus.value = 'success';
    // Tutup modal setelah beberapa detik
    setTimeout(() => {
      showImportModal.value = false;
      // Refresh data produk setelah impor berhasil
      fetchProducts(); // Pastikan Anda memiliki fungsi fetchProducts untuk memperbarui data
    }, 2000);
    
  } catch (error) {
    console.error('Import error:', error);
    importStatus.value = 'error';
    importErrors.value = ['Terjadi kesalahan saat mengimpor data. Silakan periksa format file Anda.'];
  }
};

// Fungsi untuk mengimpor data dari CSV
const importCSV = async (file) => {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    
    reader.onload = async (e) => {
      try {
        // Menggunakan PapaParse untuk parsing CSV (install: npm install papaparse)
       
        
        const csvData = e.target.result;
        Papa.parse(csvData, {
          header: true,
          skipEmptyLines: true,
          complete: async (results) => {
            if (results.errors.length > 0) {
              importErrors.value = results.errors.map(e => `Baris ${e.row}: ${e.message}`);
              reject(new Error('CSV parsing error'));
              return;
            }
            
            const products = validateAndTransformProducts(results.data);
            if (importErrors.value.length > 0) {
              reject(new Error('Validation errors'));
              return;
            }
            
            importResults.value = {
              totalRows: results.data.length,
              successRows: products.length,
              products: products
            };
            
            // Di sini Anda bisa mengirim products ke backend
            // await axios.post('/api/products/batch', { products });
            
            resolve(products);
          },
          error: (error) => {
            importErrors.value = [`Error parsing CSV: ${error.message}`];
            reject(error);
          }
        });
      } catch (error) {
        reject(error);
      }
    };
    
    reader.onerror = () => {
      importErrors.value = ['Error reading file'];
      reject(new Error('File reading error'));
    };
    
    reader.readAsText(file);
  });
};

// Fungsi untuk mengimpor data dari Excel
const importExcel = async (file) => {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    
    reader.onload = async (e) => {
      try {
        // Menggunakan library xlsx (install: npm install xlsx)
        
        
        const data = new Uint8Array(e.target.result);
        const workbook = read(data, { type: 'array' });
        
        // Ambil sheet pertama
        const worksheet = workbook.Sheets[workbook.SheetNames[0]];
        const jsonData = utils.sheet_to_json(worksheet);
        
        const products = validateAndTransformProducts(jsonData);
        if (importErrors.value.length > 0) {
          reject(new Error('Validation errors'));
          return;
        }
        
        importResults.value = {
          totalRows: jsonData.length,
          successRows: products.length,
          products: products
        };
        
        // Di sini Anda bisa mengirim products ke backend
        // await axios.post('/api/products/batch', { products });
        
        resolve(products);
      } catch (error) {
        importErrors.value = [`Error parsing Excel: ${error.message}`];
        reject(error);
      }
    };
    
    reader.onerror = () => {
      importErrors.value = ['Error reading file'];
      reject(new Error('File reading error'));
    };
    
    reader.readAsArrayBuffer(file);
  });
};

// Fungsi untuk validasi dan transformasi data produk
const validateAndTransformProducts = (data) => {
  const validProducts = [];
  const errors = [];
  
  data.forEach((row, index) => {
    // Cek struktur kolom
    const requiredFields = ['ID Barang', 'Nama Barang', 'Stock', 'Price', 'Category', 'Status'];
    const hasAllFields = requiredFields.every(field => 
      row[field] !== undefined || 
      // Periksa kemungkinan perbedaan nama kolom
      row[field.toLowerCase()] !== undefined ||
      row[field.replace(/ /g, '')] !== undefined ||
      row[field.replace(/ /g, '_')] !== undefined
    );
    
    if (!hasAllFields) {
      errors.push(`Baris ${index + 1}: Format tidak sesuai, kolom wajib tidak ditemukan.`);
      return;
    }
    
    // Ambil nilai dengan mempertimbangkan kemungkinan nama kolom berbeda
    const getValue = (key) => {
      return row[key] !== undefined ? row[key] :
             row[key.toLowerCase()] !== undefined ? row[key.toLowerCase()] :
             row[key.replace(/ /g, '')] !== undefined ? row[key.replace(/ /g, '')] :
             row[key.replace(/ /g, '_')];
    };
    
    const id = getValue('ID Barang');
    const name = getValue('Nama Barang');
    const stock = parseInt(getValue('Stock'));
    const price = parseFloat(getValue('Price'));
    const category = getValue('Category');
    const status = getValue('Status');
    
    // Validasi data
    if (!id || id.trim() === '') {
      errors.push(`Baris ${index + 1}: ID Barang tidak boleh kosong.`);
      return;
    }
    
    if (!name || name.trim() === '') {
      errors.push(`Baris ${index + 1}: Nama Barang tidak boleh kosong.`);
      return;
    }
    
    if (isNaN(stock) || stock < 0) {
      errors.push(`Baris ${index + 1}: Stock harus berupa angka positif.`);
      return;
    }
    
    if (isNaN(price) || price < 0) {
      errors.push(`Baris ${index + 1}: Price harus berupa angka positif.`);
      return;
    }
    
    if (!['Sembako', 'Minuman', 'Makanan', 'Lainnya'].includes(category)) {
      errors.push(`Baris ${index + 1}: Category harus salah satu dari: Sembako, Minuman, Makanan, Lainnya.`);
      return;
    }
    
    if (!['Avail', 'Out of Stock'].includes(status)) {
      errors.push(`Baris ${index + 1}: Status harus salah satu dari: Avail, Out of Stock.`);
      return;
    }
    
    // Tambahkan produk yang valid
    validProducts.push({
      id,
      name,
      stock,
      price,
      category,
      status,
      selected: false // untuk fitur checkbox di tabel
    });
  });
  
  importErrors.value = errors;
  return validProducts;
};

// Fungsi untuk memuat ulang data produk setelah impor berhasil
const fetchProducts = async () => {
  try {
    // Di implementasi nyata, Anda akan memanggil API untuk mendapatkan data terbaru
    // const response = await axios.get('/api/products');
    // products.value = response.data;
    
    // Untuk demo, tambahkan produk dari importResults ke daftar produk yang ada
    if (importResults.value && importResults.value.products) {
      // Jika produk dengan ID yang sama sudah ada, update datanya
      importResults.value.products.forEach(newProduct => {
        const existingIndex = products.value.findIndex(p => p.id === newProduct.id);
        if (existingIndex >= 0) {
          products.value[existingIndex] = { ...newProduct };
        } else {
          products.value.push(newProduct);
        }
      });
    }
    
    // Update displayed products dan pagination
    updateDisplayedProducts();
  } catch (error) {
    console.error('Error fetching products:', error);
  }
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