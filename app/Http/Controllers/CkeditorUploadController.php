<?php

namespace App\Http\Controllers;

use App\Models\imgUpload;
use Illuminate\Http\Request;
use Storage;

class CkeditorUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $image = request()->file('upload');
        if ($image->getMimeType() != 'image/jpeg' && $image->getMimeType() != 'image/png') {
            return "<script>alert('限定上傳JPG/PNG檔案類型,請關閉視窗後重新上傳')</script>";
        }

        $extension = $image->getClientOriginalExtension();
        $fileName = time() . '.' . $extension;
        // $path = $image->store('public/upload/ckeditor');
        $path = $image->move(public_path('upload/ckeditor'), $fileName);
        // $getFileName = explode('ckeditor/',$path);
        // dd($fileName);
        $url = Storage::disk('cke')->url($path);
        $callback = $request->input('CKEditorFuncNum');
        $CKEditor = $request->input('CKEditor');

        $imgUpload = new imgUpload();
        $imgUpload->file_name = $fileName;
        $imgUpload->type = 'ckeditor';
        $imgUpload->save();

        return "<script>alert('上傳成功')</script>";
    }
    public function getImage(){
        $imgUpload = imgUpload::get();
        return response()->json(['imgUpload' => $imgUpload]);
    }
    public function delCKEImg(Request $request){
        $getImgName = explode('ckeditor/',$request->url);
        $getImg = imgUpload::where('file_name',$getImgName[1])->first();
        $file_path = public_path('upload/ckeditor/'.$getImgName[1]);
        if(file_exists($file_path)){
            unlink($file_path);
            $getImg->delete();
            return response()->json([
                'status'=>1,
            ]);
        }else{
            return response()->json([
                'status'=>-99,
            ]);
        }
    }
}
