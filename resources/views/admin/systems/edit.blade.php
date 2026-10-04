<x-admin-layout title="แก้ไขระบบสารสนเทศ">
    @include('admin.systems.form', ['action' => route('admin.systems.update', $system), 'method' => 'put'])
</x-admin-layout>
