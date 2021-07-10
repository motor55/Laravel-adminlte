<?php namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Image;

class Upload {

    protected $file;
    protected $meta;
    protected $allowedResize = [
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/gif',
        ];

    /**
     * @param UploadedFile $file
     * @param string $path
     * @param string|null $name
     * @return $this
     */
    public function upload(UploadedFile $file, string $path, string $name = null)
    {
        $this->file = $file;

        if (empty($name)) {
            $name = Str::random(40);
        }

        if ($extension = $this->file->guessExtension()) {
            $extension = '.'.$extension;
        }

        $path = $this->file->storeAs($path, $name . $extension);

        $this->getMeta($path);

        return $this;
    }

    /**
     * @param $file
     * @return $this
     */
    public function uploadTemp($file)
    {
        $this->file = $file;

        $path = $this->file->store('temp/'.Auth::id());

        $this->getMeta($path);

        return $this;
    }

    /**
     * @param $from
     * @param $to
     * @return $this
     */
    public function move($from, $to)
    {
        $this->getMeta($from);

        $to = $to.'/'.$this->meta['basename'];

        Storage::move($from, $to);

        $this->getMeta($to);

        return $this;
    }

    /**
     * @param null $width
     * @param null $height
     *
     * @return $this
     */
    public function resize($width=null, $height=null)
    {
        if (in_array($this->meta['type'], $this->allowedResize)) {

            $file = Storage::get($this->meta['path']);

            $img = Image::make($file)
                        ->fit($width, $height, function ($constraint) {
                            //$constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->encode();

            $this->meta['size'] = strlen((string) $img);

            Storage::put($this->meta['path'], (string) $img);
        }

        return $this;
    }

    /**
     * @param null $width
     * @param null $height
     *
     * @return $this
     */
    public function thumbnail($width=null, $height=null)
    {
        if (in_array($this->meta['type'], $this->allowedResize)) {

            $file = Storage::get($this->meta['path']);

            $img = Image::make($file)
                        ->fit($width, $height)
                        // ->resize($width, $height, function ($constraint) {
                        //     $constraint->aspectRatio();
                        //     $constraint->upsize();
                        // })
                        // ->crop($width, $height)
                        ->encode();

            Storage::put($this->meta['dirname'].'/thumbnail_'.$this->meta['basename'], (string) $img);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->meta;
    }

    /**
     * @param $path
     * @return $this
     */
    private function getMeta($path)
    {
        $this->meta = pathinfo($path);
        $this->meta['path'] = $path;

        if ($this->file) {
            $this->meta['name'] = $this->file->getClientOriginalName();
            $this->meta['type'] = $this->file->getClientMimeType();
            $this->meta['size'] = $this->file->getSize();
            $this->meta['isValid'] = $this->file->isValid();
            $this->meta['maxFileSize'] = $this->file->getMaxFilesize();
            $this->meta['error'] = $this->file->getError();
            $this->meta['errorMessage'] = $this->file->getErrorMessage();
        } else {
            $this->meta['type'] = Storage::mimeType($path);
            $this->meta['size'] = Storage::size($path);
            $this->meta['meta'] = Storage::getMetaData($path);
        }

        return $this;
    }
}
