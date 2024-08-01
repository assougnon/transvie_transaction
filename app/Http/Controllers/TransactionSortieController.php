<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Transacsortie;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionSortieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $nbr = Transacsortie::whereYear('created_at', Carbon::now()->year)->get()->count();
      $montant = Transacsortie::whereYear('created_at', Carbon::now()->year)->get()->sum('montant');


        return view('depenses.depenses-liste',[
          'nombres' => $nbr,
          'total' => $montant

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $banques = Banque::all();
        return view('depenses.depenses-create',[
          'banques' => $banques,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
        'depense' => 'required',
        'description' => 'required',
        'banque_id' => 'required',
      ],
        [
          'description.required' => 'Veuillez saisir une description',
          'depense.required' => 'Veuillez saisir un montant',
          'banque_id.required' => 'Veuillez selectionner une banque',

        ]);

      $depensess = Transacsortie::create([
        'montant' => $request->depense,
        'description' => $request->description,
        'banque_id' => $request->banque_id,
      ]);

      return redirect(route('depenses-liste'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
      $columns = [
        1 => 'id',
        2 => 'montant',
        3 => 'banque_id',
        4 => 'description'
      ];

      $search = [];

      $totalData = Transacsortie::count();

      $totalFiltered = $totalData;

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

      if (empty($request->input('search.value'))) {
        $depenses = Transacsortie::offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();
      } else {
        $search = $request->input('search.value');

        $depenses = Transacsortie::where('id', 'LIKE', "%{$search}%")
          ->orWhere('montant', 'LIKE', "%{$search}%")
          ->orWhere('description', 'LIKE', "%{$search}%")
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

        $totalFiltered = Transacsortie::where('id', 'LIKE', "%{$search}%")
          ->orWhere('montant', 'LIKE', "%{$search}%")
          ->orWhere('description', 'LIKE', "%{$search}%")
          ->count();
      }

      $data = [];

      if (!empty($depenses)) {
        // providing a dummy id instead of database ids
        $ids = $start;

        foreach ($depenses as $depense) {
          $nestedData['id'] = $depense->id;
          $nestedData['fake_id'] = ++$ids;
          $nestedData['montant'] = $depense->montant;
          $nestedData['description'] = $depense->description;
          $nestedData['banque'] = $depense->banque->nom;

          $data[] = $nestedData;
        }
      }

      if ($data) {
        return response()->json([
          'draw' => intval($request->input('draw')),
          'recordsTotal' => intval($totalData),
          'recordsFiltered' => intval($totalFiltered),
          'code' => 200,
          'data' => $data,
        ]);
      } else {
        return response()->json([
          'message' => 'Internal Server Error',
          'code' => 500,
          'data' => [],
        ]);
      }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $depense = Transacsortie::find($id);
      $banques = Banque::all();

      return view('depenses.depenses-edit',[
        'depense' =>$depense,
        'banques' => $banques
      ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $request->validate([
        'depense' => 'required',
        'description' => 'required',
        'banque_id' => 'required',
      ],
        [
          'description.required' => 'Veuillez saisir une description',
          'depense.required' => 'Veuillez saisir un montant',
          'banque_id.required' => 'Veuillez selectionner une banque',

        ]);
      Transacsortie::updateOrCreate(
        ['id' =>$id],
        [
          'montant' => $request->depense,
          'description' => $request->description,
          'banque_id' => $request->banque_id,
        ]
      );
      return redirect(route('depenses-liste'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $depense = Transacsortie::where('id',$id)->first();
        $depense->delete();
    }
}
