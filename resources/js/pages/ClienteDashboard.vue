<script setup lang="ts">
import { Form, Head, Link, usePage } from '@inertiajs/vue3';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import InputError from '@/components/InputError.vue';
import { useAppearance } from '@/composables/useAppearance';
import WelcomeLayout from '@/layouts/welcome/WelcomeLayout.vue';
import { home } from '@/routes';
import { send } from '@/routes/verification';
import type { Product } from '@/types';

const props = withDefaults(
    defineProps<{
        canResetPassword: boolean;
        mustVerifyEmail?: boolean;
        status?: string;
        allProducts: Product[];
    }>(),
    {
        mustVerifyEmail: false,
        status: undefined,
    },
);

const { resolvedAppearance, updateAppearance } = useAppearance();

const setAppearance = (value: 'light' | 'dark'): void => {
    updateAppearance(value);
};

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
    <Head title="Dashboard de cliente" />

    <WelcomeLayout
        :can-reset-password="props.canResetPassword"
        :resolved-appearance="resolvedAppearance"
        :products="props.allProducts"
        @set-appearance="setAppearance"
    >
        <main class="px-6 py-8 md:px-20 lg:px-40">
            <section class="mx-auto w-full max-w-3xl rounded-2xl border border-border bg-background/80 p-6 shadow-sm dark:bg-card">
                <h1 class="text-2xl font-bold">Mi perfil</h1>
                <p class="mt-2 text-sm text-muted-foreground">
                    Actualiza tus datos de usuario para mantener tu cuenta al día.
                </p>

                <Form
                    v-bind="ProfileController.update.form()"
                    class="mt-6 space-y-5"
                    v-slot="{ errors, processing, recentlySuccessful }"
                >
                    <div class="grid gap-2">
                        <label for="name" class="text-sm font-medium">Nombre</label>
                        <input
                            id="name"
                            class="h-10 rounded-md border border-input bg-background px-3 text-sm"
                            name="name"
                            :default-value="user.name"
                            required
                            autocomplete="name"
                            placeholder="Tu nombre"
                        />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <label for="email" class="text-sm font-medium">Correo electrónico</label>
                        <input
                            id="email"
                            type="email"
                            class="h-10 rounded-md border border-input bg-background px-3 text-sm"
                            name="email"
                            :default-value="user.email"
                            required
                            autocomplete="username"
                            placeholder="correo@ejemplo.com"
                        />
                        <InputError :message="errors.email" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at" class="text-sm text-muted-foreground">
                        Tu correo aún no está verificado.
                        <Link :href="send()" as="button" class="ml-1 underline underline-offset-4">
                            Reenviar correo de verificación.
                        </Link>

                        <p v-if="status === 'verification-link-sent'" class="mt-2 font-medium text-green-600">
                            Te enviamos un nuevo enlace de verificación.
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <button
                            type="submit"
                            class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground disabled:opacity-70"
                            :disabled="processing"
                        >
                            Guardar cambios
                        </button>

                        <span v-if="recentlySuccessful" class="text-sm text-muted-foreground">Guardado.</span>
                    </div>
                </Form>

                <Link :href="home()" class="mt-6 inline-block text-sm underline underline-offset-4">Volver al inicio</Link>
            </section>
        </main>
    </WelcomeLayout>
</template>
