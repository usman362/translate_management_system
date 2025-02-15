<?php

namespace App\Repositories;

use App\Models\Translation;
use App\Interfaces\TranslationRepositoryInterface;

class TranslationRepository implements TranslationRepositoryInterface
{
    public function all()
    {
        return Translation::select(['id', 'locale', 'key', 'value'])->limit(1000)->get();
    }

    public function create(array $data)
    {
        return Translation::create($data);
    }

    public function update(int $id, array $data)
    {
        $translation = Translation::findOrFail($id);
        $translation->update($data);
        return $translation;
    }

    public function delete(int $id)
    {
        $translation = Translation::findOrFail($id);
        $translation->delete();
        return ['message' => 'Translation deleted'];
    }

    public function findByLocaleAndKey(string $locale, string $key)
    {
        return Translation::where('locale', $locale)->where('key', $key)->first();
    }

    public function search(array $filters)
    {
        $query = Translation::query();

        if (!empty($filters['key'])) {
            $query->where('key', 'like', '%' . $filters['key'] . '%');
        }

        if (!empty($filters['value'])) {
            $query->where('value', 'like', '%' . $filters['value'] . '%');
        }

        if (!empty($filters['tags'])) {
            $query->whereJsonContains('tags', $filters['tags']);
        }

        return $query->limit(1000)->get();
    }

    public function export()
    {
        return Translation::limit(1000)->get()->groupBy('locale')->map(function ($items) {
            return $items->pluck('value', 'key');
        });
    }
}
