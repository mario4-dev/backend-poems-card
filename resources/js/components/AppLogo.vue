<script setup lang="ts">
import { ref } from 'vue';

// Control de visibilidad del logo (oculta si hay error de carga)
const showLogo = ref(true);
const hideLogo = () => (showLogo.value = false);
</script>

<template>
    <div class="flex items-center">
        <div>
            <!-- <AppLogoIcon class="size-5 fill-current text-white dark:text-black" /> -->
            <img
                v-if="showLogo"
                src="/logo.png"
                alt="Logo"
                class="h-8 w-8"
                @error="hideLogo"
            />
            <div
                v-else
                class="h-8 w-8 rounded bg-[#F53003] dark:bg-[#FF4433]"
                title="Logo"
            />
        </div>
        <div class="ml-1 grid flex-1 text-left text-sm">
            <span class="mb-0.5 truncate leading-tight font-semibold">Welcome</span>
        </div>
    </div>
</template>
