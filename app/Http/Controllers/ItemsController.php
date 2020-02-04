<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Validator;

class ItemsController extends Controller
{

    public function index()
    {
        $items = Item::all();
        return response()->json($items);
    }

    public function create() //NAO USO PQ SÓ ESTOU FAZENDO O BACKEND
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required'
        ]);

        if($validator->fails()){
            $response = array('response' => $validator->messages(), 'success' => false);
            return $response;

        } else {
            //Create item
            $item = new Item;
            $item->text = $request->input('text');
            $item->body = $request->input('body');
            $item->save();

            return response()->json($item);
        }
    }

    public function show($id)
    {
        $item = Item::find($id);
        return response()->json($item);
    }

    public function edit($id) //NAO USO PQ SÓ ESTOU FAZENDO O BACKEND
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required'
        ]);

        if($validator->fails()){
            $response = array('response' => $validator->messages(), 'success' => false);
            return $response;

        } else {
            //find an item
            $item = Item::find($id);
            $item->text = $request->input('text');
            $item->body = $request->input('body');
            $item->save();

            return response()->json($item);
        }
    }

    public function destroy($id)
    {
        //Find an item
        $item = Item::find($id);
        $item->delete();

        $response = array('response' => 'Item deleted', 'success' => true);
        return $response;
    }
}
