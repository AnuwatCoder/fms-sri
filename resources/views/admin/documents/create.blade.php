<x-admin-layout title="เพิ่มเอกสาร">
    @include('admin.documents.form', ['action' => route('admin.documents.store'), 'method' => 'post'])
</x-admin-layout>
