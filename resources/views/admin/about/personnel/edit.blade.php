<x-admin-layout title="แก้ไขบุคลากร">
    @include('admin.about.personnel.form', ['action' => route('admin.about.personnel.update', $person), 'method' => 'put'])
</x-admin-layout>
