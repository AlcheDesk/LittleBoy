<?php

namespace App\Listeners;

use App\Events\ImageWasCropped;
use App\Events\ImageWasDeleted;
use App\Events\ImageWasResized;
use App\Mappers\ATM\UserContentsMapper;
use Illuminate\Support\Facades\Log;
use UniSharp\LaravelFilemanager\Events\ImageWasRenamed;
use UniSharp\LaravelFilemanager\Events\ImageWasUploaded;

class FileUploadListener
{
    private $baseService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseUserContent = new UserContentsMapper();
    }

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        $method = 'on'.class_basename($event);
        if (method_exists($this, $method)) {
            call_user_func([$this, $method], $event);
        }
    }

    function check_textdoc_mime( $filepath ) {
        $textTypes = array("text/html","text/csv","text/plain","application/pdf","text/*",
            "application/vnd.openxmlformats-officedocument.presentationml.presentation",
            "application/vnd.ms-powerpoint","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.wordprocessingml.document");

        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        $mtype = finfo_file( $finfo, $filepath );
        finfo_close( $finfo );
        Log::info("===txt==type".$mtype);
        if(in_array($mtype,$textTypes)){
            return true;
        } else{
            return false;
        }
    }

    function check_image_mime($filepath){
        $imageTypes = array("image/png","image/jpeg","image/gif","image/apng","image/x-icon",
            "image/svg+xml","image/tiff","image/webp","image/psd","image/bmp");

        $imageInfo = getimagesize($filepath);
        if (in_array($imageInfo['mime'],$imageTypes)){
            return true;
        } else{
            return false;
        }
    }

    function check_audio_mine($filepath){
        $audioTypes = array('audio/mpeg', 'audio/x-mpeg', 'audio/mpeg3', 'audio/x-mpeg-3', 'audio/aiff',
            'audio/mid', 'audio/x-aiff', 'audio/x-mpequrl','audio/midi', 'audio/x-mid',
            'audio/x-midi','audio/wav','audio/x-wav','audio/xm','audio/x-aac','audio/basic',
            'audio/flac','audio/mp4','audio/x-matroska','audio/ogg','audio/s3m','audio/x-ms-wax',
            'audio/xm');
        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        $mtype = finfo_file( $finfo, $filepath );
        finfo_close( $finfo );
        if (in_array($mtype,$audioTypes)){
            return true;
        } else{
            return false;
        }
    }

    function check_video_mine($filepath){
        $videoTypes = array("video/webm","video/ogg","application/ogg","video/x-flv","video/mp4",
            "video/x-msvideo","video/x-ms-wmv","application/x-mpegURL","video/MP2T","video/3gpp","video/quicktime");
        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        $mtype = finfo_file( $finfo, $filepath );
        finfo_close( $finfo );
        if (in_array($mtype,$videoTypes)){
            return true;
        } else{
            return false;
        }
    }

    function check_android_appfile($filepath){
        $extension = pathinfo($filepath,PATHINFO_EXTENSION);
        if (strcmp($extension,'.apk')==0){
            return true;
        } else{
            return false;
        }
    }

    function check_empty_file($filepath){
        $emptyTypes = array("inode/x-empty");
        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        $mtype = finfo_file( $finfo, $filepath );
        finfo_close( $finfo );
        if(in_array($mtype,$emptyTypes)){
            return true;
        } else{
            return false;
        }
    }

    function check_archive_file($filepath){
        $archiveTypes = array("application/zip","application/x-tar","application/x-compressed",
            "application/x-zip-compressed","multipart/x-zip",
            "application/x-gzip","application/octet-stream");
        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        $mtype = finfo_file( $finfo, $filepath );
        finfo_close( $finfo );
        if(in_array($mtype,$archiveTypes)){
            return true;
        } else{
            return false;
        }
    }

    function check_type($path){
        if ( $this->check_textdoc_mime($path) ) {
            $type = 'Text';
        } else if ($this->check_image_mime($path)){
            $type = 'Image';
        } else if($this->check_audio_mine($path)){
            $type = 'Audio';
        } else if($this->check_video_mine($path)){
            $type = 'Video';
        } else if($this->check_android_appfile($path)){
            $type = 'Android_APK';
        } else if($this->check_empty_file($path)){
            $type = 'Empty';
        } else if($this->check_archive_file($path)){
            $type = 'Archive';
        }else{
            Log::error("file type is not Support,please check!");
        }
        return $type;
    }

    function getId($hashFileValue){
        $userContent1 = $this->baseUserContent->countBySha256([],$hashFileValue);
        $id = json_decode($userContent1)->data[0]->id;
        return $id;
    }

    function insertData($path){
        $hashFileValue = hash_file( 'md5',$path ,false);
        $origin_filename = pathinfo($path,PATHINFO_FILENAME);
        $new_filename = uniqid();
        $type = $this->check_type($path);

        $userContents = [];
        $userContents['sha256'] = $hashFileValue;
        $userContents['originalName'] = $origin_filename;
        $userContents['modifiedName'] = $new_filename;
        $userContents['type'] = $type;
        $userContents['path'] = $path;
        $insertData = json_encode([$userContents]);

        return $insertData;
    }

    public function onImageWasUploaded(ImageWasUploaded $event)
    {
        try{
            $path = $event->path();
            Log::info("==upload==path===".$path);
            //should /var/www/html/storage/app/public/files/meowlomo/web/001.png
            //$path = 'D:/php/laragon/www/littleboy/storage/app/public/files/meowlomo/t.png';
            $insertData = $this->insertData($path);
            Log::info("====upload data=======".$insertData);
            $this->baseUserContent->insert($insertData,false);
        }
        catch (\Exception $e){
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function onImageWasCropped(ImageWasCropped $event)
    {
        try{
            $Path = $event->path();
            $cropPath = $event->crop_path();//裁剪并复制，此为新文件路径
            $hashFileValueOrigin = $event->hashFileValueOrigin();//裁剪之前的文件hash
            //裁剪前后的路径相同，即没有生成新的文件，可修改即可；反之，需要生成新的记录
            if (strcmp($Path,$cropPath)==0){
                $hashFileValueNew = hash_file( 'md5',$Path ,false);
                $id = $this->getId($hashFileValueOrigin);

                $userContents = [];
                $userContents['id'] = $id;
                $userContents['sha256'] = $hashFileValueNew;
                $str = json_encode([$userContents]);
                Log::info("===Crop data==update=====".$str);

                $this->baseUserContent->update($str);
            } else{
                $insertData = $this->insertData($cropPath);
                Log::info("===Crop data==insert=====".$insertData);
                $this->baseUserContent->insert($insertData,false);
            }
        }
        catch (\Exception $e){
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function onImageWasDeleted(ImageWasDeleted $event)
    {
        try{
            $path = $event->path();
            $hashFileValue = $event ->hashFileValue();
            $id = $this->getId($hashFileValue);
            Log::info("====Deleted path==".$path."====id==".$id);
            $this->baseUserContent->deleteById($id);
        }
        catch (\Exception $e){
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function onImageWasRenamed(ImageWasRenamed $event)
    {
        try{
//             $oldPath = $event->oldPath();
            $newPath = $event->newPath();
            $hashFileValue = hash_file( 'md5', $newPath, false);
            $origin_filename = pathinfo($newPath,PATHINFO_FILENAME);
            $id = $this->getId($hashFileValue);

            $userContents = [];
            $userContents['originalName'] = $origin_filename;
            $userContents['path'] = $newPath;
            $userContents['id'] = $id;
            $str = json_encode([$userContents]);
            Log::info("====Renamed data=======".$str);

            $this->baseUserContent->update($str);
        }
        catch (\Exception $e){
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function onImageWasResized(ImageWasResized $event)
    {
        try{
            $Path = $event->path();
            $hashFileValueOld = $event->hashFileValue();
            $hashFileValue = hash_file( 'md5',$Path ,false);
            $id = $this->getId($hashFileValueOld);

            $userContents = [];
            $userContents['id'] = $id;
            $userContents['sha256'] = $hashFileValue;
            $str = json_encode([$userContents]);
            Log::info("==update=resize=data=======".$str);

            $this->baseUserContent->update($str);
        }
        catch (\Exception $e){
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
