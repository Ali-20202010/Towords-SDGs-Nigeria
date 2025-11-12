<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SdgJsonService
{
    private string $base = 'data/sdg';

    public function listGoals(): array
    {
        return Cache::remember('sdg:index', 3600, function () {
            $disk = Storage::disk('local');
            if (!$disk->exists("{$this->base}/index.json")) return [];
            return json_decode($disk->get("{$this->base}/index.json"), true) ?? [];
        });
    }

    public function loadGoal(int $goal): array
    {
        $key = "sdg:goal:".$goal;
        return Cache::remember($key, 3600, function () use ($goal) {
            $disk = Storage::disk('local');
            $path = "{$this->base}/goal_{$goal}.json";
            if (!$disk->exists($path)) return [];
            return json_decode($disk->get($path), true) ?? [];
        });
    }

    public function filter(int $goal, array $q): array
    {
        $rows = $this->loadGoal($goal);

        $rows = array_values(array_filter($rows, function ($r) use ($q) {
            if (isset($q['state']) && $q['state'] !== '' && strcasecmp($r['StateName'] ?? '', $q['state']) !== 0) return false;
            if (isset($q['code'])  && $q['code']  !== '' && strcasecmp($r['indicator_code'] ?? '', $q['code']) !== 0) return false;
            if (isset($q['year_min']) && $q['year_min'] !== '' && is_numeric($r['year']) && $r['year'] < (int)$q['year_min']) return false;
            if (isset($q['year_max']) && $q['year_max'] !== '' && is_numeric($r['year']) && $r['year'] > (int)$q['year_max']) return false;
            return true;
        }));

        usort($rows, function ($a, $b) {
            return [$a['year'] ?? 0, $a['StateName'] ?? ''] <=> [$b['year'] ?? 0, $b['StateName'] ?? ''];
        });

        return $rows;
    }
}
