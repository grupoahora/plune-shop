import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('@/pages/Welcome.vue'),
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('@/pages/auth/Login.vue'),
        },
        {
            path: '/register',
            name: 'register',
            component: () => import('@/pages/auth/Register.vue'),
        },
        {
            path: '/forgot-password',
            name: 'forgot-password',
            component: () => import('@/pages/auth/ForgotPassword.vue'),
        },
        {
            path: '/reset-password/:token',
            name: 'reset-password',
            component: () => import('@/pages/auth/ResetPassword.vue'),
            props: true,
        },
        {
            path: '/confirm-password',
            name: 'confirm-password',
            component: () => import('@/pages/auth/ConfirmPassword.vue'),
        },
        {
            path: '/verify-email',
            name: 'verify-email',
            component: () => import('@/pages/auth/VerifyEmail.vue'),
        },
        {
            path: '/two-factor-challenge',
            name: 'two-factor-challenge',
            component: () => import('@/pages/auth/TwoFactorChallenge.vue'),
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: () => import('@/pages/Dashboard.vue'),
        },
        {
            path: '/settings/profile',
            name: 'settings.profile',
            component: () => import('@/pages/settings/Profile.vue'),
        },
        {
            path: '/settings/password',
            name: 'settings.password',
            component: () => import('@/pages/settings/Password.vue'),
        },
        {
            path: '/settings/two-factor',
            name: 'settings.two-factor',
            component: () => import('@/pages/settings/TwoFactor.vue'),
        },
        {
            path: '/settings/appearance',
            name: 'settings.appearance',
            component: () => import('@/pages/settings/Appearance.vue'),
        },
    ],
});

export default router;
