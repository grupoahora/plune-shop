<template>
    <section class="p-4 md:p-10">
        <div
            class="relative flex min-h-[520px] flex-col items-start justify-center overflow-hidden rounded-xl bg-cover px-8 md:px-20"
            style="
                background-position-y: 86%;
                background-image:
                    linear-gradient(
                        rgba(0, 0, 0, 0.45) 0%,
                        rgba(0, 0, 0, 0.3) 100%
                    ),
                    url('/images/bannerHome4.png');
            "
        >
            <div class="max-w-2xl space-y-6">
                <span
                    class="inline-block rounded-full border border-primary/30 bg-primary/20 px-4 py-1.5 text-xs font-bold tracking-widest text-primary uppercase"
                >
                    Champú de Romero
                </span>

                <h1
                    class="text-5xl leading-tight font-extrabold tracking-tight text-white md:text-6xl"
                >
                    Crecimiento Natural <br />
                    y Cabello Más Fuerte
                </h1>

                <p
                    class="max-w-lg text-lg leading-relaxed font-medium text-gray-200 md:text-xl"
                >
                    Estimula el crecimiento del cabello, fortalece la raíz y
                    ayuda a prevenir la caída. Elaborado con romero natural para
                    una limpieza profunda sin resecar.
                </p>

                <div class="flex flex-wrap gap-4 pt-4">
                    <button
                        class="rounded-xl bg-primary px-8 py-4 font-bold text-foreground shadow-lg shadow-primary/20 transition-all hover:-translate-y-1 hover:bg-primary/90"
                    >
                        Comprar ahora
                    </button>

                    <button
                        class="rounded-xl border border-white/30 bg-white/10 px-8 py-4 font-bold text-white backdrop-blur-md transition-all hover:bg-white/20"
                    >
                        Conoce sus beneficios
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
