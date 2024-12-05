<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Fsdata;
use App\Models\Locations;
use App\Models\Personal;

class UsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:users-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copiar usuarios desde FS';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usersFS = [];
        $url = 'https://app.fatiguescience.com/readi_api/v1/';
        $token = Fsdata::find(1);
        $responseLocations = Locations::query()->where('id_fs', '<>', 3226)->orderBy('name', 'asc')->get()->pluck('id_fs')->toArray();

        foreach($responseLocations as $locations){
            //print($locations->id_fs);
            $queryUsers = Http::withToken($token->access_token)->get($url.'users?location_id='.$locations);
            $responseUsers = $queryUsers['data'];
            $usersFS [] = $responseUsers;
        }
        //print(sizeOf($usersFS).' ');
        
        foreach($usersFS as $usersFS){

            //print(sizeOf($usersFS).'- ');
            foreach($usersFS as $users){
                
                //print_r($users['id'].'-');
                //print_r($users['attributes']['first_name'].' ');

                $saveUsers = Personal::updateOrCreate(
                    ['id_fs' => $users['id']],
                    [
                        'id_fs' => $users['id'],
                        'name' => $users['attributes']['first_name'].' '.$users['attributes']['last_name'],
                        'identifier' => $users['attributes']['identifier'],
                        'email' => $users['attributes']['email']
                    ]
                );

            }            
        }
    }
}
