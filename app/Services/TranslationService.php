<?php

namespace App\Services;

use App\Interfaces\TranslationRepositoryInterface;
use App\Interfaces\TranslationServiceInterface;

class TranslationService implements TranslationServiceInterface
{
    private TranslationRepositoryInterface $repository;

    public function __construct(TranslationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTranslations()
    {
        return $this->repository->all();
    }

    public function createTranslation(array $data)
    {
        $exists = $this->repository->findByLocaleAndKey($data['locale'], $data['key']);

        if ($exists) {
            throw new \Exception('The combination of locale and key already exists.');
        }

        return $this->repository->create($data);
    }

    public function updateTranslation(int $id, array $data)
    {
        $exists = $this->repository->findByLocaleAndKey($data['locale'], $data['key']);

        if ($exists && $exists->id !== $id) {
            throw new \Exception('The combination of locale and key already exists.');
        }

        return $this->repository->update($id, $data);
    }

    public function deleteTranslation(int $id)
    {
        return $this->repository->delete($id);
    }

    public function searchTranslations(array $filters)
    {
        return $this->repository->search($filters);
    }

    public function exportTranslations()
    {
        return $this->repository->export();
    }
}
