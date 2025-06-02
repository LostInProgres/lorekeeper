<h1 id="sudoku_title">SUDOKU</h1>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div id="sudoku_container"></div>
    </div>
</div>

<div class="text-center">
    {!! Form::open(['url' => 'minigames/' . $minigame->id . '/play']) !!}
    <div class="form-group">
        {!! Form::hidden('count', 0, ['class' => 'count']) !!}
        {!! Form::submit('submit', ['class' => 'btn btn-primary', 'id' => 'solve']) !!}
    </div>
    {!! Form::close() !!}
</div>

<style>
    /* board */
    .sudoku_board {
        margin: 6px auto;

        width: 100% !important;
        overflow: hidden;

        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;

        box-shadow: 0px 0px 5px 5px #bdc3c7;
    }

    .sudoku_board .cell {
        width: 11.11%;
        display: inline-block;
        float: left;
        cursor: pointer;
        text-align: center;
        overflow: hidden;

        -webkit-box-sizing: border-box;
        /* Safari/Chrome, other WebKit */
        -moz-box-sizing: border-box;
        /* Firefox, other Gecko */
        box-sizing: border-box;

        box-shadow: 0px 0px 0px 1px #bdc3c7;

        background: white;
    }

    .sudoku_board .cell.border_h {
        box-shadow: 0px 0px 0px 1px #bdc3c7, inset 0px -2px 0 0 #34495e;
    }

    .sudoku_board .cell.border_v {
        box-shadow: 0px 0px 0px 1px #bdc3c7, inset -2px 0 0 #34495e;
    }

    .sudoku_board .cell.border_h.border_v {
        box-shadow: 0px 0px 0px 1px #bdc3c7, inset -2px 0 0 black, inset 0px -2px 0 black;
    }

    .sudoku_board .cell span {
        color: #2c3e50;
        text-align: middle;
    }

    .sudoku_board .cell.selected,
    .sudoku_board .cell.selected.fix {
        background: #FFE;
    }

    .sudoku_board .cell.selected.current {
        box-shadow: 0px 0px 3px 3px #bdc3c7;
    }

    .sudoku_board .cell.selected.current span {
        color: white;
    }

    .sudoku_board .cell.selected.group {
        color: blue;
    }

    .sudoku_board .cell span.samevalue,
    .sudoku_board .cell.fix span.samevalue {
        font-weight: bold;
    }

    .sudoku_board .cell.notvalid,
    .sudoku_board .cell.selected.notvalid {
        font-weight: bold;
        color: white;
        ;
        background: #e74c3c;
    }

    .sudoku_board .cell.fix {
        background: #ecf0f1;
        cursor: not-allowed;
    }

    .sudoku_board .cell.fix span {
        color: #7f8c8d;
    }

    .sudoku_board .cell .solution {
        color: #d35400;
    }

    .sudoku_board .cell .note {
        color: #bdc3c7;
        width: 30% !important;
        height: 30% !important;
        text-align: top !important;
        display: inline-block;
        float: left;
        text-align: center;

        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .gameover_container .gameover {
        color: white;
        font-weight: bold;
        text-align: center;

        display: block;
        position: absolute;
        width: 90%;
        padding: 10px;

        box-shadow: 0px 0px 5px 5px #bdc3c7;
    }

    /* console */
    .board_console_container,
    .gameover_container {
        background-color: rgba(127, 140, 141, 0.7);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .board_console {
        display: block;
        margin-left: 25%;
        margin-top: 25%;
        width: 50%;
        color: white;
        background-color: rgba(127, 140, 141, 0.7);
        box-shadow: 0px 0px 5px 5px #bdc3c7;
    }

    .board_console .num {
        width: 33.33%;
        color: #2c3e50;
        padding: 1px;
        display: inline-block;
        font-weight: bold;
        text-align: center;
        cursor: pointer;

        -webkit-box-sizing: border-box;
        /* Safari/Chrome, other WebKit */
        -moz-box-sizing: border-box;
        /* Firefox, other Gecko */
        box-sizing: border-box;

        box-shadow: 0px 0px 0px 1px #bdc3c7;
    }

    .board_console .num:hover {
        color: white;
        background: #f1c40f;
    }

    .board_console .num.remove {
        width: 66.66%;
    }

    .board_console .num.note {
        background: #95a5a6;
        color: #ecf0f1;
    }

    .board_console .num.note:hover {
        background: #95a5a6;
        color: #f1c40f;
    }

    .board_console .num.selected {
        background: #f1c40f;
        box-shadow: 0px 0px 3px 3px #bdc3c7;
    }

    .board_console .num.note.selected {
        background: #f1c40f;
        box-shadow: 0px 0px 3px 3px #bdc3c7;
    }

    .board_console .num.note.selected:hover {
        color: white;
    }

    .board_console .num.no:hover {
        color: white;
        cursor: not-allowed;
    }

    .board_console .num.remove:hover {
        color: white;
        background: #c0392b;
    }

    .statistics {
        text-align: center;
    }

    #sudoku_menu ul {
        margin: 0;
        padding: 100px 0px 0px 0px;
        list-style: none;
    }

    #sudoku_menu ul li {
        margin: 0px 50px;
    }

    #sudoku_menu ul li a {
        text-align: center;
        padding: 15px 20px;
        font-weight: bold;
        color: white;
        text-decoration: none;
        display: block;
        border-bottom: 1px solid #2c3e50;
    }

    #sudoku_menu.open-sidebar {
        left: 0px;
    }

    #sidebar-toggle {
        z-index: 3;
        background: #bdc3c7;
        border-radius: 3px;
        display: block;
        position: relative;
        padding: 22px 18px;
        float: left;
    }

    #sidebar-toggle .bar {
        display: block;
        width: 28px;
        margin-bottom: 4px;
        height: 4px;
        background-color: #f0f0f0;
        border-radius: 1px;
    }

    #sidebar-toggle .bar:last-child {
        margin-bottom: 0;
    }

    /*Responsive Stuff*/
    @media all and (orientation:portrait) and (min-width: 640px) {
        h1 {
            font-size: 50px;
        }

        .statistics {
            font-size: 30px;
        }

        .sudoku_board .cell span {
            font-size: 60px;
        }

        .board_console .num {
            font-size: 60px;
        }
    }

    @media all and (orientation:landscape) and (min-height: 640px) {
        h1 {
            font-size: 50px;
        }

        .statistics {
            font-size: 30px;
        }

        .sudoku_board .cell span {
            font-size: 50px;
        }

        .board_console .num {
            font-size: 50px;
        }
    }

    @media all and (orientation:portrait) and (max-width: 1000px) {
        .sudoku_board .cell span {
            font-size: 30px;
        }
    }

    @media all and (orientation:portrait) and (max-width: 640px) {
        .sudoku_board .cell span {
            font-size: 24px;
        }

        .sudoku_board .cell .note {
            font-size: 10px;
        }
    }

    @media all and (orientation:portrait) and (max-width: 470px) {
        .sudoku_board .cell span {
            font-size: 16px;
        }

        .sudoku_board .cell .note {
            font-size: 8px;
        }
    }

    @media all and (orientation:portrait) and (max-width: 320px) {
        .sudoku_board .cell span {
            font-size: 12px;
        }

        .sudoku_board .cell .note {
            font-size: 8px;
        }
    }

    @media all and (orientation:portrait) and (max-width: 240px) {
        .sudoku_board .cell span {
            font-size: 10px;
        }
    }

    @for ($t = 0; $t < 10; $t++)
        @php $key = 'number_' . $t; @endphp
        @if ($minigame->customImageUrl($key))
            .number-panel-{{ $t }} {
                background-image: url("{{ $minigame->customImageUrl($key) }}");
                color: rgba(0,0,0,1);
            }
            
        @else
            .number-panel-{{ $t }} {
                <!-- No image found -->
            }
        @endif
    @endfor
