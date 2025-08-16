<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Membaca;
use App\Models\Menyimak;
use App\Models\Menulis;
use App\Models\Berbicara;

class MainController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Welcome to the KODINUS API',
            'status' => 'success'
        ]);
    }

    public function getMembaca()
    {
        $membaca = Membaca::all();
        return response()->json($membaca);
    }

    public function getMenyimak()
    {
        $menyimak = Menyimak::all();
        return response()->json($menyimak);
    }
    public function getMenulis()
    {
        $menulis = Menulis::all();
        return response()->json($menulis);
    }
    public function getBerbicara()
    {
        $berbicara = Berbicara::all();
        return response()->json($berbicara);
    }
    public function storeMembaca(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'soal_1' => 'required|string',
            'soal_2' => 'required|string',
            'soal_3' => 'required|string',
            'soal_4' => 'required|string',
            'soal_5' => 'required|string',
            'soal_6' => 'required|string'
        ]);
        $membaca = Membaca::create($request->all());
        return response()->json($membaca, 201);
    }
    public function storeMenyimak(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'soal_1' => 'required|string',
            'soal_2' => 'required|string',
        ]);
        $menyimak = Menyimak::create($request->all());
        return response()->json($menyimak, 201);
    }
    public function storeMenulis(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'soal_1' => 'required|string',
        ]);
        $menulis = Menulis::create($request->all());
        return response()->json($menulis, 201);
    }
    public function storeBerbicara(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'file_audio' => 'required|file|mimes:mp3,wav|max:10240',
        ]);
        $file = $request->file('file_audio');
        $filename = time() . '_' . $file->getClientOriginalName();
        // Store the file in the 'audio' directory within the 'public' disk
        // Ensure the 'public' disk is configured in config/filesystems.php
        // and the 'audio' directory exists
        // You may need to create the directory if it doesn't exist
        if (!file_exists(public_path('storage/audio'))) {
            mkdir(public_path('storage/audio'), 0755, true);
        }
        // Store the file and get the path
        // This will store the file in 'storage/app/public/audio'
        // and return the relative path to the file
        $request->file('file_audio')->storeAs('audio', $filename, 'public');
        // Save the file path in the database
        $request->merge(['file_audio' => 'storage/audio/' . $filename]);
        $request->validate([
            'nama' => 'required|string|max:255',
            'file_audio' => 'required|string',
        ]);
        $berbicara = new Berbicara();
        $berbicara->nama = $request->nama;
        $berbicara->file_audio = $request->file_audio;
        $berbicara->save();
        return response()->json($berbicara, 201);
    }
    public function updateMembaca(Request $request, $id)
    {
        $membaca = Membaca::findOrFail($id);
        $membaca->update($request->all());
        return response()->json($membaca);
    }
    public function updateMenyimak(Request $request, $id)
    {
        $menyimak = Menyimak::findOrFail($id);
        $menyimak->update($request->all());
        return response()->json($menyimak);
    }
    public function updateMenulis(Request $request, $id)
    {
        $menulis = Menulis::findOrFail($id);
        $menulis->update($request->all());
        return response()->json($menulis);
    }
    public function updateBerbicara(Request $request, $id)
    {
        $berbicara = Berbicara::findOrFail($id);
        $berbicara->update($request->all());
        return response()->json($berbicara);
    }
    public function deleteMembaca($id)
    {
        $membaca = Membaca::findOrFail($id);
        $membaca->delete();
        return response()->json(['message' => 'Membaca deleted successfully']);
    }
    public function deleteMenyimak($id)
    {
        $menyimak = Menyimak::findOrFail($id);
        $menyimak->delete();
        return response()->json(['message' => 'Menyimak deleted successfully']);
    }
    public function deleteMenulis($id)
    {
        $menulis = Menulis::findOrFail($id);
        $menulis->delete();
        return response()->json(['message' => 'Menulis deleted successfully']);
    }
    public function deleteBerbicara($id)
    {
        $berbicara = Berbicara::findOrFail($id);
        $berbicara->delete();
        return response()->json(['message' => 'Berbicara deleted successfully']);
    }
    public function searchMembaca(Request $request)
    {
        $query = $request->input('query');
        $results = Membaca::where('nama', 'LIKE', "%{$query}%")->get();
        return response()->json($results);
    }
    public function searchMenyimak(Request $request)
    {
        $query = $request->input('query');
        $results = Menyimak::where('nama', 'LIKE', "%{$query}%")->get();
        return response()->json($results);
    }   
    public function searchMenulis(Request $request)
    {
        $query = $request->input('query');
        $results = Menulis::where('nama', 'LIKE', "%{$query}%")->get();
        return response()->json($results);
    }
    public function searchBerbicara(Request $request)
    {
        $query = $request->input('query');
        $results = Berbicara::where('nama', 'LIKE', "%{$query}%")->get();
        return response()->json($results);
    }
    public function getStatistics()
    {
        $statistics = [
            'membaca_count' => Membaca::count(),
            'menyimak_count' => Menyimak::count(),
            'menulis_count' => Menulis::count(),
            'berbicara_count' => Berbicara::count(),
        ];
        return response()->json($statistics);
    }
    public function getRecentEntries()
    {
        $recentMembaca = Membaca::latest()->take(5)->get();
        $recentMenyimak = Menyimak::latest()->take(5)->get();
        $recentMenulis = Menulis::latest()->take(5)->get();
        $recentBerbicara = Berbicara::latest()->take(5)->get();

        return response()->json([
            'recent_membaca' => $recentMembaca,
            'recent_menyimak' => $recentMenyimak,
            'recent_menulis' => $recentMenulis,
            'recent_berbicara' => $recentBerbicara,
        ]);
    }
    public function getAllEntries()
    {
        $membaca = Membaca::all();
        $menyimak = Menyimak::all();
        $menulis = Menulis::all();
        $berbicara = Berbicara::all();

        return response()->json([
            'membaca' => $membaca,
            'menyimak' => $menyimak,
            'menulis' => $menulis,
            'berbicara' => $berbicara,
        ]);
    }
    public function getEntryById($id)
    {
        $membaca = Membaca::find($id);
        $menyimak = Menyimak::find($id);
        $menulis = Menulis::find($id);
        $berbicara = Berbicara::find($id);

        return response()->json([
            'membaca' => $membaca,
            'menyimak' => $menyimak,
            'menulis' => $menulis,
            'berbicara' => $berbicara,
        ]);
    }
    public function getEntriesByDate(Request $request)
    {
        $date = $request->input('date');
        $membaca = Membaca::whereDate('created_at', $date)->get();
        $menyimak = Menyimak::whereDate('created_at', $date)->get();
        $menulis = Menulis::whereDate('created_at', $date)->get();
        $berbicara = Berbicara::whereDate('created_at', $date)->get();

        return response()->json([
            'membaca' => $membaca,
            'menyimak' => $menyimak,
            'menulis' => $menulis,
            'berbicara' => $berbicara,
        ]);
    }
    public function getEntriesByName(Request $request)
    {
        $name = $request->input('name');
        $membaca = Membaca::where('nama', 'LIKE', "%{$name}%")->get();
        $menyimak = Menyimak::where('nama', 'LIKE', "%{$name}%")->get();
        $menulis = Menulis::where('nama', 'LIKE', "%{$name}%")->get();
        $berbicara = Berbicara::where('nama', 'LIKE', "%{$name}%")->get();
        return response()->json([
            'membaca' => $membaca,
            'menyimak' => $menyimak,
            'menulis' => $menulis,
            'berbicara' => $berbicara,
        ]);
    }
    public function getEntriesByKeyword(Request $request)
    {
        $keyword = $request->input('keyword');
        $membaca = Membaca::where('soal_1', 'LIKE', "%{$keyword}%")
            ->orWhere('soal_2', 'LIKE', "%{$keyword}%")
            ->orWhere('soal_3', 'LIKE', "%{$keyword}%")
            ->orWhere('soal_4', 'LIKE', "%{$keyword}%")
            ->orWhere('soal_5', 'LIKE', "%{$keyword}%")
            ->orWhere('soal_6', 'LIKE', "%{$keyword}%")
            ->get();
        $menyimak = Menyimak::where('soal_1', 'LIKE', "%{$keyword}%")
            ->orWhere('soal_2', 'LIKE', "%{$keyword}%")
            ->get();
        $menulis = Menulis::where('soal_1', 'LIKE', "%{$keyword}%")->get();
        $berbicara = Berbicara::where('nama', 'LIKE', "%{$keyword}%")->get();

        return response()->json([
            'membaca' => $membaca,
            'menyimak' => $menyimak,
            'menulis' => $menulis,
            'berbicara' => $berbicara,
        ]);
    }
}
