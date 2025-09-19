<style>
/* MY STYLES */

#container {
  width: 80vw;
  height: 80vw;
  background: #BBADA0;
	box-sizing: border-box;
	margin: 20px auto;
	border-radius: 5px;
	position: relative;
}

.cell {
	width: 16vw;
	height: 16vw;
	background-color: rgba(238, 228, 218, 0.35);
	float: left;
	margin-left: 3.2vw;
	margin-top: 3.2vw;
	line-height: 16vw;
	text-align: center;
	font-size: 1.5rem;
	border-radius: 5px;
}

#won, #lost {
	position: absolute;
	top: 3.2vw;
	left: 3.2vw;
	right: 3.2vw;
	bottom: 3.2vw;
	background-color: rgba(0, 0, 0, 0.5);
	color: #FFF;
	justify-content: center;
    align-items: center;
	line-height: 73.6vw;
	border-radius: 5px;
	font-size: 2rem;
	display: none;
}

/* Large devices (desktops, 62em and up) */
@media (min-width: 56em) {

	#container {
		width: 500px;
	  height: 500px;
	}

	.cell {
		width: 100px;
		height: 100px;
		margin-left: 20px;
		margin-top: 20px;
		line-height: 100px;
		font-size: 2.5rem;
	}

	.cell-1024, .cell-2048 {
		font-size: 2rem !important;
	}

	#won, #lost {
		top: 20px;
		left: 20px;
		right: 20px;
		bottom: 20px;
		line-height: 460px;
	}

}

/* CELLS STYLES */

.cell-2, .cell-4 {
	color: #776E65;
}

.cell-8, .cell-16, .cell-32, .cell-64,
.cell-128, .cell-256, .cell-512, .cell-1024,
.cell-2048 {
	color: #F9F6F2;
}

.cell-2 {
	background-color: #EEE4DA !important;
}

.cell-4 {
	background-color: #EDE0C8 !important;
}

.cell-8 {
	background-color: #F2B179 !important;
}

.cell-16 {
	background-color: #F59563 !important;
}

.cell-32 {
	background-color: #F67C5F !important;
}

.cell-64 {
	background-color: #F65E3B !important;
}

.cell-128 {
	background-color: #EDCF72 !important;
	box-shadow: 0px 0px 30px 10px rgba(243, 215, 116, 0.24), 0px 0px 0px 1px rgba(255, 255, 255, 0.14) inset;
}

.cell-256 {
	background-color: #EDCC61 !important;
	box-shadow: 0px 0px 30px 10px rgba(243, 215, 116, 0.318), 0px 0px 0px 1px rgba(255, 255, 255, 0.192) inset;
}

.cell-512 {
	background-color: #EDC850 !important;
	box-shadow: 0px 0px 30px 10px rgba(243, 215, 116, 0.396), 0px 0px 0px 1px rgba(255, 255, 255, 0.24) inset;
}

.cell-1024 {
	background-color: #EDC53F !important;
	box-shadow: 0px 0px 30px 10px rgba(243, 215, 116, 0.475), 0px 0px 0px 1px rgba(255, 255, 255, 0.286) inset;
	font-size: 1.25rem;
}

.cell-2048 {
	background-color: #EDC22E !important;
	box-shadow: 0px 0px 30px 10px rgba(243, 215, 116, 0.557), 0px 0px 0px 1px rgba(255, 255, 255, 0.333) inset;
	font-size: 1.25rem;
}
</style>