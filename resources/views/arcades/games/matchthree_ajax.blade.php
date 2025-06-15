<h1>Basic Match 3 Game</h1>
 <div id="exemplo"></div>

 <style>
    body{
  font-family: Verdana, Arial;
  text-align: center;
}
h1{
  margin: 20px;
}
#tabuleiro{
    display: inline-block;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    margin: 0;
    border-style: none none none none;
    border-width: 1px;
    border-color: #000;
}
.match3{
    display: inline-block;
    font-family: Verdana, Arial;
    background-color: #f9fac0;
   border: 1px solid #a51f22;
}
.casa{
    box-sizing: border-box;
   -webkit-box-sizing: border-box;
   -moz-box-sizing: border-box;
    position: relative;
    display: inline-block;
    vertical-align: top;
    width: 40px;
    height: 40px;
    margin: 0;
    padding: 2px;
    cursor: pointer;
}
.casa:hover{
    border: 2px solid #fff;
    padding: 0;
}

.casa img{
    position: relative;
    width: 30px;
    height: 30px;
    margin: 3px;
}
.selecionado{
    border: 2px solid #fff;
    padding: 0;
}
#placar{
    display: inline-block;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    float: right;
    width: 250px;
    height: 100%;
    padding: 10px;
    margin: 0;
    text-align: left;
    border-style: none;
    
}
.peca0{
    background-color: #89f673;
}
.peca1{
    background-color: #f6d273;
}
.peca2{
    background-color: #d273f6;
}
.peca3{
    background-color: #f68573;
}
.peca4{
    background-color: #73acf6;
}
</style>

<script>
    var match3 = new Object();
// informando quais imagens devem ser usadas
match3.imagens = [
    'https://www.whistlercrest.com/images/data/items/nwio5x8WB4329-image.png', 
    'https://www.whistlercrest.com/images/data/items/k9AEbSEQYc330-image.png', 
    'https://www.whistlercrest.com/images/data/items/rtJuPaEzqd331-image.png', 
    'https://www.whistlercrest.com/images/data/items/8QPDxSMtti332-image.png', 
    'https://www.whistlercrest.com/images/data/items/PZWB2gv6Cy333-image.png'
];
match3.selecionado = '';
match3.placar = new Object();
match3.placar.pontos = 0;
match3.placar.movimentos = 0;
match3.placar.combinacoes = 0;
match3.placar.sorte = 0;
match3.placar.trincas = 0;
match3.placar.quadras = 0;
match3.placar.quinas = 0;
//objeto anição possui variáveis para configurar as animações de transição
match3.animacao = new Object();
match3.animacao.velocidade = 100;
//objeto célula possui variáveis para a montagem do tabuleiro
match3.celula = new Object();
match3.celula.largura = 40;
//cria o array para a montagem do tabuleiro
match3.criaTabuleiro = function (linhas, colunas){
    match3.linhas = linhas;
    match3.colunas = colunas;
    match3.tabuleiro = new Object();
    match3.pecas = match3.imagens.length;
    match3.tabuleiro.linhas = new Array();
    for(i = 0; i < colunas; i++){
        var coluna = new Array();
        for(i2 = 0; i2 < linhas; i2++){
            var peca = (Math.floor(Math.random()*match3.pecas));
            coluna.push(peca);
        } 
        match3.tabuleiro.linhas.push(coluna);
    }
};
//monta uma peca do tabuleiro
match3.montaPeca = function(l, c, nPeca){
    var tempId = String(l) + '-' + String(c);
    var title = ''; //"id=' + tempId + ' peca=' + nPeca + ' ";
    var peca = '<div class="casa peca' + nPeca +'" id="'+ l + '-' + c +'" data-linha="'+ l +'" data-coluna="' + c + '" data-peca="' + nPeca + '" ' + title +'><img src="' + match3.imagens[nPeca] + '" /></div>';
    return peca;
};

