<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class CampaignRepository
{
    public function fetch(): array
    {
        return Http::withBasicAuth('test-dev', 'mtY1LUk7R2Ifwk2')
            ->get('https://n8n-wepando-n8n.5aqprn.easypanel.host/webhook/campanhas-test')
            ->json();
    }
}
