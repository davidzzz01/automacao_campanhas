<?php

namespace App\UseCases\Campaign;

use App\Repositories\CampaignRepository;
use App\Services\InsightService;
use App\Services\GoogleSheetsService;
use App\Helpers\CalculateCPA;

class CampaignDataUseCase
{
    protected $campaignRepository;
    protected $insightService;
    protected $googleSheetsService;

    public function __construct(
        CampaignRepository $campaignRepository,
        InsightService $insightService,
        GoogleSheetsService $googleSheetsService
    ) {
        $this->campaignRepository = $campaignRepository;
        $this->insightService = $insightService;
        $this->googleSheetsService = $googleSheetsService;
    }

    public function handle(): array
    {
        
        $raw = $this->campaignRepository->fetch();
        $data = $raw['data'] ?? [];

        $winners = [];

        
        foreach ($data as $date => $creatives) {
            foreach ($creatives as $creative) {
                $views = $creative['visualizacoes'] ?? 0;
                $conversions = $creative['conversoes'] ?? 0;
                $ctr = $creative['ctr'] ?? 0;

                if ($conversions === 0) continue;

                $cpa = CalculateCPA::from($views, $conversions);

                if ($ctr >= 2 && $conversions >= 10 && $cpa < 8.0) {
                    $creative['cpa'] = $cpa;
                    $winners[] = $creative;
                }
            }
        }

        
        $insights = $this->insightService->generate($winners);

        
        $this->googleSheetsService->appendData($insights);

        return $insights;
    }
}
