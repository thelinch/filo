<?php

namespace App\Http\Controllers\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use src\Shared\Infraestructure\Eloquent\ApiController;

class FileGetController extends ApiController
{

    public function __construct()
    {
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(Request $request)
    {
        $fileUrl = $request->query("file");
        $directory = $request->query("directory");
        $file = Storage::download("/" . $directory . "/" . $fileUrl);
        return $file;
    }
}
