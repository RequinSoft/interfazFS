<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Schedule::command('app:locations-command')->daily();
Schedule::command('app:users-command')->daily();
//Schedule::command('app:asistencia-command')->EveryFiveMinutes();
//Schedule::command('app:asistencia-hik-fs-command')->EveryTenMinutes();
//Schedule::command('app:uploaddatafs-command')->EveryTenMinutes()->between('5:00', '10:00');
//Schedule::command('app:uploaddatafs-command')->EveryTenMinutes()->between('17:00', '22:00');