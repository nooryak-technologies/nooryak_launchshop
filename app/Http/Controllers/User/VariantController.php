<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Language;
use App\Models\User\UserItemCategory;
use App\Models\User\UserItemSubCategory;
use App\Models\Variant;
use App\Models\VariantContent;
use App\Models\VariantOption;
use App\Models\VariantOptionContent;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Session;

class VariantController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $language = Language::where([['code', $request->language], ['user_id', $user_id]])->first();
        if (empty($language)) {
            $language = Language::where([['user_id', $user_id], ['is_default', 1]])->first();
        }
        if (empty($language)) {
            $language = Language::where('user_id', $user_id)->first();
        }
        $data['languages'] = Language::where('user_id', $user_id)->get();
        $data['variants'] = $language ? VariantContent::where([['user_id', $user_id], ['language_id', $language->id]])->orderBy('created_at', 'DESC')->get() : collect();

        return view('user.item.variant.index', $data);
    }

    public function create()
    {
        return view('user.item.variant.create');
    }

    public function get_subcategory(Request $request)
    {
        $subcategories = UserItemSubCategory::where('category_id', $request->category_id)->get();
        return $subcategories;
    }

    public function store(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $user_languages = Language::where('user_id', $user_id)->get();
        $defaultLang = Language::where('user_id', $user_id)->where('is_default', 1)->first()
            ?? Language::where('user_id', $user_id)->first();
        $defCode = $defaultLang ? $defaultLang->code : 'en';

        // Preprocess: Filter empty option names and auto-fill secondary languages from default language
        $reqData = $request->all();

        // Auto-fill variant names for secondary languages if empty
        if (!empty($reqData['variant_names'][$defCode])) {
            foreach ($user_languages as $lang) {
                if ($lang->code !== $defCode) {
                    if (empty($reqData['variant_names'][$lang->code]) || empty(array_filter((array)$reqData['variant_names'][$lang->code], 'strlen'))) {
                        $reqData['variant_names'][$lang->code] = $reqData['variant_names'][$defCode];
                    }
                }
            }
        }

        // Clean option names and auto-fill secondary languages
        if (!empty($reqData['option_names']) && is_array($reqData['option_names'])) {
            $cleanedOptions = [];
            $hasAnyOption = false;
            foreach ($reqData['option_names'] as $lCode => $groups) {
                if (is_array($groups)) {
                    foreach ($groups as $gKey => $vals) {
                        $filteredVals = array_filter((array)$vals, function($v) {
                            return !is_null($v) && trim($v) !== '';
                        });
                        if (!empty($filteredVals)) {
                            $hasAnyOption = true;
                            $cleanedOptions[$lCode][$gKey] = array_values($filteredVals);
                        }
                    }
                }
            }
            if ($hasAnyOption) {
                if (!empty($cleanedOptions[$defCode])) {
                    foreach ($user_languages as $lang) {
                        if ($lang->code !== $defCode) {
                            foreach ($cleanedOptions[$defCode] as $gKey => $vals) {
                                if (empty($cleanedOptions[$lang->code][$gKey])) {
                                    $cleanedOptions[$lang->code][$gKey] = $vals;
                                }
                            }
                        }
                    }
                }
                $reqData['option_names'] = $cleanedOptions;
            } else {
                unset($reqData['option_names']);
            }
        } else {
            unset($reqData['option_names']);
        }

        $request->replace($reqData);

        // Validation logic
        $validator = $this->getValidation($user_languages, $request);
        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        // Step 2: Save the Variant
        $variant = Variant::create(['user_id' => $user_id]);

        // Step 3: Save Variant Contents
        $d_category = UserItemCategory::where('id', $request->category_id)->first();
        $d_subcategory = UserItemSubCategory::where('id', $request->sub_category_id)->first();
        $category_unique_id = $d_category ? $d_category->unique_id : null;
        $subcategory_unique_id = $d_subcategory ? $d_subcategory->unique_id : null;

        foreach ($request->input('variant_names') as $languageCode => $variantNames) {
            if (empty(array_filter($variantNames, 'strlen'))) {
                continue;
            }
            $language = Language::where('code', $languageCode)->where('user_id', $user_id)->first();
            if (!$language) continue;

            $category = UserItemCategory::where('unique_id', $category_unique_id)
                ->where('language_id', $language->id)
                ->first();

            $subcategory = $subcategory_unique_id ?
                UserItemSubCategory::where('unique_id', $subcategory_unique_id)
                ->where('language_id', $language->id)
                ->first() : null;

            foreach ($variantNames as $index => $variantName) {
                if (empty($variantName)) continue;
                VariantContent::create([
                    'category_id' => $category->id ?? null,
                    'sub_category_id' => $subcategory->id ?? null,
                    'language_id' => $language->id,
                    'user_id' => $user_id,
                    'name' => $variantName,
                    'variant_id' => $variant->id
                ]);
            }

            if (isset($request->option_names[$languageCode]) && count($request->option_names[$languageCode]) > 0) {
                $variantOption = VariantOption::create([
                    'user_id' => $user_id,
                    'variant_id' => $variant->id
                ]);

                $optionColors = $request->input('option_colors', []);

                foreach ($request->option_names[$languageCode] as $key => $optionName) {
                    $options = is_array($optionName) ? $optionName : [$optionName];
                    $colorVal = $optionColors[$key] ?? null;
                    foreach ($options as $singleOption) {
                        if (empty($singleOption)) continue;
                        $this->saveVariantOptionContent(
                            $variant->id,
                            $variantOption->id,
                            $user_id,
                            $languageCode,
                            $singleOption,
                            $key,
                            $colorVal
                        );
                    }
                }
            }
        }

        Session::flash('success', __('Created successfully'));
        return response()->json([
            'status' => 'success',
            'url' => route('user.variant.index')
        ]);
    }

    public function edit($id)
    {
        $data['variant'] = Variant::where('id', $id)->firstOrFail();
        return view('user.item.variant.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::guard('web')->user()->id;
        $user_languages = Language::where('user_id', $user_id)->get();
        $defaultLang = Language::where('user_id', $user_id)->where('is_default', 1)->first()
            ?? Language::where('user_id', $user_id)->first();
        $defCode = $defaultLang ? $defaultLang->code : 'en';

        // Preprocess: Filter empty option names and auto-fill secondary languages from default language
        $reqData = $request->all();

        if (!empty($reqData['variant_names'][$defCode])) {
            foreach ($user_languages as $lang) {
                if ($lang->code !== $defCode) {
                    if (empty($reqData['variant_names'][$lang->code]) || empty(array_filter((array)$reqData['variant_names'][$lang->code], 'strlen'))) {
                        $reqData['variant_names'][$lang->code] = $reqData['variant_names'][$defCode];
                    }
                }
            }
        }

        if (!empty($reqData['option_names']) && is_array($reqData['option_names'])) {
            $cleanedOptions = [];
            $hasAnyOption = false;
            foreach ($reqData['option_names'] as $lCode => $groups) {
                if (is_array($groups)) {
                    foreach ($groups as $gKey => $vals) {
                        $filteredVals = array_filter((array)$vals, function($v) {
                            return !is_null($v) && trim($v) !== '';
                        });
                        if (!empty($filteredVals)) {
                            $hasAnyOption = true;
                            $cleanedOptions[$lCode][$gKey] = array_values($filteredVals);
                        }
                    }
                }
            }
            if ($hasAnyOption) {
                if (!empty($cleanedOptions[$defCode])) {
                    foreach ($user_languages as $lang) {
                        if ($lang->code !== $defCode) {
                            foreach ($cleanedOptions[$defCode] as $gKey => $vals) {
                                if (empty($cleanedOptions[$lang->code][$gKey])) {
                                    $cleanedOptions[$lang->code][$gKey] = $vals;
                                }
                            }
                        }
                    }
                }
                $reqData['option_names'] = $cleanedOptions;
            } else {
                unset($reqData['option_names']);
            }
        } else {
            unset($reqData['option_names']);
        }

        $request->replace($reqData);

        // Validation logic
        $validator = $this->getValidation($user_languages, $request);
        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        // Step 1: Update the Variant
        $variant = Variant::where('id', $id)->where('user_id', $user_id)->firstOrFail();

        $d_category = UserItemCategory::where('id', $request->category_id)->first();
        $d_subcategory = UserItemSubCategory::where('id', $request->sub_category_id)->first();
        $category_unique_id = $d_category ? $d_category->unique_id : null;
        $subcategory_unique_id = $d_subcategory ? $d_subcategory->unique_id : null;

        // Step 2: Update or Create Variant Contents
        foreach ($request->input('variant_names') as $languageCode => $variantNames) {
            // skip if no valid variant names for this language
            if (empty(array_filter($variantNames, 'strlen'))) {
                continue;
            }

            $language = Language::where([['code', $languageCode], ['user_id', $user_id]])->first();
            if (!$language) continue;
            $language_id = $language->id;
            $category = UserItemCategory::where([['unique_id', $category_unique_id], ['language_id', $language_id]])
                ->first();
            $subcategory = UserItemSubCategory::where([['unique_id', $subcategory_unique_id], ['language_id', $language_id]])->first() ?? NULL;

            //update or create variant contents
            foreach ($variantNames as $index => $variantName) {
                if (empty($variantName)) continue;

                VariantContent::updateOrCreate(
                    [
                        'variant_id' => $variant->id,
                        'language_id' => $language_id,
                        'user_id' => $user_id
                    ],
                    [
                        'category_id' => $category->id ?? null,
                        'sub_category_id' => $subcategory->id ?? null,
                        'name' => $variantName
                    ]
                );
            }
        }

        // Step 3: Update or Create Variant Options and Contents
        $variantOptions = $request->input('option_names');
        $optionColors = $request->input('option_colors', []);
        foreach ($variantOptions as $languageCode => $optionGroups) {
            foreach ($optionGroups as $key => $optionValues) {
                // Ensure $optionValues is an array
                $options = is_array($optionValues) ? $optionValues : [$optionValues];
                // Get or create the VariantOption model
                $variantOption = VariantOption::firstOrCreate([
                    'variant_id' => $variant->id,
                    'user_id' => $user_id,
                ]);

                $colorVal = $optionColors[$key] ?? null;

                foreach ($options as $optionName) {
                    if (empty($optionName)) continue;
                    $this->saveVariantOptionContent(
                        $variant->id,
                        $variantOption->id,
                        $user_id,
                        $languageCode,
                        $optionName,
                        $key,
                        $colorVal
                    );
                }
            }
        }

        Session::flash('success', __('Updated Successfully'));
        return "success";
    }

    private function saveVariantOptionContent($variant_id, $variantOptionId = null, $userId = null, $languageCode = null, $optionName = null, $key = null, $colorVal = null)
    {
        $lang = \App\Models\User\Language::where([['code', $languageCode], ['user_id', $userId]])->first();
        if (!$lang) return;

        $conditions = [
            'variant_id' => $variant_id,
            'language_id' => $lang->id,
            'index_key' => $key,
            'user_id' => $userId
        ];
        // Add the variant_option_id only if it's not null
        if ($variantOptionId != null) {
            $conditions['variant_option_id'] = $variantOptionId;
        }
        $variantOptionContent = VariantOptionContent::firstOrNew($conditions);
        $variantOptionContent->option_name = $optionName;

        // Resolve color code: use explicit colorVal or infer from optionName
        $finalColor = !empty($colorVal) ? trim($colorVal) : null;
        if (empty($finalColor) && function_exists('getColorHex')) {
            $finalColor = getColorHex($optionName);
        }
        if (!empty($finalColor)) {
            $variantOptionContent->color_code = $finalColor;
        }

        try {
            $variantOptionContent->save();
        } catch (\Exception $e) {
            unset($variantOptionContent->color_code);
            $variantOptionContent->save();
        }

        if (!empty($finalColor) && $variantOptionId != null) {
            try {
                $variantOpt = VariantOption::find($variantOptionId);
                if ($variantOpt) {
                    $variantOpt->color_code = $finalColor;
                    $variantOpt->save();
                }
            } catch (\Exception $e) {}
        }
    }

    public function delete($id)
    {
        $user_id = Auth::guard('web')->user()->id;
        $variant = Variant::where('id', $id)->where('user_id', $user_id)->first();
        if (!$variant) {
            $variantContent = VariantContent::where('variant_id', $id)->where('user_id', $user_id)->first();
            if (!$variantContent) {
                $variantContent = VariantContent::where('id', $id)->where('user_id', $user_id)->first();
            }
            if ($variantContent) {
                $variant = Variant::where('id', $variantContent->variant_id)->first();
            }
        }

        if ($variant) {
            VariantContent::where('variant_id', $variant->id)->delete();
            $variant_options = VariantOption::where('variant_id', $variant->id)->get();
            foreach ($variant_options as $variant_option) {
                VariantOptionContent::where('variant_option_id', $variant_option->id)->delete();
                $variant_option->delete();
            }
            VariantOptionContent::where('variant_id', $variant->id)->delete();
            $variant->delete();
            Session::flash('success', __('Deleted successfully'));
        } else {
            Session::flash('warning', __('Variant not found'));
        }

        return back();
    }

    public function bulk_delete(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $ids = $request->ids;

        if (is_array($ids)) {
            foreach ($ids as $id) {
                $variant = Variant::where('id', $id)->where('user_id', $user_id)->first();
                if (!$variant) {
                    $variantContent = VariantContent::where('variant_id', $id)->where('user_id', $user_id)->first();
                    if (!$variantContent) {
                        $variantContent = VariantContent::where('id', $id)->where('user_id', $user_id)->first();
                    }
                    if ($variantContent) {
                        $variant = Variant::where('id', $variantContent->variant_id)->first();
                    }
                }
                if ($variant) {
                    VariantContent::where('variant_id', $variant->id)->delete();
                    $variant_options = VariantOption::where('variant_id', $variant->id)->get();
                    foreach ($variant_options as $variant_option) {
                        VariantOptionContent::where('variant_option_id', $variant_option->id)->delete();
                        $variant_option->delete();
                    }
                    VariantOptionContent::where('variant_id', $variant->id)->delete();
                    $variant->delete();
                }
            }
            Session::flash('success', __('Deleted successfully'));
        }
        return 'success';
    }

    public function delete_option(Request $request)
    {
        $options = VariantOptionContent::where('index_key', $request->index)->get();
        foreach ($options as $option) {
            $option->delete();
        }
        return 'success';
    }

    public function getValidation($user_languages, $request)
    {
        $defaultLang = null;
        foreach ($user_languages as $ul) {
            if ($ul->is_default == 1) {
                $defaultLang = $ul;
                break;
            }
        }
        if (!$defaultLang && count($user_languages) > 0) {
            $defaultLang = $user_languages[0];
        }
        $defCode = $defaultLang ? $defaultLang->code : 'en';

        $rules = [
            'category_id' => 'nullable',
            "variant_names.{$defCode}" => 'required|array|min:1',
            "variant_names.{$defCode}.*" => 'required',
        ];
        $messages = [
            "variant_names.{$defCode}.*.required" => __('The variant name is required.'),
            "variant_names.{$defCode}.required" => __('The variant name is required.'),
        ];

        // Options are optional. If option rows exist, only require them if non-empty
        if ($request->has("option_names.{$defCode}") && is_array($request->input("option_names.{$defCode}"))) {
            $rules["option_names.{$defCode}.*.*"] = 'nullable';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        return $validator;
    }
}
