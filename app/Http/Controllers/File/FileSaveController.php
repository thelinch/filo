<?php

namespace App\Http\Controllers\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use src\Shared\Domain\UuidGenerator;
use src\Shared\Infraestructure\Eloquent\ApiController;

class FileSaveController extends ApiController
{
    private UuidGenerator $uuid;
    public function __construct(UuidGenerator $uuid)
    {
        $this->uuid = $uuid;
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(Request $request)
    {
        $directory = $request->query("directory");
        $files = $request->file("files");
        $collectResponseFiles = collect([]);
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $name = $this->uuid->generate();
            /*             $fileUrl = Storage::putFile("img/" . $directory, $file, $name . "." . $extension);
 */
            $fileUrl = $file->store("public/img");
            $collectResponseFiles->push(["url" => "/" . $fileUrl]);
        }
        return response()->json($collectResponseFiles->toArray());
    }
}
