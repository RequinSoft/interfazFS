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

        $asistencia = Assistance::with('sync_data')->where('exist_fs', 1)->where('sync', 0)->where('date', $dia)->where('id_hik', 'GAGE910223N6A')->get();
        
        $url = 'https://app.fatiguescience.com/readi_api/v1/attendance_times';
        $token = Fsdata::find(1);
        //print($token->access_token);

        foreach($asistencia as $asistencia){
            
            $dateBegin = Carbon::createFromFormat('Y-m-d H:i:s', $asistencia->datetime, 'America/Mexico_City');
            $dateBegin->setTimezone('UTC');

            
            $attibutes = [
                'start_time' => $dateBegin,
                'end_time' => '2024-12-09T23:00:00.000000Z',
                'label' => 'system',
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
                //'type' => 'attendance_time',
                'attributes' => $attibutes,
                'relationships' => $relationships
            ];

            $dataUpload = [
                'data' => $datos
            ];
            
            print(json_encode($dataUpload));
            $uploadAttendance = Http::withToken($token->access_token)->post($url, $dataUpload);
            print($uploadAttendance);
        }

    }
}
