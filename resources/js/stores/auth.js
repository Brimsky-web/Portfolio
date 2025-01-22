import { defineStore } from 'pinia'
import { router } from '@inertiajs/vue3'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        isAuthenticated: false,
    }),
    
    actions: {
        async login(form) {
            try {
                await form.post(route('admin.login'), {
                    onSuccess: () => {
                        this.isAuthenticated = true;
                    },
                });
            } catch (error) {
                console.error('Login failed:', error);
            }
        },

        async logout() {
            try {
                await router.post(route('admin.logout'));
                this.isAuthenticated = false;
                this.user = null;
            } catch (error) {
                console.error('Logout failed:', error);
            }
        }
    }
});
