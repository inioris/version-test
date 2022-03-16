<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Addresses;
use App\Models\Contacts;
use Illuminate\Support\Arr;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataAddresses = Addresses::all();
        foreach($dataAddresses as $data){
           Arr::set($data, 'person', Contacts::where('IdContacto', $data->IdContacto)->get());
        }
        return $dataAddresses;
    }
}
