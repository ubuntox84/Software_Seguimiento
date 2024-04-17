<?php

namespace App\Http\Controllers;

use Dcblogdev\MsGraph\Facades\MsGraph;
use Illuminate\Http\Request;

class PagesController extends Controller
{
   public function app(){
  return view('dashboard'); 

   } 
}
