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
}