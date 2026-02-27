<script setup lang="ts">
import { FlaskConical, Leaf, PawPrint } from 'lucide-vue-next';
</script>

<template>
    <section class="px-6 py-4 md:px-20">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div
                class="flex items-center gap-5 rounded-2xl border border-border bg-white p-6 transition-all hover:shadow-xl hover:shadow-primary/5 dark:border-border dark:bg-card"
            >
                <div
                    class="flex size-14 items-center justify-center rounded-xl bg-primary/10 text-primary"
                >
                    <Leaf class="size-8" />
                </div>
                <div>
                    <h3 class="text-lg font-bold">100% Orgánico</h3>
                    <p class="text-sm leading-snug text-muted-foreground">
                        Ingredientes certificados obtenidos responsablemente de
                        la naturaleza.
                    </p>
                </div>
            </div>

            <div
                class="flex items-center gap-5 rounded-2xl border border-border bg-white p-6 transition-all hover:shadow-xl hover:shadow-primary/5 dark:border-border dark:bg-card"
            >
                <div
                    class="flex size-14 items-center justify-center rounded-xl bg-primary/10 text-primary"
                >
                    <PawPrint class="size-8" />
                </div>
                <div>
                    <h3 class="text-lg font-bold">Sin Pruebas Animales</h3>
                    <p class="text-sm leading-snug text-muted-foreground">
                        Nunca pruebas en animales. Amigable con todos los seres
                        vivos.
                    </p>
                </div>
            </div>

            <div
                class="flex items-center gap-5 rounded-2xl border border-border bg-white p-6 transition-all hover:shadow-xl hover:shadow-primary/5 dark:border-border dark:bg-card"
            >
                <div
                    class="flex size-14 items-center justify-center rounded-xl bg-primary/10 text-primary"
                >
                    <FlaskConical class="size-8" />
                </div>
                <div>
                    <h3 class="text-lg font-bold">Libre de sintéticos</h3>
                    <p class="text-sm leading-snug text-muted-foreground">
                        Cero sulfatos agresivos, parabenos ni tintes
                        artificiales.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
