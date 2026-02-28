<script setup lang="ts">
import { Form, Link, router } from '@inertiajs/vue3';
import { Moon, Search, ShoppingCart, Sun, User } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Sheet,
    SheetClose,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import { Spinner } from '@/components/ui/spinner';
import { dashboard } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { store as registerStore } from '@/routes/register';
import type { Product } from '@/types';


const props = defineProps<{
    canResetPassword: boolean;
    resolvedAppearance: string;
    products: Product[];
}>();


const emit = defineEmits<{
    setAppearance: [value: 'light' | 'dark'];
}>();

const searchTerm = ref('');


const suggestedProducts = computed(() => {
    const trimmedSearchTerm = searchTerm.value.trim();

    if (trimmedSearchTerm.length < 5) {
        return [];
    }

    const normalizedSearchTerm = trimmedSearchTerm.toLowerCase();

    return props.products
        .filter((product) => {
            return (
                product.name.toLowerCase().includes(normalizedSearchTerm) ||
                product.product_code
                    .toLowerCase()
                    .includes(normalizedSearchTerm)
            );
        })
        .slice(0, 6);
});

const searchProduct = (): void => {
    if (searchTerm.value.trim().length < 2) {
        return;
    }

    router.get('/productos/buscar', { search: searchTerm.value.trim() });
};
</script>

