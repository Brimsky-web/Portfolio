<template>
    <div class="h-screen flex bg-gray-100 dark:bg-stone-900">
        <div class="m-auto w-1/3 p-8 bg-white dark:bg-stone-800 rounded-lg shadow-lg">
            <h2 class="text-center text-3xl font-bold text-gray-800 dark:text-white mb-8">Login</h2>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" id="email" v-model="form.email" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Password</label>
                    <input type="password" id="password" v-model="form.password" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>

                <button type="submit" class="w-full px-4 py-2 font-bold text-white bg-primary-500 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-primary-500 focus:border-primary-500">Login</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const form = ref({
    email: '',
    password: '',
})

const submit = async () => {
    await authStore.login(form.value)
    router.push({ name: 'dashboard' })
}
</script>
