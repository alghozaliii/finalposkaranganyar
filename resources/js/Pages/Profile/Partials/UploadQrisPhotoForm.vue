<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const user = computed(() => usePage().props.auth.user);

const qrisPhoto = ref(null);
const qrisPreview = ref(user.value.qris_photo ? `/storage/${user.value.qris_photo}` : null);

const form = useForm({
    qris_photo: null,
});

const handleQrisUpload = (event) => {
    const file = event.target.files[0];
    form.qris_photo = file;
    
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            qrisPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        qrisPreview.value = user.value.qris_photo ? `/storage/${user.value.qris_photo}` : null;
    }
};

const uploadQris = () => {
    form.post(route('owner.profile.uploadQrisPhoto'), {
        forceFormData: true,
        onSuccess: () => {
            // Optionally reset form or update preview after successful upload
            form.qris_photo = null;
            // Re-fetch user data to update the preview with new image path
            usePage().props.auth.user.qris_photo = user.value.qris_photo;
            alert('Foto QRIS berhasil diunggah!');
        },
        onError: (errors) => {
            console.error('Gagal mengunggah foto QRIS:', errors);
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Upload QRIS Photo</h2>

            <p class="mt-1 text-sm text-gray-600">
                Upload foto QRIS Anda untuk metode pembayaran QRIS.
            </p>
        </header>

        <form @submit.prevent="uploadQris" class="mt-6 space-y-6">
            <div>
                <InputLabel for="qris_photo" value="Foto QRIS" />

                <div class="relative mt-2">
                    <div class="mt-1">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg px-4 py-4 text-center bg-gray-50 hover:border-blue-400 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-600 mt-2">Klik untuk upload foto QRIS</p>
                            <div v-if="qrisPreview" class="relative w-full h-32 mb-2">
                                <img :src="qrisPreview" class="w-full h-full object-contain rounded-lg" />
                            </div>
                            <input id="qris_photo" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                accept="image/*" @change="handleQrisUpload" />
                        </div>
                    </div>
                </div>

                <InputError class="mt-2" :message="form.errors.qris_photo" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template> 