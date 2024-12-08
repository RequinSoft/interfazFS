<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Assistance;
use App\Models\Personal;
use App\Models\Fsdata;

class uploaddatafsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:uploaddatafs-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subir la asistencia a FS';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fecha = Carbon::now();
        $dia = $fecha->format('Y-m-d');
        $dataUpload = [];
        $datos = [];

        $asistencia = Assistance::with('sync_data')->where('exist_fs', 1)->where('sync', 0)->where('date', $dia)->get();
        
        $url = 'https://app.fatiguescience.com/readi_api/v1/attendance_times';
        $token = Fsdata::find(1);
        print($token->access_token);

        foreach($asistencia as $asistencia){
            
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $asistencia->datetime, 'America/Mexico_City');
            $date->setTimezone('UTC');

            $attibutes = [
                'start_time' => $date,
                'end_time' => '',
            ];

            $id = [
                'id' => $asistencia->sync_data->id_fs,
            ];

            $data = [
                'data' => $id
            ];

            $relationships = [
                'user' => $data
            ];

            $datos = [
                'attributes' => $attibutes,
                'relationships' => $relationships
            ];

            $dataUpload = [
                'data' => $datos
            ];
            //print(json_encode($dataUpload));
        }

        //print(json_encode($dataUpload));
        $uploadAttendance = Http::withToken($token->access_token)->post($url, $dataUpload);
        print($uploadAttendance);
    }
}
