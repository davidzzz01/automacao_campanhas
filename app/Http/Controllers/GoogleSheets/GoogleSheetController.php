<?php
namespace App\Http\Controllers\GoogleSheets;

use Google\Client;
use Google\Service\Sheets;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoogleSheetController extends Controller
{
    public function store(Request $request)
    {
        $client = new Client();
        $client->setAuthConfig(base_path(env('GOOGLE_APPLICATION_CREDENTIALS')));
        $client->addScope(Sheets::SPREADSHEETS);

        $service = new Sheets($client);

        $spreadsheetId = env('GOOGLE_SHEET_ID');
        $range = 'A1';
        $values = [
            [$request->nome, $request->email, now()->toDateTimeString()]
        ];

        $body = new Sheets\ValueRange(['values' => $values]);
        $params = ['valueInputOption' => 'RAW'];

        $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);

        return response()->json(['message' => 'Enviado para a planilha!']);
    }
}
