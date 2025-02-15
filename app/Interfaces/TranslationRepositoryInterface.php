<?php

namespace App\Interfaces;

interface TranslationRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function findByLocaleAndKey(string $locale, string $key);

    public function search(array $filters);
    
    public function export();
}
