<?php

namespace App\Http\Controllers;

use Cloudinary\Cloudinary;
use Illuminate\Http\Request;

class CloudinaryClient extends Controller
{
    private $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
            ]
        );
    }

    public function createPicture($picture) : string
    {
        $public_id = bin2hex(random_bytes(12));
        $this->cloudinary->uploadApi()->upload(
            $picture,
            [
                'public_id' => $public_id,
                'folder' => 'screen',
            ]
        );
        return $public_id . '/' . $public_id;
    }
}
