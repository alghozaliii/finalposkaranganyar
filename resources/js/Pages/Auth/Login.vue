<template>
  <GuestLayout>
    <Head title="Log in" />

    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <!-- Full page background with black color -->
    <section class="fixed inset-0 bg-black flex justify-center items-center overflow-y-auto">
      <!-- Login container -->
      <div class="w-full max-w-md px-4 py-8 md:py-0">
        <form @submit.prevent="submit" class="bg-zinc-900 rounded-3xl p-6 sm:p-8 md:p-10 w-full shadow-2xl border border-zinc-800">
          <div class="flex flex-col items-center">
            <div class="shrink-0 h-9 w-[75px] mb-6">
              <a href="/" class="shrink-0 h-9 w-[75px] mb-6 block text-center">
                <span class="inline-block bg-clip-text text-transparent bg-gradient-to-r from-violet-400 via-white to-purple-500 animate-shimmer">GWL</span>
              </a>
            </div>
            
            <h1 class="text-3xl sm:text-4xl font-bold text-center text-white mb-2">
              Welcome Back!
            </h1>
            <p class="text-sm sm:text-base text-center text-zinc-300">
              Please enter your credentials below to continue
            </p>
          </div>

          <!-- Email Input -->
          <div class="mt-8 mb-6">
            <InputLabel for="email" value="Email" class="block text-base font-medium text-white mb-2" />
            <div class="relative">
              <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 
                           00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <TextInput
                id="email"
                type="email"
                v-model="form.email"
                required
                autofocus
                autocomplete="username"
                placeholder="Enter your email"
                class="w-full pl-10 pr-4 py-3 rounded-xl bg-zinc-800 text-white text-base sm:text-lg placeholder-zinc-400 border border-zinc-700 focus:border-violet-400 focus:ring focus:ring-violet-300 focus:ring-opacity-50 transition-all"
              />
            </div>
            <InputError class="mt-2 text-rose-400" :message="form.errors.email" />
          </div>

          <!-- Password Input -->
          <div class="mb-6">
            <InputLabel for="password" value="Password" class="block text-base font-medium text-white mb-2" />
            <div class="relative">
              <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 
                           00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 
                           0 00-8 0v4h8z" />
                </svg>
              </div>
              <TextInput
                id="password"
                :type="showPassword ? 'text' : 'password'"
                v-model="form.password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
                class="w-full pl-10 pr-12 py-3 rounded-xl bg-zinc-800 text-white text-base sm:text-lg placeholder-zinc-400 border border-zinc-700 focus:border-violet-400 focus:ring focus:ring-violet-300 focus:ring-opacity-50 transition-all"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-3 flex items-center text-zinc-400 hover:text-white transition-colors"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path v-if="showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 
                           0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 
                           0 011.563-3.029m5.858.908a3 3 0 
                           114.243 4.243M9.878 9.878l4.242 4.242M9.88 
                           9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 
                           3l3.59 3.59m0 0A9.953 9.953 0 
                           0112 5c4.478 0 8.268 2.943 9.543 7a10.025 
                           10.025 0 01-4.132 5.411m0 0L21 21" />
                  <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 
                           5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 
                           4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
            <InputError class="mt-2 text-rose-400" :message="form.errors.password" />
          </div>

          <!-- Options: Remember Me & Forgot Password -->
          <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <label class="flex items-center text-base text-violet-300 cursor-pointer mb-4 sm:mb-0">
              <Checkbox name="remember" v-model:checked="form.remember" class="hidden" />
              <div
                :class="[
                  'w-5 h-5 rounded-md border border-violet-400 flex items-center justify-center flex-shrink-0 mr-2 transition-colors',
                  form.remember ? 'bg-violet-500 border-violet-500' : 'bg-transparent'
                ]"
              >
                <svg v-if="form.remember" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <span>Remember me</span>
            </label>

            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="text-base text-violet-300 hover:text-violet-100 transition-colors underline"
            >
              Forgot Password?
            </Link>
          </div>

          <!-- Submit Button -->
          <PrimaryButton
            type="submit"
            class="w-full py-4 text-base sm:text-lg font-medium text-white bg-gradient-to-r from-violet-500 to-purple-600 rounded-xl hover:from-violet-600 hover:to-purple-700 transition-all shadow-lg transform hover:-translate-y-0.5 active:translate-y-0"
            :class="{ 'opacity-75 cursor-not-allowed': form.processing }"
            :disabled="form.processing"
          >
            <span v-if="form.processing" class="mr-2">
              <svg class="animate-spin h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 
                        0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 
                        014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
            </span>
            {{ form.processing ? 'Logging in...' : 'Login' }}
          </PrimaryButton>

          <!-- Register Link -->
          <div class="mt-6 text-center">
            <p class="text-zinc-400">
              Don't have an account?
              <Link :href="route('register')" class="text-violet-400 hover:text-violet-300 transition-colors">
                Register here
              </Link>
            </p>
          </div>
        </form>
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
  canResetPassword: Boolean,
  status: String,
})

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const showPassword = ref(false)

function submit() {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<style scoped>
/* Fixed full-page background */
section {
  min-height: 100vh;
  background-color: #000;
}

/* Improved styling for form elements */
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

/* Override PrimaryButton styles */
:deep(button[type="submit"]) {
  width: 100%;
  padding: 1rem;
  font-weight: 500;
  letter-spacing: 0.025em;
  text-transform: none;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
              0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Error message styling */
:deep(.text-red-600) {
  color: rgb(251, 113, 133);
}

/* Hover pulse animation */
@keyframes pulse {
  0%, 100% { opacity: 1; }
  50%     { opacity: 0.85; }
}

:deep(button[type="submit"]:hover:not(:disabled)) {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Responsive adjustments */
@media (max-width: 640px) {
  :deep(button[type="submit"]) {
    padding: 0.75rem;
  }
}

@media (min-width: 768px) {
  form {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
  }
}
</style>