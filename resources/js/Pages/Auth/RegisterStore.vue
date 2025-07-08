<template>
    <GuestLayout>
        <Head title="Register Store" />

        <!-- Full page background with black color -->
        <section class="fixed inset-0 bg-black flex justify-center items-start overflow-y-auto pt-20 md:pt-24 pb-10">   
            <div class="w-full max-w-2xl px-4 my-8">
                <form @submit.prevent="submit" enctype="multipart/form-data" class="bg-zinc-900 rounded-3xl p-6 sm:p-8 md:p-10 shadow-2xl border border-zinc-800">
                    <!-- Header dengan Logo SIKARA yang Ditingkatkan -->
                    <div class="flex flex-col items-center mb-8">
                        <!-- Container Logo dengan efek lebih kuat -->
                        <div class="shrink-0 h-16 w-[140px] mb-6 relative overflow-hidden">
                            <!-- Background efek cahaya -->
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/20 via-purple-600/20 to-violet-600/20 rounded-lg blur-xl animate-pulse"></div>
                            
                            <!-- Lingkaran efek di belakang logo -->
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 bg-gradient-to-br from-violet-700/40 to-indigo-600/40 rounded-full blur-md"></div>
                            
                            <!-- SIKARA Text dengan efek yang lebih kaya -->
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
                                <a href="/" class="block">
                                    <span class="text-3xl font-extrabold tracking-widest inline-block bg-clip-text text-transparent bg-gradient-to-r from-violet-400 via-white to-purple-500 animate-shimmer drop-shadow-lg">SIKARA</span>
                                </a>
                            </div>
                            
                            <!-- Garis bawah logo -->
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-16 h-[2px] bg-gradient-to-r from-violet-500 to-indigo-500"></div>
                            
                            <!-- Efek partikel (titik-titik cahaya) -->
                            <div class="absolute top-0 left-0 w-full h-full">
                                <div class="absolute top-1 left-3 w-1 h-1 rounded-full bg-purple-300 animate-ping"></div>
                                <div class="absolute top-2 right-5 w-1 h-1 rounded-full bg-indigo-300 animate-ping" style="animation-delay: 0.5s"></div>
                                <div class="absolute bottom-2 left-6 w-1 h-1 rounded-full bg-violet-300 animate-ping" style="animation-delay: 1s"></div>
                            </div>
                        </div>
                        
                        <!-- Teks Header -->
                        <h1 class="text-3xl sm:text-4xl font-bold text-center text-white mb-2">
                            Daftarkan Toko Anda
                        </h1>
                        <p class="text-sm sm:text-base text-center text-zinc-300">
                            Silakan lengkapi data untuk mendaftar sebagai partner
                        </p>
                    </div>

                    <!-- Form sections with improved spacing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                        <!-- Section 1: Akun -->
                        <div>
                            <h2 class="text-lg font-semibold text-violet-300 mb-4">Informasi Akun</h2>
                            
                            <div class="mb-4">
                                <InputLabel for="name" value="Nama Lengkap" class="block text-sm font-medium text-white mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <TextInput id="name" type="text" class="w-full pl-10 pr-4 py-2 rounded-xl bg-zinc-800 text-white text-base placeholder-zinc-400 border border-zinc-700 focus:border-violet-400 focus:ring focus:ring-violet-300 focus:ring-opacity-50" 
                                        v-model="form.name" required placeholder="Masukkan nama lengkap" />
                                </div>
                                <InputError class="mt-1 text-rose-400 text-sm" :message="form.errors.name" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="email" value="Email" class="block text-sm font-medium text-white mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <TextInput id="email" type="email" class="w-full pl-10 pr-4 py-2 rounded-xl bg-zinc-800 text-white text-base placeholder-zinc-400 border border-zinc-700 focus:border-violet-400 focus:ring focus:ring-violet-300 focus:ring-opacity-50" 
                                        v-model="form.email" required placeholder="Masukkan alamat email" />
                                </div>
                                <InputError class="mt-1 text-rose-400 text-sm" :message="form.errors.email" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="password" value="Password" class="block text-sm font-medium text-white mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <TextInput id="password" type="password" class="w-full pl-10 pr-4 py-2 rounded-xl bg-zinc-800 text-white text-base placeholder-zinc-400 border border-zinc-700 focus:border-violet-400 focus:ring focus:ring-violet-300 focus:ring-opacity-50" 
                                        v-model="form.password" required placeholder="Buat password" />
                                </div>
                                <InputError class="mt-1 text-rose-400 text-sm" :message="form.errors.password" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="password_confirmation" value="Konfirmasi Password" class="block text-sm font-medium text-white mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <TextInput id="password_confirmation" type="password" class="w-full pl-10 pr-4 py-2 rounded-xl bg-zinc-800 text-white text-base placeholder-zinc-400 border border-zinc-700 focus:border-violet-400 focus:ring focus:ring-violet-300 focus:ring-opacity-50" 
                                        v-model="form.password_confirmation" required placeholder="Konfirmasi password" />
                                </div>
                                <InputError class="mt-1 text-rose-400 text-sm" :message="form.errors.password_confirmation" />
                            </div>
                        </div>

                        <!-- Section 2: Informasi Toko -->
                        <div>
                            <h2 class="text-lg font-semibold text-violet-300 mb-4 mt-6 md:mt-0">Informasi Toko</h2>
                            
                            <div class="mb-4">
                                <InputLabel for="store_name" value="Nama Toko" class="block text-sm font-medium text-white mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <TextInput id="store_name" type="text" class="w-full pl-10 pr-4 py-2 rounded-xl bg-zinc-800 text-white text-base placeholder-zinc-400 border border-zinc-700 focus:border-violet-400 focus:ring focus:ring-violet-300 focus:ring-opacity-50" 
                                        v-model="form.store_name" required placeholder="Masukkan nama toko" />
                                </div>
                                <InputError class="mt-1 text-rose-400 text-sm" :message="form.errors.store_name" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="address" value="Alamat" class="block text-sm font-medium text-white mb-1" />
                                <div class="relative">
                                    <div class="absolute top-3 left-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <TextInput id="address" type="text" class="w-full pl-10 pr-4 py-2 rounded-xl bg-zinc-800 text-white text-base placeholder-zinc-400 border border-zinc-700 focus:border-violet-400 focus:ring focus:ring-violet-300 focus:ring-opacity-50" 
                                        v-model="form.address" required placeholder="Masukkan alamat toko" />
                                </div>
                                <InputError class="mt-1 text-rose-400 text-sm" :message="form.errors.address" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="nik" value="NIK" class="block text-sm font-medium text-white mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                    </div>
                                    <TextInput id="nik" type="text" class="w-full pl-10 pr-4 py-2 rounded-xl bg-zinc-800 text-white text-base placeholder-zinc-400 border border-zinc-700 focus:border-violet-400 focus:ring focus:ring-violet-300 focus:ring-opacity-50" 
                                        v-model="form.nik" required placeholder="Masukkan NIK (16 digit)" maxlength="16" />
                                </div>
                                <InputError class="mt-1 text-rose-400 text-sm" :message="form.errors.nik" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="phone" value="Nomor Telepon (WA)" class="block text-sm font-medium text-white mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <TextInput id="phone" type="text" class="w-full pl-10 pr-4 py-2 rounded-xl bg-zinc-800 text-white text-base placeholder-zinc-400 border border-zinc-700 focus:border-violet-400 focus:ring focus:ring-violet-300 focus:ring-opacity-50" 
                                        v-model="form.phone" required placeholder="Masukkan nomor WhatsApp" />
                                </div>
                                <InputError class="mt-1 text-rose-400 text-sm" :message="form.errors.phone" />
                            </div>
                        </div>
                    </div>

                    <!-- Upload Section -->
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-violet-300 mb-4">Upload Dokumen</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">
                            <!-- Upload Foto KTP -->
                            <div class="mb-4">
                                <InputLabel for="ktp_photo" value="Foto KTP" class="block text-sm font-medium text-white mb-1" />
                                <div class="relative">
                                    <div class="mt-1">
                                        <div class="border-2 border-dashed border-zinc-700 rounded-xl px-4 py-4 bg-zinc-800 hover:border-violet-400 transition-colors duration-300">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-zinc-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p class="text-sm text-zinc-400 mb-2">Klik untuk upload foto KTP</p>
                                                <div v-if="ktpPreview" class="relative w-full h-32 mb-2">
                                                    <img :src="ktpPreview" class="w-full h-full object-contain rounded-lg" />
                                                </div>
                                                <input id="ktp_photo" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                    accept="image/*" @change="handleKtpUpload" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <InputError class="mt-1 text-rose-400 text-sm" :message="form.errors.ktp_photo" />
                            </div>

                            <!-- Upload Foto Selfie -->
                            <div class="mb-4">
                                <InputLabel for="selfie_photo" value="Foto Selfie" class="block text-sm font-medium text-white mb-1" />
                                <div class="relative">
                                    <div class="mt-1">
                                        <div class="border-2 border-dashed border-zinc-700 rounded-xl px-4 py-4 bg-zinc-800 hover:border-violet-400 transition-colors duration-300">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-zinc-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <p class="text-sm text-zinc-400 mb-2">Klik untuk upload foto selfie</p>
                                                <div v-if="selfiePreview" class="relative w-full h-32 mb-2">
                                                    <img :src="selfiePreview" class="w-full h-full object-contain rounded-lg" />
                                                </div>
                                                <input id="selfie_photo" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                    accept="image/*" @change="handleSelfieUpload" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <InputError class="mt-1 text-rose-400 text-sm" :message="form.errors.selfie_photo" />
                            </div>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="mt-8 flex flex-col-reverse sm:flex-row items-center justify-between gap-4">
                        <Link :href="route('login')" class="text-violet-400 hover:text-violet-300 transition-colors underline text-center sm:text-left w-full sm:w-auto">
                            Sudah punya akun? Login
                        </Link>

                        <PrimaryButton 
                            type="submit" 
                            class="w-full sm:w-auto py-3 px-6 text-base font-medium text-white bg-gradient-to-r from-violet-500 to-purple-600 rounded-xl hover:from-violet-600 hover:to-purple-700 transition-all shadow-lg transform hover:-translate-y-0.5 active:translate-y-0"
                            :class="{ 'opacity-75 cursor-not-allowed': form.processing }" 
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing" class="mr-2">
                                <svg class="animate-spin h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                            {{ form.processing ? 'Mendaftar...' : 'Daftar' }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </section>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    ssoUser: {
        type: Object,
        required: true
    }
});

