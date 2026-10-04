<x-admin-layout title="เพิ่มภารกิจ">
    @include('admin.about.responsibilities.form', ['action' => route('admin.about.responsibilities.store'), 'method' => 'post'])
</x-admin-layout>
