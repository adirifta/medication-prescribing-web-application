<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface ExaminationRepositoryInterface extends RepositoryInterface
{
    public function getByDoctor(int $doctorId, array $filters = []): LengthAwarePaginator;
    public function createWithPrescription(array $examinationData, array $prescriptionData = []);
}
