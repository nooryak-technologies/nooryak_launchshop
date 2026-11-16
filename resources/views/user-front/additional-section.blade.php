@php
  $sectionName = trim(@$data->section_name ?? '');
  $rawContent = @$data->content ?? '';
  $hasMedia = preg_match('/<(img|iframe|video|audio|svg|embed|object|picture)\b/i', $rawContent);
  $cleanText = trim(strip_tags(str_replace(['&nbsp;', '&#160;'], ' ', $rawContent)));
  $hasContent = ($cleanText !== '' || $hasMedia);
@endphp
@if($sectionName !== '' || $hasContent)
<section class="custom-section pb-70 {{ $possition }}">
  <div class="container">
    <div class="row">
      @if($sectionName !== '')
      <div class="col-12">
        <div class="section-title title-inline mb-10">
          <h2 class="title mb-20">
            {{ @$data->section_name }} </h2>
        </div>
      </div>
      @endif
      @if($hasContent)
      <div class="col-12">
        {!! replaceBaseUrl($data->content ?? null) !!}
      </div>
      @endif
    </div>
  </div>
</section>
@endif