//monta a representação gráfica do tabuleiro
match3.montaTabuleiro = function(container){
    match3.container = container;
    //percorrendo as linhas do tabuleiro
    $(container).html('<div id="tabuleiro"></div>');
    $.each(match3.tabuleiro.linhas, function(indice, linha){
        //percorrendo colunas do tabuleiro
        
        $.each(linha, function(ind2, coluna){
            var l = indice;
            var c = ind2;
            var nPeca = coluna;
            $("#tabuleiro").append(match3.montaPeca(l, c, nPeca));
        });
        $("#tabuleiro").append('</br>');
    });
    
    $(container).append('<div id="placar">SCORE: <span id="nPontos">0</span><br>matches: <span id="nCombinacoes">0</span><br>match 3: <span id="nTrincas">0</span><br>match 4: <span id="nQuadras">0</span><br>match 5: <span id="nQuinas">0</span><br>lucky: <span id="nSorte">0</span><br><br>moves: <span id="nMovimentos">0</span></div>');
    
    var larguraContainer = match3.celula.largura * match3.tabuleiro.linhas[0].length + 250; 
    var larguraTabuleiro = match3.celula.largura * match3.tabuleiro.linhas[0].length; 
    var altura = match3.celula.altura * match3.tabuleiro.linhas.length; 
    
    $(container).addClass('match3').css('width', larguraContainer + 'px').css('height', altura + 'px');
    $('#tabuleiro').css('width', larguraTabuleiro + 'px').css('height', altura + 'px');
    
    match3.verificaTudo2('sorte');
};

match3.placar.incrementa = function(placar){
    switch(placar){
        case 'combinacao' : 
            match3.placar.combinacoes++;
            $("#nCombinacoes").html(match3.placar.combinacoes);
            break;
        case 'sorte' : 
            match3.placar.sorte++;
            $("#nSorte").html(match3.placar.sorte);
            match3.placar.pontos += 2;
            $("#nPontos").html(match3.placar.pontos);
            break;
        case 'trinca' : 
            match3.placar.trincas++;
            $("#nTrincas").html(match3.placar.trincas);
            match3.placar.pontos += 3;
            $("#nPontos").html(match3.placar.pontos);
            break;
        case 'quadra' : 
            match3.placar.quadras++;
            $("#nQuadras").html(match3.placar.quadras);
            match3.placar.pontos += 4;
            $("#nPontos").html(match3.placar.pontos);
            break;
        case 'quina' : 
            match3.placar.quinas++;
            $("#nQuinas").html(match3.placar.quinas);
            match3.placar.pontos += 5;
            $("#nPontos").html(match3.placar.pontos);
            break;
        case 'movimento' :
            match3.placar.movimentos++;
            $("#nMovimentos").html(match3.placar.movimentos);
            break;
            
    }
    
}
match3.pedeTroca = function(id){
    if(match3.selecionado === ''){
        match3.selecionado = id;
        $("#" + id).addClass("selecionado");
    }else{
        var linha = $("#" + match3.selecionado).data("linha");
        var coluna = $("#" + match3.selecionado).data("coluna");
       
        if(
            //id === (String(linha - 1) + '-' + String(coluna-1)) || diagonal
            id === (String(linha - 1) + '-' + String(coluna)) ||
            //id === (String(linha - 1) + '-' + String(coluna+1)) || diagonal
            id === (String(linha) + '-' + String(coluna-1)) ||
            id === (String(linha) + '-' + String(coluna+1)) ||
            //id === (String(linha + 1) + '-' + String(coluna-1)) || diagonal
            id === (String(linha + 1) + '-' + String(coluna)) //||
            //id === (String(linha + 1) + '-' + String(coluna+1)) diagonal
        ){
            $("#" + match3.selecionado).removeClass("selecionado");
            match3.troca(match3.selecionado, id);
            match3.selecionado = '';
        }else{
            $("#" + match3.selecionado).removeClass("selecionado");
            match3.selecionado = id;
            $("#" + match3.selecionado).addClass("selecionado");
        }

    }
}
match3.troca = function(id1, id2){
    var peca1 = match3.tabuleiro.linhas[$("#" + id1).data('linha')][$("#" + id1).data('coluna')];
    var peca2 = match3.tabuleiro.linhas[$("#" + id2).data('linha')][$("#" + id2).data('coluna')];
    var title1 = $("#" + id1).attr('title');
    var title2 = $("#" + id2).attr('title');
    var class1 = 'peca' + peca1;
    var class2 = 'peca' + peca2;
    match3.tabuleiro.linhas[$("#" + id1).data('linha')][$("#" + id1).data('coluna')]=peca2;
    match3.tabuleiro.linhas[$("#" + id2).data('linha')][$("#" + id2).data('coluna')]=peca1;
    $("#" + id1).data('peca', peca2);
    $("#" + id2).data('peca', peca1);
    $("#" + id1).attr('title', title2);
    $("#" + id2).attr('title', title1);
    $("#" + id1).removeClass(class1).addClass(class2);
    $("#" + id2).removeClass(class2).addClass(class1);
    var distancia = match3.celula.largura; 
    match3.placar.incrementa('movimento');
    if($("#" + id1).data('linha') === $("#" + id2).data('linha')){
        var top1 = '';
        var top2 = '';
    }else if($("#" + id1).data('linha') > $("#" + id2).data('linha')){
        var top1 = "-=" + distancia;
        var top2 = "+=" + distancia;
    }else if($("#" + id1).data('linha') < $("#" + id2).data('linha')){
        var top1 = "+=" + distancia;
        var top2 = "-=" + distancia;
    }
    if($("#" + id1).data('coluna') === $("#" + id2).data('coluna')){
        var left1 = '';
        var left2 = '';
    }else if($("#" + id1).data('coluna') > $("#" + id2).data('coluna')){
        var left1 = "-=" + distancia;
        var left2 = "+=" + distancia;
    }else if($("#" + id1).data('coluna') < $("#" + id2).data('coluna')){
        var left1 = "+=" + distancia;
        var left2 = "-=" + distancia;
    }

    $( "#" + id1 ).animate({
        top: top1,
        left: left1
        
      }, match3.animacao.velocidade, function() {
        $( "#" + id1 ).css("top", 0).css("left", 0);
        $("#" + id1 + ' img').attr('src', match3.imagens[peca2]);
    });
    $( "#" + id2 ).animate({
        top: top2,
        left: left2
        
      }, match3.animacao.velocidade, function() {
         $( "#" + id2 ).css("top", 0).css("left", 0);
         $("#" + id2 + ' img').attr('src', match3.imagens[peca1]);
        match3.verificaTudo2();
    });
};

