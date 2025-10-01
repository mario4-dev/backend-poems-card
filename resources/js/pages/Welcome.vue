<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

interface LoginForm {
  email: string;
  password: string;
  remember: boolean;
}

const form = useForm<LoginForm>({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  });
};

// Mostrar logo si existe el archivo (fallback a un placeholder si falla)
const showLogo = ref(true);
const hideLogo = () => (showLogo.value = false);
</script>

<template>
  <div>
    <Head title="Welcome">
      <link rel="preconnect" href="https://rsms.me/" />
      <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div
      class="min-h-screen bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a] flex items-center justify-center"
    >
      <main class="w-full max-w-md">
        <div
          class="w-full rounded-lg bg-white p-8 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
        >
          <!-- Logo -->
          <div class="mb-6 flex flex-col items-center text-center">
            <div
              class="mb-3 flex h-12 w-12 items-center justify-center rounded-md bg-[#fff2f2] dark:bg-[#1D0002]"
            >
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
            <h1 class="text-lg font-medium">Bienvenido</h1>
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
              Ingresa con tu cuenta
            </p>
          </div>

          <!-- Ya autenticado -->
          <div v-if="$page.props.auth?.user" class="space-y-4 text-center">
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
              Ya estás autenticado
              <span v-if="$page.props.auth.user.name">
                como {{ $page.props.auth.user.name }}
              </span>.
            </p>
            <Link
              href="/dashboard"
              class="inline-flex w-full items-center justify-center rounded-sm border border-black bg-[#1b1b18] px-5 py-2 text-sm font-medium text-white hover:border-black hover:bg-black dark:border-[#eeeeec] dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white"
            >
              Ir al Dashboard
            </Link>
          </div>

          <!-- Formulario de acceso (2 inputs) -->
          <form v-else @submit.prevent="submit" class="space-y-4" novalidate>
            <div>
            <label class="mb-1 block text-sm">Correo electrónico</label>
            <input
              v-model="form.email"
              type="email"
              autocomplete="email"
              required
              class="w-full rounded-md border border-[#e3e3e0] bg-[#FDFDFC] px-3 py-2 text-[13px] outline-none ring-0 placeholder:text-[#9a9a95] focus:border-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] dark:placeholder:text-[#77756f] dark:focus:border-[#FF4433]"
              placeholder="tucorreo@ejemplo.com"
            />
            <p v-if="form.errors.email" class="mt-1 text-xs text-red-600">
              {{ form.errors.email }}
            </p>
          </div>

          <div>
            <label class="mb-1 block text-sm">Contraseña</label>
            <input
              v-model="form.password"
              type="password"
              autocomplete="current-password"
              required
              class="w-full rounded-md border border-[#e3e3e0] bg-[#FDFDFC] px-3 py-2 text-[13px] outline-none ring-0 placeholder:text-[#9a9a95] focus:border-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] dark:placeholder:text-[#77756f] dark:focus:border-[#FF4433]"
              placeholder="••••••••"
            />
            <p v-if="form.errors.password" class="mt-1 text-xs text-red-600">
              {{ form.errors.password }}
            </p>
          </div>

          <div class="flex items-center justify-between text-sm">
            <!-- <label class="inline-flex items-center gap-2">
              <input
                v-model="form.remember"
                type="checkbox"
                class="h-4 w-4 rounded border-[#e3e3e0] text-[#f53003] focus:ring-[#f53003] dark:border-[#3E3E3A] dark:text-[#FF4433]"
              />
              <span>Recordarme</span>
            </label> -->

            <!-- Enlace auxiliar opcional -->
            <!-- <Link
              href="/login"
              class="text-[#f53003] underline underline-offset-4 dark:text-[#FF4433]"
            >
              ¿Problemas para entrar?
            </Link> -->
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="mt-1 inline-flex w-full items-center justify-center rounded-sm border border-black bg-[#1b1b18] px-5 py-2 text-sm font-medium text-white hover:border-black hover:bg-black disabled:opacity-60 dark:border-[#eeeeec] dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white"
          >
            Entrar
          </button>
        </form>
      </div>
    </main>
  </div>
   </div>
</template>
