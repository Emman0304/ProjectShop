<?php

namespace App\Http\Controllers;

use App\Models\tblEmployees;
use Illuminate\Http\Request;
use App\Classes\Admin as AdminClass;
use App\Models\tblFiles;
use Illuminate\Support\Facades\Validator;

class GlobalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Profile(Request $request,$id)
    {
        $AdminClass = new AdminClass;

        $decrypID = base64_decode($id);

        $personalData = tblEmployees::where(['user_id' => $decrypID])->first();
        
        $imgSrc = $this->fetchImg($decrypID);

        $data=[
            'data' => $personalData,
            'position' => $AdminClass->PostDesc($personalData->Position),
            'EmpfileActive' => 'active',
            'listActive' => 'active',
            'menu' => 'menu-open',
            'id' => $decrypID,
            'imgData' => isset($imgSrc) ? $imgSrc:"",
        ];

        return view('components.profile',$data);
    }

    public function uploadImage(Request $request)
    {
        if ($request->file != "undefined") {

            $validator = Validator::make($request->all(), [
                'file' => 'required|image'
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
        }else{
            $return = ['status' => 0, 'message' => 'No File Selected', 'newImgSrc' => "" ];
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
