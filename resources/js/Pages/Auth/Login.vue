<template>
  <GuestLayout>
    <Head title="Log in" />

    <!-- Full page background with black color -->
    <section class="fixed inset-0 bg-gradient-to-b from-purple-400 to-violet-900 flex justify-center items-center overflow-y-auto">
      <div class="w-full max-w-md px-6 py-8 mx-auto">
        <!-- Status Message -->
        <div v-if="status" class="mb-4 p-3 bg-green-900/40 border border-green-500 rounded-lg text-sm font-medium text-green-400">
          {{ status }}
        </div>

        <!-- Error Message -->
        <div v-if="$page.props.flash.error" class="mb-4 p-3 bg-red-900/40 border border-red-500 rounded-lg text-sm font-medium text-red-400">
          {{ $page.props.flash.error }}
        </div>

        <!-- Header dengan Logo SIKARA -->
        <div class="flex flex-col items-center mb-8">
          <!-- Container Logo dengan efek -->
          <div class="shrink-0 h-16 w-60 mb-6 relative overflow-hidden">
            <!-- Background efek cahaya -->
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/30 via-purple-600/30 to-violet-600/30 rounded-lg blur-xl animate-pulse"></div>
            
            <!-- Lingkaran efek di belakang logo -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 bg-gradient-to-br from-purple-700/40 to-purple  -600/40 rounded-full blur-md"></div>
            
            <!-- SIKARA Text dengan efek -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
              <a href="/" class="block">
                <span class="text-5xl font-extrabold tracking-widest inline-block bg-clip-text text-transparent bg-gradient-to-r from-violet-400 via-white to-purple-500 drop-shadow-lg">SIKARA</span>
              </a>
            </div>
            
            <!-- Garis bawah logo -->
            <!-- <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-20 h-0.5 bg-gradient-to-r from-violet-500 to-indigo-500"></div> -->
            
            <!-- Efek partikel -->
            <div class="absolute top-0 left-0 w-full h-full">
              <div class="absolute top-1 left-3 w-1 h-1 rounded-full bg-purple-300 animate-ping"></div>
              <div class="absolute top-2 right-5 w-1 h-1 rounded-full bg-indigo-300 animate-ping" style="animation-delay: 0.5s"></div>
              <div class="absolute bottom-2 left-6 w-1 h-1 rounded-full bg-violet-300 animate-ping" style="animation-delay: 1s"></div>
            </div>
          </div>
          
          <!-- Teks Header -->
          <h1 class="text-3xl sm:text-4xl font-bold text-center text-white mb-2">
            Login to Account
          </h1>
          <p class="text-sm sm:text-base text-center text-zinc-300">
            Enter your credentials to access your account
          </p>
        </div>

        <form @submit.prevent="submit" class="space-y-6 bg-white/30 backdrop-blur-900/60 p-6 rounded-2xl border border-white-800 backdrop-blur-sm shadow-xl">
          <!-- Single Login Input -->
          <div>
            <InputLabel for="login" value="Email or Username" class="block text-base font-medium text-white mb-2" />
            <div class="relative">
              <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <TextInput
                id="login"
                type="text"
                v-model="form.login"
                required
                autofocus
                placeholder="Enter your email or username"
                class="w-full pl-10 pr-4 py-3 rounded-xl bg-white/5 backdrop-blur-sm text-white placeholder-white/500 border border-white/20 focus:border-violet-200 focus:ring focus:ring-violet-300 focus:ring-opacity-50 transition-all"
              />
            </div>
            <InputError class="mt-2 text-rose-400" :message="form.errors.login" />
          </div>

          <!-- Password Input -->
          <div>
            <InputLabel for="password" value="Password" class="block text-base font-medium text-white mb-2" />
            <div class="relative">
              <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
              <TextInput
                id="password"
                :type="showPassword ? 'text' : 'password'"
                v-model="form.password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
                class="w-full pl-10 pr-12 py-3 rounded-xl bg-white/5 backdrop-blur-sm text-white placeholder-white/500 border border-white/20 focus:border-wihte-400 focus:ring focus:ring-white-300 focus:ring-opacity-100 transition-all"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-3 flex items-center text-white-400 hover:text-white transition-colors"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path v-if="showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                  <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
            <InputError class="mt-2 text-rose-400" :message="form.errors.password" />
          </div>

          <!-- Options: Remember Me & Forgot Password -->
          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <label class="flex items-center text-sm text-violet-300 cursor-pointer">
              <input 
                type="checkbox" 
                v-model="form.remember" 
                class="w-4 h-4 rounded bg-white-700 text-violet-500 border-white-600 focus:ring-violet-400 focus:ring-opacity-25"
              />
              <span class="ml-2">Remember me</span>
            </label>

            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="text-sm text-violet-300 hover:text-violet-100 transition-colors"
            >
              Forgot Password?
            </Link>
          </div>

          <!-- Submit Button -->
          <PrimaryButton
            type="submit"
            class="w-full py-3 text-base font-medium text-white bg-gradient-to-r from-violet-500 to-purple-600 rounded-xl hover:from-violet-600 hover:to-purple-700 transition-all shadow-lg transform hover:-translate-y-0.5 active:translate-y-0"
            :class="{ 'opacity-75': form.processing }"
            :disabled="form.processing"
          >
            <template v-if="form.processing">
              <svg class="animate-spin h-5 w-5 text-white mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Logging in...
            </template>
            <template v-else>
              Login
            </template>
          </PrimaryButton>

          <!-- SSO Login Button -->
          <div class="mt-4">
            <a
              href="/sso/redirect"
              class="w-full flex items-center justify-center py-3 px-4 border border-white-700 rounded-xl text-base font-medium text-white bg-white-800 hover:bg-purple-500 transition-all shadow-lg transform hover:-translate-y-0.5 active:translate-y-0"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                <path d="M12 6c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/>
              </svg>
              Login dengan SSO Karanganyar
            </a>
          </div>

          <!-- Register Link -->
          <div class="pt-2 text-center">
            <p class="text-gray-300 text-sm">
              Don't have an account?
              <Link :href="route('register')" class="text-violet-400 hover:text-violet-300 transition-colors font-medium">
                Register here
              </Link>
            </p>
          </div>
        </form>

        <!-- Additional information or branding can go here -->
        <div class="mt-8 text-center text-xs text-white-500">
          &copy; {{ new Date().getFullYear() }} SIKARA. All rights reserved.
        </div>
      </div>
    </section>
  </GuestLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import Checkbox from '@/Components/Checkbox.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

defineProps({
  canResetPassword: {
    type: Boolean,
    default: false
  },
  status: {
    type: String,
    default: ''
  },
})

const form = useForm({
    login: '',
    password: '',
    remember: false,
})

const showPassword = ref(false)

function submit() {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
    preserveScroll: true
  })
}
</script>

<style scoped>
/* Shimmer effect for logo text */
@keyframes shimmer {
  0% {
    background-position: -200% 0;
  }
  100% {
    background-position: 200% 0;
  }
}

.animate-shimmer {
  animation: shimmer 3s linear infinite;
  background-size: 200% 100%;
}

/* Custom scrollbar for webkit browsers */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: rgba(39, 39, 42, 0.5);
}

::-webkit-scrollbar-thumb {
  background: rgba(139, 92, 246, 0.5);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(139, 92, 246, 0.7);
}

/* Media queries for responsiveness */
@media (max-width: 640px) {
  section {
    padding: 1rem;
  }
}

/* Focus styles */
input:focus, button:focus {
  outline: none;
  box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.3);
}
</style>