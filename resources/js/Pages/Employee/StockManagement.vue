<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3'; // Add router here
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';

// Define props dengan destructuring
const props = defineProps({
    products: {
        type: Array,
        default: () => []
    },
    addProductRoute: {
        type: String,
        required: true
    },
    listProductsRoute: {
        type: String,
        required: true
    }
}); 

// Get user role
const page = usePage();
const isOwner = computed(() => {
    return page.props.auth.user.role_id === 2;
});

// Data states - gunakan props.products sebagai nilai awal
const products = ref(props.products || []);
const itemsPerPage = ref(5);
const currentPage = ref(1);
const allSelected = ref(false);
const activeActionMenu = ref(null);
const showImportModal = ref(false);
const showAddProductModal = ref(false);
const selectedFile = ref(null);
const showSidebar = ref(false);

// Tambahkan state untuk modal edit dan produk yang sedang diedit
const showEditModal = ref(false);
const editingProduct = ref({
    id: '',
    code: '',
    name: '',
    stock: 0,
    average_price: 0,
    selling_price: 0,
    category: '',
    unit: '',
});

// Fungsi untuk melihat detail produk
const viewDetails = (product) => {
    // Implement view details functionality
    console.log('View details for product:', product);
    activeActionMenu.value = null;
};

// Tambahkan definisi newProduct
const newProduct = ref({
    id: '',
    name: '',
    stock: 0,
    average_price: 0,
    markup: 0,
    selling_price: 0,
    category: '',
    unit: '',
    status: 'Avail',
    selected: false
});

// Perbaiki fungsi fetchProducts
const fetchProducts = async () => {
    try {
        const response = await axios.get(props.listProductsRoute);
        if (response.data && response.data.products) {
            products.value = response.data.products.map(product => ({
                ...product,
                selected: false,
                status: product.stock > 0 ? 'Avail' : 'Out of Stock'
            }));
        }
    } catch (error) {
        console.error('Error fetching products:', error);
        products.value = [];
    }
};

// Computed properties
const totalPages = computed(() => Math.ceil(products.value.length / itemsPerPage.value));

const displayedProducts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return products.value.slice(start, end);
});

const paginationNumbers = computed(() => {
    const pages = [];
    const maxVisiblePages = 5;
    
    if (totalPages.value <= maxVisiblePages) {
        for (let i = 1; i <= totalPages.value; i++) {
            pages.push(i);
        }
    } else {
        let startPage = Math.max(1, currentPage.value - 2);
        let endPage = Math.min(totalPages.value, startPage + maxVisiblePages - 1);
        
        if (endPage - startPage < maxVisiblePages - 1) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        for (let i = startPage; i <= endPage; i++) {
            pages.push(i);
        }
    }
    return pages;
});

// Methods
const formatPrice = (price) => price.toLocaleString('id-ID');

const selectAll = () => {
    products.value.forEach(product => {
        product.selected = allSelected.value;
    });
};

const openActionMenu = (index) => {
    activeActionMenu.value = activeActionMenu.value === index ? null : index;
};

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        activeActionMenu.value = null;
    }
};

// CRUD Operations
const editProduct = (product) => {
    if (!isOwner.value) {
        alert('Hanya owner yang dapat mengedit produk');
        return;
    }
    
    // Set data produk yang akan diedit
    editingProduct.value = { ...product };
    showEditModal.value = true;
    activeActionMenu.value = null;
};

const deleteProduct = async (product) => {
    if (confirm(`Anda yakin ingin menghapus ${product.name}?`)) {
        try {
            await axios.delete(`/api/products/${product.id}`);
            await fetchProducts();
        } catch (error) {
            console.error('Error deleting product:', error);
        }
    }
    activeActionMenu.value = null;
};

