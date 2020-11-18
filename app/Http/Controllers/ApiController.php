<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function index()
    {
        return Note::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        $note = new Note([
            'title' => $request->input('title'),
            'note' => $request->input('note'),
        ]);

        $file = $request->file('file');
        if ($file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $note->file = $file->storeAs('files', $fileName);
        }

        $note->save();
        return response()->json(['success' => $note->save() ]);
    }

    public function destroy($id)
    {
        $note = Note::find($id);
        if ($note->file) {
            Storage::disk()->delete($note->file);
        }
        return response()->json(['success' => $note->delete()]);
    }
}
