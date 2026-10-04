<x-admin-layout title="แก้ไขภารกิจ">
    @include('admin.about.responsibilities.form', ['action' => route('admin.about.responsibilities.update', $responsibility), 'method' => 'put'])
</x-admin-layout>