</style>


<script>
    /* Work in progress */
    /**
    Sudoku game
    */
    function Sudoku(params) {
        var t = this;

        this.INIT = 0;
        this.RUNNING = 1;
        this.END = 2;

        this.id = params.id || 'sudoku_container';
        this.displaySolution = params.displaySolution || 0;
        this.displaySolutionOnly = params.displaySolutionOnly || 0;
        this.displayTitle = params.displayTitle || 0;
        this.highlight = params.highlight || 0;
        this.fixCellsNr = params.fixCellsNr || 32;
        this.n = 3;
        this.nn = this.n * this.n;
        this.cellsNr = this.nn * this.nn;

        if (this.fixCellsNr < 10) this.fixCellsNr = 10;
        if (this.fixCellsNr > 70) this.fixCellsNr = 70;

        this.init();

        //counter
        setInterval(function() {
            t.timer();
        }, 1000);

        return this;
    }
    Sudoku.prototype.init = function() {
        this.status = this.INIT;
        this.cellsComplete = 0;
        this.board = [];
        this.boardSolution = [];
        this.cell = null;
        this.markNotes = 0;
        this.secondsElapsed = 0;

        if (this.displayTitle == 0) {
            $('#sudoku_title').hide();
        }

        this.board = this.boardGenerator(this.n, this.fixCellsNr);

        return this;
    };
    Sudoku.prototype.timer = function() {
        if (this.status === this.RUNNING) {
            this.secondsElapsed++;
            $('.time').text('' + this.secondsElapsed);
        }
    };
    /**
    Shuffle array
    */
    Sudoku.prototype.shuffle = function(array) {
        var currentIndex = array.length,
            temporaryValue = 0,
            randomIndex = 0;

        while (0 !== currentIndex) {
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

        return array;
    };
    /**
    Generate the sudoku board
    */
    Sudoku.prototype.boardGenerator = function(n, fixCellsNr) {
        var matrix_fields = [],
            index = 0,
            i = 0,
            j = 0,
            j_start = 0,
            j_stop = 0;

        //generate solution
        this.boardSolution = [];

        //shuffle matrix indexes
        for (i = 0; i < this.nn; i++) {
            matrix_fields[i] = i + 1;
        }

        //shuffle sudoku 'collors'
        matrix_fields = this.shuffle(matrix_fields);
        for (i = 0; i < n * n; i++) {
            for (j = 0; j < n * n; j++) {
                var value = Math.floor((i * n + i / n + j) % (n * n) + 1);
                this.boardSolution[index] = value;
                index++;
            }
        }

        //shuffle sudokus indexes of bands on horizontal and vertical
        var blank_indexes = [];
        for (i = 0; i < this.n; i++) {
            blank_indexes[i] = i + 1;
        }


        //shuffle sudokus bands horizontal
        var bands_horizontal_indexes = this.shuffle(blank_indexes);
        var board_solution_tmp = [];
        index = 0;
        for (i = 0; i < bands_horizontal_indexes.length; i++) {
            j_start = (bands_horizontal_indexes[i] - 1) * this.n * this.nn;
            j_stop = bands_horizontal_indexes[i] * this.n * this.nn;

            for (j = j_start; j < j_stop; j++) {
                board_solution_tmp[index] = this.boardSolution[j];
                index++;
            }
        }
        this.boardSolution = board_solution_tmp;


        //shuffle sudokus bands vertical
        var bands_vertical_indexes = this.shuffle(blank_indexes);
        board_solution_tmp = [];
        index = 0;
        for (k = 0; k < this.nn; k++) {
            for (i = 0; i < this.n; i++) {
                j_start = (bands_vertical_indexes[i] - 1) * this.n;
                j_stop = bands_vertical_indexes[i] * this.n;

                for (j = j_start; j < j_stop; j++) {
                    board_solution_tmp[index] = this.boardSolution[j + (k * this.nn)];
                    index++;
                }
            }
        }
        this.boardSolution = board_solution_tmp;

        //shuffle sudokus lines on each bands horizontal
        //TO DO

        //shuffle sudokus columns on each bands vertical
        //TO DO

        //board init
        var board_indexes = [],
            board_init = [];

        //shuffle board indexes and cut empty cells
        for (i = 0; i < this.boardSolution.length; i++) {
            board_indexes[i] = i;
            board_init[i] = 0;
        }

        board_indexes = this.shuffle(board_indexes);
        board_indexes = board_indexes.slice(0, this.fixCellsNr);

        //build the init board
        for (i = 0; i < board_indexes.length; i++) {
            board_init[board_indexes[i]] = this.boardSolution[board_indexes[i]];
            if (parseInt(board_init[board_indexes[i]]) > 0) {
                this.cellsComplete++;
            }
        }

        return (this.displaySolutionOnly) ? this.boardSolution : board_init;
    };
    /**
    Draw sudoku board in the specified container
    */
    Sudoku.prototype.drawBoard = function() {
        var index = 0,
            position = {
                x: 0,
                y: 0
            },
            group_position = {
                x: 0,
                y: 0
            };

        var sudoku_board = $('<div></div>').addClass('sudoku_board');
        var sudoku_statistics = $('<div></div>')
            .addClass('statistics')
            .html('<b>Cells:</b> <span class="cells_complete">' + this.cellsComplete + '/' + this.cellsNr + '</span> <b>Time:</b> <span class="time">' + this.secondsElapsed + '</span>');

        $('#' + this.id).empty();

        //draw board
        for (i = 0; i < this.nn; i++) {
            for (j = 0; j < this.nn; j++) {
                position = {
                    x: i + 1,
                    y: j + 1
                };
                group_position = {
                    x: Math.floor((position.x - 1) / this.n),
                    y: Math.floor((position.y - 1) / this.n)
                };

                // LOSTODO: here, we want to set the value to the corresponding image, so that the image displays instead of the number where needed.

                var value = (this.board[index] > 0 ? this.board[index] : ''),
                    value_solution = (this.boardSolution[index] > 0 ? this.boardSolution[index] : ''),
                    cell = $('<div></div>')
                    .addClass('cell')
                    .addClass(function() { return "number-panel-" + value; })
                    .attr('x', position.x)
                    .attr('y', position.y)
                    .attr('gr', group_position.x + '' + group_position.y)
                    .html('<span>' + value + '</span>');

                if (this.displaySolution) {
                    $('<span class="solution">(' + value_solution + ')</span>').appendTo(cell);
                }

                if (value > 0) {
                    cell.addClass('fix');
                }

                if (position.x % this.n === 0 && position.x != this.nn) {
                    cell.addClass('border_h');
                }

                if (position.y % this.n === 0 && position.y != this.nn) {
                    cell.addClass('border_v');
                }

                cell.appendTo(sudoku_board);
                index++;
            }
        }

        sudoku_board.appendTo('#' + this.id);

        //draw console
        var sudoku_console_cotainer = $('<div></div>').addClass('board_console_container');
        var sudoku_console = $('<div></div>').addClass('board_console');

        for (i = 1; i <= this.nn; i++) {
            var numberpnl = i;
            $('<div></div>').addClass('num').addClass(function() { return "number-panel-" + numberpnl; }).text(i).appendTo(sudoku_console);
        }

        $('<div></div>').addClass('num remove').text('X').appendTo(sudoku_console);
        $('<div></div>').addClass('num note').text('?').appendTo(sudoku_console);

        //draw gameover
        var sudoku_gameover = $('<div class="gameover_container"><div class="gameover">Congratulation!</div></div>');

        //add all to sudoku container
        sudoku_console_cotainer.appendTo('#' + this.id).hide();
        sudoku_console.appendTo(sudoku_console_cotainer);
        sudoku_statistics.appendTo('#' + this.id);
        sudoku_gameover.appendTo('#' + this.id).hide();

        //adjust size
        this.resizeWindow();
    };
    Sudoku.prototype.resizeWindow = function() {
        console.time("resizeWindow");

        var screen = {
            w: $(window).width(),
            h: $(window).height()
        };

        //adjust the board
        var b_pos = $('#' + this.id + ' .sudoku_board').offset(),
            b_dim = {
                w: $('#' + this.id + ' .sudoku_board').width(),
                h: $('#' + this.id + ' .sudoku_board').height()
            },
            s_dim = {
                w: $('#' + this.id + ' .statistics').width(),
                h: $('#' + this.id + ' .statistics').height()
            };

        var screen_wr = screen.w + s_dim.h + b_pos.top + 10;

        if (screen_wr > screen.h) {
            $('#' + this.id + ' .sudoku_board').css('width', (screen.h - b_pos.top - s_dim.h - 14));
            $('#' + this.id + ' .board_console').css('width', (b_dim.h / 2));
        } else {
            $('#' + this.id + ' .sudoku_board').css('width', '98%');
            $('#' + this.id + ' .board_console').css('width', '50%');
        }

        var cell_width = $('#' + this.id + ' .sudoku_board .cell:first').width(),
            note_with = Math.floor(cell_width / 2) - 1;

        $('#' + this.id + ' .sudoku_board .cell').height(cell_width);
        $('#' + this.id + ' .sudoku_board .cell span').css('line-height', cell_width + 'px');
        $('#' + this.id + ' .sudoku_board .cell .note').css({
            'line-height': note_with + 'px',
            'width': note_with,
            'height': note_with
        });

        //adjust the console
        var console_cell_width = $('#' + this.id + ' .board_console .num:first').width();
        $('#' + this.id + ' .board_console .num').css('height', console_cell_width);
        $('#' + this.id + ' .board_console .num').css('line-height', console_cell_width + 'px');

        //adjust console
        b_dim = {
            w: $('#' + this.id + ' .sudoku_board').width(),
            h: $('#' + this.id + ' .sudoku_board').width()
        };
        b_pos = $('#' + this.id + ' .sudoku_board').offset();
        c_dim = {
            w: $('#' + this.id + ' .board_console').width(),
            h: $('#' + this.id + ' .board_console').height()
        };

        //adjust the gameover container
        var gameover_pos_new = {
            left: (screen.w / 20),
            top: (screen.w / 20 + b_pos.top)
        };

        $('#' + this.id + ' .gameover').css({
            'left': gameover_pos_new.left,
            'top': gameover_pos_new.top
        });

        console.log('screen', screen);
        console.timeEnd("resizeWindow");
    };
    /**
    Show console
    */
    Sudoku.prototype.showConsole = function(cell) {
        $('#' + this.id + ' .board_console_container').show();

        var
            t = this,
            oldNotes = $(this.cell).find('.note');

        //init
        $('#' + t.id + ' .board_console .num').removeClass('selected');

        //mark buttons
        if (t.markNotes) {
            //select markNote button
            $('#' + t.id + ' .board_console .num.note').addClass('selected');

            //select buttons
            $.each(oldNotes, function() {
                var noteNum = $(this).text();
                $('#' + t.id + ' .board_console .num:contains(' + noteNum + ')').addClass('selected');
            });
        }

        return this;
    };
    /**
    Hide console
    */
    Sudoku.prototype.hideConsole = function(cell) {
        $('#' + this.id + ' .board_console_container').hide();
        return this;
    };
    /**
    Select cell and prepare it for input from sudoku board console
    */
    Sudoku.prototype.cellSelect = function(cell) {
        this.cell = cell;

        var value = $(cell).text() | 0,
            position = {
                x: $(cell).attr('x'),
                y: $(cell).attr('y')
            },
            group_position = {
                x: Math.floor((position.x - 1) / 3),
                y: Math.floor((position.y - 1) / 3)
            },
            horizontal_cells = $('#' + this.id + ' .sudoku_board .cell[x="' + position.x + '"]'),
            vertical_cells = $('#' + this.id + ' .sudoku_board .cell[y="' + position.y + '"]'),
            group_cells = $('#' + this.id + ' .sudoku_board .cell[gr="' + group_position.x + '' + group_position.y + '"]'),
            same_value_cells = $('#' + this.id + ' .sudoku_board .cell span:contains(' + value + ')');

        //remove all other selections
        $('#' + this.id + ' .sudoku_board .cell').removeClass('selected current group bg-danger');
        $('#' + this.id + ' .sudoku_board .cell span').removeClass('samevalue text-danger');
        //select current cell
        $(cell).addClass('selected current bg-danger');

        //highlight select cells
        if (this.highlight > 0) {
            horizontal_cells.addClass('selected');
            vertical_cells.addClass('selected');
            group_cells.addClass('selected group');
            same_value_cells.not($(cell).find('span')).addClass('samevalue text-danger');
        }

        if ($(this.cell).hasClass('fix')) {
            $('#' + this.id + ' .board_console .num').addClass('no');
        } else {
            $('#' + this.id + ' .board_console .num').removeClass('no');

            this.showConsole();
            this.resizeWindow();
        }
    };
    /**
    Add value from sudoku console to selected board cell
    */
    Sudoku.prototype.addValue = function(value) {
        console.log('prepare for addValue', value);

        var
            position = {
                x: $(this.cell).attr('x'),
                y: $(this.cell).attr('y')
            },
            group_position = {
                x: Math.floor((position.x - 1) / 3),
                y: Math.floor((position.y - 1) / 3)
            },

            horizontal_cells = '#' + this.id + ' .sudoku_board .cell[x="' + position.x + '"]',
            vertical_cells = '#' + this.id + ' .sudoku_board .cell[y="' + position.y + '"]',
            group_cells = '#' + this.id + ' .sudoku_board .cell[gr="' + group_position.x + '' + group_position.y + '"]',

            horizontal_cells_exists = $(horizontal_cells + ' span:contains(' + value + ')'),
            vertical_cells_exists = $(vertical_cells + ' span:contains(' + value + ')'),
            group_cells_exists = $(group_cells + ' span:contains(' + value + ')'),

            horizontal_notes = horizontal_cells + ' .note:contains(' + value + ')',
            vertical_notes = vertical_cells + ' .note:contains(' + value + ')',
            group_notes = group_cells + ' .note:contains(' + value + ')',

            old_value = parseInt($(this.cell).not('.notvalid').text()) || 0;


        if ($(this.cell).hasClass('fix')) {
            return;
        }

        //delete value or write it in cell
        $(this.cell).find('span').removeClass( "number-panel-1 number-panel-2 number-panel-3 number-panel-4 number-panel-5 number-panel-6 number-panel-7 number-panel-8 number-panel-9" ).addClass(function() {return (value === 0) ? '' : "number-panel-" + value;}).text((value === 0) ? '' : value);

        if (this.cell !== null && (horizontal_cells_exists.length || vertical_cells_exists.length || group_cells_exists.length)) {
            if (old_value !== value) {
                $(this.cell).addClass('notvalid');
            } else {
                $(this.cell).find('span').text('');
            }
        } else {
            //add value
            $(this.cell).removeClass('notvalid');
            console.log('Value added ', value);

            //remove all notes from current cell,  line column and group
            $(horizontal_notes).remove();
            $(vertical_notes).remove();
            $(group_notes).remove();
        }

        //recalculate completed cells
        this.cellsComplete = $('#' + this.id + ' .sudoku_board .cell:not(.notvalid) span:not(:empty)').length;
        console.log('is game over? ', this.cellsComplete, this.cellsNr, (this.cellsComplete === this.cellsNr));
        //game over
        if (this.cellsComplete === this.cellsNr) {
            this.gameOver();
        }

        $('#' + this.id + ' .statistics .cells_complete').text('' + this.cellsComplete + '/' + this.cellsNr);

        return this;
    };
    /**
    Add note from sudoku console to selected board cell
    */
    Sudoku.prototype.addNote = function(value) {
        console.log('addNote', value);

        var
            t = this,
            oldNotes = $(t.cell).find('.note'),
            note_width = Math.floor($(t.cell).width() / 2);

        //add note to cell
        if (oldNotes.length < 9) {
            $('<div></div>')
                .addClass('note')
                .css({
                    'line-height': note_width + 'px',
                    'height': note_width - 1,
                    'width': note_width - 1
                })
                .text(value)
                .appendTo(this.cell);
        }

        return this;
    };
    /**
    Remove note from sudoku console to selected board cell
    */
    Sudoku.prototype.removeNote = function(value) {
        if (value === 0) {
            $(this.cell).find('.note').remove();
        } else {
            $(this.cell).find('.note:contains(' + value + ')').remove();
        }

        return this;
    };
    /**
    End game routine
    */
    Sudoku.prototype.gameOver = function() {
        console.log('GAME OVER!');
        this.status = this.END;

        $('#' + this.id + ' .gameover_container').show();
        $('.count').val(1);
    };
    /**
    Run a new sudoku game
    */
    Sudoku.prototype.run = function() {
        this.status = this.RUNNING;

        var t = this;
        this.drawBoard();

        //click on board cell
        $('#' + this.id + ' .sudoku_board .cell').on('click', function(e) {
            t.cellSelect(this);
        });

        //click on console num
        //LOSTTODO: Make images not paste "NaN". What even is NaN? Not a number??? I think images can be numbers if they want to be.
        $('#' + this.id + ' .board_console .num').on('click', function(e) {
            var
                value = parseInt($(this).text());
                clickMarkNotes = $(this).hasClass('note'),
                clickRemove = $(this).hasClass('remove'),
                numSelected = $(this).hasClass('selected');

            if (clickMarkNotes) {
                console.log('clickMarkNotes');
                t.markNotes = !t.markNotes;

                if (t.markNotes) {
                    $(this).addClass('selected');
                } else {
                    $(this).removeClass('selected');
                    t.removeNote(0).showConsole();
                }

            } else {
                if (t.markNotes) {
                    if (!numSelected) {
                        if (!value) {
                            t.removeNote(0).hideConsole();
                        } else {
                            t.addValue(0).addNote(value).hideConsole();
                        }
                    } else {
                        t.removeNote(value).hideConsole();
                    }
                } else {
                    t.removeNote(0).addValue(value).hideConsole();
                }
            }
        });

        //click outer console
        $('#' + this.id + ' .board_console_container').on('click', function(e) {
            if ($(e.target).is('.board_console_container')) {
                $(this).hide();
            }
        });

        $(window).resize(function() {
            t.resizeWindow();
        });
    };
    //main
    $(function() {
        console.time("loading time");

        //init
        $('head').append('<meta name="viewport" content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,width=device-width,height=device-height,target-densitydpi=device-dpi,user-scalable=yes" />');

        //game
        var game = new Sudoku({
            id: 'sudoku_container',
            fixCellsNr: 30,
            highlight: 1,
            displayTitle: 1,
            //displaySolution: 1,
            //displaySolutionOnly: 1,
        });

        game.run();

        //restart game
        $('#' + game.id + ' .restart').on('click', function() {
            game.init().run();
        });

        console.timeEnd("loading time");
    });
</script>
