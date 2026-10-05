<x-portal-layout title="เอกสารและดาวน์โหลด" description="ดาวน์โหลดแผนยุทธศาสตร์ งบประมาณ ตัวชี้วัด กฎหมาย คู่มือ และแบบฟอร์มของหน่วยงาน">
    <main id="main-content">
        <x-page-hero title="เอกสาร/ดาวน์โหลด" eyebrow="DOCUMENTS & DOWNLOADS" description="รวมแผนยุทธศาสตร์ งบประมาณ ตัวชี้วัด กฎหมาย คู่มือ และแบบฟอร์มไว้ในที่เดียว" icon="bi-folder-fill" />

        <section class="subpage-content" aria-labelledby="documents-list-title">
            <div class="container-fluid">
                <livewire:document-directory />
            </div>
        </section>
    </main>
</x-portal-layout>
