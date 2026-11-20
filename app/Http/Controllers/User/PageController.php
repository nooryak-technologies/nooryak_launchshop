<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\User\Language;
use App\Models\User\UserPage;
use App\Models\User\UserPageContent;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Purifier;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $lang = Language::where('code', $request->language)->where('user_id', $user_id)->firstOrFail();
        $lang_id = $lang->id;

        // Ensure default dynamic policy pages (Privacy, Terms, Shipping, Return) exist for this merchant
        $this->ensureDefaultPolicyPagesExist($user_id, $lang_id);

        $apages = UserPage::join('user_page_contents', 'user_page_contents.page_id', 'user_pages.id')
            ->where('user_page_contents.language_id', $lang->id)
            ->where('user_pages.user_id', $user_id)
            ->select('user_pages.*', 'user_page_contents.title', 'user_page_contents.slug')
            ->orderBy('user_pages.serial_number', 'asc')
            ->orderBy('user_pages.created_at', 'desc')
            ->get();
        $data['apages']  = $apages;

        $data['lang_id'] = $lang_id;


        $current_package = UserPermissionHelper::currentPackagePermission(Auth::guard('web')->user()->id);
        $features = json_decode($current_package->features, true);
        if (is_array($features) && in_array("Custom Page", $features)) {
            $data['custom_page_limit'] = $current_package->number_of_custom_page;
            return view('user.page.index', $data);
        } else {
            return redirect('user-dashboard');
        }
    }

    public function create()
    {
        $user_id = Auth::guard('web')->user()->id;
        $data['de_lang'] = Language::where('is_default', 1)->where('user_id', $user_id)->firstOrFail();

        $current_package = UserPermissionHelper::currentPackagePermission(Auth::guard('web')->user()->id);
        $features = json_decode($current_package->features, true);
        if (is_array($features) && in_array("Custom Page", $features)) {
            $c_pages = UserPage::where('user_id', Auth::guard('web')->user()->id)->count();
            if ($c_pages > $current_package->number_of_custom_page) {
                Session::flash('warning', __('Delete Additional Page to Create New Page!'));
                return redirect()->route('user.page.index', ['language' => $data['de_lang']->code])->with('success');
            }
        }

        $data['userLangs'] = Language::where('user_id', $user_id)->get();
        return view('user.page.create', $data);
    }

    public function store(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;

        $rules = [
            'status' => 'required',
            'serial_number' => 'required'
        ];

        $languages = Language::where('user_id', $user_id)->get();
        // $defaulLang = Language::where('user_id', Auth::guard('web')->user()->id)
        //     ->where('is_default', 1)
        //     ->first();
        // $rules[$defaulLang->code . '_title'] = 'required';
        // $rules[$defaulLang->code . '_body'] = 'required';
        // $slug = make_slug($request[$defaulLang->code . '_title']);
        // $rules[$defaulLang->code . '_title'] = [
        //     'required',
        //     'max:255',
        //     function ($attribute, $value, $fail) use ($slug, $defaulLang, $user_id) {
        //         $bis = UserPageContent::where('language_id', $defaulLang->id)->where('user_id', $user_id)->get();
        //         foreach ($bis as $key => $bi) {
        //             if (strtolower($slug) == strtolower($bi->slug)) {
        //                 $fail(__('The title field must be unique for') . ' ' . $defaulLang->name . ' ' . __('language'));
        //             }
        //         }
        //     }
        // ];


        foreach ($languages as $language) {
            $code = $language->code;
            $langaugeName = ' ' . $language->name . ' ' . __('language');

            if (
                $language->is_default == 1 ||
                $request->input($code . '_title') ||
                $request->input($code . '_body')
            ) {
                $rules[$code . '_title'] = 'required';
                $rules[$code . '_body'] = 'required';
                $slug = make_slug($request[$code . '_title']);
                $rules[$code . '_title'] = [
                    'required',
                    'max:255',
                    function ($attribute, $value, $fail) use ($slug, $language, $user_id) {
                        $bis = UserPageContent::where('language_id', $language->id)->where('user_id', $user_id)->get();
                        foreach ($bis as $key => $bi) {
                            if (strtolower($slug) == strtolower($bi->slug)) {
                                $fail(__('The title field must be unique for') . ' ' . $language->name . ' ' . __('language'));
                            }
                        }
                    }
                ];
            }

            $messages[$code . '_title.required'] = __('The title field is required') . $langaugeName;;
            $messages[$code . '_body.required'] = __('The body field is required') . $langaugeName;;
            $messages[$code . '_title.unique'] = __('The title field must be unique for') . $langaugeName;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $in = $request->all();
        $in['user_id'] = $user_id;
        $page = UserPage::create($in);

        foreach ($languages as $language) {
            if (
                $language->is_default == 1 ||
                $request->input($code . '_title') ||
                $request->input($code . '_body')
            ) {
                $pageContent = new UserPageContent();
                $pageContent->page_id = $page->id;
                $pageContent->user_id = $user_id;
                $pageContent->language_id = $language->id;
                $pageContent->title = $request[$language->code . '_title'];
                $pageContent->slug = make_slug($request[$language->code . '_title']);
                $pageContent->body = Purifier::clean($request[$language->code . '_body'], 'youtube');
                $pageContent->save();
            }
        }

        Session::flash('success', __('Created successfully'));
        return "success";
    }

    public function edit($pageID)
    {
        $current_package = UserPermissionHelper::currentPackagePermission(Auth::guard('web')->user()->id);
        $features = json_decode($current_package->features, true);
        if (is_array($features) && in_array("Custom Page", $features)) {
            $c_pages = UserPage::where('user_id', Auth::guard('web')->user()->id)->count();
            if ($c_pages > $current_package->number_of_custom_page) {
                Session::flash('warning', __('Delete page to enable editing'));
                return redirect()->back()->with('success');
            }
        }

        $user_id  = Auth::guard('web')->user()->id;
        $data['page'] = UserPage::where([['user_id', $user_id], ['id', $pageID]])->firstOrFail();
        $data['de_lang'] = Language::where('is_default', 1)->where('user_id', $user_id)->firstOrFail();
        $data['userLangs'] = Language::where('user_id', $user_id)->get();
        return view('user.page.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::guard('web')->user()->id;
        $rules = [
            'status' => 'required',
            'serial_number' => 'required'
        ];

        $languages = Language::where('user_id', $user_id)->get();
        // $defaulLang = Language::where('user_id', Auth::guard('web')->user()->id)
        //     ->where('is_default', 1)
        //     ->first();
        // $rules[$defaulLang->code . '_title'] = 'required';
        // $rules[$defaulLang->code . '_body'] = 'required';
        // $slug = make_slug($request[$defaulLang->code . '_title']);
        // $rules[$defaulLang->code . '_title'] = [
        //     'required',
        //     'max:255',
        //     function ($attribute, $value, $fail) use ($slug, $defaulLang, $user_id) {
        //         $bis = UserPageContent::where('language_id', $defaulLang->id)->where('user_id', $user_id)->get();
        //         foreach ($bis as $key => $bi) {
        //             if (strtolower($slug) == strtolower($bi->slug)) {
        //                 $fail(__('The title field must be unique for') . ' ' . $defaulLang->name . ' ' . __('language'));
        //             }
        //         }
        //     }
        // ];


        foreach ($languages as $language) {
            $code = $language->code;
            $langaugeName = ' ' . $language->name . ' ' . __('language');

            if (
                $language->is_default == 1 ||
                $request->input($code . '_title') ||
                $request->input($code . '_body')
            ) {
                $rules[$code . '_title'] = 'required';
                $rules[$code . '_body'] = 'required';
                $slug = make_slug($request[$code . '_title']);
                $rules[$code . '_title'] = [
                    'required',
                    'max:255',
                    function ($attribute, $value, $fail) use ($slug, $language, $user_id, $id) {
                        $bis = UserPageContent::where('language_id', $language->id)->where('user_id', $user_id)->where('page_id', '<>', $id)->get();
                        foreach ($bis as $key => $bi) {
                            if (strtolower($slug) == strtolower($bi->slug)) {
                                $fail(__('The title field must be unique for') . ' ' . $language->name . ' ' . __('language'));
                            }
                        }
                    }
                ];
            }

            $messages[$code . '_title.required'] = __('The title field is required') . $langaugeName;;
            $messages[$code . '_body.required'] = __('The body field is required') . $langaugeName;;
            $messages[$code . '_title.unique'] = __('The title field must be unique for') . $langaugeName;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $in = $request->all();

        $page = UserPage::where([['id', $id], ['user_id', $user_id]])->firstOrFail();
        $page->update($in);

        foreach ($languages as $language) {
            $pageContent = UserPageContent::where([['page_id', $page->id], ['language_id', $language->id]])->first();
            if (empty($pageContent)) {
                $pageContent = new UserPageContent();
                $pageContent->page_id = $page->id;
                $pageContent->user_id = $user_id;
                $pageContent->language_id = $language->id;
            }
            if (
                // empty($pageContent) ||
                $language->is_default == 1 ||
                $request->input($code . '_title') ||
                $request->input($code . '_body')
            ) {
                $pageContent->title = $request[$language->code . '_title'];
                $pageContent->slug = make_slug($request[$language->code . '_title']);
                $pageContent->body = Purifier::clean($request[$language->code . '_body'], 'youtube');
                $pageContent->save();
            }
        }
        Session::flash('success', __('Updated Successfully'));
        return "success";
    }

    public function delete(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $pageID = $request->pageid;

        $page = UserPage::where([['id', $pageID], ['user_id', $user_id]])->first();
        if (!$page) {
            Session::flash('warning', __('Page not found'));
            return redirect()->back();
        }

        $pageContents = UserPageContent::where('page_id', $pageID)->get();
        foreach ($pageContents as $pageContent) {
            if ($this->isProtectedPolicySlug($pageContent->slug)) {
                Session::flash('warning', __('Default policy pages (Privacy, Terms, Shipping, Return) required for payment gateways cannot be deleted. You can edit them at any time.'));
                return redirect()->back();
            }
        }

        foreach ($pageContents as $pageContent) {
            $pageContent->delete();
        }
        $page->delete();
        Session::flash('success', __('Deleted successfully'));
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        $user_id = Auth::guard('web')->user()->id;

        $hasProtected = false;
        foreach ($ids as $id) {
            $page = UserPage::where([['id', $id], ['user_id', $user_id]])->first();
            if (!$page) continue;

            $pageContents = UserPageContent::where('page_id', $id)->get();
            $isProtected = false;
            foreach ($pageContents as $pageContent) {
                if ($this->isProtectedPolicySlug($pageContent->slug)) {
                    $isProtected = true;
                    $hasProtected = true;
                    break;
                }
            }

            if ($isProtected) {
                continue;
            }

            foreach ($pageContents as $pageContent) {
                $pageContent->delete();
            }
            $page->delete();
        }

        if ($hasProtected) {
            Session::flash('warning', __('Default policy pages cannot be deleted. Other selected pages were deleted successfully.'));
        } else {
            Session::flash('success', __('Deleted successfully'));
        }
        return "success";
    }

    /**
     * Check if a page slug belongs to the required payment gateway default policy set.
     */
    public function isProtectedPolicySlug($slug)
    {
        $protected = [
            'privacy-policy',
            'terms-and-conditions',
            'terms-conditions',
            'shipping-policy',
            'shipping-and-delivery-policy',
            'return-policy',
            'refund-policy',
            'return-and-refund-policy'
        ];
        return in_array(strtolower(trim($slug)), $protected);
    }

    /**
     * Automatically seed or update default merchant policies with dynamic store info.
     */
    protected function ensureDefaultPolicyPagesExist($userId, $langId)
    {
        $user = \App\Models\User::find($userId);
        if (!$user) return;

        $shopName = !empty($user->shop_name) ? $user->shop_name : (!empty($user->username) ? $user->username : 'Our Store');
        $shopEmail = !empty($user->email) ? $user->email : 'support@launchshop.in';
        $shopPhone = !empty($user->phone) ? $user->phone : '';
        $shopAddress = !empty($user->address) ? $user->address : '';
        if (!empty($user->city)) {
            $shopAddress .= ($shopAddress ? ', ' : '') . $user->city;
        }
        if (!empty($user->country)) {
            $shopAddress .= ($shopAddress ? ', ' : '') . $user->country;
        }

        $policies = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'alt_slugs' => ['privacy-policy'],
                'body' => $this->getPrivacyPolicyTemplate($shopName, $shopEmail, $shopPhone, $shopAddress),
                'serial' => 1
            ],
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'alt_slugs' => ['terms-and-conditions', 'terms-conditions'],
                'body' => $this->getTermsConditionsTemplate($shopName, $shopEmail, $shopPhone, $shopAddress),
                'serial' => 2
            ],
            [
                'title' => 'Shipping Policy',
                'slug' => 'shipping-policy',
                'alt_slugs' => ['shipping-policy', 'shipping-and-delivery-policy'],
                'body' => $this->getShippingPolicyTemplate($shopName, $shopEmail, $shopPhone, $shopAddress),
                'serial' => 3
            ],
            [
                'title' => 'Return Policy',
                'slug' => 'return-policy',
                'alt_slugs' => ['return-policy', 'refund-policy', 'return-and-refund-policy'],
                'body' => $this->getReturnPolicyTemplate($shopName, $shopEmail, $shopPhone, $shopAddress),
                'serial' => 4
            ]
        ];

        foreach ($policies as $policy) {
            $existingContent = UserPageContent::where('user_id', $userId)
                ->whereIn('slug', $policy['alt_slugs'])
                ->first();

            if (!$existingContent) {
                $page = UserPage::create([
                    'user_id' => $userId,
                    'status' => 1,
                    'serial_number' => $policy['serial']
                ]);

                UserPageContent::create([
                    'page_id' => $page->id,
                    'user_id' => $userId,
                    'language_id' => $langId,
                    'title' => $policy['title'],
                    'slug' => $policy['slug'],
                    'body' => $policy['body']
                ]);
            } else {
                // If body is empty or blank, populate with dynamic template
                if (empty(trim(strip_tags($existingContent->body)))) {
                    $existingContent->body = $policy['body'];
                    $existingContent->save();
                }
            }
        }
    }

    protected function getPrivacyPolicyTemplate($shopName, $email, $phone, $address)
    {
        return '<h3>Privacy Policy for ' . htmlspecialchars($shopName) . '</h3>'
            . '<p>At <strong>' . htmlspecialchars($shopName) . '</strong>, accessible from our online store, the privacy of our visitors and customers is one of our main priorities. This Privacy Policy document outlines the types of information that is collected and recorded by us and how we use it.</p>'
            . '<h4>1. Information We Collect</h4>'
            . '<p>When you place an order or create an account, we may collect personal information including your full name, email address, phone number, shipping and billing address, and payment transaction details.</p>'
            . '<h4>2. How We Use Your Information</h4>'
            . '<ul>'
            . '<li>To process, fulfill, and ship your orders efficiently.</li>'
            . '<li>To send order confirmation and delivery status updates.</li>'
            . '<li>To provide customer support and respond to your inquiries.</li>'
            . '<li>To prevent fraudulent transactions and improve site security.</li>'
            . '</ul>'
            . '<h4>3. Information Sharing & Third Parties</h4>'
            . '<p>We do not sell, rent, or trade your personal data. Your shipping address and contact number are securely shared with authorized logistics partners (such as Shiprocket and registered delivery couriers) solely for delivering your purchases. Payment data is securely handled by PCI-DSS compliant payment gateways (such as Razorpay and UPI).</p>'
            . '<h4>4. Data Security</h4>'
            . '<p>We implement industry-standard technical and organizational security measures to protect your personal details against unauthorized access, loss, or misuse.</p>'
            . '<h4>5. Contact Us</h4>'
            . '<p>If you have any questions or concerns regarding our Privacy Policy, please contact our support team:</p>'
            . '<p><strong>Store:</strong> ' . htmlspecialchars($shopName) . '<br>'
            . ($email ? '<strong>Email:</strong> <a href="mailto:' . htmlspecialchars($email) . '">' . htmlspecialchars($email) . '</a><br>' : '')
            . ($phone ? '<strong>Phone:</strong> <a href="tel:' . htmlspecialchars($phone) . '">' . htmlspecialchars($phone) . '</a><br>' : '')
            . ($address ? '<strong>Address:</strong> ' . htmlspecialchars($address) : '')
            . '</p>';
    }

    protected function getTermsConditionsTemplate($shopName, $email, $phone, $address)
    {
        return '<h3>Terms and Conditions</h3>'
            . '<p>Welcome to <strong>' . htmlspecialchars($shopName) . '</strong>. By accessing or using our online store and purchasing our products, you agree to be bound by the following terms and conditions.</p>'
            . '<h4>1. General Conditions</h4>'
            . '<p>We reserve the right to refuse service to anyone for any reason at any time. Prices for our products are subject to change without notice. We reserve the right at any time to modify or discontinue any product or service without notice.</p>'
            . '<h4>2. Products & Pricing</h4>'
            . '<p>All descriptions of products or product pricing are subject to change at any time without notice at our sole discretion. We have made every effort to display as accurately as possible the colors and images of our products.</p>'
            . '<h4>3. Accuracy of Billing & Account Information</h4>'
            . '<p>You agree to provide current, complete, and accurate purchase and account information for all purchases made at our store. You agree to promptly update your account and other information, including your email address and phone numbers, so that we can complete your transactions and contact you as needed.</p>'
            . '<h4>4. Order Cancellations & Payments</h4>'
            . '<p>We reserve the right to limit or prohibit orders that, in our sole judgment, appear to be placed by dealers, resellers, or distributors. Payment must be received in full before an order is dispatched.</p>'
            . '<h4>5. Governing Law</h4>'
            . '<p>These Terms of Service and any separate agreements whereby we provide you services shall be governed by and construed in accordance with the laws of India.</p>'
            . '<h4>6. Contact Information</h4>'
            . '<p>Questions about the Terms and Conditions should be sent to:</p>'
            . '<p><strong>Store:</strong> ' . htmlspecialchars($shopName) . '<br>'
            . ($email ? '<strong>Email:</strong> <a href="mailto:' . htmlspecialchars($email) . '">' . htmlspecialchars($email) . '</a><br>' : '')
            . ($phone ? '<strong>Phone:</strong> <a href="tel:' . htmlspecialchars($phone) . '">' . htmlspecialchars($phone) . '</a><br>' : '')
            . ($address ? '<strong>Address:</strong> ' . htmlspecialchars($address) : '')
            . '</p>';
    }

    protected function getShippingPolicyTemplate($shopName, $email, $phone, $address)
    {
        return '<h3>Shipping & Delivery Policy</h3>'
            . '<p>Thank you for visiting and shopping at <strong>' . htmlspecialchars($shopName) . '</strong>. Following are the terms and conditions that constitute our Shipping Policy.</p>'
            . '<h4>1. Shipment Processing Time</h4>'
            . '<p>All orders are typically processed within 1–2 business days (excluding weekends and public holidays) after receiving your order confirmation email. You will receive another notification when your order has shipped.</p>'
            . '<h4>2. Shipping Rates & Delivery Estimates</h4>'
            . '<p>Shipping charges for your order will be calculated and displayed at checkout. Standard delivery within India usually takes between <strong>3 to 7 business days</strong> depending on the destination pincode and courier service availability.</p>'
            . '<h4>3. Shipment Confirmation & Order Tracking</h4>'
            . '<p>You will receive a shipment confirmation email or SMS containing your tracking number(s) once your order has shipped. The tracking number will be active within 24 hours via our logistics partners (e.g., Shiprocket / Bluedart / Delhivery / India Post).</p>'
            . '<h4>4. Damages & Lost Shipments</h4>'
            . '<p>If you receive your order damaged or suspect it was lost in transit, please contact us immediately with your order number and photographs of the damaged packaging and product so we can initiate a swift claim and replacement.</p>'
            . '<h4>5. Contact Us</h4>'
            . '<p>For any queries related to shipping and deliveries, please reach out to us:</p>'
            . '<p><strong>Store:</strong> ' . htmlspecialchars($shopName) . '<br>'
            . ($email ? '<strong>Email:</strong> <a href="mailto:' . htmlspecialchars($email) . '">' . htmlspecialchars($email) . '</a><br>' : '')
            . ($phone ? '<strong>Phone:</strong> <a href="tel:' . htmlspecialchars($phone) . '">' . htmlspecialchars($phone) . '</a><br>' : '')
            . ($address ? '<strong>Address:</strong> ' . htmlspecialchars($address) : '')
            . '</p>';
    }

    protected function getReturnPolicyTemplate($shopName, $email, $phone, $address)
    {
        return '<h3>Return & Refund Policy</h3>'
            . '<p>At <strong>' . htmlspecialchars($shopName) . '</strong>, we value our customers and strive to provide high-quality products. If you are not entirely satisfied with your purchase, we are here to help.</p>'
            . '<h4>1. Return Window</h4>'
            . '<p>Our return policy is valid for <strong>7 days</strong> from the date you receive your package. If 7 days have gone by since your delivery, unfortunately, we cannot offer you a return, refund, or exchange.</p>'
            . '<h4>2. Return Eligibility</h4>'
            . '<ul>'
            . '<li>The item must be unused, unwashed, and in the same condition that you received it.</li>'
            . '<li>The item must be in the original packaging with all brand tags and accessories intact.</li>'
            . '<li>A receipt or proof of purchase (Order ID) is required to complete your return.</li>'
            . '</ul>'
            . '<h4>3. Non-Returnable Items</h4>'
            . '<p>Certain types of goods are exempt from being returned, such as perishable items, personal care or hygiene products, and custom-made or personalized products, unless they arrived damaged or defective.</p>'
            . '<h4>4. Refund Process</h4>'
            . '<p>Once your return is received and inspected by our warehouse team, we will notify you of the approval or rejection of your refund. If approved, your refund will be processed back to your original method of payment (or via UPI/bank transfer) within <strong>5 to 7 business days</strong>.</p>'
            . '<h4>5. How to Initiate a Return</h4>'
            . '<p>To initiate a return or replacement, please contact our support team with your order number and details:</p>'
            . '<p><strong>Store:</strong> ' . htmlspecialchars($shopName) . '<br>'
            . ($email ? '<strong>Email:</strong> <a href="mailto:' . htmlspecialchars($email) . '">' . htmlspecialchars($email) . '</a><br>' : '')
            . ($phone ? '<strong>Phone:</strong> <a href="tel:' . htmlspecialchars($phone) . '">' . htmlspecialchars($phone) . '</a><br>' : '')
            . ($address ? '<strong>Address:</strong> ' . htmlspecialchars($address) : '')
            . '</p>';
    }
}
