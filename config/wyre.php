<?php

return [
    'key' => env('WYRE_KEY','AK-JU9977VD-LN8HRRGA-HPJ6PY8C-ZD2NXEJQ'),
    'secret' => env('WYRE_SECRET','SK-TZLE3JYG-WWDFWFAD-HTLEVHCU-JJYLUVHX'),
    //TODO Test url
    //'url' => env('WYRE_URL','https://api.testwyre.com'),
    'auth-url' => 'https://api.sendwyre.com/',
    'url' => 'https://pay.sendwyre.com/',
    'accountId' => env('WYRE_ACCOUT_ID','AC_QHH6HTQLQY6'),
];
