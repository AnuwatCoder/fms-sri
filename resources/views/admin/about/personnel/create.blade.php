<x-admin-layout title="เพิ่มบุคลากร">
    @include('admin.about.personnel.form', ['action' => route('admin.about.personnel.store'), 'method' => 'post'])
</x-admin-layout>
