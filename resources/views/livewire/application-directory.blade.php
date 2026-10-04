<div>
    @unless ($compact)
        <div class="subpage-toolbar">
            <div><h2 id="systems-list-title">ระบบทั้งหมด</h2><p>เลือกใช้งานระบบที่ต้องการ หรือค้นหาจากชื่อและประเภทของระบบ</p></div>
            <form class="portal-search subpage-search" role="search" wire:submit="$refresh">
                <label class="visually-hidden" for="systemsSearch">ค้นหาระบบ</label>
                <i class="bi bi-search" aria-hidden="true"></i>
                <input id="systemsSearch" type="search" placeholder="ค้นหาระบบ..." autocomplete="off" wire:model.live.debounce.300ms="search" data-system-search>
                <button type="submit" aria-label="ค้นหา"><i class="bi bi-search" aria-hidden="true"></i></button>
            </form>
        </div>
        <div class="filter-pills" aria-label="หมวดหมู่ระบบ">
            @foreach ([
                'all' => 'ทั้งหมด',
                'plan' => 'แผนและโครงการ',
                'revenue' => 'บริหารรายได้',
                'data' => 'ข้อมูลและรายงาน',
                'service' => 'บริการและบุคลากร',
            ] as $value => $label)
                <button type="button" class="{{ $category === $value ? 'active' : '' }}" wire:click="setCategory('{{ $value }}')">
                    {{ $label }} @if ($value === 'all') <strong>{{ $totalApplications }}</strong> @endif
                </button>
            @endforeach
        </div>
    @endunless

    <div class="position-relative">
        <div class="livewire-loading" wire:loading.delay aria-live="polite"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span> กำลังอัปเดต...</div>
        @if ($applications->isNotEmpty())
            <div class="row g-{{ $compact ? '3' : '4' }}">
                @foreach ($applications as $application)
                    <div class="{{ $compact ? 'col-md-6 col-xl-3' : 'col-md-6 col-lg-4 col-xl-3' }}" wire:key="application-{{ $application->id }}">
                        <x-system-card :application="$application" :favorite-key="$application->id" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state" role="status"><i class="bi bi-search"></i><p class="mb-0">ไม่พบระบบที่ตรงกับคำค้นหา</p></div>
        @endif
    </div>
</div>
