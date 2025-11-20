<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function privateEvents()
{
    return view('services.private-events');
}

public function catering()
{
    return view('services.catering');
}

public function vipPackages()
{
    return view('services.vip-packages');
}

public function corporateEvents()
{
    return view('services.corporate-events');
}

}
