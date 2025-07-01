<?php

namespace App\Containers\AppSection\Themesettings\Actions;

use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Containers\AppSection\Themesettings\Tasks\UpdateThemesettingsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Carbon;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\App;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UpdateThemesettingsAction extends Action
{
    public function run($request)
    {

        $getTenant = Auth::user();
        $tenantid = $getTenant['tenant_id'];

        // echo "Gallery Category ::=> ".$request->category;die;

        $image_type = "png";
        $folderPath = 'public/img/';

        // Logo Image
        if (!empty($request->logo)) {
            if (!file_exists(public_path('img'))) {
                mkdir(public_path('img'), 0755, true);
            }
            // $image_bace64 = base64_decode($request->logo);
            $logoimagefile = uniqid() . '.' . $image_type;
            //$image_enc_bace64 = "data:image/png;base64,".$request->logo;
            $image_enc_bace64 = $request->logo;
            ///////////////////////////////////////////
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($image_enc_bace64);
            $image->toPng()->save(public_path('img/' . $logoimagefile));
            $logoImage = $folderPath . $logoimagefile;
            // dd($logoImage);
        } else {
            $logoImage = '';
        }

        // Favicon Logo Image
        if (!empty($request->favicon)) {
            if (!file_exists(public_path('img'))) {
                mkdir(public_path('img'), 0755, true);
            }

            // $image_bace64 = base64_decode($request->favicon);
            $faviconimagefile = uniqid() . '.' . $image_type;
            //$favicon_image_enc_bace64 = "data:image/png;base64,".$request->favicon;
            $favicon_image_enc_bace64 = $request->favicon;
            //echo $favicon_image_enc_bace64;die;

            ///////////////////////////////////////////
            $manager = new ImageManager(Driver::class);
            $favicon_image = $manager->read($favicon_image_enc_bace64);
            $favicon_image->toPng()->save(public_path('img/' . $faviconimagefile));
            $faviconImage = $folderPath . $faviconimagefile;
        } else {
            $faviconImage = '';
        }


        $data_filter = $request->sanitizeInput([
            // add your request data here
            'name' => $request->name,
            'description' => $request->description,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'mailer' => $request->mailer,
            'mailpath' => $request->mailpath,
            'smtphost' => $request->smtphost,
            'smtpemail' => $request->smtpemail,
            'smtppassword' => $request->smtppassword,
            'port' => $request->port,
            'ssl_tls_type' => $request->ssl_tls_type,
            'recaptcha_key' => $request->recaptcha_key,
            'recaptcha_secret' => $request->recaptcha_secret,
        ]);

        $data = array_filter($data_filter);
        $data['logo'] = $logoImage;
        $data['favicon'] = $faviconImage;

        return app(UpdateThemesettingsTask::class)->run($request->id, $data);
    }
}
