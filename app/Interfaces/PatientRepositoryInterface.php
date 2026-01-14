<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface PatientRepositoryInterface extends RepositoryInterface
{
    public function search(string $query): LengthAwarePaginator;
    public function getWithExaminations(int $id);
    public function getAllWithExaminationsCount(?string $search = null);
    public function getWithExaminationsAndDoctor(int $id);
}
