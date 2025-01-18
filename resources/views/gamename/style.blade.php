<style>
/* board */
.sudoku_board {
    margin:6px auto;
  
    width: 100% !important;

    overflow: hidden;
    
    -webkit-user-select: none;  
    -moz-user-select: none;    
    -ms-user-select: none;      
    user-select: none;
    
    box-shadow: 0px 0px 5px 5px #bdc3c7;
}

.sudoku_board .cell {    
    width:11.11%;    
    display: inline-block;    
    float:left;
    cursor:pointer;    
    text-align: center;
    overflow: hidden;  
    
    -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	    -moz-box-sizing: border-box;    /* Firefox, other Gecko */
	    box-sizing: border-box;
    
    box-shadow: 0px 0px 0px 1px #bdc3c7;
  
    background:white;
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
    color:#2c3e50;
    text-align:middle;    
}

.sudoku_board .cell.selected, .sudoku_board .cell.selected.fix {
    background:#FFE;    
}

.sudoku_board .cell.selected.current {
    box-shadow: 0px 0px 3px 3px #bdc3c7;
}

.sudoku_board .cell.selected.current span {
    color:white;
}

.sudoku_board .cell.selected.group {
    color:blue;    
}

.sudoku_board .cell span.samevalue, .sudoku_board .cell.fix span.samevalue {
    font-weight:bold;  
}

.sudoku_board .cell.notvalid, .sudoku_board .cell.selected.notvalid{
    font-weight:bold;
    color:white;;
    background:#e74c3c;
}

.sudoku_board .cell.fix {
    background:#ecf0f1;
    cursor:not-allowed;
}

.sudoku_board .cell.fix span {
  color:#7f8c8d;
}

.sudoku_board .cell .solution {
  color:#d35400;
}

.sudoku_board .cell .note {
    color:#bdc3c7;    
    width:30% !important;    
    height:30% !important;
    text-align: top !important;
    display: inline-block;    
    float:left;
    text-align:center;
  
    -webkit-box-sizing: border-box;
	    -moz-box-sizing: border-box;
	    box-sizing: border-box;
}

.gameover_container .gameover {
    color:white;
    font-weight:bold;
	    text-align:center; 
    
    display:block;
    position:absolute;       
    width:90%;    
    padding:10px;
    
    box-shadow: 0px 0px 5px 5px #bdc3c7;
}

/* console */
.board_console_container, .gameover_container {
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
    display:block;
    margin-left:25%;
    margin-top:25%;  
    width:50%;        
    color:white;
    background-color: rgba(127, 140, 141, 0.7);
    box-shadow: 0px 0px 5px 5px #bdc3c7;
}

.board_console .num {
    width:33.33%;    
    color:#2c3e50;    
    padding: 1px;
    display: inline-block;    
    font-weight:bold;
    text-align: center;    
    cursor:pointer;
    
    -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	    -moz-box-sizing: border-box;    /* Firefox, other Gecko */
	    box-sizing: border-box;
    
    box-shadow: 0px 0px 0px 1px #bdc3c7;
}


.board_console .num:hover {
    color:white;
    background:#f1c40f;
}

.board_console .num.remove {
    width:66.66%;    
}

.board_console .num.note {
    background:#95a5a6;
    color:#ecf0f1;
}

.board_console .num.note:hover {
    background:#95a5a6;
    color:#f1c40f;
}

.board_console .num.selected {
    background:#f1c40f;
    box-shadow: 0px 0px 3px 3px #bdc3c7;
}

.board_console .num.note.selected {
    background:#f1c40f;  
    box-shadow: 0px 0px 3px 3px #bdc3c7;
}

.board_console .num.note.selected:hover {
  color:white;
}

.board_console .num.no:hover {
    color:white;
    cursor:not-allowed;
}

.board_console .num.remove:hover {
    color:white;
    background:#c0392b;
}

.statistics {
    text-align:center;    
}



#sudoku_menu ul {
   margin: 0;
   padding: 100px 0px 0px 0px;
   list-style: none;
}

#sudoku_menu ul li{
  margin: 0px 50px;
}

#sudoku_menu ul li a {
  text-align:center;
  padding: 15px 20px;
  font-weight: bold;
  color: white;
  text-decoration: none;
  display: block;
  border-bottom: 1px solid #2c3e50;
}

#sudoku_menu.open-sidebar {
  left:0px;
}

#sidebar-toggle {
    z-index:3;
    background: #bdc3c7;
    border-radius: 3px;
    display: block;
    position: relative;
    padding: 22px 18px;
    float: left;
}

#sidebar-toggle .bar{
    display: block;
    width: 28px;
    margin-bottom: 4px;
    height: 4px;
    background-color: #f0f0f0;
    border-radius: 1px;   
}

#sidebar-toggle .bar:last-child{
     margin-bottom: 0;   
}



/*Responsive Stuff*/

@media all and (orientation:portrait) and (min-width: 640px){
    h1 { font-size:50px; }
    .statistics { font-size:30px; }    
    .sudoku_board .cell span { font-size:60px; }    
    .board_console .num { font-size:60px; }
}

@media all and (orientation:landscape) and (min-height: 640px){
    h1 { font-size:50px; }
    .statistics { font-size:30px; }
    .sudoku_board .cell span { font-size:50px; }
    .board_console .num { font-size:50px; }
}

@media all and (orientation:portrait) and (max-width: 1000px){
    .sudoku_board .cell span { font-size:30px; }   
}

@media all and (orientation:portrait) and (max-width: 640px){
	.sudoku_board .cell span { font-size:24px; }
  .sudoku_board .cell .note { font-size:10px; }
}

@media all and (orientation:portrait) and (max-width: 470px){
	.sudoku_board .cell span { font-size:16px; }
.sudoku_board .cell .note { font-size:8px; }
}

@media all and (orientation:portrait) and (max-width: 320px){
	.sudoku_board .cell span { font-size:12px; }
.sudoku_board .cell .note { font-size:8px; }
}

@media all and (orientation:portrait) and  (max-width: 240px){
	.sudoku_board .cell span { font-size:10px; }   
}
</style>