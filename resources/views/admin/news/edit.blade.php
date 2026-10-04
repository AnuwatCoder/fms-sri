<x-admin-layout title="แก้ไขข่าว/ประกาศ">
    @include('admin.news.form', ['action' => route('admin.news.update', $newsItem), 'method' => 'put'])
</x-admin-layout>
