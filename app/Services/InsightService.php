<?php
namespace App\Services;

class InsightService
{
    public function generate(array $creatives): array
    {
        return array_map(function ($creative) {
            $cpa = number_format($creative['cpa'], 2, ',', '.');
            $creative['insight'] = "CPA R$ $cpa - Desempenho acima da média.";
            return $creative;
        }, $creatives);
    }
}