const saveNewProduct = async () => {
    if (!newProduct.value.name || !newProduct.value.category) {
        alert('Nama dan Kategori produk harus diisi!');
        return;
    }

    try {
        await axios.post('/api/products', newProduct.value);
        await fetchProducts();
        showAddProductModal.value = false;
        newProduct.value = {
            id: '',
            name: '',
            stock: 0,
            average_price: 0,
            markup: 0,
            selling_price: 0,
            category: '',
            unit: '',
            status: 'Avail',
            selected: false
        };
    } catch (error) {
        console.error('Error creating product:', error);
    }
};

// Tambahkan fungsi untuk menyimpan perubahan
const saveEditedProduct = async () => {
    try {
        const response = await axios.put(`/api/products/${editingProduct.value.id}`, editingProduct.value);
        if (response.status === 200) {
            await fetchProducts();
            showEditModal.value = false;
        }
    } catch (error) {
        console.error('Error updating product:', error);
        alert('Gagal mengupdate produk');
    }
};

// Add toggle status function
const toggleStatus = async (product) => {
    try {
        await axios.patch(`/api/products/${product.id}/toggle-status`);
        product.is_active = !product.is_active;
        // Refresh product list to reflect changes
        await fetchProducts();
    } catch (error) {
        console.error('Error toggling product status:', error);
        alert('Gagal mengubah status produk');
    }
};

// Add logout method
const logout = () => {
    router.post(route('logout'));
};

// Lifecycle hooks
onMounted(() => {
    fetchProducts();
    
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.action-button') && activeActionMenu.value !== null) {
            activeActionMenu.value = null;
        }
    });
});

</script>

