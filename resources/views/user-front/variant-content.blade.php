@php
  $seen_variations = [];
@endphp
@foreach ($product_variations as $product_variation)
  @php
    $product_variation_content = App\Models\User\ProductVariationContent::where([
        ['product_variation_id', $product_variation->id],
        ['language_id', $language_id],
    ])->first();

    if (!$product_variation_content) {
        $product_variation_content = App\Models\User\ProductVariationContent::where('product_variation_id', $product_variation->id)->first();
    }

    $variant_content = null;
    if ($product_variation_content) {
        $variant_content = App\Models\VariantContent::where('id', $product_variation_content->variation_name)->first();
    }
    
    $vName = $variant_content ? $variant_content->name : ('Option ' . $product_variation->id);
    
    // Prevent duplicate variation groups (e.g. "Pack" rendered twice)
    if (isset($seen_variations[$vName])) {
        continue;
    }
    $seen_variations[$vName] = true;

    $variant_content_options = App\Models\User\ProductVariantOption::where([
        ['product_variation_id', $product_variation->id],
    ])->get();
  @endphp
  @if ($product_variation_content && count($variant_content_options) > 0)
    @php
      $variantName = @$variant_content->name ?? ('Option ' . $product_variation->id);
      $isColor = in_array(strtolower(trim($variantName)), ['color', 'colors', 'colour', 'colours']) 
              || str_contains(strtolower($variantName), 'color') 
              || str_contains(strtolower($variantName), 'colour');
      $displayHeading = ucfirst($variantName);
      if (!str_starts_with(strtolower($displayHeading), 'select')) {
          $displayHeading = __('Select') . ' ' . $displayHeading;
      }
    @endphp
    <div class="col-12 mb-3 variation-group-col">
      <h4 class="mb-2 color-primary" style="font-weight: 700; font-size: 15px; color: #1e293b;">{{ $displayHeading }}:</h4>
      <div class="d-flex flex-wrap align-items-center gap-2 py-1">
        @foreach ($variant_content_options as $variant_content_option)
          @php
            $variant_option_contents = App\Models\User\ProductVariantOptionContent::where([
                ['product_variant_option_id', $variant_content_option->id],
                ['language_id', $language_id],
            ])->first();

            if (!$variant_option_contents) {
                $variant_option_contents = App\Models\User\ProductVariantOptionContent::where('product_variant_option_id', $variant_content_option->id)->first();
            }

            $opt_name = '';
            if ($variant_option_contents) {
                if ($variant_option_contents->option_content) {
                    $opt_name = $variant_option_contents->option_content->option_name;
                } elseif (!empty($variant_option_contents->option_name)) {
                    $vContent = App\Models\VariantOptionContent::find($variant_option_contents->option_name);
                    $opt_name = $vContent ? $vContent->option_name : $variant_option_contents->option_name;
                }
            }

            $sup_option_content = make_input_name($opt_name);
            $id_name = make_input_name($opt_name);
            $main_id = $sup_option_content . '_' . $id_name . '_' . $variant_content_option->id;
            $opt_group_name = !empty($variant_content->name) ? $variant_content->name : 'Option ' . $product_variation->id;
            $colorHex = ($isColor || !empty(getColorHex($opt_name))) ? getColorHex($opt_name) : null;
          @endphp
          <div class="variant-item-wrap">
            <input class="voptions custom-variant-radio" data-option_id="{{ $variant_content_option->id }}"
              data-variation_id="{{ $product_variation->id }}" data-option="{{ $opt_group_name }}"
              data-name="{{ $opt_name }}"
              data-price="{{ currency_converter($variant_content_option->price) }}"
              data-stock="{{ $variant_content_option->stock }}" type="radio"
              name="{{ make_input_name($opt_group_name) }}[]" value=""
              id="voptions_{{ $main_id }}">
            @if ($isColor && $colorHex)
              <label class="variant-color-swatch" for="voptions_{{ $main_id }}" title="{{ $opt_name }}" data-bs-toggle="tooltip">
                <span class="color-circle" style="background-color: {{ $colorHex }};"></span>
              </label>
            @else
              <label class="variant-pill-btn" for="voptions_{{ $main_id }}">
                <span class="variant-text">{{ $opt_name }}</span>
              </label>
            @endif
          </div>
        @endforeach
      </div>
    </div>
  @endif
@endforeach
@if (empty($seen_variations))
  <h4 class="text-center">{{ $keywords['No Variation Found'] ?? __('No Variation Found') }}</h4>
@endif
