<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\ImagemNoticia;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
