<?php

namespace Database\Seeders;

use App\Models\Poem;
use App\Models\User;
use Illuminate\Database\Seeder;

class PoemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un usuario de prueba
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Usuario de Prueba',
                'password' => bcrypt('password'),
            ]
        );

        // Crear poemas de ejemplo
        $poems = [
            [
                'title' => 'Siempre tú',
                'content' => "Siempre fuiste el sonido de las olas que calma mi corazón cuando los vientos de la vida golpean fuerte.\n\nEn cada amanecer, en cada atardecer,\ntu recuerdo me acompaña como una melodía eterna.",
                'author' => 'RapsodAz',
                'color' => '#8B5CF6',
            ],
            [
                'title' => 'Odisea',
                'content' => "No sé cómo llegamos al punto donde necesito de ti para poder sonreír, donde todo lo que pasamos no fue más que un efímero adiós que nunca supimos pronunciar.\n\nLa distancia se convierte en un océano\nque separa dos almas que se buscan.",
                'author' => 'RapsodAz',
                'color' => '#BD92FC',
            ],
            [
                'title' => 'Reflexiones Nocturnas',
                'content' => "En la quietud de la noche, cuando el mundo duerme,\nlas palabras cobran vida en mi mente.\n\nCada verso es un suspiro,\ncada estrofa un latido del corazón.",
                'author' => 'RapsodAz',
                'color' => '#5E5E97',
            ],
            [
                'title' => 'Renacimiento',
                'content' => "Como el ave fénix que renace de sus cenizas,\nmi alma se levanta cada mañana\ncon la esperanza de un nuevo amanecer.\n\nLa vida es un ciclo eterno\nde muerte y renacimiento.",
                'author' => 'RapsodAz',
                'color' => '#17AD92',
            ],
        ];

        foreach ($poems as $poemData) {
            Poem::create([
                ...$poemData,
                'user_id' => $user->id,
            ]);
        }
    }
}
