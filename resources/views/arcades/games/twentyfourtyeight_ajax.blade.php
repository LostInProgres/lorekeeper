<div class="row">
  <div class="col-md-9">
      <div id="container">
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        <div class="cell"></div>
        {!! Form::open(['url' => 'arcade/' . $arcade->id . '/play']) !!}
          {!! Form::hidden('count', 0, ['class' => 'count']) !!}
          <div id="won">
            <h2>You've Won! {!! Form::submit('submit score', ['class' => 'btn btn-primary', 'id' => 'solve']) !!}</h2><br>
          </div>
          <div id="lost">
              <h2>Game over! {!! Form::submit('submit score', ['class' => 'btn btn-primary', 'id' => 'solve']) !!}</h2><br>
          </div>
        {!! Form::close() !!}
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <p>score</p>
      <p class="actualscore"></p>
    </div>
  </div>

</div>


@include('arcades.games.twentyfourtyeight_CSS', ['arcade' => $arcade])

<script>
function Game () {
  this.grid = [[0, 0, 0, 0],[0, 0, 0, 0],[0, 0, 0,    0],[0, 0, 0, 0]];
  this.score = 0;
  this.init();
}

Game.prototype.init = function () {
  this.addRandomCell();
  this.addRandomCell();
  this.printCells();
  this.printScore();
  this.move();
};

Game.prototype.getRandom2 = function () {
  return Math.random() < 0.9 ? 2 : 4;
};

Game.prototype.getRandom4 = function () {
  return Math.floor(Math.random() * 4);
};

Game.prototype.addRandomCell = function () {
  var line = this.getRandom4();
  var column = this.getRandom4();

  if (this.grid[line][column] === 0) {
    this.grid[line][column] = this.getRandom2();
  } else {
    this.addRandomCell();
  }
};

Game.prototype.resetView = function () {
  var i,
      j,
      cell = document.getElementsByClassName('cell');

      i = 0;
      while (i < this.grid.length) {
        j = 0;
        while (j < this.grid[i].length) {
          cell[i*4 + j].innerHTML = '';
          cell[i*4 + j].className = 'cell';
          j += 1;
        }
        i += 1;
      }
};

Game.prototype.printCells = function () {
  var i,
      j,
      cell = document.getElementsByClassName('cell');

  this.resetView();

      i = 0;
      while (i < this.grid.length) {
        j = 0;
        while (j < this.grid[i].length) {
          if (this.grid[i][j] > 0) {
            cell[i*4 + j].innerHTML = this.grid[i][j];
          }
          j += 1;
        }
        i += 1;
      }
  this.addClasses();
};

Game.prototype.printScore = function () {
  var score = document.getElementsByClassName('actualscore')[0];

  score.innerHTML = this.score;
};

Game.prototype.addClasses = function () {
  var i,
      j,
      cell = document.getElementsByClassName('cell');

  i = 0;
  while (i < 16) {
    j = 2;
    if (cell[i].innerHTML) {
      while (j != cell[i].innerHTML) {
        j = j * 2;
      }
      cell[i].className = 'cell cell-' + j;
    }
    i += 1;
  }
};

Game.prototype.moveLeft = function () {
  var i,
      j,
      k,
      canMove = false;

  i = 0;
  while (i < this.grid.length) {
    if (this.grid[i] != [0, 0, 0, 0]) {
      k = 0;
      while (k < this.grid[i].length) {
        j = 0;
          while (j < this.grid[i].length - 1) {
            if (this.grid[i][j] === 0) {
              this.grid[i][j] = this.grid[i][j+1];
              this.grid[i][j+1] = 0;
              if (this.grid[i][j] !== 0) {
                canMove = true;
              }
            }
            j += 1;
          }
        k += 1;
      }
    }
    i += 1;
  }

  return canMove;

};