<template>
    <header
        class="sticky top-0 z-50 flex items-center justify-between border-b border-solid border-border bg-background px-6 py-4 whitespace-nowrap lg:px-20 dark:border-border dark:bg-card"
    >
        <div class="flex items-center gap-12">
            <div class="flex items-center gap-3">
                <div class="size-8 text-primary">
                    <svg
                        fill="currentColor"
                        viewBox="0 0 48 48"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z"
                        />
                    </svg>
                </div>
                <h2 class="text-xl font-extrabold tracking-tight">Plune</h2>
            </div>
            <nav class="hidden items-center gap-10 md:flex">
                <a
                    class="text-sm font-semibold transition-colors hover:text-primary"
                    href="#"
                    >Tienda</a
                >
                <a
                    class="text-sm font-semibold transition-colors hover:text-primary"
                    href="#"
                    >Nosotros</a
                >
                <a
                    class="text-sm font-semibold transition-colors hover:text-primary"
                    href="#"
                    >Contacto</a
                >
            </nav>
        </div>

        <div class="flex flex-1 items-center justify-end gap-6">
            <form
                class="relative hidden w-full max-w-sm items-center sm:flex"
                @submit.prevent="searchProduct"
            >
                <div class="flex w-full items-center">
                    <Input
                        v-model="searchTerm"
                        class="rounded-r-none"
                        placeholder="Buscar producto"
                        type="search"
                    />
                    <Button
                        class="rounded-l-none"
                        type="submit"
                        variant="outline"
                    >
                        <Search class="size-4" />
                    </Button>
                </div>

                <div
                    v-if="suggestedProducts.length > 0"
                    class="absolute top-full right-0 left-0 z-20 mt-2 overflow-hidden rounded-xl border border-border bg-background shadow-xl"
                >
                    <Link
                        v-for="product in suggestedProducts"
                        :key="product.id"
                        :href="`/productos/${product.id}`"
                        class="block border-b border-border px-4 py-3 text-sm hover:bg-muted last:border-b-0"
                    >
                        <p class="font-semibold">{{ product.name }}</p>
                        <p class="text-xs text-muted-foreground">
                            {{ product.product_code }}
                        </p>
                    </Link>
                </div>
            </form>

            <div class="flex gap-3">
                <div
                    class="inline-flex items-center gap-1 rounded-xl border border-border bg-white p-1 dark:border-border dark:bg-card"
                >
                    <button
                        :class="[
                            'flex size-8 items-center justify-center rounded-lg transition-all',
                            resolvedAppearance === 'light'
                                ? 'bg-muted text-foreground dark:bg-card dark:text-white'
                                : 'text-muted-foreground hover:bg-muted dark:text-muted-foreground dark:hover:bg-card',
                        ]"
                        aria-label="Cambiar a modo claro"
                        type="button"
                        @click="emit('setAppearance', 'light')"
                    >
                        <Sun class="size-4" />
                    </button>
                    <button
                        :class="[
                            'flex size-8 items-center justify-center rounded-lg transition-all',
                            resolvedAppearance === 'dark'
                                ? 'bg-muted text-foreground dark:bg-card dark:text-white'
                                : 'text-muted-foreground hover:bg-muted dark:text-muted-foreground dark:hover:bg-card',
                        ]"
                        aria-label="Cambiar a modo oscuro"
                        type="button"
                        @click="emit('setAppearance', 'dark')"
                    >
                        <Moon class="size-4" />
                    </button>
                </div>

                <button
                    class="flex size-10 items-center justify-center rounded-xl border border-border bg-white transition-all hover:border-primary dark:border-border dark:bg-card"
                    type="button"
                >
                    <ShoppingCart
                        class="size-5 text-foreground dark:text-white"
                    />
                </button>

                <Sheet v-if="!$page.props.auth.user">
                    <SheetTrigger as-child>
                        <Button
                            class="flex size-10 items-center justify-center rounded-xl border border-border bg-white transition-all hover:border-primary hover:bg-white dark:border-border dark:bg-card"
                        >
                            <User
                                class="size-5 text-foreground dark:text-white"
                            />
                        </Button>
                    </SheetTrigger>
                    <SheetContent
                        class="border-border bg-background text-foreground sm:max-w-md dark:border-border dark:bg-card dark:text-white"
                    >
                        <SheetHeader
                            class="space-y-2 border-b border-border px-6 pb-4 dark:border-border"
                        >
                            <SheetTitle
                                class="text-2xl font-extrabold tracking-tight"
                                >Iniciar sesión</SheetTitle
                            >
                            <SheetDescription
                                class="text-sm text-muted-foreground dark:text-muted-foreground"
                            >
                                Ingresa tus credenciales para acceder a tu
                                cuenta.
                            </SheetDescription>
                        </SheetHeader>
                        <Form
                            v-bind="store.form()"
                            v-slot="{ errors, processing }"
                            :reset-on-success="['password']"
                            class="grid flex-1 auto-rows-min gap-6 px-6 py-6"
                        >
                            <div class="grid gap-3">
                                <Label class="text-sm font-semibold" for="email"
                                    >Correo electrónico</Label
                                >
                                <Input
                                    id="email"
                                    :tabindex="1"
                                    autocomplete="email"
                                    autofocus
                                    class="rounded-xl border-border bg-white focus-visible:border-primary focus-visible:ring-primary/30 dark:border-border dark:bg-card"
                                    name="email"
                                    placeholder="email@example.com"
                                    required
                                    type="email"
                                />
                                <InputError :message="errors.email" />
                            </div>

                            <div class="grid gap-3">
                                <div class="flex items-center justify-between">
                                    <Label
                                        class="text-sm font-semibold"
                                        for="password"
                                        >Contraseña</Label
                                    >
                                    <TextLink
                                        v-if="canResetPassword"
                                        :href="request()"
                                        :tabindex="5"
                                        class="text-sm"
                                        >Olvidaste tu contraseña?</TextLink
                                    >
                                </div>
                                <Input
                                    id="password"
                                    :tabindex="2"
                                    autocomplete="current-password"
                                    class="rounded-xl border-border bg-white focus-visible:border-primary focus-visible:ring-primary/30 dark:border-border dark:bg-card"
                                    name="password"
                                    placeholder="Password"
                                    required
                                    type="password"
                                />
                                <InputError :message="errors.password" />
                            </div>

                            <div class="flex items-center justify-between">
                                <Label
                                    class="flex items-center space-x-3"
                                    for="remember"
                                >
                                    <Checkbox
                                        id="remember"
                                        :tabindex="3"
                                        name="remember"
                                    />
                                    <span>Recordarme</span>
                                </Label>
                            </div>

                            <SheetFooter
                                class="gap-3 border-t border-border pt-6 dark:border-border"
                            >
                                <Button
                                    :tabindex="4"
                                    class="w-full rounded-xl bg-primary py-3 font-bold text-foreground transition-all hover:bg-primary/90"
                                    type="submit"
                                >
                                    <Spinner
                                        v-if="processing"
                                        class="h-4 w-4 animate-spin"
                                    />
                                    <span v-else>Entrar</span>
                                </Button>
                                <SheetClose as-child>
                                    <Button
                                        class="w-full rounded-xl border border-border bg-white py-3 font-semibold text-foreground hover:border-primary dark:border-border dark:bg-card"
                                        type="button"
                                        variant="outline"
                                        >Cancelar</Button
                                    >
                                </SheetClose>
                                <div
                                    class="w-full text-center text-sm text-muted-foreground dark:text-muted-foreground"
                                >
                                    ¿No tienes una cuenta?
                                    <Sheet>
                                        <SheetTrigger as-child>
                                            <button
                                                class="font-semibold text-primary transition-colors hover:text-primary/80"
                                                type="button"
                                            >
                                                Regístrate
                                            </button>
                                        </SheetTrigger>
                                        <SheetContent
                                            class="border-border bg-background text-foreground sm:max-w-md dark:border-border dark:bg-card dark:text-white"
                                        >
                                            <SheetHeader
                                                class="space-y-2 border-b border-border px-6 pb-4 dark:border-border"
                                            >
                                                <SheetTitle
                                                    class="text-2xl font-extrabold tracking-tight"
                                                >
                                                    Crear cuenta
                                                </SheetTitle>
                                                <SheetDescription
                                                    class="text-sm text-muted-foreground dark:text-muted-foreground"
                                                >
                                                    Regístrate para comprar y
                                                    gestionar tus pedidos.
                                                </SheetDescription>
                                            </SheetHeader>

                                            <Form
                                                v-bind="registerStore.form()"
                                                v-slot="{ errors, processing }"
                                                :reset-on-success="[
                                                    'password',
                                                    'password_confirmation',
                                                ]"
                                                class="grid flex-1 auto-rows-min gap-6 px-6 py-6"
                                            >
                                                <div class="grid gap-3">
                                                    <Label
                                                        class="text-sm font-semibold"
                                                        for="register-name"
                                                    >
                                                        Nombre completo
                                                    </Label>
                                                    <Input
                                                        id="register-name"
                                                        :tabindex="1"
                                                        autocomplete="name"
                                                        autofocus
                                                        class="rounded-xl border-border bg-white focus-visible:border-primary focus-visible:ring-primary/30 dark:border-border dark:bg-card"
                                                        name="name"
                                                        placeholder="Nombre completo"
                                                        required
                                                        type="text"
                                                    />
                                                    <InputError
                                                        :message="errors.name"
                                                    />
                                                </div>

                                                <div class="grid gap-3">
                                                    <Label
                                                        class="text-sm font-semibold"
                                                        for="register-email"
                                                    >
                                                        Correo electrónico
                                                    </Label>
                                                    <Input
                                                        id="register-email"
                                                        :tabindex="2"
                                                        autocomplete="email"
                                                        class="rounded-xl border-border bg-white focus-visible:border-primary focus-visible:ring-primary/30 dark:border-border dark:bg-card"
                                                        name="email"
                                                        placeholder="email@example.com"
                                                        required
                                                        type="email"
                                                    />
                                                    <InputError
                                                        :message="errors.email"
                                                    />
                                                </div>

                                                <div class="grid gap-3">
                                                    <Label
                                                        class="text-sm font-semibold"
                                                        for="register-password"
                                                    >
                                                        Contraseña
                                                    </Label>
                                                    <Input
                                                        id="register-password"
                                                        :tabindex="3"
                                                        autocomplete="new-password"
                                                        class="rounded-xl border-border bg-white focus-visible:border-primary focus-visible:ring-primary/30 dark:border-border dark:bg-card"
                                                        name="password"
                                                        placeholder="Contraseña"
                                                        required
                                                        type="password"
                                                    />
                                                    <InputError
                                                        :message="
                                                            errors.password
                                                        "
                                                    />
                                                </div>

                                                <div class="grid gap-3">
                                                    <Label
                                                        class="text-sm font-semibold"
                                                        for="register-password-confirmation"
                                                    >
                                                        Confirmar contraseña
                                                    </Label>
                                                    <Input
                                                        id="register-password-confirmation"
                                                        :tabindex="4"
                                                        autocomplete="new-password"
                                                        class="rounded-xl border-border bg-white focus-visible:border-primary focus-visible:ring-primary/30 dark:border-border dark:bg-card"
                                                        name="password_confirmation"
                                                        placeholder="Confirma tu contraseña"
                                                        required
                                                        type="password"
                                                    />
                                                    <InputError
                                                        :message="
                                                            errors.password_confirmation
                                                        "
                                                    />
                                                </div>

                                                <SheetFooter
                                                    class="gap-3 border-t border-border pt-6 dark:border-border"
                                                >
                                                    <Button
                                                        :tabindex="5"
                                                        class="w-full rounded-xl bg-primary py-3 font-bold text-foreground transition-all hover:bg-primary/90"
                                                        type="submit"
                                                    >
                                                        <Spinner
                                                            v-if="processing"
                                                            class="h-4 w-4 animate-spin"
                                                        />
                                                        <span v-else
                                                            >Crear cuenta</span
                                                        >
                                                    </Button>
                                                    <SheetClose as-child>
                                                        <Button
                                                            class="w-full rounded-xl border border-border bg-white py-3 font-semibold text-foreground hover:border-primary dark:border-border dark:bg-card"
                                                            type="button"
                                                            variant="outline"
                                                        >
                                                            Cancelar
                                                        </Button>
                                                    </SheetClose>
                                                </SheetFooter>
                                            </Form>
                                        </SheetContent>
                                    </Sheet>
                                </div>
                            </SheetFooter>
                        </Form>
                    </SheetContent>
                </Sheet>
            </div>

            <nav class="hidden items-center gap-3 lg:flex">
                <Link
                    v-if="
                        $page.props.auth.user &&
                        $page?.props.auth.user.roles[0]?.name == 'Administrador'
                    "
                    :href="dashboard()"
                    class="rounded-xl border border-border px-4 py-2 text-sm font-semibold transition-colors hover:border-primary dark:border-border"
                    >Dashboard</Link
                >
                <Link
                    v-if="
                        $page.props.auth.user &&
                        $page?.props.auth.user.roles[0]?.name == 'Cliente'
                    "
                    :href="dashboard()"
                    class="rounded-xl border border-border px-4 py-2 text-sm font-semibold transition-colors hover:border-primary dark:border-border"
                    >Mi Cuenta</Link
                >
            </nav>
        </div>
    </header>
</template>