match3.somePeca = function(id){
    var linha = $( "#" + id).data('linha');
    var coluna = $( "#" + id).data('coluna');
    var pecaAntiga = match3.tabuleiro.linhas[linha][coluna];
    if(linha === 0){
        var novaPeca = (Math.floor(Math.random()*match3.pecas));
    }
    else{
        var novaPeca = match3.tabuleiro.linhas[linha-1][coluna];
    }
    match3.tabuleiro.linhas[linha][coluna] = novaPeca; 
        
    for (i = linha -1; i >= 0; i--){
        var idAtual = String(i) + '-' + String(coluna);
        match3.caiPeca(idAtual);
    }
    match3.somePecaVisual(id, novaPeca, pecaAntiga);
};

match3.caiPeca = function(id){
    var linha = $( "#" + id).data('linha');
    var coluna = $( "#" + id).data('coluna');
    var pecaAntiga = match3.tabuleiro.linhas[linha][coluna];
    if(linha === 0){
        var novaPeca = (Math.floor(Math.random()*match3.pecas));
    }
    else{
        var novaPeca = match3.tabuleiro.linhas[linha-1][coluna];
    }
    match3.tabuleiro.linhas[linha][coluna] = novaPeca; 
    match3.caiPecaVisual(id, novaPeca, pecaAntiga);
};
match3.somePecaVisual = function(id, novaPeca, pecaAntiga){
    $("#" + id).animate({
        opacity: 0
    }, match3.animacao.velocidade, function() {
        $("#" + id).css('opacity', '1');
        $("#" + id).data('peca', novaPeca);
        $("#" + id).attr('title', 'id = '+ id + ' peca = ' + novaPeca);
        $("#" + id).removeClass('peca' + pecaAntiga);
        $("#" + id).addClass('peca' + novaPeca);
        $("#" + id + ' img').attr('src', match3.imagens[novaPeca]);
    });
};
match3.caiPecaVisual = function(id, novaPeca, pecaAntiga){
    $("#" + id).animate({
        top: match3.celula.largura
    }, match3.animacao.velocidade, function() {
        $("#" + id).css('top', 0);
        $("#" + id).data('peca', novaPeca);
        $("#" + id).attr('title', 'id = '+ id + ' peca = ' + novaPeca);
        $("#" + id).removeClass('peca' + pecaAntiga);
        $("#" + id).addClass('peca' + novaPeca);
        $("#" + id + ' img').attr('src', match3.imagens[novaPeca]);
    });
};

