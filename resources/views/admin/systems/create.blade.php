<x-admin-layout title="เพิ่มระบบสารสนเทศ">
    @include('admin.systems.form', ['action' => route('admin.systems.store'), 'method' => 'post'])
</x-admin-layout>
