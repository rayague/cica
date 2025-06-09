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

        return response()->json(['success' => true]);
    }

    public function update(Request $request, CommandeImage $image)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        try {
            // Supprimer l'ancienne image
            if ($image->image_path) {
                $oldPath = public_path('storage/' . $image->image_path);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Sauvegarder la nouvelle image
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Déplacer l'image vers le dossier public
            $file->move(public_path('storage/commande-images'), $fileName);

            // Mettre à jour l'image dans la base de données
            $image->update([
                'image_path' => 'commande-images/' . $fileName,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize()
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour de l\'image: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
