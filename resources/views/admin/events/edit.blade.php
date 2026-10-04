<x-admin-layout title="แก้ไขกิจกรรม">
    @include('admin.events.form', ['action' => route('admin.events.update', $event), 'method' => 'put'])
</x-admin-layout>
