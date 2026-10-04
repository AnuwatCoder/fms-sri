<x-admin-layout title="แก้ไขเอกสาร">
    @include('admin.documents.form', ['action' => route('admin.documents.update', $document), 'method' => 'put'])
</x-admin-layout>