<template>
    <Head title="Stock Management" />

    <AuthenticatedLayout>
        <div class="flex min-h-screen bg-gray-100">
            <!-- Sidebar -->
            <aside
                :class="[
                    'bg-white shadow-lg flex flex-col items-center pt-6 fixed inset-y-0 left-0 transition-transform z-30',
                    showSidebar ? 'translate-x-0' : '-translate-x-full',
                    'md:translate-x-0 md:static md:w-24 w-64',
                    'safe-area-inset-left'
                ]"
            >
                <nav class="flex flex-col items-center gap-10 mt-8 flex-1">
                    <!-- Dashboard -->
                    <a href="/dashboard" class="flex flex-col items-center">
                        <div class="p-3 rounded-md text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <span class="text-xs mt-2">Dashboard</span>
                    </a>

                    <!-- Stock Management -->
                    <a href="/stock-management" class="flex flex-col items-center">
                        <div class="p-3 rounded-md bg-purple-100 text-purple-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="text-xs mt-2">Stock Barang</span>
                    </a>
                </nav>

                <!-- Logout Button -->
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
                v-if="showSidebar"
                @click="showSidebar = false"
                class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden"
            ></div>

            <!-- Main content -->
            <div class="flex-1 md:ml-24 w-full overflow-x-hidden">
                <!-- Mobile header -->
                <header class="flex items-center justify-between bg-white p-4 shadow md:hidden safe-area-inset-top">
                    <button @click="showSidebar = !showSidebar" class="p-2 -m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold">Stock Management</h1>
                    <div class="w-8 h-8 rounded-full bg-gray-300"></div>
                </header>

                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                            <div class="stock-management">
                                <div class="header">
                                    <h2 class="title">Product</h2>
                                    <div class="actions">
                                        <div class="showing">
                                            Showing
                                        <select v-model="itemsPerPage" class="page-select">
                                            <option :value="2">2</option>
                                            <option :value="5">5</option>
                                            <option :value="10">10</option>
                                            <option :value="25">25</option>
                                            <option :value="50">50</option>
                                        </select>
                                        </div>
                                        <button class="btn-filter">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                        
                                        
                                        <!-- Integration with your original links -->
                                        <Link 
                                            v-if="addProductRoute"
                                            :href="addProductRoute"
                                            class="btn-add"
                                        >
                                            Tambah Produk
                                        </Link>
                                    </div>
                                </div>

                                <div class="product-table">
                                <table>
                                    <thead>
        <tr>
            <th width="30">
                <input type="checkbox" @change="selectAll" v-model="allSelected">
            </th>
            <th>ID Barang</th>
            <th>Nama Barang</th>
            <th>Stock</th>
            <th>Harga Rata-rata</th>
            <th>Keuntungan/Produk</th> <!-- Ganti Markup (%) jadi Keuntungan/Produk -->
            <th>Harga Jual</th>
            <th>Category</th>
            <th>Unit</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr v-if="products.length === 0">
            <td colspan="12" class="py-4 px-4 border-b text-center"> <!-- Update colspan dari 11 ke 12 -->
                Tidak ada produk tersedia
            </td>
        </tr>
        <tr v-for="(product, index) in displayedProducts" :key="product.id">
            <td>
                <input type="checkbox" v-model="product.selected">
            </td>
            <td>{{ product.code }}</td>
            <td>{{ product.name }}</td>
            <td>{{ product.stock }}</td>
            <td>Rp {{ Number(product.average_price).toLocaleString() }}</td>
            <td>Rp {{ Number(product.profit).toLocaleString() }}</td> <!-- Tampilkan profit -->
            <td>Rp {{ Number(product.selling_price).toLocaleString() }}</td>
            <td>{{ product.category || '-' }}</td>
            <td>{{ product.unit || '-' }}</td>
            <td>
                <select 
                    :value="product.is_active ? 'active' : 'inactive'"
                    @change="toggleStatus(product)"
                    class="px-3 py-1 rounded text-sm font-medium border"
                    :class="{
                        'bg-green-100 text-green-600': product.is_active,
                        'bg-red-100 text-red-600': !product.is_active
                    }"
                >
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </td>
            <td>
                <button class="action-button" @click="openActionMenu(index)">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <div class="action-menu" v-if="activeActionMenu === index">
                    <button 
                        @click="editProduct(product)"
                        :class="{ 'disabled': !isOwner }"
                        :title="!isOwner ? 'Hanya owner yang dapat mengedit produk' : ''"
                    >
                        {{ isOwner ? 'Edit' : 'Edit (Owner Only)' }}
                    </button>
                </div>
            </td>
        </tr>
    </tbody>
                                </table>
                                </div>

                                <div class="pagination">
                                    <div class="pagination-info">
                                        {{ currentPage }} of {{ totalPages }}
                                    </div>
                                    <div class="pagination-controls">
                                        <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button 
                                            v-for="page in paginationNumbers" 
                                            :key="page" 
                                            @click="goToPage(page)"
                                            :class="{ active: currentPage === page }"
                                        >
                                            {{ page }}
                                        </button>
                                        <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Import Modal -->
                                <div class="modal" v-if="showImportModal">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Import Data Produk</h3>
                                            <button class="close-btn" @click="showImportModal = false">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="import-instructions">
                                                <p>Silahkan upload file Excel (.xlsx) atau CSV untuk mengimpor data produk.</p>
                                                <p>Download template: 
                                                    <a href="#" @click.prevent="downloadTemplate">template-import-produk.xlsx</a>
                                                </p>
                                            </div>
                                            <div class="file-upload">
                                                <input type="file" id="fileInput" @change="handleFileChange" accept=".xlsx,.xls,.csv">
                                                <div class="upload-zone" @click="triggerFileInput" @dragover.prevent @drop.prevent="handleFileDrop">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    <p>Drag and drop file atau klik untuk memilih</p>
                                                    <span v-if="selectedFile">File terpilih: {{ selectedFile.name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn-cancel" @click="showImportModal = false">Batal</button>
                                            <button class="btn-import" @click="importData" :disabled="!selectedFile">Import</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add Product Modal -->
                                <div class="modal" v-if="showAddProductModal">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Tambah Produk Baru</h3>
                                            <button class="close-btn" @click="showAddProductModal = false">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="productId">ID Barang</label>
                                                <input type="text" id="productId" v-model="newProduct.id" placeholder="ID Barang">
                                            </div>
                                            <div class="form-group">
                                                <label for="productName">Nama Barang</label>
                                                <input type="text" id="productName" v-model="newProduct.name" placeholder="Nama Barang">
                                            </div>
                                            <div class="form-group">
                                                <label for="productStock">Stock</label>
                                                <input type="number" id="productStock" v-model="newProduct.stock" placeholder="Stock">
                                            </div>
                                            <div class="form-group">
                                                <label for="productPrice">Price (Rp)</label>
                                                <input type="number" id="productPrice" v-model="newProduct.price" placeholder="Price">
                                            </div>
                                            <div class="form-group">
                                                <label for="productCategory">Category</label>
                                                <select id="productCategory" v-model="newProduct.category">
                                                    <option value="">Pilih Kategori</option>
                                                    <option value="Sembako">Sembako</option>
                                                    <option value="Makanan Instan & Siap Saji">Makanan Instan & Siap Saji</option>
                                                    <option value="Camilan & Snack">Camilan & Snack</option>
                                                    <option value="Minuman">Minuman</option>
                                                    <option value="Produk Susu">Produk Susu</option>
                                                    <option value="Bumbu Dapur">Bumbu Dapur</option>
                                                    <option value="Produk Beku & Dingin">Produk Beku & Dingin</option>
                                                    <option value="Rokok & Aksesoris">Rokok & Aksesoris</option>
                                                    <option value="Kebutuhan Kebersihan">Kebutuhan Kebersihan</option>
                                                    <option value="Lainnya">Lainnya</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="productStatus">Status</label>
                                                <select id="productStatus" v-model="newProduct.status">
                                                    <option value="Avail">Avail</option>
                                                    <option value="Out of Stock">Out of Stock</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn-cancel" @click="showAddProductModal = false">Batal</button>
                                            <button class="btn-save" @click="saveNewProduct">Simpan</button>
                                        </div>
                                        <div class="form-group">
                                            <label for="productUnit">Unit</label>
                                            <select id="productUnit" v-model="newProduct.unit">
                                                <option value="">Pilih Unit</option>
                                                <option value="pcs">pcs</option>
                                                <option value="box">box</option>
                                                <option value="kg">kg</option>
                                                <option value="liter">liter</option>
                                                <option value="pack">pack</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Product Modal -->
                                <div class="modal" v-if="showEditModal">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Edit Produk</h3>
                                            <button class="close-btn" @click="showEditModal = false">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Kode Produk</label>
                                                <input type="text" v-model="editingProduct.code" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Produk</label>
                                                <input type="text" v-model="editingProduct.name" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Stok</label>
                                                <input type="number" v-model="editingProduct.stock" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Harga Rata-rata</label>
                                                <input type="number" v-model="editingProduct.average_price" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Harga Jual</label>
                                                <input type="number" v-model="editingProduct.selling_price" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select v-model="editingProduct.category">
                                                    <option value="">Pilih Kategori</option>
                                                    <option value="Sembako">Sembako</option>
                                                    <option value="Makanan Instan & Siap Saji">Makanan Instan & Siap Saji</option>
                                                    <option value="Camilan & Snack">Camilan & Snack</option>
                                                    <option value="Minuman">Minuman</option>
                                                    <option value="Produk Susu">Produk Susu</option>
                                                    <option value="Bumbu Dapur">Bumbu Dapur</option>
                                                    <option value="Produk Beku & Dingin">Produk Beku & Dingin</option>
                                                    <option value="Rokok & Aksesoris">Rokok & Aksesoris</option>
                                                    <option value="Kebutuhan Kebersihan">Kebutuhan Kebersihan</option>
                                                    <option value="Lainnya">Lainnya</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Unit</label>
                                                <select v-model="editingProduct.unit">
                                                    <option value="">Pilih Unit</option>
                                                    <option value="pcs">pcs</option>
                                                    <option value="box">box</option>
                                                    <option value="kg">kg</option>
                                                    <option value="liter">liter</option>
                                                    <option value="pack">pack</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Table</label>
                                                <select v-model="editingProduct.table">
                                                    <option value="">Pilih Table</option>
                                                    <option value="1">Table 1</option>
                                                    <option value="2">Table 2</option>
                                                    <option value="3">Table 3</option>
                                                    <option value="4">Table 4</option>
                                                    <option value="5">Table 5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn-cancel" @click="showEditModal = false">Batal</button>
                                            <button class="btn-save" @click="saveEditedProduct">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.stock-management {
    background-color: #ffffff;
    border-radius: 8px;
    /* Shadow removed as it's already provided by the parent container */
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.title {
    font-size: 1.5rem;
    color: #333;
    font-weight: 500;
    margin: 0;
}

.actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.showing {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #666;
}

.page-select {
    padding: 5px 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #fff;
}

.btn-filter, .btn-export, .btn-add, .btn-view {
    padding: 8px 16px;
    border-radius: 4px;
    border: 1px solid #ddd;
    background-color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.875rem;
}

.btn-add {
    background-color: #6c5ce7;
    color: white;
    border: none;
}

.btn-view {
    background-color: #2ecc71;
    color: white;
    border: none;
}


.product-table {
    overflow-x: auto;
    margin-bottom: 20px;
}


thead th {
    padding: 12px 15px;
    text-align: left;
    background-color: #f8f9fa;
    color: #333;
    font-weight: 500;
    border-bottom: 1px solid #ddd;
}

tbody td {
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
}

.status-toggle {
    display: inline-block;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.status-badge.available {
    background-color: #2ecc71;
    color: white;
}

.status-badge.unavailable {
    background-color: #e74c3c;
    color: white;
}

.status-badge:hover {
    opacity: 0.8;
    transform: scale(1.05);
}

.action-button {
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

.action-menu {
    position: absolute;
    right: 20px;
    background-color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    z-index: 10;
}

.action-menu button {
    display: block;
    width: 100%;
    padding: 8px 16px;
    text-align: left;
    border: none;
    background-color: transparent;
    cursor: pointer;
}

.action-menu button:hover {
    background-color: #f1f1f1;
}

.action-menu button.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    color: #666;
    background-color: #f5f5f5;
}

.action-menu button.disabled:hover {
    background-color: #f5f5f5;
}

.pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}

.pagination-info {
    color: #666;
}

.pagination-controls {
    display: flex;
    gap: 5px;
}

.pagination-controls button {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ddd;
    background-color: #fff;
    border-radius: 4px;
    cursor: pointer;
}

.pagination-controls button.active {
    background-color: #6c5ce7;
    color: white;
    border-color: #6c5ce7;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
}

.modal-content {
    background-color: #fff;
    border-radius: 8px;
    width: 500px;
    max-width: 90%;
    max-height: 90%;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #ddd;
}

.modal-header h3 {
    margin: 0;
    font-weight: 500;
}

.close-btn {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 15px 20px;
    border-top: 1px solid #ddd;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-cancel, .btn-import, .btn-save {
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-cancel {
    background-color: #f1f1f1;
    border: 1px solid #ddd;
}

.btn-import, .btn-save {
    background-color: #6c5ce7;
    color: white;
    border: none;
}

.btn-import:disabled {
    background-color: #a29bfa;
    cursor: not-allowed;
}

.import-instructions {
    margin-bottom: 20px;
}

.import-instructions a {
    color: #6c5ce7;
    text-decoration: underline;
}

.file-upload {
    margin-top: 15px;
}

.file-upload input[type="file"] {
    display: none;
}

.upload-zone {
    border: 2px dashed #ddd;
    border-radius: 4px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.3s;
}

.upload-zone:hover {
    border-color: #6c5ce7;
}

.upload-zone i {
    font-size: 24px;
    color: #6c5ce7;
    margin-bottom: 10px;
}

.upload-zone p {
    margin: 10px 0;
}

.upload-zone span {
    display: block;
    margin-top: 10px;
    color: #6c5ce7;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

/* Add this if you want to style inputs/selects inside .form-group */
.form-group input,
.form-group select {
    border-radius: 4px;
    border: 1px solid #ddd;
    padding: 8px 12px;
    width: 100%;
}

</style>
<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>