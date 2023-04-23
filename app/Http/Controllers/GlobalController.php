<?php

namespace App\Http\Controllers;

use App\Models\tblEmployees;
use Illuminate\Http\Request;
use App\Classes\Admin as AdminClass;
use App\Models\tblFiles;

class GlobalController extends Controller
{
    public function Profile(Request $request,$id)
    {
        $AdminClass = new AdminClass;

        $decrypID = base64_decode($id);

        $personalData = tblEmployees::where(['user_id' => $decrypID])->first();
        
        $img = tblFiles::where(['user_id' => $decrypID])->first();

        if (!empty($img)) {
            $imgEnc = base64_encode($img->data);
            $imgSrc = "data:image;base64,".$imgEnc;
        }
        
        $data['data'] = $personalData;
        $data['position'] = $AdminClass->PostDesc($personalData->Position);
        $data['EmpfileActive'] = 'active';
        $data['listActive'] = 'active';
        $data['menu'] = 'menu-open';
        $data['id'] = $decrypID; 
        $data['imgData'] = isset($imgSrc) ? $imgSrc:"";


        return view('components.profile',$data);
    }

    public function uploadImage(Request $request)
    {
        $image = $request->file('file');
        $name = $image->getClientOriginalName();
        $type = $image->getClientMimeType();
        $size = $image->getSize();
        $data = file_get_contents($image);

        tblFiles::getModel()->updateOrCreate([
                        'user_id' => $request->id,
                    ],[
                        'name' => $name,
                        'type' => $type,
                        'size' => $size,
                        'data' => $data,
                    ]);
        
        $return = ['status' => 1, 'message' => 'Uploaded Successfully'];

        return $return;
    }
}
