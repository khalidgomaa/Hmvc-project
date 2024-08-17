<?php

namespace Modules\Employee\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Employee\App\Models\TempImage;

class TempImageController extends Controller
{
    public function create(Request $request){
        $image = $request->image;
        if(!empty($image)){
            $ext = $image->getClientOriginalExtension();
            $newName = time() . '.' . $ext;

            // Save the original image
            $image->move(public_path('temp_images'), $newName);

    
            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            return response()->json([
                'status' => true,
                'image_id'=> $tempImage->id ,
                'message' => 'Image uploaded successfully', 
                'filename' => $newName,
                'image-path' => asset('/temp_images/'.$newName),
              
            ]);
        }
         
        return response()->json([
            'status' => false, 
            'message' => 'No image file found in the request']);
   }
}
