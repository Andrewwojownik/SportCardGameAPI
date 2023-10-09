<?php

use App\Models\Card;
use App\Models\Duel;
use App\Models\DuelCards;
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
        /**
         * @var \App\Models\Player $player
         */
        $player = auth()->user()->player;
        $duel = Duel::where('player_one_id', $player->id)->orWhere('player_two_id', $player->id)->first();

        if ($duel == null) {
            $oponentPlayer = \App\Models\Player::where('level', $player->level)->whereNull('user_id')->first(); //TODO random get bot player
            $duel = new Duel();
            $duel->player_one_id = $player->id;
            $duel->player_two_id = $oponentPlayer->id;
            $duel->last_finished_round = 0;
            $duel->save();

            /**
             * @var \App\Models\Card $card
             */
            foreach ($player->cards as $card) {
                $playerCard = new \App\Models\DuelCards();
                $playerCard->card_id = $card->id;
                $playerCard->player_id = $player->id;
                $playerCard->duel_id = $duel->id;
                $playerCard->save();
            }

            /**
             * @var \App\Models\Card $card
             */
            foreach ($oponentPlayer->cards as $card) {
                $oponentCard = new \App\Models\DuelCards();
                $oponentCard->card_id = $card->id;
                $oponentCard->player_id = $oponentPlayer->id;
                $oponentCard->duel_id = $duel->id;
                $oponentCard->save();
            }
        }

        return response()->json();
    });

    //CURRENT GAME DATA
    Route::get('duels/active', function (Request $request) {
        $player = auth()->user()->player;
        $duel = Duel::where('player_one_id', $player->id)->orWhere('player_two_id', $player->id)->first();
        $oponentPlayerId = ($player->id == $duel->player_one_id ? $duel->player_two_id : $duel->player_one_id);
        $oponentPlayer = \App\Models\Player::where('id', $oponentPlayerId)->first();

        $gamePointCalculator = app()->make(\App\Game\GamePointCalculator::class);

        //TODO more elegant query or store current points in duel data

        $yourCards = DuelCards::where('player_id', $player->id)
            ->where('duel_id', $duel->id)
            ->whereNotNull('used_in_round')
            ->get();
        $yourPoints = $gamePointCalculator->calculateGamePoints($yourCards);

        $opponentCards = DuelCards::where('player_id', $oponentPlayerId)
            ->where('duel_id', $duel->id)
            ->whereNotNull('used_in_round')
            ->get();
        $opponentPoints = $gamePointCalculator->calculateGamePoints($opponentCards);

        if ($duel->last_finished_round >= 5) {
            $duelHistory = new \App\Models\DuelHistory();
            $duelHistory->player_one_id = $player->id;
            $duelHistory->player_two_id = $oponentPlayerId;
            $duelHistory->player_one_points = $yourPoints;
            $duelHistory->player_two_points = $opponentPoints;
            $duelHistory->winner_id = ($yourPoints > $opponentPoints ? $player->id : $oponentPlayerId);
            $duelHistory->save();
            $duel->delete();

            if ($duelHistory->winner_id == $player->id) {
                $player->level_points += 20;
                $player->save();
                $levelCalculator = app()->make(\App\Game\LevelCalculator::class);

                if ($player->level_points > $levelCalculator->getPointsForNextLevel($player->level)) {
                    ++$player->level;
                    $player->save();
                }
            }
        }

        return [
            'round' => (int)($duel->last_finished_round + 1),
            'your_points' => $yourPoints,
            'opponent_points' => $opponentPoints,
            'status' => $duel->last_finished_round >= 5 ? 'finished' : 'active',
            'cards' => $player?->cards,
        ];
    });

    //User has just selected a card
    Route::post('duels/action', function (Request $request) {
        /**
         * @var \App\Models\Player $player
         */
        $player = auth()->user()->player;
        $duel = Duel::where('player_one_id', $player->id)->orWhere('player_two_id', $player->id)->first();

        if ($duel == null) {
            return response()->json();
        }

        $cardId = $request->get('id');

        $card = DuelCards::where('player_id', $player->id)
            ->where('duel_id', $duel->id)
            ->where('card_id', $cardId)
            ->whereNull('used_in_round')
            ->first();

        $card->used_in_round = ($duel->last_finished_round + 1);
        $card->save();

        $oponentPlayerId = ($player->id == $duel->player_one_id ? $duel->player_two_id : $duel->player_one_id);
        //TODO get random NPC card
        $opponentCard = DuelCards::where('player_id', $oponentPlayerId)
            ->where('duel_id', $duel->id)
            ->whereNull('used_in_round')
            ->first();

        $opponentCard->used_in_round = ($duel->last_finished_round + 1);
        $opponentCard->save();

        $duel->last_finished_round = ($duel->last_finished_round + 1);
        $duel->save();

        //move from here because of frontend
        /*if ($duel->last_finished_round >= 5) {
            $gamePointCalculator = app()->make(\App\Game\GamePointCalculator::class);

            $yourCards = DuelCards::where('player_id', $player->id)
                ->where('duel_id', $duel->id)
                ->whereNotNull('used_in_round')
                ->get();
            $yourPoints = $gamePointCalculator->calculateGamePoints($yourCards);

            $opponentCards = DuelCards::where('player_id', $oponentPlayerId)
                ->where('duel_id', $duel->id)
                ->whereNotNull('used_in_round')
                ->get();
            $opponentPoints = $gamePointCalculator->calculateGamePoints($opponentCards);

            $duelHistory = new \App\Models\DuelHistory();
            $duelHistory->player_one_id = $player->id;
            $duelHistory->player_two_id = $oponentPlayerId;
            $duelHistory->player_one_points = $yourPoints;
            $duelHistory->player_two_points = $opponentPoints;
            $duelHistory->winner_id = ($yourPoints > $opponentPoints ? $player->id : $oponentPlayerId);
            $duelHistory->save();
            $duel->delete();

            if ($duelHistory->winner_id == $player->id) {
                $player->level_points += 20;
                $player->save();
                $levelCalculator = app()->make(\App\Game\LevelCalculator::class);

                if ($player->level_points > $levelCalculator->getPointsForNextLevel($player->level)) {
                    ++$player->level;
                    $player->save();
                }
            }
        }*/

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
