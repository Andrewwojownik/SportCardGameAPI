<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authorization\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    //START THE DUEL
    Route::post('duels', function (Request $request) {
        return response()->json();
    });

    //CURRENT GAME DATA
    Route::get('duels/active', function (Request $request) {
        return [
            'round' => 4,
            'your_points' => 260,
            'opponent_points' => 100,
            'status' => 'active',
            'cards' => auth()->user()->player?->cards,
        ];
    });

    //User has just selected a card
    Route::post('duels/action', function (Request $request) {
        return response()->json();
    });

    //DUELS HISTORY
    Route::get('duels', function (Request $request) {
        $user = auth()->user();
        $player = $user->player;
        $duels = \App\Models\DuelHistory::where('player_one_id', $player->id)->orWhere('player_two_id', $player->id)->get();

        $duelResults = [];
        foreach ($duels as $duel) {
            $playerName = $duel->playerOne->user?->name ?? ('BOT ' . $duel->player_one_id);
            $oponentName = $duel->playerTwo->user?->name ?? ('BOT ' . $duel->player_two_id);

            if ($duel->player_two_id === $player->id) {
                [$oponentName, $playerName] = [$playerName, $oponentName];
            }

            $duelResults[] = [
                'id' => $duel->id,
                'player_name' => $playerName,
                'opponent_name' => $oponentName,
                'won' => (int)($duel->winner_id === $player->id),
            ];
        }

        return $duelResults;
    });

    //CARDS
    Route::post('cards', function (Request $request) {
        $user = auth()->user();

        $cardChooser = app()->make(\App\Game\CardChooser::class);

        if ($cardChooser->isAllowedToDrawNewCard(auth()->user()->player?->level ?? 1, count(auth()->user()->player?->cards ?? []))) {
            $newCard = $cardChooser->chooseNextCard(\App\Models\Card::get());

            $user->player->cards()->attach($newCard);
        }

        return response()->json();
    });

    //USER DATA
    Route::get('user-data', function (Request $request) {
        $cardChooser = app()->make(\App\Game\CardChooser::class);
        $levelCalculator = app()->make(\App\Game\LevelCalculator::class);

        return [
            'id' => auth()->user()->id,
            'username' => auth()->user()->name,
            'level' => auth()->user()->player?->level ?? 1,
            'level_points' => (auth()->user()->player?->level_points ?? 1) . '/' . $levelCalculator->getPointsForNextLevel(auth()->user()->player?->level ?? 1),
            'cards' => auth()->user()->player?->cards,
            'new_card_allowed' => $cardChooser->isAllowedToDrawNewCard(auth()->user()->player?->level ?? 1, count(auth()->user()->player?->cards ?? [])),
        ];
    });
});
