<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Folklore\Image\Facades\Image;
use Illuminate\Support\Facades\File;

trait ImageUploadTraits {

    /**
     *@param type $file
     * @return string
     */
    private function _uploadPic($file, $profile) {
        $userPic = $file;
        if ($profile == "profile") {
            $profileDirectory = env('PROFILE_PIC_DIR');
        } else if($profile == "cover"){
            $profileDirectory = env('UPLOADS_COVER_DIRECTORY');
        }else if($profile == "interest"){
            $profileDirectory = env('UPLOADS_INTEREST_DIRECTORY');
        }else if($profile == "creation"){
            $profileDirectory = env('UPLOADS_CREATION_DIRECTORY');
        }else if($profile == "temp"){
            $profileDirectory = env('TEMP_DIR');
        }

        $destinationPath = sprintf($profileDirectory);
        $ext = $userPic->getClientOriginalExtension();
        $userPicName = md5(Carbon::now()).rand(1111, 9999).'.'.$ext;
        $move = $userPic->move($destinationPath, $userPicName);
        if($profile != "temp") {
            $this->_createThumb($destinationPath, $userPicName, $profile);
        }
        if(!$move){
            return "error";
        }else{
            return $userPicName;
        }
    }

    /**
     *
     * @param type $directory
     * @param type $file
     */
    private function _createThumb($directory, $file, $profile) {
        $fileLocation = $directory . "/" . $file;
        if($profile == "creation" || $profile == "profile" ||$profile == "cover"){
            $fileThumbLocation = $directory . "/thumb/" . $file;
            $thumbDirectory = $directory . '/thumb';
        }else{
            $fileThumbLocation = $directory . "/" . env('UPLOAD_THUMB_DIRECTORY') . "/" . $file;
            $thumbDirectory = $directory . '/' . env('UPLOAD_THUMB_DIRECTORY');
        }
        if (!file_exists($thumbDirectory)) {
            File::makeDirectory($thumbDirectory, $mode = 0777, true, true);
        }

        $thumbnail = Image::open($fileLocation)
            ->thumbnail(new \Imagine\Image\Box(300,300));

        $thumbnail->save($fileThumbLocation);
    }
}