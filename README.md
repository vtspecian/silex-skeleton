# silex-skeleton

Isto é uma estrutura do framework Silex 1.3.5, está organizado de uma forma que agiliza o desevolvimento de novas aplicações.
Segue abaixo mais detalhes de sua organização.

### Controllers

Para adicionar um novo controller basta criar uma classe na pasta app/controllers que tenha o sufixo "Controller" em seu nome.

### Views

As views utilizam o template engine do Symfony PHPEngine, para renderizar uma view é necessário criar uma pasta dentro de app/views/ com o nome igual ao prefixo de seu controller, por exemplo, se o seu controller se chama HelloController, é necessário criar uma pasta chamada hello, e dentro desta pasta criar sua view, para chama-lá é necessário utilizar o seguinte comando em seu controller:
```php
return $app['templating-hello']->render('hello.php', ['nome' => 'Victor']);
```

### Models

Para criar um model basta criar uma classe na pasta app/models que extenda a classe BaseModel, é recomendado que o sufixo da classe tenha a palavra "Model" para se manter uma organização.
No controller não é necessário adicionar o include do Model, basta chamá-lo normalmente como no exemplo:
```php
$Produto  = new ProdutoModel($app);
$produtos = $Produto->findAll();
```

### Middlewares

Para criar um middleware basta criar uma classe na pasta app/middlewares que contenha a palavra "Middleware" no sufixo de seu nome, esta classe deve implementar a interface "IMiddleware", na aplicação tem um exemplo de middleware que valida a sessão.
Com o middleware criado, cada rota que desejar utilizar o middleware deve possuir uma chamada ao método before, por exemplo, se o middleware se chamar "session", então a rota deve chamar o método before da seguinte forma:
```php
->before($middleware['session']);
```

### Dados de acesso ao banco de dados

Os dados de acesso ao banco de dados ficam em app/config/database.php

Para mais informações sobre o funcionamento do Silex, acesse o seguinte link: [http://silex.sensiolabs.org/doc/1.3/](http://silex.sensiolabs.org/doc/1.3/)



