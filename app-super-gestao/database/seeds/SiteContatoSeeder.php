<?php

use App\SiteContato;
use Illuminate\Database\Seeder;

class SiteContatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $contato = new SiteContato();
        // $contato->nome = 'Satoru Gojo';
        // $contato->telefone = '(11) 1111-1111';
        // $contato->email = 'omaisforte@jjk.com';
        // $contato->motivo_contato = '1';
        // $contato->mensagem = 'Está tudo bem, eu sou o mais forte.';
        // $contato->save();

        factory(SiteContato::class, 100)->create();
    }
}
