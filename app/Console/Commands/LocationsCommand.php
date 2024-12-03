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
        $user = Auth::user();
        $fecha = Carbon::now();
        $hora = $fecha->format('H:i:s');
        $url = 'https://app.fatiguescience.com/readi_api/v1/';
        $token = Fsdata::find(1);

        $queryLocations = Http::withToken($token->access_token)->get($url.'locations');
        $responseLocations = $queryLocations['data'];
        
        foreach($responseLocations as $locations){
            //print($locations['id']);
            $locations = Locations::updateOrCreate([
                'id_fs' => $locations['id'],
                'name' => $locations['attributes']['name']
            ]);
        }
    }
}
