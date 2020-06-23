<?php

namespace App\Http\Controllers;

class AssignmentController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function index()
    {
    	$X = array(3, 5, 12, 9, 5); 
	
		$Y = array(4, 11, 8, 5, 6); 
	 	  
		$n = sizeof($X);

		$result = ['result parameter :' => $this->shoelaceFormula($X, $Y, $n)];
		
		return response()->json($result);  
    }

    public function shoelaceFormula($X, $Y, $n) 
	{ 
	    $a = 0.0; 
	
	  	$j = $n - 1; 
	    
	    for ($i = 0; $i < $n; $i++) 
	    { 
            $a += ($X[$j] + $X[$i]) *  
             	  ($Y[$j] - $Y[$i]);      
	        $j = $i;  
	    } 
	    return abs($a / 2.0); 
	} 
}