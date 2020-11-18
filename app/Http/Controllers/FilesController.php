<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function file($id) {
        $note = Note::find($id);

        if (is_null($note) 
            || empty($note->file) 
            || !Storage::disk()->exists($note->file)) {
            abort(404);
        }

        return response()->download(storage_path('app') . '/' . $note->file);
    }
}
