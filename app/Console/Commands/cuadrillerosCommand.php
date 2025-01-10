<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Assistance;
use App\Models\Cuadrilleros;

class cuadrillerosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cuadrilleros-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {        
        $fecha = Carbon::now();

        $dia = $fecha->format('Y-m-d');       


        $usersFS = Cuadrilleros::with('asistioCuadrillero')->get();
        print($usersFS[0]->exist_fs);

        foreach($usersFS as $usersFS){

            if (isset($usersFS->asistioCuadrillero)){
    
                //print('Existe');
                if ($usersFS->asistioCuadrillero->cuadrillero == 0){
    
                    //print('Actualizó');
                    $updateAssistance = Assistance::query()->where('id_hik', $usersFS->RFC)->where('date', $dia)->update([
                        'cuadrillero' => 1
                    ]);
                }
            }
        }
    }
}
