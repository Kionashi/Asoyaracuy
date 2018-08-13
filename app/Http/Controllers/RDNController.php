<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RDNController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function view($view = null, $data = [], $mergeData = [])
    {
        return view($view, $data, $mergeData)
        ->with('breadcrumbs', $this->breadcrumbs)
        ->with('subtitle', $this->subtitle)
        ->with('title', $this->title)
        ;
    }
}
