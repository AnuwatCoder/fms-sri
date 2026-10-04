<x-portal-layout title="ข่าวสารและประกาศ" description="ข่าวสาร ประกาศ และกิจกรรมล่าสุดของงานแผนยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ">
    <main id="main-content">
        <x-page-hero title="ข่าวสารและประกาศ" eyebrow="NEWS & ANNOUNCEMENTS" description="ติดตามข่าวประชาสัมพันธ์ ประกาศสำคัญ และกิจกรรมของหน่วยงาน" icon="bi-newspaper" />

        <section class="subpage-content" aria-labelledby="news-list-title">
            <div class="container-fluid">
                <livewire:news-directory />
            </div>
        </section>
    </main>
</x-portal-layout>
