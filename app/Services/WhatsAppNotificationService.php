<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppNotificationService
{
    /**
     * Default constants and fallbacks
     */
    const DEFAULT_GATEWAY_URL = 'http://localhost:8000';
    const DEFAULT_ACCESS_TOKEN = '6005c0f6de385fe7';
    const DEFAULT_INSTANCE_ID = 'E351BB42DC82';
    const DEFAULT_DB_NAME = 'nooryak_whatautomation';

    const DEFAULT_OTP_TEMPLATE = "Your OTP verification code is *{otp}* for *{product_name}* - This code is valid for *{validity_minutes} minutes* - Please do not share it with anyone.";
    
    const DEFAULT_CREDENTIALS_TEMPLATE = "🎉 *Congratulations! Your {product_name} store is live!*\n\nYour store account has been created successfully.\n\n👤 *Store Name:* {store_name}\n📧 *Email / Username:* {email}\n🔑 *Password:* {password}\n📦 *Plan:* {plan_name}\n\n🔗 *Store Live URL:*\n{store_url}\n\n🔐 *Dashboard Login:*\n{login_url}\n\nNeed help? Reply to this message anytime.\n– Team {product_name} 🚀";

    const DEFAULT_INVOICE_TEMPLATE = "🧾 *Payment Receipt / Invoice Confirmation*\n\nThank you for your payment with *{product_name}*!\n\n📄 *Invoice / Order ID:* #{invoice_id}\n📦 *Plan / Product:* {plan_title}\n💰 *Amount Paid:* {amount}\n💳 *Payment Method:* {payment_method}\n\n🔗 *View / Download Invoice:*\n{invoice_url}\n\nThank you for choosing *{product_name}*! 🚀";

    const DEFAULT_EXPIRY_WARNING_TEMPLATE = "⚠️ *Subscription Expiry Notice*\n\nHello *{user_name}*,\n\nYour *{product_name}* subscription ({plan_name}) will expire in *{days_left}* on *{expire_date}*.\n\nTo ensure your store and services remain active without interruption, please renew your plan now:\n\n🔗 *Renew / Extend Plan:*\n{renewal_url}\n\nNeed assistance? Reply to this message anytime.\n– Team {product_name} 🚀";

    const DEFAULT_RENEWAL_TEMPLATE = "🎉 *Congratulations {customer_name}! Your plan has been renewed!*\n\nYour *{product_name}* subscription (*{plan_name}*) has been renewed successfully.\n\n📅 *New Expiry Date:* {expire_date}\n✨ *Status:* Fully Active\n🌐 All website features, editor navigation, and services are now fully unlocked.\n\nThank you for choosing *{product_name}*! 🚀";

    /**
     * Get the default WhatsApp gateway endpoint base URL.
     */
    public static function getEndpoint(): string
    {
        return env('WHATSAPP_SERVER_URL', self::DEFAULT_GATEWAY_URL);
    }

    /**
     * Get the default WhatsApp API token.
     */
    public static function getAccessToken(): string
    {
        return env('WHATSAPP_ACCESS_TOKEN', self::DEFAULT_ACCESS_TOKEN);
    }

    /**
     * Get the default WhatsApp active instance ID.
     */
    public static function getInstanceId(): string
    {
        return env('WHATSAPP_INSTANCE_ID', self::DEFAULT_INSTANCE_ID);
    }

    /**
     * Get the target database for Universal 1-Node Server.
     */
    public static function getDatabaseName(): string
    {
        return env('WHATSAPP_DB', self::DEFAULT_DB_NAME);
    }

    /**
     * Resolve WhatsApp Gateway configuration for LaunchShop.
     */
    public static function getWhatsAppConfig(): array
    {
        $cacheKey = 'whatsapp_gateway_config_launchshop';
        $cached = Cache::get($cacheKey);
        if ($cached && is_array($cached) && !empty($cached['instance_id'])) {
            return $cached;
        }

        $config = [
            'endpoint' => self::getEndpoint(),
            'access_token' => self::getAccessToken(),
            'instance_id' => self::getInstanceId(),
            'db' => self::getDatabaseName(),

            'is_active' => (int)env('WHATSAPP_NOTIFICATIONS_ENABLED', 1),
            'otp_active' => (int)env('WHATSAPP_OTP_ENABLED', 1),
            'credentials_active' => (int)env('WHATSAPP_CREDENTIALS_ENABLED', 1),
            'invoice_active' => (int)env('WHATSAPP_INVOICE_ENABLED', 1),

            'otp_template' => env('WHATSAPP_OTP_TEMPLATE', self::DEFAULT_OTP_TEMPLATE),
            'credentials_template' => env('WHATSAPP_CREDENTIALS_TEMPLATE', self::DEFAULT_CREDENTIALS_TEMPLATE),
            'invoice_template' => env('WHATSAPP_INVOICE_TEMPLATE', self::DEFAULT_INVOICE_TEMPLATE),
        ];

        try {
            Cache::put($cacheKey, $config, 300);
        } catch (\Throwable $e) {}

        return $config;
    }

    /**
     * Dynamically resolve currently active instance & access token:
     * 1. Asks the local Node server (/active_instance)
     * 2. Checks WhatsApp MySQL database (accounts table with status=1)
     * 3. Falls back to config or default
     */
    public static function resolveActiveCredentials(?string $customDb = null, ?string $customEndpoint = null): array
    {
        $resolvedDb = $customDb ?: self::getDatabaseName();
        $endpointBase = rtrim($customEndpoint ?: self::getEndpoint(), '/');

        $cacheKey = 'dynamic_whatsapp_credentials_' . md5($resolvedDb . $endpointBase);
        $cached = Cache::get($cacheKey);
        if (!empty($cached['instance_id']) && !empty($cached['access_token'])) {
            return $cached;
        }

        $resolvedInstance = null;
        $resolvedToken = null;

        // Method 1: Ask Node engine on port 8000
        try {
            $nodeUrl = $endpointBase . '/active_instance?db=' . urlencode($resolvedDb);
            $res = Http::timeout(2)->withoutVerifying()->get($nodeUrl);
            if ($res->successful()) {
                $data = $res->json();
                if (($data['status'] ?? '') === 'success' && !empty($data['instance_id'])) {
                    $resolvedInstance = $data['instance_id'];
                    $resolvedToken = $data['access_token'] ?: self::getAccessToken();
                    $resolvedDb = $data['db'] ?: $resolvedDb;
                }
            }
        } catch (\Throwable $e) {}

        // Method 2: Query MySQL database directly for active account (status = 1)
        if (empty($resolvedInstance)) {
            $dbNames = [
                $resolvedDb,
                'nooryak_whatautomation',
                'replix_automation',
            ];

            $host = env('DB_HOST', '127.0.0.1');
            $port = env('DB_PORT', '3306');
            $user = env('DB_USERNAME_admin', env('DB_USERNAME', 'root'));
            $pass = env('DB_PASSWORD_admin', env('DB_PASSWORD', ''));

            foreach ($dbNames as $dbName) {
                try {
                    $pdo = new \PDO("mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4", $user, $pass, [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_SILENT,
                        \PDO::ATTR_TIMEOUT => 2,
                    ]);

                    $stmt = $pdo->query("SELECT token, team_id, name FROM accounts WHERE status = 1 AND social_network = 'whatsapp_unofficial' AND category = 'profile' ORDER BY id DESC LIMIT 1");
                    $acc = $stmt ? $stmt->fetch(\PDO::FETCH_ASSOC) : null;

                    if ($acc && !empty($acc['token'])) {
                        $resolvedInstance = $acc['token'];
                        $resolvedDb = $dbName;

                        if (!empty($acc['team_id'])) {
                            $tStmt = $pdo->prepare("SELECT id_secure FROM teams WHERE id = ? LIMIT 1");
                            $tStmt->execute([$acc['team_id']]);
                            $tRow = $tStmt->fetch(\PDO::FETCH_ASSOC);
                            if ($tRow && !empty($tRow['id_secure'])) {
                                $resolvedToken = $tRow['id_secure'];
                            }
                        }
                        break;
                    }
                } catch (\Throwable $ex) {}
            }
        }

        if (empty($resolvedInstance)) {
            $resolvedInstance = self::getInstanceId();
        }
        if (empty($resolvedToken)) {
            $resolvedToken = self::getAccessToken();
        }

        $credentials = [
            'instance_id'  => $resolvedInstance,
            'access_token' => $resolvedToken,
            'db'           => $resolvedDb,
        ];

        try {
            Cache::put($cacheKey, $credentials, 60);
        } catch (\Throwable $cEx) {}

        return $credentials;
    }

    /**
     * Clean and format phone number into international numeric format.
     */
    public static function formatNumber($phone, string $defaultCountryCode = '91'): string
    {
        if (empty($phone)) {
            return '';
        }

        $digits = preg_replace('/[^0-9]/', '', (string) $phone);
        if ($digits === '') {
            return '';
        }

        $cleanCode = preg_replace('/[^0-9]/', '', $defaultCountryCode) ?: '91';

        if (strpos($digits, $cleanCode . '0') === 0 && strlen($digits) === (strlen($cleanCode) + 11)) {
            $digits = $cleanCode . substr($digits, strlen($cleanCode) + 1);
        }

        $trimmed = ltrim($digits, '0');

        if (strlen($trimmed) === 10) {
            return $cleanCode . $trimmed;
        }

        if (strpos($trimmed, $cleanCode) === 0 && strlen($trimmed) === (strlen($cleanCode) + 10)) {
            return $trimmed;
        }

        if (strlen($digits) === 11 && strpos($digits, '0') === 0) {
            return $cleanCode . substr($digits, 1);
        }

        return $trimmed ?: $digits;
    }

    /**
     * Send arbitrary message or media via WhatsApp Gateway.
     */
    public static function sendMessage(
        $phone,
        string $message,
        ?string $mediaUrl = null,
        ?string $filename = null,
        ?array $customConfig = null
    ): array {
        $formattedNumber = self::formatNumber($phone);
        if (empty($formattedNumber)) {
            Log::warning("WhatsAppNotificationService: Cannot send message, phone number is empty or invalid. Input: {$phone}");
            return [
                'success' => false,
                'message' => 'Invalid or empty phone number.',
            ];
        }

        $config = $customConfig ?: self::getWhatsAppConfig();

        if (empty($config['is_active'])) {
            Log::info("WhatsAppNotificationService: WhatsApp notifications are toggled OFF in settings. Skipping.");
            return [
                'success' => false,
                'skipped' => true,
                'message' => 'WhatsApp gateway is disabled in settings.',
            ];
        }

        $configuredEndpoint = rtrim($config['endpoint'] ?: self::getEndpoint(), '/');
        $endpointCandidates = array_values(array_unique(array_filter([
            'http://127.0.0.1:8000',
            $configuredEndpoint,
            'http://localhost:8000',
            env('WHATSAPP_SERVER_URL', 'http://127.0.0.1:8000'),
        ])));

        // Check if explicit instance and token were supplied
        $accessToken = $config['access_token'] ?: self::getAccessToken();
        $instanceId = $config['instance_id'] ?: self::getInstanceId();
        $dbName = $config['db'] ?: self::getDatabaseName();

        // If instance was default or empty, attempt dynamic discovery
        if (empty($instanceId) || $instanceId === self::DEFAULT_INSTANCE_ID) {
            $activeCreds = self::resolveActiveCredentials($dbName, $configuredEndpoint);
            $accessToken = $activeCreds['access_token'] ?: $accessToken;
            $instanceId = $activeCreds['instance_id'] ?: $instanceId;
            $dbName = $activeCreds['db'] ?: $dbName;
        }

        $tokensToTry = array_values(array_unique(array_filter([
            $accessToken,
            str_starts_with($accessToken, 'token_') ? substr($accessToken, 6) : (str_starts_with($accessToken, 'team_') ? $accessToken : 'token_' . $accessToken),
        ])));

        $instancesToTry = array_values(array_unique(array_filter([
            $instanceId,
        ])));
        if (empty($instancesToTry)) {
            $instancesToTry = array_filter([self::getInstanceId()]);
        }

        $lastResult = [
            'success' => false,
            'message' => 'No delivery attempt completed.',
        ];

        foreach ($endpointCandidates as $candEndpoint) {
            $sendPath = rtrim($candEndpoint, '/') . '/send_message';
            foreach ($instancesToTry as $currentInstance) {
                foreach ($tokensToTry as $currentToken) {
                    $queryUrl = $sendPath . '?' . http_build_query([
                        'access_token' => $currentToken,
                        'instance_id'  => $currentInstance,
                        'db'           => $dbName,
                    ]);

                $payload = [
                    'access_token' => $currentToken,
                    'instance_id'  => $currentInstance,
                    'number'       => $formattedNumber,
                    'message'      => $message,
                    'caption'      => $message,
                    'db'           => $dbName,
                ];

                if (!empty($mediaUrl)) {
                    $payload['media_url'] = $mediaUrl;
                    if (!empty($filename)) {
                        $payload['filename'] = $filename;
                    }
                }

                $logPrefix = "[" . date('Y-m-d H:i:s') . "] [WhatsAppGateway] Number: {$formattedNumber} | Instance: {$currentInstance} | ";

                try {
                    $response = Http::asForm()
                        ->timeout(12)
                        ->withoutVerifying()
                        ->post($queryUrl, $payload);

                    $status  = $response->status();
                    $body    = $response->json();
                    $bodyStr = $response->body();

                    $isSuccess = $response->successful() && (
                        ($body['status'] ?? '') === 'success' ||
                        ($body['status'] ?? '') === 1 ||
                        ($body['status'] ?? '') === true ||
                        ($body['success'] ?? false) === true ||
                        !empty($body['data']['key']['id']) ||
                        !empty($body['message_id'])
                    );

                    $logLine = $logPrefix . "Status: {$status} | Success: " . ($isSuccess ? 'YES' : 'NO') . " | Response: {$bodyStr}\n";

                    try {
                        @file_put_contents(storage_path('logs/whatsapp_gateway.log'), $logLine, FILE_APPEND);
                    } catch (\Throwable $fEx) {}

                    Log::info("WhatsApp Gateway Response for {$formattedNumber}: {$bodyStr}");

                    if ($isSuccess) {
                        return [
                            'success'     => true,
                            'status'      => $status,
                            'response'    => $body,
                            'body'        => $bodyStr,
                            'instance_id' => $currentInstance,
                        ];
                    }

                    $lastResult = [
                        'success'     => false,
                        'status'      => $status,
                        'response'    => $body,
                        'message'     => $body['message'] ?? 'Gateway returned failure.',
                        'body'        => $bodyStr,
                        'instance_id' => $currentInstance,
                    ];

                    $msgLower = strtolower($body['message'] ?? '');
                    if (!str_contains($msgLower, 'token') && !str_contains($msgLower, 'instance') && !str_contains($msgLower, 'auth')) {
                        return $lastResult;
                    }
                } catch (\Throwable $e) {
                    $errLine = $logPrefix . "EXCEPTION: " . $e->getMessage() . "\n";
                    try {
                        @file_put_contents(storage_path('logs/whatsapp_gateway.log'), $errLine, FILE_APPEND);
                    } catch (\Throwable $fEx) {}

                    Log::error("WhatsApp Gateway Exception for {$formattedNumber}: " . $e->getMessage());

                    $lastResult = [
                        'success' => false,
                        'message' => $e->getMessage(),
                    ];
                }
            }
        }
        }

        return $lastResult;
    }

    /**
     * Send OTP Verification Code via WhatsApp using dynamic templates and placeholders.
     */
    public static function sendOtp($phone, $otp, string $productName = 'LaunchShop'): array
    {
        $cleanProductName = 'LaunchShop';

        $config = self::getWhatsAppConfig();

        if (empty($config['is_active']) || empty($config['otp_active'])) {
            Log::info("WhatsAppNotificationService: OTP notifications toggled OFF in settings. Skipping.");
            return [
                'success' => false,
                'skipped' => true,
                'message' => 'WhatsApp OTP notifications are disabled.',
            ];
        }

        $template = !empty($config['otp_template']) ? $config['otp_template'] : self::DEFAULT_OTP_TEMPLATE;

        $productDisplayName = 'LaunchShop';
        $message = str_replace(
            ['{otp}', '{product_name}', '{validity_minutes}*', '{validity_minutes}'],
            [$otp, $productDisplayName, '5', '5'],
            $template
        );

        return self::sendMessage($phone, $message, null, null, $config);
    }

    /**
     * Send Website Launch / Store Credentials via WhatsApp using dynamic templates and placeholders.
     */
    public static function sendWebsiteLaunchCredentials(
        $phone,
        string $storeName,
        string $storeLiveLink,
        string $loginLink,
        string $email,
        string $password,
        ?string $planName = null,
        string $productName = 'LaunchShop'
    ): array {
        $config = self::getWhatsAppConfig();

        if (empty($config['is_active']) || empty($config['credentials_active'])) {
            Log::info("WhatsAppNotificationService: Website Launch credentials notifications toggled OFF in settings. Skipping.");
            return [
                'success' => false,
                'skipped' => true,
                'message' => 'WhatsApp Store Credentials notifications are disabled.',
            ];
        }

        $template = !empty($config['credentials_template']) ? $config['credentials_template'] : self::DEFAULT_CREDENTIALS_TEMPLATE;

        $message = str_replace(
            ['{user_name}', '{store_name}', '{email}', '{password}', '{store_url}', '{login_url}', '{product_name}', '{plan_name}'],
            [$storeName, $storeName, $email, $password, $storeLiveLink, $loginLink, $productName, $planName ?: 'Standard Plan'],
            $template
        );

        return self::sendMessage($phone, $message, null, null, $config);
    }

    /**
     * Send Payment Receipt / Invoice Confirmation via WhatsApp using dynamic templates and placeholders.
     */
    public static function sendInvoice(
        $phone,
        $invoiceId,
        $amount,
        ?string $planTitle = null,
        ?string $paymentMethod = null,
        ?string $invoiceUrl = null,
        string $productName = 'LaunchShop'
    ): array {
        $config = self::getWhatsAppConfig();

        if (empty($config['is_active']) || empty($config['invoice_active'])) {
            Log::info("WhatsAppNotificationService: Invoice notifications toggled OFF in settings. Skipping.");
            return [
                'success' => false,
                'skipped' => true,
                'message' => 'WhatsApp Invoice notifications are disabled.',
            ];
        }

        $template = !empty($config['invoice_template']) ? $config['invoice_template'] : self::DEFAULT_INVOICE_TEMPLATE;

        $message = str_replace(
            ['{user_name}', '{invoice_id}', '{amount}', '{plan_title}', '{payment_method}', '{invoice_url}', '{product_name}'],
            ['Customer', $invoiceId, $amount, $planTitle ?: $productName, $paymentMethod ?: 'Online Payment', $invoiceUrl ?: '', $productName],
            $template
        );

        $filename = !empty($invoiceId) ? "Invoice_{$invoiceId}.pdf" : "Invoice.pdf";

        return self::sendMessage($phone, $message, $invoiceUrl, $filename, $config);
    }

    /**
     * Send Subscription Expiry Warning Notification via WhatsApp.
     */
    public static function sendExpiryReminder(
        $phone,
        string $userName,
        string $planName,
        string $daysLeft,
        string $expireDate,
        string $renewalUrl,
        string $productName = 'LaunchShop'
    ): array {
        $config = self::getWhatsAppConfig();

        if (empty($config['is_active'])) {
            Log::info("WhatsAppNotificationService: WhatsApp notifications disabled in settings. Skipping expiry reminder.");
            return [
                'success' => false,
                'skipped' => true,
                'message' => 'WhatsApp notifications are disabled.',
            ];
        }

        $template = !empty($config['expiry_template']) ? $config['expiry_template'] : self::DEFAULT_EXPIRY_WARNING_TEMPLATE;

        $productDisplayName = 'LaunchShop';

        $message = str_replace(
            ['{user_name}', '{product_name}', '{plan_name}', '{days_left}', '{expire_date}', '{renewal_url}'],
            [$userName, $productDisplayName, $planName, $daysLeft, $expireDate, $renewalUrl],
            $template
        );

        return self::sendMessage($phone, $message, null, null, $config);
    }

    /**
     * Send Plan Renewed Notification via WhatsApp.
     */
    public static function sendPlanRenewedNotification(
        $phone,
        string $customerName,
        string $planName,
        string $expireDate,
        string $productName = 'LaunchShop'
    ): array {
        $config = self::getWhatsAppConfig();

        if (empty($config['is_active'])) {
            Log::info("WhatsAppNotificationService: WhatsApp notifications disabled in settings. Skipping plan renewed notification.");
            return [
                'success' => false,
                'skipped' => true,
                'message' => 'WhatsApp notifications are disabled.',
            ];
        }

        $template = !empty($config['renewal_template']) ? $config['renewal_template'] : self::DEFAULT_RENEWAL_TEMPLATE;
        $productDisplayName = 'LaunchShop';

        $message = str_replace(
            ['{customer_name}', '{user_name}', '{product_name}', '{plan_name}', '{expire_date}'],
            [$customerName, $customerName, $productDisplayName, $planName, $expireDate],
            $template
        );

        return self::sendMessage($phone, $message, null, null, $config);
    }
}
