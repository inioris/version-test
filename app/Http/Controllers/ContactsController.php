<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;
use App\Models\Addresses;
use App\Models\Phone;
use Illuminate\Support\Arr;


class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {

         if($request->input('name')){
              $dataContactsFilter = Contacts::where('Nombre', 'LIKE', '%'.$request->input('name').'%')->get();
              foreach($dataContactsFilter as $data){
                 Arr::set($data, 'phone', Phone::where('IdContacto', $data->IdContacto)->get());
                 Arr::set($data, 'address', Addresses::where('IdContacto', $data->IdContacto)->get());
              }
              return response()->json($dataContactsFilter, 200);
         }
         if($request->input('lastName')){
            $dataContactsFilter = Contacts::where('Apellido', 'LIKE', '%'.$request->input('lastName').'%')->get();
            foreach($dataContactsFilter as $data){
                Arr::set($data, 'phone', Phone::where('IdContacto', $data->IdContacto)->get());
                Arr::set($data, 'address', Addresses::where('IdContacto', $data->IdContacto)->get());
            }
            return response()->json($dataContactsFilter, 200);
         }
         if($request->input('phone')){
            $dataContactsFilter = Phone::where('Telefono', $request->input('phone'))->get();
            foreach($dataContactsFilter as $dataPhone){
                $dataPerson = Contacts::findOrFail($dataPhone->IdContacto);
                Arr::set($dataPhone, 'person', $dataPerson);
            }
            return response()->json($dataContactsFilter, 200);
         }

         $dataContacts = Contacts::all();

         foreach($dataContacts as $data){
           Arr::set($data, 'phone', Phone::where('IdContacto', $data->IdContacto)->get());
           Arr::set($data, 'address', Addresses::where('IdContacto', $data->IdContacto)->get());
         }

        return response()->json($dataContacts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contacts = new Contacts;
        $contacts->Nombre = $request->input('name');
        $contacts->Apellido = $request->input('lastName');
        $contacts->save();

        $idContacts = Contacts::latest('IdContacto')->first();

        if($request->input('address')){
            $addresses = new Addresses;

            if(is_array($request->input('address'))){
                foreach($request->input('address') as $addressValue){
                    $fields = array(
                        'Descripcion' => $addressValue,
                        'IdContacto' => $idContacts->IdContacto,
                    );
                  $addresses::create($fields);
                }
            } else {
                $addresses->Descripcion = $request->input('address');
                $addresses->IdContacto = $idContacts->IdContacto;
                $addresses::save();
            }
        }

        if($request->input('phone')) {
            $phone = new Phone;
            if(is_array($request->input('phone'))){
               foreach($request->input('phone') as $phoneValue) {
                    $fields = array(
                      'Telefono' => $phoneValue,
                      'IdContacto' => $idContacts->IdContacto,
                    );
                    $phone::create($fields);
               }
            }else {
                $phone->Telefono = $request->input('phone');
                $phone->IdContacto = $idContacts->IdContacto;
                $phone->save();
            }
        }

        return response()->json([
            'res' => true,
            'Contacts' => $idContacts,
            'message' => "Contacto Guardado Correctamente",
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Contacts::find($id);
        Arr::set($data, 'phone', Phone::where('IdContacto', $data->IdContacto)->get());
        Arr::set($data, 'address', Addresses::where('IdContacto', $data->IdContacto)->get());
        return $data;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contacts::findOrFail($id);
        $contact->delete();
        return response()->json([
          "Mensaje"=>"Eliminado Correctamente"
        ]);

    }
}
