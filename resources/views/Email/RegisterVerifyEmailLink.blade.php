<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Verify Email</title>
      <style type="text/css">
         body{
         margin:0;
         padding:0;
         }
         @media (max-width:600px){
         table.main_outter {
         width: 100% !important;
         padding: 0 15px !important;
         }  
         body, table{
           width:100%!important;
         } 
         }
      </style>
   </head>
   <body style="width:600px;margin:auto;background: #ececec;" width="600px">
      <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="600px" id="bodyTable" style="background: #ececec;padding: 20px 0px 40px;">
         <tr>
            <td>
               <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="width:600px;margin:auto; padding:0 15px;">
                  <tr>
                     <td align="center" valign="top" id="templatePreheader" style="padding:28px 15px;background: #fff;">
                        <h1 style="color: #152c3b;">Verify This Email Address</h1>
                        <h4 style="color: #152c3b;">Welcome To Demo Site</h4>
                        <p style="color: #152c3b;">Hello <?php echo $name ?>,</p>
                        <?php if (isset($email)) {
                           ?>
                           <p style="color: #152c3b;">Email: <?php echo $email ?>,</p>
                           <?php
                        }?>
                        <p style="color: #152c3b;">Please click the button below to verify your email address.</p>
                        <table border="0" cellspacing="0" cellpadding="0">
                           <tr>
                              <td  style="background:#fa869b;padding: 12px 28px 12px 28px; border-radius:3px" align="center">{<?php echo $activation_key ?>}</td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <h5 style="margin-bottom:0;">Need Support ?</h5>
                        <p style="margin-top:8px;">Feel free to email us if you have any questions, comments or suggestions. We'll be happy to resolve your issues.</p>
                     </td>
                  </tr>
                  <tr> <td align="center" width="100%" style="color:#656565;font-size:12px;line-height:24px;padding-bottom:30px;padding-top:10px"> <a href="<?php echo url('/') ?>" style="color:#656565;text-decoration:underline" target="_blank">Home</a> &nbsp; | &nbsp; <a href="<?php echo url('term-conditions') ?>" style="color:#656565;text-decoration:underline" target="_blank">Terms & Conditions </a> &nbsp; | &nbsp; <a href="<?php echo url('/privacy-policy') ?>" style="color:#656565;text-decoration:underline" target="_blank" >Privacy Policy</a> &nbsp; | &nbsp; <a href="<?php echo url('contact') ?>" style="color:#656565;text-decoration:underline" target="_blank" >Contact Us</a> <div style="font-family:Helvetica,Arial,sans-serif;word-break:normal" class="m_-7945920018577717712address-link">
 ABN 66643322749</div> <div style="font-family:Helvetica,Arial,sans-serif;word-break:normal">
© 2020-2021 Best of the bunch. All rights reserved
</div> </td> </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>