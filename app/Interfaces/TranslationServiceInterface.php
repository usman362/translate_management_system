<?php

namespace App\Interfaces;

interface TranslationServiceInterface
{
    public function getAllTranslations();
    public function createTranslation(array $data);
    public function updateTranslation(int $id, array $data);
    public function deleteTranslation(int $id);
    public function searchTranslations(array $filters);
    public function exportTranslations();
}
