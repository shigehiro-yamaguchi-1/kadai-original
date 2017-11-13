<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function counts($item) {
        $count_high_rates = $item->high_rate_users()->count();
        $count_low_rates = $item->low_rate_users()->count();
        
        return [
            'count_high_rates' => $count_high_rates,
            'count_low_rates' => $count_low_rates,
        ];
    }
}
