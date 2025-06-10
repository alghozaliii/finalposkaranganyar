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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
              <!-- Total Revenue Card --> 
              <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-4 sm:p-6 text-white">
                <h3 class="text-base sm:text-lg mb-2 sm:mb-4">Total Revenue</h3>
                <div class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2 sm:mb-4">Rp {{ formatCurrency(totalRevenue) }}</div>
                <div class="flex items-center text-sm sm:text-base">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                  </svg>
                  <span>{{ revenueGrowth }}% from last month</span>
                </div>
              </div>
              <!-- Total Sales Card -->
              <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-4 sm:p-6 text-white">
                <h3 class="text-base sm:text-lg mb-2 sm:mb-4">Total Sales</h3>
                <div class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2 sm:mb-4">{{ totalSales }}</div>
                <div class="flex items-center text-sm sm:text-base">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                  </svg>
                  <span>{{ salesGrowth }}% from last month</span>
                </div>
              </div>
              <!-- Customer Card -->
              <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-lg p-4 sm:p-6 text-white">
                <h3 class="text-base sm:text-lg mb-2 sm:mb-4">Customer</h3>
                <div class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2 sm:mb-4">{{ totalCustomers }}</div>
                <div class="flex items-center text-sm sm:text-base">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-green-300 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                  </svg>
                  <span>{{ customerGrowth }}% from last Month</span>
                </div>
              </div>
            </div>
            
            <!-- Revenue Chart and Top Products -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
              <!-- Revenue Chart -->
              <div class="lg:col-span-2 bg-white rounded-lg border p-3 sm:p-4 md:p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
                  <h3 class="text-base sm:text-lg font-medium">Total Revenue</h3>
                  <div class="flex gap-2 text-sm">
                    <select v-model="chartPeriod" class="border rounded px-2 py-1">
                      <option>Month</option>
                      <option>Year</option>
                    </select>
                  </div>
                </div>
                <div class="h-40 sm:h-48 md:h-64 relative">
                  <!-- Chart content -->
                </div>
              </div>
              
              <!-- Top Products -->
              <div class="bg-white rounded-lg border p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-medium mb-4">Top Products</h3>
                <div class="space-y-3 sm:space-y-4">
                  <div v-for="(product, index) in recommendedProducts" :key="index" 
                       class="flex justify-between items-center p-2 sm:p-3 border-b last:border-0">
                    <div class="flex items-center gap-2 text-sm sm:text-base">
                      <span class="text-gray-500">{{ String(index+1).padStart(2,'0') }}</span>
                      <span class="truncate max-w-[150px] sm:max-w-[200px]">{{ product.name }}</span>
                    </div>
                    <div class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs sm:text-sm">
                      {{ product.sales }}%
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Transaction History -->
            <div class="bg-white rounded-lg border p-3 sm:p-4 md:p-6">
              <h3 class="text-base sm:text-lg font-medium mb-4">History Transaksi</h3>
              <div class="overflow-x-auto -mx-3 sm:-mx-4 md:-mx-6">
                <div class="inline-block min-w-full align-middle">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Invoice</th>
                        <th class="hidden sm:table-cell px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="hidden sm:table-cell px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="(invoice, index) in transactionHistory" :key="invoice.invoice_number" 
                          @click="handleRowClick(invoice)" 
                          class="hover:bg-gray-50 cursor-pointer">
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-sm">{{ index + 1 }}</td>
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-sm">{{ invoice.invoice_number }}</td>
                        <td class="hidden sm:table-cell px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-sm">{{ formatDate(invoice.created_at) }}</td>
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-sm">Rp {{ formatCurrency(invoice.total_price || invoice.total_amount || 0) }}</td>
                        <td class="hidden sm:table-cell px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap capitalize text-sm">{{ invoice.payment_method }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Laporan Penjualan Section -->
          <div v-if="activeSection === 'laporan'" class="bg-purple-50 rounded-2xl p-5">
            <h1 class="text-2xl text-gray-800 font-semibold mb-5">Laporan Penjualan</h1>
              
            <!-- Date Filter -->
            <div class="flex justify-between mb-5">
              <div class="flex gap-3">
                <button @click="goToSales" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                  Rekap
                </button>
                <button @click="goToSalesRecommendation" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                  Rekomendasi
                </button>
              </div>
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
                    <select v-model="chartPeriod" class="border border-gray-200 rounded px-3 py-1 text-sm">
                      <option>Month</option>
                      <option>Year</option>
                    </select>
                  </div>
                </div>
                <div class="relative h-48">
                  <svg width="100%" height="200" viewBox="0 0 800 200">
                    <!-- Generate path dynamically -->
                    <path
                      :d="generateLinePath(monthlyRevenueData)"
                      fill="none"
                      stroke="#A78BFA"
                      stroke-width="3"
                    />
                    <!-- Plot points -->
                    <template v-for="(point, index) in getChartPoints(monthlyRevenueData)" :key="index">
                      <circle
                        :cx="point.x"
                        :cy="point.y"
                        r="6"
                        fill="white"
                        stroke="#A78BFA"
                        stroke-width="2"
                        :title="`${point.month}: Rp ${formatCurrency(point.value)}`"
                      />
                    </template>
                  </svg>
                  <div class="flex justify-between mt-2">
                    <div v-for="month in chartLabels" :key="month" class="text-xs text-gray-500">
                      {{ month.substring(0,3) }}
                    </div>
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
          <div v-if="activeSection==='employees'" class="space-y-4 md:space-y-6 px-2 md:px-6">
            <!-- Form Tambah Employee -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 md:p-6">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Karyawan</h3>
              <form v-on:submit.prevent="submitForm" class="grid grid-cols-1 gap-4">
                <div class="space-y-4">
                  <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input id="username" v-model="form.username" type="text" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"/>
                    <div v-if="form.errors.username" class="text-red-500 text-xs mt-1">{{ form.errors.username }}</div>
                  </div>

                  <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" v-model="form.password" type="password" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"/>
                    <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
                  </div>

                  <div>
                    <label for="employees_role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select id="employees_role" v-model="form.employees_role"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                      <option value="cashier">Kasir</option>
                      <option value="stock">Stock Admin</option>
                    </select>
                  </div>
                </div>

                <div class="mt-2">
                  <button type="submit" :disabled="form.processing"
                          class="w-full md:w-auto bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    Tambah Karyawan
                  </button>
                </div>
              </form>
            </div>

            <!-- Tabel Daftar Karyawan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 md:p-6">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Karyawan</h3>
              <div class="overflow-x-auto -mx-4 md:mx-0">
                <div class="min-w-full inline-block align-middle">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th class="p-3 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="p-3 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                        <th class="p-3 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="hidden md:table-cell p-3 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat</th>
                        <th class="p-3 md:px-6 md:py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-if="!employees.length">
                        <td colspan="5" class="p-3 md:px-6 md:py-4 text-center text-gray-500 text-sm">
                          Belum ada karyawan terdaftar.
                        </td>
                      </tr>
                      <tr v-for="(emp, idx) in employees" :key="emp.id" class="hover:bg-gray-50">
                        <td class="p-3 md:px-6 md:py-4 whitespace-nowrap text-sm">{{ idx + 1 }}</td>
                        <td class="p-3 md:px-6 md:py-4 whitespace-nowrap text-sm">{{ emp.name }}</td>
                        <td class="p-3 md:px-6 md:py-4 whitespace-nowrap text-sm capitalize">{{ emp.employees_role }}</td>
                        <td class="hidden md:table-cell p-3 md:px-6 md:py-4 whitespace-nowrap text-sm">{{ emp.created_at }}</td>
                        <td class="p-3 md:px-6 md:py-4 whitespace-nowrap text-right text-sm">
                          <button @click="deleteEmployee(emp.id)" 
                                  class="text-red-600 hover:text-red-900 text-sm font-medium">
                            Hapus
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
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
const dateRange = computed(() => `${startDate.value} - ${endDate.value}`);
const chartPeriod = ref('Month');
const averageSale = computed(() => totalRevenue.value / totalSales.value || 0);
const topItem = computed(() => topProducts.value?.[0]?.name || 'No data');
const topItemAmount = computed(() => topProducts.value?.[0]?.total_quantity || 0);
const chartLabels = ref([
  'January', 'February', 'March', 'April', 'May', 'June',
  'July', 'August', 'September', 'October', 'November', 'December'
]);

// Payment methods data
const paymentMethodsData = ref({
  qris: 0,
  cash: 0
});

// Update payment methods calculation when transaction history changes
watch(() => transactionHistory.value, (transactions) => {
  if (!transactions?.length) return;
  
  const total = transactions.length;
  const qrisCount = transactions.filter(t => t.payment_method === 'qris').length;
  
  paymentMethodsData.value = {
    qris: Math.round((qrisCount / total) * 100),
    cash: Math.round(((total - qrisCount) / total) * 100)
  };
}, { immediate: true });

// Top stock changes based on top products
const topStockChanges = computed(() => 
  topProducts.value?.slice(0, 3).map(product => ({
    name: product.name,
    amount: product.total_quantity
  })) || []
);

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
  username: '',
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
const goToDashboard = () => router.get(route('owner.dashboard'));
const goToCashier = () => router.get(route('owner.cashier'));
const goToStock = () => router.get(route('owner.stock'));
const goToEmployees = () => router.get(route('owner.employees'));
const goToFAQ = () => router.get(route('owner.HelpdeskOwner'));
const goToLaporan = () => router.get(route('owner.laporan'));
const logout = () => router.post(route('logout'));
const setActiveTab = t => activeTab.value = t;

// Formatting helpers
const formatCurrency = v => new Intl.NumberFormat('id-ID').format(v);
const formatNumber = number => number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

// Submit tambah karyawan
const submitForm = () => {
  form.post(route('employees.store'), {
    onSuccess: () => {
      form.reset();
      // Reload employees list
      reloadEmployees();
    }
  });
};

// Add function to reload employees
const reloadEmployees = async () => {
  try {
    const response = await axios.get(route('owner.dashboard'));
    employees.value = response.data.employees;
  } catch (error) {
    console.error('Error loading employees:', error);
  }
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

    // Update chart labels based on data
    if (data.chartLabels) {
      chartLabels.value = data.chartLabels;
    }

    // Calculate payment methods distribution
    if (data.transactionHistory?.length) {
      const total = data.transactionHistory.length;
      const qrisCount = data.transactionHistory.filter(t => t.payment_method === 'qris').length;
      
      paymentMethodsData.value = {
        qris: Math.round((qrisCount / total) * 100),
        cash: Math.round(((total - qrisCount) / total) * 100)
      };
    }

    // Update monthly revenue data
    if (data.chartData) {
      chartData.value = data.chartData;
    }

  } catch (e) {
    console.error('Gagal sinkronisasi data sales:', e);
  }
});

