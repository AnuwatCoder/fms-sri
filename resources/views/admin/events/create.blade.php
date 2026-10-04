<x-admin-layout title="เพิ่มกิจกรรม">
    @include('admin.events.form', ['action' => route('admin.events.store'), 'method' => 'post'])
</x-admin-layout>
