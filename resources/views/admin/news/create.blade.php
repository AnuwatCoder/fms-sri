<x-admin-layout title="เพิ่มข่าว/ประกาศ">
    @include('admin.news.form', ['action' => route('admin.news.store'), 'method' => 'post'])
</x-admin-layout>
