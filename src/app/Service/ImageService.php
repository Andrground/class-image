<?php

namespace App\Service;

use Illuminate\Http\Request;
use Image;

class ImageService
{
    /**
     * Cria uma imagem thumbnail
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageCreate(Request $request)
    {
        if($request->hasFile('img')) {
            //get filename with extension
            $filenamewithextension = $request->file('img')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('img')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            //Upload File
            $request->file('img')->storeAs('public/img', $filenametostore);
            $request->file('img')->storeAs('public/img/thumbnail', $filenametostore);

            //Resize image here
            $thumbnailpath = public_path('storage/img/thumbnail/' . $filenametostore);

            $img = Image::make($thumbnailpath)->resize(100, null, function($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($thumbnailpath);

            return redirect('images')->with('success', "Image uploaded successfully.");
        }
    }

    public function imageWithBackground(Request $request)
    {
        if ($request->hasFile('img')) {
            //get filename with extension
            $filenamewithextension = $request->file('img')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('img')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            //Upload File
            $request->file('img')->storeAs('public/img', $filenametostore);
            $request->file('img')->storeAs('public/img/canvas', $filenametostore);

            //Resize image here
            $path = public_path('storage/img/canvas/' . $filenametostore);

            $image = Image::make($request->file('img'));

            /* if you want to have a perfect and complete circle using the whole width and height the image
             must be shaped as as square. If your images are not guaranteed to be a square maybe you could
             use Intervention's fit() function */
            $image->fit(300,300);
            $image->save($path);

            return [
                'status' => '00',
                'message' => 'FOI NEGOW!'
            ];
        }
    }

    public function imageCrop(Request $request)
    {
        if($request->hasFile('img')) {
            //get filename with extension
            $filenamewithextension = $request->file('img')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('img')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            //Upload File
            $request->file('img')->storeAs('public/img', $filenametostore);
            $request->file('img')->storeAs('public/img/crop', $filenametostore);

            //Resize image here
            $path = public_path('storage/img/crop/' . $filenametostore);

            $image = Image::make($request->file('img'));
            $image->crop(100, 100, 25, 25);;
            $image->save($path);

            return [
                'status' => '00',
                'message' => 'FOI NEGOW!'
            ];
        }
    }

    public function imageResizeWithBorder(Request $request)
    {
        if ($request->hasFile('img')) {
            //get filename with extension
            $filenamewithextension = $request->file('img')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('img')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            //Upload File
            $request->file('img')->storeAs('public/img', $filenametostore);
            $request->file('img')->storeAs('public/img/circle', $filenametostore);

            //Resize image here
            $path = public_path('storage/img/circle/' . $filenametostore);
            $path2 = public_path('storage/img/circle/' . 'bri'. $filenametostore);

            $image = Image::make($request->file('img'));
            $image->backup();
            $image->brightness(50);
            $image->save($path2);
            $image->reset();

            $image->encode('png');
            $image->resizeCanvas(1280, 720, 'center', false, 'ff00ff');
            $image->save($path);

            return [
                'status' => '00',
                'message' => 'FOI NEGOW!'
            ];
        }
    }
}