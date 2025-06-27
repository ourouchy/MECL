<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarouselImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarouselImageController extends Controller
{
    public function index()
    {
        try {
            $images = CarouselImage::all()->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image' => url(Storage::url($image->image)),
                    'link' => $image->link ?? '', // Évite d'avoir `null`
                    'button_text' => $image->button_text ?? 'Voir plus' // Valeur par défaut
                ];
            });

            return response()->json($images, 200);

        } catch (\Exception $e) {
            Log::error("Erreur lors de la récupération des images du carrousel: " . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'link' => 'nullable|string', // Changé de url à string pour accepter tous les types de liens
                'button_text' => 'nullable|string|max:255'
            ]);

            if (!$request->hasFile('image')) {
                return response()->json(['message' => 'Aucune image envoyée'], 400);
            }

            // S'assurer que le répertoire existe
            Storage::disk('public')->makeDirectory('carousel');

            $path = $request->file('image')->store('carousel', 'public');

            // Déboguer le chemin du fichier
            Log::info('Chemin de fichier: ' . $path);

            $image = CarouselImage::create([
                'image' => $path,
                'link' => $request->input('link', ''),
                'button_text' => $request->input('button_text', 'Voir plus')
            ]);

            return response()->json($image, 201);

        } catch (\Exception $e) {
            // Journaliser l'erreur avec tous les détails
            Log::error("Erreur lors de l'upload d'une image: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['message' => 'Erreur lors de l\'upload: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $image = CarouselImage::findOrFail($id);

            // Vérifier si le fichier existe avant de le supprimer
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }

            $image->delete();

            return response()->json(['message' => 'Image supprimée'], 200);

        } catch (\Exception $e) {
            Log::error("Erreur lors de la suppression d'une image: " . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la suppression'], 500);
        }
    }
}
