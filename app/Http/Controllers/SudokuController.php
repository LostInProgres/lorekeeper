<?php

namespace App\Http\Controllers;

use App\Models\Currency\Currency;
use Illuminate\Http\Request;
use App\Services\SudokuService;
use Auth;
use Config;

class SudokuController extends Controller {
    /**********************************************************************************************

     Word Search

    **********************************************************************************************/

    /**
     * Shows the Sudoku index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex() {
        return view('Sudoku.index', [
            'user'  => Auth::user(),
        ]);
    }

    /*
     * Submits the Sudoku for rewards.
     */
    public function postSubmitSudoku(Request $request, SudokuService $service) {
        if ($service->submitSudoku($request->get('count'), Auth::user())) {
            return redirect()->to('word-search');
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }
}