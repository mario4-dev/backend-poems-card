<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { computed } from 'vue';

defineProps<{
  poemCount: number;
}>();

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout>
    <div class="p-6">
      <div class="grid gap-6 md:grid-cols-2">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center">
          <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            ¡Bienvenido de nuevo, {{ user.name }}!
          </h1>
          <p class="mt-2 text-gray-600 dark:text-gray-400">
            Desde aquí puedes gestionar tus poemas.
          </p>
          <div class="mt-6">
            <Button as-child>
              <Link :href="route('poems.index')">Ver mis poemas</Link>
            </Button>
          </div>
        </div>

        <!-- Card para el contador de poemas -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
          <h2 class="text-lg font-medium text-gray-500 dark:text-gray-400">
            Poemas Publicados
          </h2>
          <p class="mt-1 text-4xl font-bold text-gray-900 dark:text-gray-100">
            {{ poemCount }}
          </p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
