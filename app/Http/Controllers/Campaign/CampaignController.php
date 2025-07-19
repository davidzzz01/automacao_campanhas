<?php
namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\UseCases\Campaign\CampaignDataUseCase;

class CampaignController extends Controller
{
    public function __invoke(CampaignDataUseCase $useCase)
    {
        try {
            $result = $useCase->handle();
            return response()->json(['success' => true, 'data' => $result]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error' => $th->getMessage()], 500);
        }
    }
}
