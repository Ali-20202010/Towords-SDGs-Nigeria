<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SdgJsonService;

class WebIndicatorController extends Controller
{
    /** GET /indicators-listing */
    public function GetAllIndicators(SdgJsonService $svc)
    {
        // keep your original order
        $tables = [
            "goal_1","goal_2","goal_3","goal_4","goal_5","goal_6","goal_7",
            "goal_8","goal_15","goal_16","goal_17",
        ];

        $goals = [];
        foreach ($tables as $table) {
            $g    = self::goalNumFromTable($table);
            $rows = $svc->loadGoal($g);

            [$stateKey, $valueKey, $yearKey, $labelKey] = self::detectKeys($rows);

            // distinct labels (ASC)
            $set = [];
            foreach ($rows as $r) {
                $label = $r[$labelKey] ?? null;
                if ($label !== null && $label !== '') $set[$label] = true;
            }
            $list = array_keys($set);
            sort($list, SORT_NATURAL | SORT_FLAG_CASE);

            // same shape as old DB: objects with Global_SDG_indicators
            $goals[] = array_map(fn($x) => (object)['Global_SDG_indicators' => $x], $list);
        }

        return view('welcome', compact('goals'));
    }

    /** GET /detail_indicators/{name}/{table_name} */
    public function GetDetailIndicators(string $name, string $table_name, Request $request, SdgJsonService $svc)
    {
        $tablename = $table_name;                // e.g. goal_3
        $goal      = self::goalNumFromTable($tablename);
        $rows      = $svc->loadGoal($goal);

        // --- detect actual column keys present in this goal JSON
        [$stateKey, $valueKey, $yearKey, $labelKey] = self::detectKeys($rows);

        // --- helpers
        $norm = function (?string $s): string {
            if ($s === null) return '';
            $s = rawurldecode($s);
            $s = html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $s = str_replace('_', ' ', $s);
            $s = preg_replace('/[“”„‟"\'’‘`]+/u', '', $s);
            $s = preg_replace('/\s+/', ' ', $s);
            $s = mb_strtolower(trim($s));
            $s = preg_replace('/[^a-z0-9\.\,\-\s]/u', '', $s);
            return trim($s);
        };
        $toNumber = function ($v) {
            if ($v === null || $v === '') return null;
            if (is_string($v)) {
                // remove commas/spaces and trailing % if any
                $v = str_replace([' ', ','], '', $v);
                $v = rtrim($v, '%');
            }
            return is_numeric($v) ? (float)$v : null;
        };

        // --- choose indicator label robustly
        $incoming = $norm($name);
        $labels = [];
        foreach ($rows as $r) {
            $lab = $r[$labelKey] ?? null;
            if ($lab) $labels[$norm($lab)] = $lab;
        }
        $indicatorname = $labels[$incoming] ?? '';
        if ($indicatorname === '') {
            foreach ($labels as $nk => $orig) { if (mb_strpos($nk, $incoming) !== false) { $indicatorname = $orig; break; } }
        }
        if ($indicatorname === '' && !empty($labels)) $indicatorname = reset($labels);

        // --- filter rows for indicator (exact normalized → contains → fallback all)
        $filtered = array_values(array_filter($rows, fn($r) => isset($r[$labelKey]) && $norm($r[$labelKey]) === $norm($indicatorname)));
        if (empty($filtered)) {
            $filtered = array_values(array_filter($rows, fn($r) => isset($r[$labelKey]) && mb_strpos($norm($r[$labelKey]), $norm($indicatorname)) !== false));
        }
        if (empty($filtered)) $filtered = $rows;

        // --- sidebar list (pending_goals)
        $indsAll = [];
        foreach ($rows as $r) { $lab = $r[$labelKey] ?? null; if ($lab) $indsAll[$lab] = true; }
        $indsAll = array_keys($indsAll);
        sort($indsAll, SORT_NATURAL | SORT_FLAG_CASE);
        $pending_goals = array_map(fn($x) => (object)['Global_SDG_indicators' => $x], $indsAll);

        // --- states list (objects with StateName)
        $statesArr = array_values(array_unique(array_map(fn($r) => $r[$stateKey] ?? null, $filtered)));
        $statesArr = array_values(array_filter($statesArr, fn($s) => $s !== null && $s !== ''));
        $states    = array_map(fn($s) => (object)['StateName' => $s], $statesArr);

        // --- newest numeric per state (BAR + MAP)
        $grouped = [];
        foreach ($filtered as $r) {
            $state = $r[$stateKey] ?? null;
            if (!$state) continue;
            $grouped[$state][] = $r;
        }
        $byStateNewest = [];
        foreach ($grouped as $state => $rs) {
            $best = null;
            foreach ($rs as $row) {
                $val = $toNumber($row[$valueKey] ?? null);
                if ($val === null) continue;
                $yr = $row[$yearKey] ?? null;
                if (!is_numeric($yr)) continue;
                if ($best === null || (int)$yr > ($best['year'] ?? PHP_INT_MIN)) {
                    $best = ['StateName' => $state, 'value' => round($val, 2), 'year' => (int)$yr];
                }
            }
            if ($best !== null) $byStateNewest[$state] = $best;
        }

        // BAR vars your Blade expects
        $goalvalue = array_map(fn($r) => (object)['StateName' => $r['StateName'], 'value' => $r['value']], array_values($byStateNewest));
        $new_goal_value = array_map(fn($r) => ['StateName' => $r['StateName'], 'value' => $r['value']], array_values($byStateNewest));
        $newgoalvalue = json_encode($new_goal_value, JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

        // MAP uses same selection
        $mapvalue = json_encode(array_values(array_map(fn($r) => ['StateName' => $r['StateName'], 'value' => $r['value']], $byStateNewest)), JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

        // --- LINE (>2018), keep lower-case 'value'
        $yearToExclude = 2018;
        $new_line_value = [];
        foreach ($statesArr as $state) {
            $series = array_values(array_filter($filtered, fn($r) =>
                ($r[$stateKey] ?? null) === $state &&
                is_numeric($r[$yearKey] ?? null) &&
                $r[$yearKey] > $yearToExclude
            ));
            usort($series, fn($a,$b) => ($a[$yearKey] ?? 0) <=> ($b[$yearKey] ?? 0));
            $new_line_value[$state] = array_map(fn($r) => (object)[
                'StateName' => $r[$stateKey] ?? null,
                'year'      => $r[$yearKey] ?? null,
                'value'     => $toNumber($r[$valueKey] ?? null),
            ], $series);
        }
        $newlinevalue = json_encode($new_line_value, JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

        // --- TABLE (years & values per state)
        $tableyear_arr = array_values(array_unique(array_map(fn($r) => $r[$yearKey] ?? null, $filtered)));
        $tableyear_arr = array_values(array_filter($tableyear_arr, fn($y) => $y !== null));
        sort($tableyear_arr);
        $tableyear = array_map(fn($y) => (object)['year' => is_numeric($y) ? (int)$y : null], $tableyear_arr);

        $new_table_value = [];
        foreach ($statesArr as $state) {
            $ts = array_values(array_filter($filtered, fn($r) => ($r[$stateKey] ?? null) === $state));
            $seenY = [];
            $list = [];
            foreach ($ts as $r) {
                $y = $r[$yearKey] ?? null;
                if ($y === null || isset($seenY[$y])) continue;
                $seenY[$y] = true;
                $list[] = (object)[
                    'StateName' => $r[$stateKey] ?? null,
                    'year'      => is_numeric($y) ? (int)$y : null,
                    'value'     => $toNumber($r[$valueKey] ?? null),
                ];
            }
            $new_table_value[$state] = $list;
        }

        // --- NEXT / BACK goals (choose a sample indicator)
        $next = $this->getnexttable_json($goal, $svc);
        $back = $this->periviousnexttable_json($goal, $svc);
        $next_goal  = ['data' => $next['indicator'], 'next_table' => 'goal_'.$next['goal']];
        $back_goal  = ['data' => $back['indicator'], 'pervious_table' => 'goal_'.$back['goal']];

        // --- detail goals (lower-case 'value')
        $detailgoals = array_map(fn($r) => (object)[
            'adm0' => $r['adm0'] ?? null,
            'adm1' => $r['adm1'] ?? null,
            'StateName' => $r[$stateKey] ?? null,
            'indicator_code' => $r['indicator_code'] ?? null,
            'frequency' => $r['frequency'] ?? null,
            'year' => $r[$yearKey] ?? null,
            'value' => $toNumber($r[$valueKey] ?? null),
            'indicator' => $r['indicator'] ?? null,
            'description' => $r['description'] ?? null,
            'unit' => $r['unit'] ?? null,
            'scale' => $r['scale'] ?? null,
            'Global_SDG_indicators' => $r[$labelKey] ?? null,
        ], $filtered);

        // pretty title in the page header
        $indicatorname = $indicatorname ?: ($indsAll[0] ?? $name);

        return view('indicator', compact(
            'indicatorname',
            'detailgoals',
            'goalvalue',
            'newgoalvalue',
            'newlinevalue',
            'mapvalue',
            'tableyear',
            'new_table_value',
            'new_line_value',
            'states',
            'tablename',
            'next_goal',
            'back_goal',
            'pending_goals'
        ));
    }

    /* ---------------- helpers ---------------- */

    /** Convert "goal_6" → 6 */
    private static function goalNumFromTable(string $t): int
    {
        return preg_match('/goal_(\d+)/', $t, $m) ? (int)$m[1] : 1;
    }

    /**
     * Auto-detect the column names in a goal JSON file.
     * Returns [stateKey, valueKey, yearKey, labelKey]
     */
    private static function detectKeys(array $rows): array
    {
        if (empty($rows)) return ['StateName','Value','year','Global_SDG_indicators'];

        $candidates = function(array $row, array $options) {
            // exact first
            foreach ($options as $opt) if (array_key_exists($opt, $row)) return $opt;
            // case-insensitive fallback
            $lower = array_change_key_case($row, CASE_LOWER);
            foreach ($options as $opt) {
                $lo = strtolower($opt);
                if (array_key_exists($lo, $lower)) {
                    // return the actual key that matches that lower
                    foreach ($row as $k => $_) if (strtolower($k) === $lo) return $k;
                }
            }
            // default to first
            return $options[0];
        };

        $sample = $rows[0];

        $stateKey = $candidates($sample, ['StateName','state','State','ADM1','adm1','Province','province','LGA','lga']);
        $valueKey = $candidates($sample, ['Value','value','VALUE','Val','val','Amount','amount']);
        $yearKey  = $candidates($sample, ['year','Year','YEAR']);
        $labelKey = $candidates($sample, ['Global_SDG_indicators','indicator','Indicator','INDICATOR']);

        return [$stateKey, $valueKey, $yearKey, $labelKey];
    }

    private function getnexttable_json(int $goal, SdgJsonService $svc): array
    {
        $order = [1,2,3,4,5,6,7,8,15,16,17];
        $i = array_search($goal, $order, true);
        $next = $order[($i === false) ? 0 : (($i+1) % count($order))];

        $rows = $svc->loadGoal($next);
        [$_s,$_v,$_y,$labelKey] = self::detectKeys($rows);
        $inds = [];
        foreach ($rows as $r) { $lab = $r[$labelKey] ?? null; if ($lab) $inds[$lab] = true; }
        $inds = array_keys($inds);
        sort($inds, SORT_NATURAL | SORT_FLAG_CASE);
        return ['goal' => $next, 'indicator' => $inds[0] ?? ''];
    }

    private function periviousnexttable_json(int $goal, SdgJsonService $svc): array
    {
        $order = [1,2,3,4,5,6,7,8,15,16,17];
        $i = array_search($goal, $order, true);
        $prev = $order[($i === false) ? 0 : (($i - 1 + count($order)) % count($order))];

        $rows = $svc->loadGoal($prev);
        [$_s,$_v,$_y,$labelKey] = self::detectKeys($rows);
        $inds = [];
        foreach ($rows as $r) { $lab = $r[$labelKey] ?? null; if ($lab) $inds[$lab] = true; }
        $inds = array_keys($inds);
        sort($inds, SORT_NATURAL | SORT_FLAG_CASE);
        return ['goal' => $prev, 'indicator' => $inds[0] ?? ''];
    }
}
