<script setup lang="ts">
import { FlaskConical, Leaf, PawPrint } from 'lucide-vue-next';
</script>

<template>
    <section class="px-6 py-4 md:px-20">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div
                class="flex items-center gap-5 rounded-2xl border border-[#dbe6df] bg-white p-6 transition-all hover:shadow-xl hover:shadow-[#13ec5b]/5 dark:border-[#2a3a2e] dark:bg-[#1a2e20]"
            >
                <div
                    class="flex size-14 items-center justify-center rounded-xl bg-[#13ec5b]/10 text-[#13ec5b]"
                >
                    <Leaf class="size-8" />
                </div>
                <div>
                    <h3 class="text-lg font-bold">100% Orgánico</h3>
                    <p class="text-sm leading-snug text-[#61896f]">
                        Ingredientes certificados obtenidos responsablemente de
                        la naturaleza.
                    </p>
                </div>
            </div>

            <div
                class="flex items-center gap-5 rounded-2xl border border-[#dbe6df] bg-white p-6 transition-all hover:shadow-xl hover:shadow-[#13ec5b]/5 dark:border-[#2a3a2e] dark:bg-[#1a2e20]"
            >
                <div
                    class="flex size-14 items-center justify-center rounded-xl bg-[#13ec5b]/10 text-[#13ec5b]"
                >
                    <PawPrint class="size-8" />
                </div>
                <div>
                    <h3 class="text-lg font-bold">Sin Pruebas Animales</h3>
                    <p class="text-sm leading-snug text-[#61896f]">
                        Nunca pruebas en animales. Amigable con todos los seres
                        vivos.
                    </p>
                </div>
            </div>

            <div
                class="flex items-center gap-5 rounded-2xl border border-[#dbe6df] bg-white p-6 transition-all hover:shadow-xl hover:shadow-[#13ec5b]/5 dark:border-[#2a3a2e] dark:bg-[#1a2e20]"
            >
                <div
                    class="flex size-14 items-center justify-center rounded-xl bg-[#13ec5b]/10 text-[#13ec5b]"
                >
                    <FlaskConical class="size-8" />
                </div>
                <div>
                    <h3 class="text-lg font-bold">Libre de sintéticos</h3>
                    <p class="text-sm leading-snug text-[#61896f]">
                        Cero sulfatos agresivos, parabenos ni tintes
                        artificiales.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
