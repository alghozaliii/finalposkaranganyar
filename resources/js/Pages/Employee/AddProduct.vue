<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import axios from 'axios';

const form = useForm({
  code: '',
  name: '',
  stock: 0,
  average_price: 0,
  selling_price: 0,
  category: '',
  unit: '',
});

const existingProduct = ref(null);

const keuntunganBaru = computed(() => {
  return form.selling_price - form.average_price;
});
const stokBaru = computed(() => {
  if (existingProduct.value) {
    return Number(existingProduct.value.stock) + Number(form.stock);
  }
  return form.stock;
});

// Cek produk saat kode berubah
watch(() => form.code, async (newCode) => {
  if (!newCode) {
    existingProduct.value = null;
    return;
  }
  try {
    const res = await axios.get(`/employee/stock/check?code=${encodeURIComponent(newCode)}`);
    existingProduct.value = res.data.product || null;
  } catch {
    existingProduct.value = null;
  }
});

// Jika produk ditemukan, isi otomatis nama produk di form
watch(existingProduct, (val) => {
  if (val) {
    form.name = val.name;
  }
});

function addProduct() {
  form.post('/employee/stock', {
    onSuccess: () => {
      form.reset();
      existingProduct.value = null;
    },
    onError: () => {
      // error handling
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
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6 text-gray-900">
          <form @submit.prevent="addProduct" class="space-y-6">
            <div>
              <label class="block mb-1">Kode Produk</label>
              <input v-model="form.code" type="text" class="w-full border p-2 rounded" required />
              <div v-if="form.errors.code" class="text-red-500 text-sm">{{ form.errors.code }}</div>
              <!-- Info produk lama -->
              <div v-if="existingProduct" class="p-3 mb-2 bg-yellow-50 border border-yellow-300 rounded">
                <div class="font-semibold text-yellow-700 mb-1">Produk ditemukan!</div>
                <div class="text-sm">
                  <div>Stok lama: <span class="font-bold">{{ existingProduct.stock }}</span></div>
                  <div>Harga beli lama: <span class="font-bold">Rp {{ Number(existingProduct.average_price).toLocaleString('id-ID') }}</span></div>
                  <div>Harga jual lama: <span class="font-bold">Rp {{ Number(existingProduct.selling_price).toLocaleString('id-ID') }}</span></div>
                  <div>Keuntungan lama: <span class="font-bold">Rp {{ Number(existingProduct.selling_price - existingProduct.average_price).toLocaleString('id-ID') }}</span></div>
                </div>
              </div>
            </div>
            <div>
              <label class="block mb-1">Nama Produk</label>
              <input v-model="form.name" type="text" class="w-full border p-2 rounded" required />
              <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
            </div>
            <div>
              <label class="block mb-1">Stok</label>
              <input v-model.number="form.stock" type="number" class="w-full border p-2 rounded" required min="1" />
              <div v-if="existingProduct" class="text-sm mt-1">
                Stok setelah update: <span class="font-bold text-blue-700">{{ stokBaru }}</span>
              </div>
            </div>
            <div>
              <label class="block mb-1">Harga Beli</label>
              <input v-model.number="form.average_price" type="number" class="w-full border p-2 rounded" required min="0" />
            </div>
            <div>
              <label class="block mb-1">Harga Jual</label>
              <input v-model.number="form.selling_price" type="number" class="w-full border p-2 rounded" required min="0" />
              <div v-if="form.selling_price && form.average_price" class="text-sm mt-1">
                Keuntungan per produk baru: <span class="font-bold text-green-700">Rp {{ keuntunganBaru.toLocaleString('id-ID') }}</span>
              </div>
            </div>
            <div>
              <label for="category">Kategori</label>
              <select v-model="form.category" id="category" class="w-full border p-2 rounded">
                <option value="">Pilih Kategori</option>
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
            </div>
            <div>
              <label for="unit">Unit</label>
              <select v-model="form.unit" id="unit" class="w-full border p-2 rounded">
                <option value="" disabled>Pilih unit</option>
                <option value="pcs">pcs</option>
                <option value="box">box</option>
                <option value="kg">kg</option>
                <option value="liter">liter</option>
              </select>
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