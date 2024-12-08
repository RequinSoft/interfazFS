<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Assistance;
use App\Models\Personal;

class AsistenciaHikFsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:asistencia-hik-fs-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar que los usuarios en FS asistieron a la Unidad de Negocio';

    /**
     * Execute the console command.
     */
    public function handle()
    {        
        $fecha = Carbon::now();
        $dia = $fecha->format('Y-m-d');

        $usersFS = Personal::with('exist_fs')->get();
        //print($usersFS[0]->exist_fs);

        foreach($usersFS as $usersFS){

            if (isset($usersFS->exist_fs)){
    
                //print('Existe');
                if ($usersFS->exist_fs->exist_fs == 0){
    
                    //print('Actualizó');
                    $updateAssistance = Assistance::query()->where('id_hik', $usersFS->identifier)->where('date', $dia)->update([
                        'exist_fs' => 1
                    ]);
                }
            }
        }

    }
}
