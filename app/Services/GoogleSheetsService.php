<?php
namespace App\Services;

use Google_Client;
use Google_Service_Sheets;

class GoogleSheetsService
{
    protected $client;
    protected $service;
    protected $spreadsheetId;

    public function __construct()
    {
        $this->spreadsheetId = config('services.google.sheets_id'); 

        $this->client = new Google_Client();
        $this->client->setApplicationName('Campanha Insights');
        $this->client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(storage_path('app/google/credentials.json')); 
        $this->service = new Google_Service_Sheets($this->client);
    }

    public function append(array $data, string $range = 'Vencedores!A1')
    {
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);
        $params = ['valueInputOption' => 'RAW'];
        $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, $params);
    }
}
