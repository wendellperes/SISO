var req;

function Validacao(tipo, param, valor) {

// Verificando Browser
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
    var url = "../webservices/validacao.php?tipo="+tipo+"&param="+param+"&valor="+valor;

// Chamada do método open para processar a requisição
    req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
    req.onreadystatechange = function () {

        // Exibe a mensagem "Buscando Noticias..." enquanto carrega
        if (req.readyState == 1) {
            document.getElementById('resultadoqtdvalor').innerHTML = 'Calculando...';
        }

        // Verifica se o Ajax realizou todas as operações corretamente
        if (req.readyState == 4 && req.status == 200) {

            // Resposta retornada pelo busca.php
            var resposta = req.responseText;

            // Abaixo colocamos a(s) resposta(s) na div resultado
            document.getElementById('resultadoqtdvalor').innerHTML = resposta;
        }
    }
    req.send(null);
}

function buscarProdutos(tipo, param, valor) {

// Verificando Browser
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
    var url = "../webservices/retornarprodutos.php?tipo="+tipo+"&param="+param+"&valor="+valor;

// Chamada do método open para processar a requisição
    req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
    req.onreadystatechange = function () {

        // Exibe a mensagem "Buscando Noticias..." enquanto carrega
        if (req.readyState == 1) {
            document.getElementById('resultadoprodutos').innerHTML = 'Buscando Produtos...';
        }

        // Verifica se o Ajax realizou todas as operações corretamente
        if (req.readyState == 4 && req.status == 200) {

            // Resposta retornada pelo busca.php
            var resposta = req.responseText;

            // Abaixo colocamos a(s) resposta(s) na div resultado
            document.getElementById('resultadoprodutos').innerHTML = resposta;
        }
    }
    req.send(null);
}

function buscarFornecedor(tipo, valor) {

// Verificando Browser
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
    var url = "../webservices/retornarfornecedor.php?tipo="+tipo+"&valor="+valor;

// Chamada do método open para processar a requisição
    req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
    req.onreadystatechange = function () {

        // Exibe a mensagem "Buscando Noticias..." enquanto carrega
        if (req.readyState == 1) {
            document.getElementById('resultadofornecedor').innerHTML = 'Buscando Fornecedores...';
        }

        // Verifica se o Ajax realizou todas as operações corretamente
        if (req.readyState == 4 && req.status == 200) {

            // Resposta retornada pelo busca.php
            var resposta = req.responseText;

            // Abaixo colocamos a(s) resposta(s) na div resultado
            document.getElementById('resultadofornecedor').innerHTML = resposta;
        }
    }
    req.send(null);
}

function chamarProdutoSaida(tipo, param, valor) {

// Verificando Browser
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
    var url = "../webservices/retornarprodutos.php?tipo="+tipo+"&param="+param+"&valor="+valor;

// Chamada do método open para processar a requisição
    req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
    req.onreadystatechange = function () {

        // Exibe a mensagem "Buscando Noticias..." enquanto carrega
        if (req.readyState == 1) {
            document.getElementById('resultadoprodutos').innerHTML = 'Buscando Produtos ...';
        }

        // Verifica se o Ajax realizou todas as operações corretamente
        if (req.readyState == 4 && req.status == 200) {

            // Resposta retornada pelo busca.php
            var resposta = req.responseText;
            
            // Abaixo colocamos a(s) resposta(s) na div resultado
            document.getElementById('resultadoprodutos').innerHTML = resposta;
            
        }
    }
    req.send(null);
}

