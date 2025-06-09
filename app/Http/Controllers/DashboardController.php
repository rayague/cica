<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $commandesEnCours = Commande::where('statut', 'en_cours')->count();
        $commandesTerminees = Commande::where('statut', 'terminee')->count();
        $commandesAnnulees = Commande::where('statut', 'annulee')->count();
        $totalCommandes = Commande::count();
        $totalRevenus = Commande::where('statut', 'terminee')->sum('montant_total');
        $dernieresCommandes = Commande::with('client')->latest()->take(5)->get();

        return view('utilisateurs.dashboard', compact(
            'commandesEnCours',
            'commandesTerminees',
            'commandesAnnulees',
            'totalCommandes',
            'totalRevenus',
            'dernieresCommandes'
        ));
    }
}
