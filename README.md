# laravel_upload
app.php add next line

> Intervention\Image\ImageServiceProvider::class
> EzApp\Upload\UploadServiceProvider::class
alias 
        'Image' => Intervention\Image\Facades\Image::class
        
> php artisan vendor:publish --tag=ezapp_upload 

