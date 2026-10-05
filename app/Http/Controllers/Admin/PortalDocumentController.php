<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortalDocumentRequest;
use App\Models\PortalDocument;
use App\Services\PortalDocumentService;
use App\Support\DocumentFilePresentation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalDocumentController extends Controller
{
    public function index(Request $request): View
    {
        $documents = PortalDocument::query()
            ->search($request->string('q')->toString())
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.documents.index', compact('documents'));
    }

    public function create(): View
    {
        return view('admin.documents.create', [
            'document' => new PortalDocument,
            'categories' => DocumentCategory::options(),
            'filePresentations' => DocumentFilePresentation::presets(),
        ]);
    }

    public function store(PortalDocumentRequest $request, PortalDocumentService $service): RedirectResponse
    {
        $service->save(new PortalDocument, $request->validated());

        return to_route('admin.documents.index')->with('success', 'เพิ่มเอกสารเรียบร้อยแล้ว');
    }

    public function edit(PortalDocument $document): View
    {
        return view('admin.documents.edit', [
            'document' => $document,
            'categories' => DocumentCategory::options(),
            'filePresentations' => DocumentFilePresentation::presets(),
        ]);
    }

    public function update(PortalDocumentRequest $request, PortalDocument $document, PortalDocumentService $service): RedirectResponse
    {
        $service->save($document, $request->validated());

        return to_route('admin.documents.index')->with('success', 'บันทึกเอกสารเรียบร้อยแล้ว');
    }

    public function destroy(PortalDocument $document, PortalDocumentService $service): RedirectResponse
    {
        $service->delete($document);

        return to_route('admin.documents.index')->with('success', 'ลบเอกสารเรียบร้อยแล้ว');
    }
}
