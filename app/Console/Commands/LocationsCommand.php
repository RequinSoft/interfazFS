<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Fsdata;
use App\Models\Locations;

class LocationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:locations-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copiar Locations desde FS';

    /**
     * Execute the console command.
     */
    public function handle()
    {        
        $url = 'https://app.fatiguescience.com/readi_api/v1/locations';
        $token = Fsdata::find(1);
        $locationsOnFS = [];

        $queryLocations = Http::withToken($token->access_token)->get($url);
        $responseLocations = $queryLocations['data'];
        
        foreach($responseLocations as $locations){
            //print($locations['attributes']['name']);

            //Guardamos los ids de los Locations en FS en el array LocationsOnFS
            $locationsOnFS[] = $locations['id'];
            $validarExistencia = Locations::query()->where('id_fs', $locations['id'])->count();

            if($validarExistencia == 0){
                $locations = Locations::create([
                    'id_fs' => $locations['id'],
                    'name' => $locations['attributes']['name']
                ]);

                //print('Se crea nuevo grupo '.$locations['attributes']['name']);
            }else{
                $locationOnDB = Locations::query()->where('id_fs', $locations['id'])->get();

                if($locations['attributes']['name'] != $locationOnDB[0]->name){
                    
                    $locations = Locations::query()->where('id_fs', $locations['id'])->update([
                        'id_fs' => $locations['id'],
                        'name' => $locations['attributes']['name']
                    ]);

                }

            }

            
        }

        $locationsOnDB = Locations::query()->where('id_fs', '<>', 3226)->orderBy('name', 'asc')->get()->pluck('id_fs', 'name')->toArray();

        foreach($locationsOnDB as $onDB){
            //print('Borrar '.$onDB.'     ');
            if(!in_array($onDB, $locationsOnFS)){

                $getIdLocation = Locations::query()->where('id_fs', $onDB)->get();
                //print($getIdLocation[0]->id);
                
                $locations = Locations::find($getIdLocation[0]->id)->delete();
                //print('Borrar '.$onDB);
            }
        }
    }
}
