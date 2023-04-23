<?php

namespace App\Http\Controllers;

use App\Models\tblEmployees;
use Illuminate\Http\Request;
use App\Classes\Admin as AdminClass;
use App\Models\tblFiles;
use Illuminate\Support\Facades\Validator;

class GlobalController extends Controller
{
    public function Profile(Request $request,$id)
    {
        $AdminClass = new AdminClass;

        $decrypID = base64_decode($id);

        $personalData = tblEmployees::where(['user_id' => $decrypID])->first();
        
        $imgSrc = $this->fetchImg($decrypID);
        
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
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048' //max file size in KB
        ]);

        $return = ['status' => 0, 'message' => $validator->errors()->all(), 'newImgSrc' => "" ];

        if (!$validator->fails()) {
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

            $newImgSrc = $this->fetchImg($request->id);
            
            $return = ['status' => 1, 'message' => 'Uploaded Successfully', 'newImgSrc' => $newImgSrc ];
        }
    
        return $return;
    }

    public function fetchImg($id)
    {
        $img = tblFiles::where(['user_id' => $id])->first();

        if (!empty($img)) {
            $imgEnc = base64_encode($img->data);
            $imgSrc = "data:image;base64,".$imgEnc;
        }

        $imgSrc = isset($imgSrc) ? $imgSrc:"";

        return $imgSrc;
    }
}
