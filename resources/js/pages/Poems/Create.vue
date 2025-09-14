<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { route } from 'ziggy-js';

const form = useForm({
  title: '',
  content: '',
  author: '',
  color: '#3B82F6', // Color azul por defecto
});

const submitting = ref(false);
const error = ref<string | null>(null);

const submit = async () => {
  submitting.value = true;
  error.value = null;
  
  try {
    const csrf = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement | null)?.getAttribute('content') ?? '';
    const response = await fetch('/api/poems', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf,
      } as Record<string, string>,
      body: JSON.stringify(form)
    });
    
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error((errorData && errorData.message) || 'Error al crear el poema');
    }
    
    // Redireccionar a la lista de poemas
    window.location.href = route('poems.index');
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Error desconocido al crear el poema';
  } finally {
    submitting.value = false;
  }
};
</script>

<template>
  <AppLayout>
    <Head title="Crear Poema" />
    
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <Heading title="Crear Nuevo Poema" />
            
            <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
              <strong class="font-bold">Error:</strong>
              <span class="block sm:inline">{{ error }}</span>
            </div>
            
            <form @submit.prevent="submit" class="space-y-6">
              <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
                <input 
                  id="title" 
                  v-model="form.title" 
                  type="text" 
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                  required 
                />
                <InputError :message="form.errors.title" class="mt-2" />
              </div>
              
              <div>
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contenido</label>
                <textarea 
                  id="content" 
                  v-model="form.content" 
                  rows="5" 
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                  required
                ></textarea>
                <InputError :message="form.errors.content" class="mt-2" />
              </div>
              
              <div>
                <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Autor</label>
                <input 
                  id="author" 
                  v-model="form.author" 
                  type="text" 
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                  required 
                />
                <InputError :message="form.errors.author" class="mt-2" />
              </div>
              
              <div>
                <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                <div class="flex items-center mt-1">
                  <input 
                    id="color" 
                    v-model="form.color" 
                    type="color" 
                    class="h-10 w-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                  />
                  <input 
                    v-model="form.color" 
                    type="text" 
                    class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                    required 
                  />
                </div>
                <InputError :message="form.errors.color" class="mt-2" />
              </div>
              
              <div class="flex items-center justify-end mt-4">
                <a 
                  :href="route('poems.index')"
                  class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition mr-2"
                >
                  Cancelar
                </a>
                <button 
                  type="submit" 
                  class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
                  :disabled="submitting"
                >
                  <span v-if="submitting" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Guardando...
                  </span>
                  <span v-else>Guardar Poema</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>