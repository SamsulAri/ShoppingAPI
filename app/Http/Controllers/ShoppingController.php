<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShoppingController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        return $this->user
        ->shoppings()
        ->get(['name'])
        ->toArray();
    }

    public function show($id)
    {
        $shopping = $this->user->shoppings()->find($id);

        if (!$shopping) {
            return response()->json([
            'success' => false,
            'message' => 'Sorry, shopping with id ' . $id . ' cannot be found'
            ], 400);
        }

        return $shopping;
    }
    public function store(Request $request)
    {
        $this->validate($request, [
        'name' => 'required',
        ]);

        $shopping = new Shopping();
        $shopping->name = $request->name;

        if ($this->user->shoppings()->save($shopping))
            return response()->json([
            'success' => true,
            'shopping' => $shopping
            ]);
        else
            return response()->json([
            'success' => false,
            'message' => 'Sorry, shopping could not be added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $shopping = $this->user->shoppings()->find($id);

        if (!$shopping) {
        return response()->json([
        'success' => false,
        'message' => 'Sorry, shopping with id ' . $id . ' cannot be found'
        ], 400);
        }

        $updated = $shopping->fill($request->all())
        ->save();

        if ($updated) {
            return response()->json([
            'success' => true
            ]);
        } else {
            return response()->json([
            'success' => false,
            'message' => 'Sorry, shopping could not be updated'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $shopping = $this->user->shoppings()->find($id);

        if (!$shopping) {
        return response()->json([
        'success' => false,
        'message' => 'Sorry, shopping with id ' . $id . ' cannot be found'
        ], 400);
        }

        if ($shopping->delete()) {
            return response()->json([
            'success' => true
            ]);
        } else {
            return response()->json([
            'success' => false,
            'message' => 'Shopping could not be deleted'
            ], 500);
        }
    }
}
