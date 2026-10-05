@props(['person', 'featured' => false])

<article {{ $attributes->class(['person-card', 'person-card--'.$person->color, 'person-card--featured' => $featured]) }}>
    <div class="person-card__avatar" aria-hidden="true">
        @if ($person->photo_url)
            <img src="{{ $person->photo_url }}" alt="">
        @else
            <span>{{ $person->initials }}</span>
        @endif
    </div>
    <div class="person-card__body">
        <div class="person-card__badges">
            @if ($person->unit)<span class="person-card__unit">{{ $person->unit }}</span>@endif
            @if ($person->is_head)<span class="person-card__head"><i class="bi bi-star-fill"></i> หัวหน้างาน</span>@endif
        </div>
        <h3>{{ $person->name_th }}</h3>
        <p class="person-card__name-en">{{ $person->name_en }}</p>
        <p class="person-card__position">{{ $person->position_th }}<small>{{ $person->position_en }}</small></p>
        @if ($person->email || $person->phone)
            <div class="person-card__contact" aria-label="ช่องทางติดต่อของ {{ $person->name_th }}">
                @if ($person->email)<a href="mailto:{{ $person->email }}"><i class="bi bi-envelope-fill" aria-hidden="true"></i><span>{{ $person->email }}</span></a>@endif
                @if ($person->phone)<a href="{{ $person->phone_url }}"><i class="bi bi-telephone-fill" aria-hidden="true"></i><span>{{ $person->phone }}</span></a>@endif
            </div>
        @endif
        @if ($person->responsibility_items !== [])
            <div class="person-card__responsibilities">
                <button class="person-card__responsibility-toggle collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#personResponsibilities{{ $person->id }}" aria-expanded="false" aria-controls="personResponsibilities{{ $person->id }}">
                    <span><i class="bi bi-list-check" aria-hidden="true"></i> ภาระงานที่รับผิดชอบ</span>
                    <span class="person-card__toggle-text"><span class="person-card__toggle-collapsed">ดูทั้งหมด</span><span class="person-card__toggle-expanded">ย่อ</span><i class="bi bi-chevron-down" aria-hidden="true"></i></span>
                </button>
                <div class="collapse" id="personResponsibilities{{ $person->id }}">
                    <ul>
                        @foreach ($person->responsibility_items as $responsibility)
                            <li>{!! $responsibility !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</article>
