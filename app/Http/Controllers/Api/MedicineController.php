<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MedicineApiService;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    private MedicineApiService $medicineService;

    public function __construct(MedicineApiService $medicineService)
    {
        $this->medicineService = $medicineService;
        $this->middleware('auth');
    }

    public function getMedicines()
    {
        try {
            $medicines = $this->medicineService->getMedicines();
            return response()->json([
                'success' => true,
                'data' => $medicines
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch medicines',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMedicinePrice($medicineId)
    {
        try {
            $price = $this->medicineService->getCurrentPrice($medicineId);
            return response()->json([
                'success' => true,
                'price' => $price
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch medicine price',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function searchMedicines(Request $request)
    {
        try {
            $search = $request->get('q', '');
            $medicines = $this->medicineService->getMedicines();

            if ($search) {
                $medicines = array_filter($medicines, function ($medicine) use ($search) {
                    return stripos($medicine['name'], $search) !== false;
                });
            }

            return response()->json([
                'success' => true,
                'data' => array_values($medicines)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search medicines',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
