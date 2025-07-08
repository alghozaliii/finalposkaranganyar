<template>
  <div class="bg-white rounded-lg border overflow-hidden">
    <div class="p-4 md:p-6">
      <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-4">Daftar Akun Owner</h2>
      <div class="overflow-x-auto -mx-4 md:mx-0">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
              <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Toko</th>
              <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat Toko</th>
              <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
              <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
              <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. WA</th>
              <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-if="!owners.length">
              <td colspan="9" class="px-3 md:px-6 py-4 text-center text-gray-500">Tidak ada owner terdaftar</td>
            </tr>
            <tr v-for="owner in owners" :key="owner.id" class="hover:bg-gray-50">
              <td class="px-3 md:px-6 py-4 text-sm">{{ owner.name }}</td>
              <td class="px-3 md:px-6 py-4 text-sm">{{ owner.email }}</td>
              <td class="px-3 md:px-6 py-4 text-sm">{{ owner.store_name || '-' }}</td>
              <td class="px-3 md:px-6 py-4 text-sm">{{ owner.store_address || '-' }}</td>
              <td class="px-3 md:px-6 py-4 text-sm">{{ owner.address || '-' }}</td>
              <td class="px-3 md:px-6 py-4 text-sm">{{ owner.nik || '-' }}</td>
              <td class="px-3 md:px-6 py-4 text-sm">{{ owner.phone || '-' }}</td>
              <td class="px-3 md:px-6 py-4 text-sm">
                <select v-model="owner.store_status" @change="updateStoreStatus(owner, owner.store_status)" class="border rounded px-2 py-1">
                  <option value="aktif">Aktif</option>
                  <option value="nonaktif">Nonaktif</option>
                </select>
              </td>
              <td class="px-3 md:px-6 py-4 text-sm">
                <div v-if="owner.employees && owner.employees.length" class="space-y-1">
                  <div v-for="emp in owner.employees" :key="emp.id" class="break-words">
                    {{ emp.name }} ({{ emp.employees_role }})
                  </div>
                </div>
                <span v-else class="text-gray-500">Tidak ada pegawai</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  owners: {
    type: Array,
    default: () => []
  }
});

import { router } from '@inertiajs/vue3';

function updateStoreStatus(owner, value) {
  router.post(route('admin.owner.updateStoreStatus', owner.id), { store_status: value }, {
    preserveScroll: true,
    onSuccess: () => {},
    onError: () => {},
  });
}
</script> 