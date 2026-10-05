<?php

namespace App\View\Components;

use App\Models\SeoSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class PortalLayout extends Component
{
    public SeoSetting $seoSetting;

    public string $metaTitle;

    public string $metaDescription;

    public string $metaImage;

    public string $canonicalUrl;

    /** @var array<string, mixed> */
    public array $structuredData;

    public function __construct(
        public string $title = 'FMS Portal',
        public ?string $description = null,
        public ?string $image = null,
        public string $type = 'website',
    ) {
        $this->seoSetting = SeoSetting::query()->first() ?? $this->fallbackSeoSetting();
        $this->metaTitle = in_array($title, ['FMS Portal', 'หน้าหลัก'], true)
            ? $this->seoSetting->default_title
            : $title.' | '.$this->seoSetting->site_name;
        $this->metaDescription = Str::limit(
            preg_replace('/\s+/u', ' ', strip_tags($description ?: $this->seoSetting->default_description)) ?? '',
            160,
            '',
        );
        $this->metaImage = $this->absoluteUrl($image ?: $this->seoSetting->og_image_url);
        $this->canonicalUrl = url()->current();
        $this->structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $this->seoSetting->site_name,
            'url' => url('/'),
            'inLanguage' => 'th-TH',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => route('search.index').'?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    public function render(): View
    {
        return view('components.portal-layout');
    }

    private function absoluteUrl(string $url): string
    {
        return Str::startsWith($url, ['http://', 'https://']) ? $url : url($url);
    }

    private function fallbackSeoSetting(): SeoSetting
    {
        return new SeoSetting([
            'site_name' => 'FMS Portal',
            'default_title' => 'งานยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ',
            'default_description' => 'ศูนย์รวมระบบสารสนเทศ ข่าวสาร เอกสาร และบริการของงานยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ',
            'og_image_path' => 'images/psu-fms-logo-th.png',
            'robots_index' => true,
            'robots_follow' => true,
        ]);
    }
}