// Initialize expandedInvoices before it's used
const expandedInvoices = ref([]);

// Add toggle function for expanding invoice details
const toggleInvoiceDetails = (invoiceNumber) => {
  const index = expandedInvoices.value.indexOf(invoiceNumber);
  if (index === -1) {
    expandedInvoices.value.push(invoiceNumber);
  } else {
    expandedInvoices.value.splice(index, 1);
  }
};

// Add a click handler to the invoice row in the template
const handleRowClick = (invoice) => {
  toggleInvoiceDetails(invoice.invoice_number);
};

// Replace the monthlyRevenueData computed property:
const monthlyRevenueData = computed(() => {
  if (!chartData.value || !chartData.value.length) {
    return chartLabels.value.map(month => ({
      month,
      total_revenue: 0
    }));
  }
  return chartLabels.value.map((month, index) => {
    const monthData = chartData.value.find(d => d.month === (index + 1));
    return {
      month,
      total_revenue: monthData?.total_revenue || 0
    };
  });
});

// Add these reactive refs:
const chartData = ref([]);

// Update the onMounted section:
onMounted(async () => {
  try {
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

    // Update chart data properly
    if (data.chartData) {
      chartData.value = data.chartData;
    }

  } catch (e) {
    console.error('Gagal sinkronisasi data sales:', e);
  }
});

// Update the helper functions:
const getBarHeight = (revenue) => {
  const maxRevenue = Math.max(...monthlyRevenueData.value.map(d => d.total_revenue), 1);
  if (maxRevenue === 0) return 0;
  return Math.min((revenue / maxRevenue) * 100, 100);
};

const generateLinePath = (data) => {
  if (!data.length) return '';
  const points = getChartPoints(data);
  return points.reduce((path, point, i) => 
    `${path}${i === 0 ? 'M' : 'L'} ${point.x},${point.y}`, '');
};

const getChartPoints = (data) => {
  const maxRevenue = Math.max(...data.map(d => d.total_revenue), 1);
  const width = 800;
  const height = 200;
  const padding = 20;
  
  return data.map((point, index) => ({
    x: padding + (index * ((width - (padding * 2)) / (data.length - 1))),
    y: height - (padding + ((point.total_revenue / maxRevenue) * (height - (padding * 2)))),
    month: point.month,
    value: point.total_revenue
  }));
};

// Replace the format date helper with this implementation
const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  const options = {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    hour12: false
  };
  return new Intl.DateTimeFormat('id-ID', options).format(date);
};
</script>