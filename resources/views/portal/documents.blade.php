<x-portal-layout title="เอกสารและดาวน์โหลด" description="ดาวน์โหลดคู่มือ แบบฟอร์ม นโยบาย และแนวปฏิบัติของหน่วยงาน">
    <main id="main-content">
        <x-page-hero title="เอกสาร/ดาวน์โหลด" eyebrow="DOCUMENTS & DOWNLOADS" description="รวบรวมคู่มือ แบบฟอร์ม นโยบาย และแนวปฏิบัติที่เกี่ยวข้องไว้ในที่เดียว" icon="bi-folder-fill" />

        <section class="subpage-content" aria-labelledby="documents-list-title">
            <div class="container-fluid">
                <livewire:document-directory />
            </div>
        </section>
    </main>
</x-portal-layout>
