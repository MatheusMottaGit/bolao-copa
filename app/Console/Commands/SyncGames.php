<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Prediction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncGames extends Command
{
    protected $signature = 'sync:games';
    protected $description = 'Sincroniza jogos e resultados da Copa via football-data.org';

    public function handle(): void
    {
        $apiKey = config('services.football_api.key');
        $baseUrl = config('services.football_api.url');

        // 2026 FIFA World Cup — competition code WC
        $response = Http::withHeaders(['X-Auth-Token' => $apiKey])
            ->get("{$baseUrl}/competitions/WC/matches");

        if ($response->failed()) {
            $this->error('Falha ao acessar a API: ' . $response->status());
            return;
        }

        $matches = $response->json('matches', []);

        foreach ($matches as $match) {
            $apiId = $match['id'];
            $status = $this->mapStatus($match['status']);
            $homeScore = $match['score']['fullTime']['home'] ?? null;
            $awayScore = $match['score']['fullTime']['away'] ?? null;

            $game = Game::updateOrCreate(
                ['api_id' => $apiId],
                [
                    'home_team' => $match['homeTeam']['name'],
                    'away_team' => $match['awayTeam']['name'],
                    'starts_at' => $match['utcDate'],
                    'home_score' => $homeScore,
                    'away_score' => $awayScore,
                    'status' => $status,
                ]
            );

            if ($status === 'finished' && $homeScore !== null && $awayScore !== null) {
                $this->calculatePoints($game, $homeScore, $awayScore);
            }
        }

        $this->info('Sincronização concluída. ' . count($matches) . ' jogos processados.');
    }

    private function mapStatus(string $apiStatus): string
    {
        return match ($apiStatus) {
            'SCHEDULED', 'TIMED' => 'scheduled',
            'IN_PLAY', 'PAUSED', 'HALFTIME' => 'in_progress',
            'FINISHED' => 'finished',
            default => 'scheduled',
        };
    }

    private function calculatePoints(Game $game, int $homeScore, int $awayScore): void
    {
        $predictions = Prediction::where('game_id', $game->id)->get();

        foreach ($predictions as $prediction) {
            $points = 0;

            if ($prediction->home_score === $homeScore && $prediction->away_score === $awayScore) {
                $points = 3; // placar exato
            } elseif ($this->sameOutcome($prediction->home_score, $prediction->away_score, $homeScore, $awayScore)) {
                $points = 1; // acertou vencedor ou empate
            }

            $prediction->update(['points' => $points]);
        }
    }

    private function sameOutcome(int $predH, int $predA, int $realH, int $realA): bool
    {
        $predResult = $predH <=> $predA;
        $realResult = $realH <=> $realA;

        return $predResult === $realResult;
    }
}
