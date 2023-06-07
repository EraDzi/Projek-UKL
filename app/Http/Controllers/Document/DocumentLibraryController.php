<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DocumentLibraryController extends Controller
{
    /**
     * Display the document library.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $documents = Document::orderBy('upload_date', 'desc')->get();
        $pageSlug = 'documents'; // Set the value of $pageSlug

        return view('documents.index', compact('documents', 'pageSlug'));
    }

    /**
     * Show the form for creating a new document.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created document.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'photo' => 'required|image',
        ]);

        $file = $request->file('photo');

        $document = new Document();
        $document->name = $request->input('name');
        $document->upload_date = now();
        $document->photo_path = $file->store('public/photos'); // Store the photo in the "public/photos" directory
        $document->save();

        return redirect()->route('documents.index');
    }

    /**
     * Remove the specified document from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Delete the document file from storage
        Storage::disk('public')->delete($document->photo_path);

        // Delete the document from the database
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document has been deleted.');
    }
}