Game.prototype.moveRight = function () {
  var i,
      j,
      k,
      canMove = false;

  i = 0;
  while (i < this.grid.length) {
    if (this.grid[i] != [0, 0, 0, 0]) {
      k = 0;
      while (k < this.grid[i].length) {
        j = this.grid.length - 1;
          while (j > 0) {
            if (this.grid[i][j] === 0) {
              this.grid[i][j] = this.grid[i][j-1];
              this.grid[i][j-1] = 0;
              if (this.grid[i][j] !== 0) {
                canMove = true;
              }
            }
            j -= 1;
          }
        k += 1;
      }
    }
    i += 1;
  }

  return canMove;

};

Game.prototype.moveUp = function () {
  var i,
      j,
      k,
      canMove = false;

  k = 0;
  while (k < this.grid.length - 1) {
    i = 0;
    while (i < this.grid.length - 1) {
      j = 0;
      while (j < this.grid.length) {
        if (this.grid[i][j] === 0) {
          this.grid[i][j] = this.grid[i+1][j];
          this.grid[i+1][j] = 0;
          if (this.grid[i][j] !== 0) {
            canMove = true;
          }
        }
        j += 1;
      }
      i += 1;
    }
    k += 1;
  }

  return canMove;

};

Game.prototype.moveDown = function () {
  var i,
      j,
      k,
      canMove = false;

  k = 0;
  while (k < this.grid.length - 1) {
    i = this.grid.length - 1;
    while (i > 0) {
      j = 0;
      while (j < this.grid.length) {
        if (this.grid[i][j] === 0) {
          this.grid[i][j] = this.grid[i-1][j];
          this.grid[i-1][j] = 0;
          if (this.grid[i][j] !== 0) {
            canMove = true;
          }
        }
        j += 1;
      }
      i -= 1;
    }
    k += 1;
  }

  return canMove;

};

Game.prototype.checkMatchesLeft = function () {
  var i,
      j,
      canMerge = false;

  i = 0;
  while (i < this.grid.length) {
    j = 0;
    while (j < this.grid[i].length - 1) {
      if (this.grid[i][j] !== 0 && this.grid[i][j] === this.grid[i][j+1]) {
        this.grid[i][j] = this.grid[i][j] * 2;
        this.score += this.grid[i][j];
        this.grid[i][j+1] = 0;
        canMerge = true;
      }
      j += 1;
    }
    i += 1;
  }

  this.moveLeft();
  return canMerge;

};

Game.prototype.checkMatchesRight = function () {
  var i,
      j,
      canMerge = false;

  i = 0;
  while (i < this.grid.length) {
    j = this.grid.length - 1;
    while (j > 0) {
      if (this.grid[i][j] !== 0 && this.grid[i][j] === this.grid[i][j-1]) {
        this.grid[i][j] = this.grid[i][j] * 2;
        this.score += this.grid[i][j];
        this.grid[i][j-1] = 0;
        canMerge = true;
      }
      j -= 1;
    }
    i += 1;
  }

  this.moveRight();
  return canMerge;

};

Game.prototype.checkMatchesUp = function () {
  var i,
      j,
      canMerge = false;

  i = 0;
  while (i < this.grid.length - 1) {
    j = 0;
    while (j < this.grid.length) {
      if (this.grid[i][j] !== 0 && this.grid[i][j] === this.grid[i+1][j]) {
        this.grid[i][j] = this.grid[i][j] * 2;
        this.score += this.grid[i][j];
        this.grid[i+1][j] = 0;
        canMerge = true;
      }
      j += 1;
    }
    i += 1;
  }

  this.moveUp();
  return canMerge;

};

Game.prototype.checkMatchesDown = function () {
  var i,
      j,
      canMerge = false;

  i = this.grid.length - 1;
  while (i > 0) {
    j = 0;
    while (j < this.grid.length) {
      if (this.grid[i][j] !== 0 && this.grid[i][j] === this.grid[i-1][j]) {
        this.grid[i][j] = this.grid[i][j] * 2;
        this.score += this.grid[i][j];
        this.grid[i-1][j] = 0;
        canMerge = true;
      }
      j += 1;
    }
    i -= 1;
  }

  this.moveDown();
  return canMerge;

};

