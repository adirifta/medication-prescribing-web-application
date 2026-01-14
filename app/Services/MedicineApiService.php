<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Traits\Auditable;

class MedicineApiService
{
    use Auditable;

    private $baseUrl;
    private $token;
    private $email;
    private $password;

    public function __construct()
    {
        $this->email = config('services.medicine_api.email');
        $this->password = config('services.medicine_api.password');
        $this->baseUrl = config('services.medicine_api.base_url');
        $this->authenticate();
    }

    private function authenticate(): void
    {
        $cacheKey = 'medicine_api_token';

        if (Cache::has($cacheKey)) {
            $this->token = Cache::get($cacheKey);
            return;
        }

        $response = Http::post($this->baseUrl . '/auth', [
            'email' => $this->email,
            'password' => $this->password
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->token = $data['access_token'];
            Cache::put($cacheKey, $this->token, now()->addSeconds($data['expires_in'] - 60));
        } else {
            throw new \Exception('Failed to authenticate with Medicine API');
        }
    }

    public function getMedicines(): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->get($this->baseUrl . '/medicines');

        if ($response->successful()) {
            return $response->json()['medicines'] ?? [];
        }

        return [];
    }

    public function getMedicinePrices(string $medicineId, string $date = null): array
    {
        if (!$date) {
            $date = now()->format('Y-m-d');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->get($this->baseUrl . "/medicines/{$medicineId}/prices");

        if ($response->successful()) {
            $prices = $response->json()['prices'] ?? [];

            // Find the applicable price for the given date
            foreach ($prices as $price) {
                $startDate = $price['start_date']['value'] ?? null;
                $endDate = $price['end_date']['value'] ?? null;

                if ($startDate && $date >= $startDate) {
                    if (!$endDate || $date <= $endDate) {
                        return $price;
                    }
                }
            }
        }

        return [];
    }

    public function getCurrentPrice(string $medicineId): float
    {
        $priceData = $this->getMedicinePrices($medicineId);
        return $priceData['unit_price'] ?? 0;
    }
}
