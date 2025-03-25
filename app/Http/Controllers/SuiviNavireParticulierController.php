<?php

namespace App\Http\Controllers;

use App\Models\SuiviNavireParticulier;
use Illuminate\Http\Request;

class SuiviNavireParticulierController extends Controller
{
    // Affiche la liste des suivis avec filtrage
    public function index(Request $request)
    {
        $query = SuiviNavireParticulier::query();

        // Filtrage par année sur la colonne 'date'
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        // Filtrage par mois sur la colonne 'date'
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        // Filtrage par jour sur la colonne 'date'
        if ($request->filled('day')) {
            $query->whereDay('date', $request->day);
        }

        // Filtrage sur un intervalle de dates (date de début et date de fin)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Vous pouvez, si besoin, ajouter un tri par date décroissante et une pagination
        $suivis = $query->orderBy('date', 'desc')->get();

        return view('suivi_navire_particulier.index', compact('suivis'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('suivi_navire_particulier.create');
    }

    // Stocke un nouveau suivi
    public function store(Request $request)
    {
        $request->validate([
            'date'       => 'required|date',
            'nom_navire' => 'required|string|max:255',
            'mmsi'       => 'required|string|max:255',
            'observations' => 'nullable|string',
        ]);

        SuiviNavireParticulier::create($request->all());

        return redirect()->route('suivi_navire_particuliers.index')
                         ->with('success', 'Suivi créé avec succès.');
    }

    // Supprime un suivi
    public function destroy($id)
    {
        $suivi = SuiviNavireParticulier::findOrFail($id);
        $suivi->delete();

        return redirect()->route('suivi_navire_particuliers.index')
                         ->with('success', 'Suivi supprimé avec succès.');
    }
}
