<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\daf;

class dafController extends Controller
{
    public function verDAF(){
        $daf = daf::all();
        return $daf;
    }

}
