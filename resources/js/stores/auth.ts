import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import type { User } from '@/types';

export const useAuthStore = defineStore('auth', () => {
    const user = ref<User | null>({
        id: 1,
        name: 'Demo User',
        email: 'demo@example.com',
        avatar: undefined,
        email_verified_at: '2025-01-01T00:00:00Z',
        created_at: '2025-01-01T00:00:00Z',
        updated_at: '2025-01-01T00:00:00Z',
    });

    const isAuthenticated = computed(() => user.value !== null);

    function setUser(newUser: User | null) {
        user.value = newUser;
    }

    function logout() {
        user.value = null;
    }

    return {
        user,
        isAuthenticated,
        setUser,
        logout,
    };
});
