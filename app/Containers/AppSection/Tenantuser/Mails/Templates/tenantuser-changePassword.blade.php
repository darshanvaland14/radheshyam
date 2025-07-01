<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--[if !mso]><!-->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!--<![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title></title>
</head>

<html>
<head>
	<title><?php echo $data['sitename']; ?></title>
</head>
<body>

<table border="0" width="600" cellspacing="0" cellpadding="0" align="center">
  <tbody>
    <tr>
      <td align="left" valign="top">
        <div style="height: 110px; text-align: center;"><center><img style="margin-top: 0px; border-radius: 5px; margin-bottom: 10px;" src="<?php echo $data['sitelogo']; ?>" alt="" width="80" /></center></div>
      </td>
    </tr>
    <tr>
      <td style="font-family: Arial,Helvetica,sans-serif; font-size: 13px; padding: 10px; border-width: 2px 2px 1px; border-style: solid; border-color: #0c3779; color: #0c3779; background-color: #fff;" align="center" valign="top" bgcolor="#fff">
        <table style="margin-top: 10px;" border="0" width="100%" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td style="font-family: Arial,Helvetica,sans-serif; font-size: 13px; color: #000;" align="left" valign="top">
                <div style="font-size: 15px; text-align: left;">
									<p><?php echo $data['message']; ?></p>
								</div>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr style="width: 100%;">
      <td style="background-color: #0c3779; border-bottom: 3px solid #0c3779; border-left: 2px solid #0c3779; border-right: 2px solid #0c3779;" align="left" valign="top" bgcolor="#222">
        <table style="width: 100.205%; height: 90px;" border="0" width="100%" cellspacing="0" cellpadding="15">
          <tbody>
            <tr style="width: 100%;">
              <td style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-size: 14px; padding: 10px; width: 19.7559%; color: #ffffff; border-bottom: 1px solid #ffffff; border-right: 1px solid #ffffff; font-weight: bold;" align="left" valign="top">Call Us</td>
              <td style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-size: 14px; padding: 10px; width: 27.1387%; color: #ffffff; border-bottom: 1px solid #ffffff; font-weight: bold; border-right: 1px solid #ffffff;">Reach Us</td>
              <td style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-size: 14px; padding: 10px; width: 27.1387%; color: #ffffff; border-bottom: 1px solid #ffffff; font-weight: bold;" align="left" valign="top">Name</td>
            </tr>
            <tr style="width: 100%;">
              <td style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; text-align: center; text-decoration: none; border-right: 1px solid #ffffff; font-size: 14px; padding: 0px 0px 10px; width: 19.7559%;" align="left" valign="top"><br /> <a style="color: #ffffff; text-decoration: none;" href="tel:<?php echo $data['mobile']; ?> "><strong style="color: #ffffff; text-decoration: none;"><?php echo $data['mobile']; ?></strong></a></td>
              <td style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; text-align: center; padding: 0px 0px 10px; font-size: 14px; width: 27.1387%; border-right: 1px solid #ffffff;"><a style="color: #ffffff; text-decoration: none;" href="mailto:<?php echo $data['tenantemail']; ?>"> <br /<strong style="color: #ffffff; text-decoration: none;"><?php echo $data['tenantemail']; ?></strong></a></td>
              <td style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; text-align: center; padding: 0px 0px 10px; font-size: 14px; width: 27.1387%;" align="left" valign="top"><a style="color: #ffffff; text-decoration: none;" href="#" target="_blank" rel="noopener"> <br /> <strong style="color: #ffffff; text-decoration: none;"><?php echo $data['tenantname']; ?></strong> </a></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>


</body>
</html>
