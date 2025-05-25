<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const form = useForm({
  code: '',
  name: '',
  stock: 0,
  average_price: 0,
  selling_price: 0,
  category: '',
  unit: '',
});

const oldStock = ref(0);
const oldPrice = ref(0);
const newStock = ref(0);
const newPrice = ref(0);

const totalStock = computed(() => oldStock.value + newStock.value);

const averagePrice = computed(() => {
  const total = totalStock.value;
  if (total === 0) return 0;
  return ((oldStock.value * oldPrice.value) + (newStock.value * newPrice.value)) / total;
});

function addProduct() {
  form.stock = totalStock.value;
  form.average_price = averagePrice.value.toFixed(2);

  form.post('/employee/stock', {
    onSuccess: () => {
      alert('Produk berhasil ditambahkan!');
      form.reset();
      oldStock.value = 0;
      oldPrice.value = 0;
      newStock.value = 0;
      newPrice.value = 0;
    },
    onError: () => {
      alert('Gagal menambahkan produk. Periksa isian.');
    }
  });
}
</script>

<template>
  <Head title="Tambah Produk" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Produk</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6 text-gray-900">
          <form @submit.prevent="addProduct" class="space-y-6">
            <div>
              <label class="block mb-1">Kode Produk</label>
              <input v-model="form.code" type="text" class="w-full border p-2 rounded" required />
              <div v-if="form.errors.code" class="text-red-500 text-sm">{{ form.errors.code }}</div>
            </div>

            <div>
              <label class="block mb-1">Nama Produk</label>
              <input v-model="form.name" type="text" class="w-full border p-2 rounded" required />
              <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
            </div>
            <div>
              <label for="category">Kategori</label>
              <select v-model="form.category" id="category">
                <option value="Sembako">Sembako</option>
                <option value="Makanan Instan & Siap Saji">Makanan Instan & Siap Saji</option>
                <option value="Camilan & Snack">Camilan & Snack</option>
                <option value="Minuman">Minuman</option>
                <option value="Produk Susu">Produk Susu</option>
                <option value="Bumbu Dapur">Bumbu Dapur</option>
                <option value="Produk Beku & Dingin">Produk Beku & Dingin</option>
                <option value="Rokok & Aksesoris">Rokok & Aksesoris</option>
                <option value="Kebutuhan Kebersihan Pribadi">Kebutuhan Kebersihan Pribadi</option>
                <option value="Kebutuhan Rumah Tangga">Kebutuhan Rumah Tangga</option>
                <option value="Perlengkapan Mandi & Cuci">Perlengkapan Mandi & Cuci</option>
                <option value="Perlengkapan Bayi & Anak">Perlengkapan Bayi & Anak</option>
                <option value="Obat-Obatan Ringan">Obat-Obatan Ringan</option>
                <option value="Peralatan Dapur">Peralatan Dapur</option>
                <option value="Alat Tulis & Sekolah">Alat Tulis & Sekolah</option>
                <option value="Perlengkapan Plastik & Rumah">Perlengkapan Plastik & Rumah</option>
                <option value="Pulsa & Token">Pulsa & Token</option>
                <option value="Peralatan Elektronik Kecil">Peralatan Elektronik Kecil</option>
                <option value="Kosmetik Ringan">Kosmetik Ringan</option>
                <option value="Makanan Hewan">Makanan Hewan</option>
              </select>

              <label for="unit">Unit</label>
              <select v-model="form.unit" id="unit">
                <option value="" disabled>Pilih unit</option>
                <option value="pcs">pcs</option>
                <option value="box">box</option>
                <option value="kg">kg</option>
                <option value="liter">liter</option>
              </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label>Stok Lama</label>
                <input v-model.number="oldStock" type="number" class="w-full border p-2 rounded" required />
              </div>
              <div>
                <label>Harga Lama</label>
                <input v-model.number="oldPrice" type="number" class="w-full border p-2 rounded" required />
              </div>
              <div>
                <label>Stok Baru</label>
                <input v-model.number="newStock" type="number" class="w-full border p-2 rounded" required />
              </div>
              <div>
                <label>Harga Baru</label>
                <input v-model.number="newPrice" type="number" class="w-full border p-2 rounded" required />
              </div>
            </div>

           <div class="bg-gray-100 p-4 rounded">
  <p><strong>Total Stok:</strong> {{ totalStock }}</p>
  <p><strong>Harga Rata-rata:</strong> Rp {{ averagePrice.toLocaleString('id-ID', {minimumFractionDigits: 2}) }}</p>
  <p><strong>Estimasi Keuntungan per Produk:</strong> Rp {{ (form.selling_price - averagePrice).toLocaleString('id-ID', {minimumFractionDigits: 2}) }}</p>
</div>

            <div>
              <label class="block mb-1">Harga Jual</label>
              <input v-model.number="form.selling_price" type="number" class="w-full border p-2 rounded" required />
              <div v-if="form.errors.selling_price" class="text-red-500 text-sm">{{ form.errors.selling_price }}</div>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
              Simpan Produk
            </button>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>