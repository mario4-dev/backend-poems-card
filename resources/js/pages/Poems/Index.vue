<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { route } from 'ziggy-js';

interface Poem {
  id: number;
  title: string;
  author: string;
  color: string;
}

const poems = ref<Poem[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

const fetchPoems = async () => {
  try {
    loading.value = true;
    const response = await fetch('/api/poems');
    if (!response.ok) {
      throw new Error('Error al cargar los poemas');
    }
    poems.value = (await response.json()) as Poem[];
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Error desconocido al cargar los poemas';
  } finally {
    loading.value = false;
  }
};

const deletePoem = async (id: number) => {
  if (!confirm('¿Estás seguro de que deseas eliminar este poema?')) {
    return;
  }
  
  try {
    const csrf = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement | null)?.getAttribute('content') ?? '';
    const response = await fetch(`/api/poems/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf,
      } as Record<string, string>,
    
    });
    
    if (!response.ok) {
      throw new Error('Error al eliminar el poema');
    }
    
    // Actualizar la lista de poemas
    poems.value = poems.value.filter((poem) => poem.id !== id);
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Error desconocido al eliminar el poema';
  }
};

onMounted(() => {
  fetchPoems();
});
</script>

<template>
  <AppLayout>
    <Head title="Administrar Poemas" />
    
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center mb-6">
              <Heading title="Administrar Poemas" />
              <Link 
                :href="route('poems.create')"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
              >
                Crear Nuevo Poema
              </Link>
            </div>
            
            <div v-if="loading" class="text-center py-4">
              <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto"></div>
              <p class="mt-2 text-gray-600 dark:text-gray-400">Cargando poemas...</p>
            </div>
            
            <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
              <strong class="font-bold">Error:</strong>
              <span class="block sm:inline">{{ error }}</span>
            </div>
            
            <div v-else-if="poems.length === 0" class="text-center py-4">
              <p class="text-gray-600 dark:text-gray-400">No hay poemas disponibles. ¡Crea uno nuevo!</p>
            </div>
            
            <div v-else class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Título</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Autor</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Color</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                  <tr v-for="poem in poems" :key="poem.id">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ poem.id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ poem.title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ poem.author }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="h-4 w-4 rounded-full mr-2" :style="{ backgroundColor: poem.color }"></div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ poem.color }}</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <div class="flex space-x-2">
                        <Link 
                          :href="route('poems.edit', poem.id)"
                          class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                        >
                          Editar
                        </Link>
                        <button 
                          @click="deletePoem(poem.id)"
                          class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                        >
                          Eliminar
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>