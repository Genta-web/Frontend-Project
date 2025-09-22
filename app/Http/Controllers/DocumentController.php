<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    //
    public function index(Request $request){
        $query = Document::with('uploader')->orderBy('created_at', 'desc');

        if ($request->filled('upload_date')) {
            $query->whereDate('created_at', $request->upload_date);
        }
        if ($request->filled('uploader')) {
            $query->whereHas('uploader', function($q) use ($request) {
                $q->where('username', 'like', '%' . $request->uploader . '%')
                  ;
            });
        }

        $dokumen = $query->get();

        return view('manajemen-dokumen.index', compact('dokumen'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'path' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:10240', // only document files
            'description' => 'nullable|string',
        ]);

        $file = $request->file('path');

        // Upload file to storage/app/documents
        $filePath = $file->store('documents');

        Document::create([
            'title' => $request->title,
            'path' => $filePath,
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by' => auth()->id(),
            'description' => $request->description,
        ]);

        return redirect()->route('dokumen.index')->with('success', 'Document saved successfully.');
    }

    public function edit($id){
        $document = Document::with('uploader')->findOrFail($id);
        return view('manajemen-dokumen.edit', compact('document'));
    }

    public function show($id){
        $document = Document::with('uploader')->findOrFail($id);
        return view('manajemen-dokumen.show', compact('document'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required|string|max:255',
            'path' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:10240', // document file optional on update
            'description' => 'nullable|string',
        ]);

        $document = Document::findOrFail($id);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        // If a new file is uploaded, save and delete the old file
        if ($request->hasFile('path')) {
            $file = $request->file('path');

            // Delete old file if exists
            if ($document->path && Storage::exists($document->path)) {
                Storage::delete($document->path);
            }

            $data['path'] = $file->store('documents');
            $data['original_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
        }

        $document->update($data);

        return redirect()->route('dokumen.index')->with('success', 'Document updated successfully.');

    }

    public function delete($id){
        $document = Document::findOrFail($id);
        // Delete file from storage
        if ($document->path && Storage::exists($document->path)) {
            Storage::delete($document->path);
        }
        $document->delete();

        return redirect()->route('dokumen.index')->with('success', 'Document deleted successfully.');
    }

    public function download($id){
        $document = Document::findOrFail($id);

        if ($document->path && Storage::exists($document->path)) {
            // Use original filename if available, otherwise use title with extension
            $fileName = $document->original_name ?: ($document->title . '.' . pathinfo($document->path, PATHINFO_EXTENSION));
            return Storage::download($document->path, $fileName);
        }

        return redirect()->back()->with('error', 'File not found.');
    }


}
