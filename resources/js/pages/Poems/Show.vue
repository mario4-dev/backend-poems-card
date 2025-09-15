<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { route } from 'ziggy-js';

interface Poem {
  id: number;
  title: string;
  content: string;
  author: string;
  color: string;
  created_at: string;
  updated_at: string;
}

const props = defineProps<{
  poem: Poem;
}>();
</script>

<template>
  <AppLayout>
    <Head title="Ver Poema" />
    
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center mb-6">
              <Heading :title="poem.title" />
              <div class="flex space-x-2">
                <Link 
                  :href="route('poems.edit', poem.id)"
                  class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
                >
                  Editar
                </Link>
                <Link 
                  :href="route('poems.index')"
                  class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition"
                >
                  Volver
                </Link>
              </div>
            </div>

            <div class="space-y-6">
              <!-- Información del poema -->
              <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Autor</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ poem.author }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Color</label>
                    <div class="flex items-center mt-1">
                      <div class="h-4 w-4 rounded-full mr-2" :style="{ backgroundColor: poem.color }"></div>
                      <span class="text-sm text-gray-900 dark:text-white">{{ poem.color }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Contenido del poema -->
              <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg p-6">
                <div 
                  class="text-lg leading-relaxed whitespace-pre-wrap"
                  :style="{ color: poem.color }"
                >
                  {{ poem.content }}
                </div>
              </div>

              <!-- Metadatos -->
              <div class="text-sm text-gray-500 dark:text-gray-400">
                <p>Creado: {{ new Date(poem.created_at).toLocaleDateString('es-ES', { 
                  year: 'numeric', 
                  month: 'long', 
                  day: 'numeric',
                  hour: '2-digit',
                  minute: '2-digit'
                }) }}</p>
                <p v-if="poem.updated_at !== poem.created_at">
                  Actualizado: {{ new Date(poem.updated_at).toLocaleDateString('es-ES', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                  }) }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
