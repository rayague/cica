<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CommandeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommandeImageController extends Controller
{
    public function store(Request $request, Commande $commande)
    {
        $request->validate([
            'image' => 'required|image|max:2048', // 2MB max
        ]);

        $imageCount = $commande->images()->count();
        if ($imageCount >= 10) {
            return response()->json([
                'error' => 'Maximum 10 images autorisées par commande'
            ], 400);
        }

        $file = $request->file('image');
        $path = $file->store('commande-images', 'public');

        $image = $commande->images()->create([
            'image_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize()
        ]);

        return response()->json([
            'message' => 'Image ajoutée avec succès',
            'image' => $image
        ]);
    }

    public function destroy(CommandeImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json([
            'message' => 'Image supprimée avec succès'
        ]);
    }

    public function update(Request $request, CommandeImage $image)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        Storage::disk('public')->delete($image->image_path);

        $file = $request->file('image');
        $path = $file->store('commande-images', 'public');

        $image->update([
            'image_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize()
        ]);

        return response()->json([
            'message' => 'Image mise à jour avec succès',
            'image' => $image
        ]);
    }
}