Game.prototype.move = function () {

  var self = this;
  var move,
      check;

  document.addEventListener('keydown', function movements(e) {
    e = e || window.event;

    if (e.keyCode == '37') {
      move = self.moveLeft();
      check = self.checkMatchesLeft();
      if (move || check) {
        self.addRandomCell();
        self.printCells();
        self.printScore();
      }
    }
    else if (e.keyCode == '38') {
      move = self.moveUp();
      check = self.checkMatchesUp();
      if (move || check) {
        self.addRandomCell();
        self.printCells();
        self.printScore();
      }
    }
    else if (e.keyCode == '39') {
      move = self.moveRight();
      check = self.checkMatchesRight();
      if (move || check) {
        self.addRandomCell();
        self.printCells();
        self.printScore();
      }
    }
    else if (e.keyCode == '40') {
      move = self.moveDown();
      check = self.checkMatchesDown();
      if (move || check) {
        self.addRandomCell();
        self.printCells();
        self.printScore();
      }
    }

    self.checkIfLost();

    if (self.checkIfWon()) {
      console.log('gagné');
      document.removeEventListener('keydown', movements);
    }

  });

  document.addEventListener('touchstart', handleTouchStart, false);
  document.addEventListener('touchmove', handleTouchMove, false);

  var xDown = null;
  var yDown = null;

  function handleTouchStart(evt) {
      xDown = evt.touches[0].clientX;
      yDown = evt.touches[0].clientY;
  };

  function handleTouchMove(evt) {
    event.preventDefault();

    self.checkIfLost();

    if (self.checkIfWon()) {
      document.removeEventListener('touchstart', handleTouchStart, false);
    }

      if ( ! xDown || ! yDown ) {
          return;
      }

      var xUp = evt.touches[0].clientX;
      var yUp = evt.touches[0].clientY;

      var xDiff = xDown - xUp;
      var yDiff = yDown - yUp;

      if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {
          if ( xDiff > 0 ) {
            move = self.moveLeft();
            check = self.checkMatchesLeft();
            if (move || check) {
              self.addRandomCell();
              self.printCells();
              self.printScore();
            }
          } else {
            move = self.moveRight();
            check = self.checkMatchesRight();
            if (move || check) {
              self.addRandomCell();
              self.printCells();
              self.printScore();
            }
          }
      } else {
          if ( yDiff > 0 ) {
            move = self.moveUp();
            check = self.checkMatchesUp();
            if (move || check) {
              self.addRandomCell();
              self.printCells();
              self.printScore();
            }
          } else {
            move = self.moveDown();
            check = self.checkMatchesDown();
            if (move || check) {
              self.addRandomCell();
              self.printCells();
              self.printScore();
            }
          }
      }
      /* reset values */
      xDown = null;
      yDown = null;

  };

};

Game.prototype.checkIfWon = function () {
  var i,
      won = false,
      div = document.getElementById('won');

  i = 0;
  while (i < this.grid.length) {
    if (this.grid[i].indexOf(2048) > -1) {
      won = true;
      div.style.display = 'block';
      break;
    }
    i += 1;
  }

  return won;

};

Game.prototype.checkIfLost = function () {
  var i,
      j,
      lost = true,
      div = document.getElementById('lost');

  i = 0;
  while (i < this.grid.length - 1) {
    j = 0;
    while (j < this.grid.length) {
      if (this.grid[i][j] === 0 || this.grid[i][j] === this.grid[i+1][j] || this.grid[i+1][j] === 0) {
        lost = false;
      }
      j += 1;
    }
    i += 1;
  }

  i = 0;
  while (i < this.grid.length) {
    j = 0;
    while (j < this.grid[i].length - 1) {
      if (this.grid[i][j] === 0 || this.grid[i][j] === this.grid[i][j+1] || this.grid[i][j+1] === 0) {
        lost = false;
      }
      j += 1;
    }
    i += 1;
  }

  if (lost) {
    div.style.display = 'flex';
  }

};

new Game();
</script>