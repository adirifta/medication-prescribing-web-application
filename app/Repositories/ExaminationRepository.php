<?php

namespace App\Repositories;

use App\Models\Examination;
use App\Interfaces\ExaminationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ExaminationRepository extends BaseRepository implements ExaminationRepositoryInterface
{
    public function __construct(Examination $model)
    {
        parent::__construct($model);
    }

    public function getByDoctor(int $doctorId, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->where('doctor_id', $doctorId)
            ->with(['patient', 'prescription']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date_from'])) {
            $query->whereDate('examination_date', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('examination_date', '<=', $filters['date_to']);
        }

        return $query->orderBy('examination_date', 'desc')->paginate(10);
    }

    public function createWithPrescription(array $examinationData, array $prescriptionData = []): Examination
    {
        return DB::transaction(function () use ($examinationData, $prescriptionData) {
            $examination = $this->create($examinationData);

            if (!empty($prescriptionData)) {
                $examination->prescription()->create($prescriptionData);
            }

            return $examination;
        });
    }
}