const ktpPhoto = ref(null);
const selfiePhoto = ref(null);
const ktpPreview = ref(null);
const selfiePreview = ref(null);

const form = useForm({
    name: props.ssoUser.nama,
    email: props.ssoUser.email,
    password: '',
    password_confirmation: '',
    store_name: '',
    address: props.ssoUser.alamat,
    nik: props.ssoUser.nik,
    phone: props.ssoUser.no_wa,
    ktp_photo: null,
    selfie_photo: null,
});

// Fungsi untuk preview foto KTP
const handleKtpUpload = (event) => {
    const file = event.target.files[0];
    form.ktp_photo = file;
    
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            ktpPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Fungsi untuk preview foto selfie
const handleSelfieUpload = (event) => {
    const file = event.target.files[0];
    form.selfie_photo = file;
    
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            selfiePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Fungsi submit form dengan FormData
const submit = () => {
    const formData = new FormData();
    
    for (const key in form) {
        if (form[key] !== null) {
            formData.append(key, form[key]);
        }
    }

    form.post(route('sso.register.store'), {
        forceFormData: true, // Pastikan dikirim sebagai FormData
        onFinish: () => {
            form.reset('password', 'password_confirmation');
            // Reset file preview jika registrasi berhasil
            ktpPreview.value = null;
            selfiePreview.value = null;
            form.ktp_photo = null;
            form.selfie_photo = null;
        },
    });
};
</script>

<style scoped>
/* Fixed full-page background */
section {
    min-height: 100vh;
    background-color: #000;
}

/* Override input styles */
:deep(.form-input),
:deep(.form-select),
:deep(.form-textarea) {
    border-radius: 0.75rem;
    background-color: rgb(39, 39, 42);
    border-color: rgb(63, 63, 70);
    color: #fff;
    padding: 0.75rem 1rem;
    width: 100%;
}

:deep(.form-input:focus),
:deep(.form-select:focus),
:deep(.form-textarea:focus) {
    border-color: rgb(167, 139, 250);
    box-shadow: 0 0 0 2px rgba(167, 139, 250, 0.2);
}

/* Enhanced upload area */
input[type="file"] {
    cursor: pointer;
}

/* Button styles */
:deep(button[type="submit"]) {
    font-weight: 500;
    letter-spacing: 0.025em;
    text-transform: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Hover pulse animation */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50%     { opacity: 0.85; }
}

/* Shimmer animation for SIKARA text */
@keyframes shimmer {
    0% { background-position: -100% 0; }
    100% { background-position: 200% 0; }
}

.animate-shimmer {
    background-size: 200% auto;
    animation: shimmer 3s linear infinite;
}

:deep(button[type="submit"]:hover:not(:disabled)) {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Shadow for form on larger screens */
@media (min-width: 768px) {
    form {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
}
</style> 