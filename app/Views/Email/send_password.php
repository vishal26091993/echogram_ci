<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Trade Logic</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style type="text/css">
    body{ font-family: Arial, sans-serif; font-size: 16px; line-height: 26px; }
    p{ margin: 0; }
  </style>
</head>
<body style="margin: 0; padding: 0;">
     <table align="" border="0" cellpadding="0" cellspacing="0" width="650" style="margin:0 auto;background-color:#f6f6f6;">
     <tr style="background: linear-gradient(to bottom, #fcbd9b, #ffbc98);">
      <td align="left">
        <a href="#" style="display:block;padding-top: 10px;padding-bottom: 10px;">
            <img src="<?= ASSET_URL; ?>assets/images/circle_logo.png" alt="Trade Logic" style="padding-left: 20px;height: 50px;">
        </a>
      </td>
     </tr>
     <tr>
        <td bgcolor="#f6f6f6" style="padding: 40px 30px 40px 30px;" colspan="2">
             <table border="0" cellpadding="0" cellspacing="0" width="100%">
              
                  <tr>
                    <td>
                      <p style="font-size: 16px;"><strong>Hello, <?php echo $data['name']; ?></strong></p>
                    </td>
                  </tr>                  
                  <tr>                    
                    <td style="padding: 20px 0 30px 0;">                        
                        <p>Your Technician Account Details , </p><br>
                        <p> <b>Username : </b> <?php echo $data['email']; ?></p>
                        <p> <b>Password : </b> <?php echo $data['password_decode']; ?></p>
                       
                    </td>
                 </tr>
             
                 <tr>
                    <td><strong>Regards,</strong><br>Trade Logic.</td> 
                 </tr>
                             
             </table>
        </td>
     </tr>
     <tr>
        <td bgcolor="#ffbc98" style="padding: 15px 0 15px 0;" valign="middle" colspan="2">
          <table border="0" cellpadding="0" cellspacing="0" width="100%" align="left">
            <tr>
              <td align="left" width="25%" style="padding-left: 20px;">
                <a href="#" style="color: #fff;font-size: 13px;font-weight:bold;  text-decoration: none;">Copyright &copy;<?php echo date("Y"); ?>  Trade Logic. All Rights Reserved.</a>
              </td>
            </tr>
          </table>
        </td>
     </tr>     
  </table>
</body>
</html>