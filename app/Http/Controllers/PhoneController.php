<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phone;
use App\Models\Contacts;
use Illuminate\Support\Arr;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataPhone = Phone::all();
        foreach($dataPhone as $data){
            Arr::set($data, 'person', Contacts::where('IdContacto', $data->IdContacto)->get());
        }
        return $dataPhone;
    }
}
