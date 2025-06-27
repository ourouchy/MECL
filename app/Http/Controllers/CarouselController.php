<?php


namespace App\Http\Controllers;

use App\Models\CarouselImage;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function getImages()
    {
        $images = CarouselImage::all()->map(function ($image) {
            return [
                'id' => $image->id,
                'image' => url(Storage::url($image->image)),
                'link' => $image->link ?? '',
                'button_text' => $image->button_text ?? 'Voir plus'
            ];
        });

        return response()->json($images);
    }
}
