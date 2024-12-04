<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Image;
use function PHPUnit\Framework\fileExists;

class CkeditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {


            $key = 'upload';
            $format = getSetting('optimize');
            $i = Image::load($request->file($key)->getRealPath())
                ->optimize()
//                ->sharpen(10)
                //                ->quality(90)
                //                ->nonQueued()
                ->format($format);

            $filename = 'optimized-' . $request->file($key)->getClientOriginalName() . '_' . time() . '.webp';
            if (getSetting('watermark')) {
                $i->watermark(public_path('upload/images/logo.png'),
                    AlignPosition::BottomLeft, 5, 5, Unit::Percent,
                    config('app.media.watermark_size'), Unit::Percent,
                    config('app.media.watermark_size'), Unit::Percent, Fit::Contain,
                    config('app.media.watermark_opacity'));
            }
            $directoryPath = storage_path('app/public/upload');

            if (!file_exists($directoryPath)) {
                if (!mkdir($directoryPath, 0777, true) && !is_dir($directoryPath)) {
                    // Handle error - directory creation failed
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $directoryPath));
                }
            }
            $i->save(storage_path() . '/app/public/upload/'.$filename);

//            $originName = $request->file('upload')->getClientOriginalName();
//            $fileName = pathinfo($originName, PATHINFO_FILENAME);
//            $extension = $request->file('upload')->getClientOriginalExtension();
//            $fileName = $fileName . '_' . time() . '.' . $extension;
//
//            $request->file('upload')->move(public_path('upload/images'), $fileName);


            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url =\Storage::url('upload/' . $filename);

            $msg = __('Image uploaded successfully');
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