match3.verificaTudo2 = function(sorte){
    sorte = (sorte === undefined)? false : true ;
    var totalDeLinhas = match3.tabuleiro.linhas.length -1;
    var totalDeColunas = match3.tabuleiro.linhas[0].length -1;
    var match = false;
    for(linha = totalDeLinhas; linha > -1 && match === false; linha--){
        for(coluna = totalDeColunas; coluna > -1 && match === false; coluna--){
           match = match3.verificaMatch(linha, coluna);
        }
    }
    if(match === true){
        match3.verificaTudo2(true);
        if(sorte === true){
            match3.placar.incrementa('sorte');
        }
    }
};
match3.verificaMatch = function(linha, coluna){
    var peca = match3.tabuleiro.linhas[linha][coluna];
    var tempPeca = peca;
    var tempLinha = linha;
    var tempColuna = coluna;
    var matchLinha = 0;
    var matchColuna = 0;
    var eliminaLinha = new Array();
    var eliminaColuna = new Array();
    eliminaLinha.push(linha + '-' + coluna);
    eliminaColuna.push(linha + '-' + coluna);
    //verificando linha
    
    while((tempPeca === peca)&&(tempLinha > -1)){
        tempLinha--;
        matchColuna++; 
        if(tempLinha !== -1){
            tempPeca = match3.tabuleiro.linhas[String(tempLinha)][String(coluna)];
            //console.log(tempLinha + '-' + coluna);
            //colocando o id num array que será usado para eliminar as peças caso façam match
            if(peca === tempPeca){
                eliminaColuna.push(String(tempLinha) + '-' + String(coluna));
            }    
        }
    }
    tempPeca = peca;
    while((tempPeca === peca)&&(tempColuna > -1)){
        tempColuna--;
        matchLinha++; 
        tempPeca = match3.tabuleiro.linhas[linha][tempColuna];
        //colocando o id num array que será usado para eliminar as peças caso façam match
        if(peca === tempPeca){
            eliminaLinha.push(linha + '-' + tempColuna);
        }    
        
    }
    if((matchLinha > 2) || (matchColuna > 2)){
        if(matchColuna > 2){
            var totalEliminaColuna = eliminaColuna.length -1;
            while(totalEliminaColuna > -1){
                match3.somePeca(eliminaColuna[totalEliminaColuna]);
                totalEliminaColuna--;
            };
            match3.placar.incrementa('combinacao');
        }
        if(matchLinha > 2){ 
            $.each(eliminaLinha, function(indice, id){
                match3.somePeca(id); 
            });
            match3.placar.incrementa('combinacao');
            switch(eliminaLinha.length){
                case 3 : 
                    match3.placar.incrementa('trinca');
                    break;
                case 4 : 
                    match3.placar.incrementa('quadra');
                    break;
                case 5 : 
                    match3.placar.incrementa('quina');
                    break;
            }
        }
        return true;
    }
    else{
       return false;
    }
};

$("body").ready(function(){
    match3.criaTabuleiro(15,10);
    match3.montaTabuleiro('#exemplo');

    $(".casa").on("click", function(){
        match3.pedeTroca($(this).attr('id'));
    }); 
    $("button").on("click", function(){
        match3.verificaTudo2();
    });
    
});


</script>