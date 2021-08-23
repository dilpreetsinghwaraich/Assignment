<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function SendEmail($emailTo = '', $emailSubject = '', $emailBody = '')
    {  
        $whitelist = array(
            '127.0.0.1',
            '::1',
            'localhost'
        );

        if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
            return;
        }

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: Infiway <noreply@infiway.ae>' . "\r\n";
        //$emailBody=CleanHtml($emailBody);
        return mail($emailTo,$emailSubject,$emailBody,$headers);
        return false;
    }
    public function fileuploadExtra($request, $key){
        $file = $request->file($key);
        $destinationPath = 'uploads/'.date('Y').'/'.date('M');
        $filename = time().'-'.str_replace(' ','-',$file->getClientOriginalName());
        $upload_success = $file->move($destinationPath, $filename);
        $uploaded_file = 'uploads/'.date('Y').'/'.date('M').'/'.$filename;            
        return $uploaded_file;
    }
}
