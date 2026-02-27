<script setup lang="ts">
import { Mail, MapPin, Phone } from 'lucide-vue-next';
</script>

<template>
    <footer
        class="border-t border-border bg-white px-6 py-16 md:px-20 dark:border-border dark:bg-background"
    >
        <div class="grid grid-cols-1 gap-12 md:grid-cols-4">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="size-6 text-primary">
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
                    <h2 class="text-xl font-bold tracking-tight">Plune</h2>
                </div>
                <p class="text-sm leading-relaxed text-muted-foreground">
                    Cosmética sólida inspirada en la naturaleza. Hecha a mano,
                    responsable con el planeta y pensada para el bienestar de tu
                    cabello y tu piel.
                </p>
            </div>

            <div>
                <h4 class="mb-6 font-bold">Tienda</h4>
                <ul class="space-y-4 text-sm text-muted-foreground">
                    <li>
                        <a
                            class="transition-colors hover:text-primary"
                            href="#"
                            >Champús en barra</a
                        >
                    </li>
                    <li>
                        <a
                            class="transition-colors hover:text-primary"
                            href="#"
                            >Acondicionadores</a
                        >
                    </li>
                    <li>
                        <a
                            class="transition-colors hover:text-primary"
                            href="#"
                            >Kits y regalos</a
                        >
                    </li>
                    <li>
                        <a
                            class="transition-colors hover:text-primary"
                            href="#"
                            >Nuevos productos</a
                        >
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="mb-6 font-bold">Ayuda</h4>
                <ul class="space-y-4 text-sm text-muted-foreground">
                    <li>
                        <a
                            class="transition-colors hover:text-primary"
                            href="#"
                            >Política de envíos</a
                        >
                    </li>
                    <li>
                        <a
                            class="transition-colors hover:text-primary"
                            href="#"
                            >Cambios y devoluciones</a
                        >
                    </li>
                    <li>
                        <a
                            class="transition-colors hover:text-primary"
                            href="#"
                            >Preguntas frecuentes</a
                        >
                    </li>
                    <li>
                        <a
                            class="transition-colors hover:text-primary"
                            href="#"
                            >Rastrear pedido</a
                        >
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="mb-6 font-bold">Contacto</h4>
                <ul class="space-y-4 text-sm text-muted-foreground">
                    <li class="flex items-center gap-2">
                        <Mail class="size-4" /> plune2024@gmail.com
                    </li>
                    <li class="flex items-center gap-2">
                        <Phone class="size-4" /> +57 318 509 4016
                    </li>
                    <li class="flex items-start gap-2">
                        <MapPin class="size-4" /><span>Colombia</span>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="mt-16 flex flex-col items-center justify-between gap-4 border-t border-border pt-8 md:flex-row dark:border-border"
        >
            <p class="text-xs text-muted-foreground">
                © 2026 Plune. Todos los derechos reservados.
            </p>
            <div class="flex gap-8 text-xs text-muted-foreground">
                <a class="hover:text-primary" href="#"
                    >Política de privacidad</a
                >
                <a class="hover:text-primary" href="#"
                    >Términos y condiciones</a
                >
            </div>
        </div>
    </footer>
</template>
