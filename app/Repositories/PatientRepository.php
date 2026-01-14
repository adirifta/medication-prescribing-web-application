<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Interfaces\PatientRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientRepository extends BaseRepository implements PatientRepositoryInterface
{
    public function __construct(Patient $model)
    {
        parent::__construct($model);
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->model->where('name', 'like', "%{$query}%")
            ->orWhere('medical_record_number', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->orderBy('name')
            ->paginate(10);
    }

    public function getWithExaminations(int $id)
    {
        return $this->model->with(['examinations' => function ($query) {
            $query->orderBy('examination_date', 'desc');
        }])->find($id);
    }

    public function getAllWithExaminationsCount(?string $search = null)
    {
        $query = $this->model->withCount('examinations');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('medical_record_number', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    public function getWithExaminationsAndDoctor(int $id)
    {
        return $this->model->with(['examinations' => function ($query) {
            $query->with(['doctor', 'prescription.items'])->orderBy('examination_date', 'desc');
        }])->find($id);
    }
}
