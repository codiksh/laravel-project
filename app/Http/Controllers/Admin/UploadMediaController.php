<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadMediaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UploadMediaController extends Controller
{
    /**
     * Upload file using dropzone
     *
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function uploadMedia(UploadMediaRequest $request)
    {
        $user = Auth::User();
        if($request->hasFile('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $media = $user->addMedia($request->file('file'))
                ->toMediaCollection('temp-uploads');

            return Response::json([
                'message' => 'File has been successfully uploaded!',
                'uploaded_media_id' => $media->uuid,
                'fileName' => $fileName,
                'media_id' => $media->id
            ]);
        }
        return true;
    }

    /**
     * remove uploaded file using dropzone
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function removeMedia(Request $request){
        if($request->mediaUuid){
            Media::where('uuid', $request->mediaUuid)->delete();
            return Response::json([
                'message' => 'File has been successfully removed!',
                'status' => true
            ]);
        }
        return false;
    }
}
