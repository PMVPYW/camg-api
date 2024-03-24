<?php

namespace App\Http\Controllers;

use App\Models\ImagemNoticia;
use Illuminate\Http\Request;

class ImagemNoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ImagemNoticia::all();
    }


}
