Fluxo de desenvolvimento com Symfony PHP
========================


**Instalar o Symfony**

A forma mais prática de instalar o symfony é usando o composer  
composer create-project symfony/framework-standard-edition my_project_name  
  
Durante a instalação será pedido os dados de conexão do banco de dados e servidor de SMTP.  
  
Para executar o projeto em ambiente de desenvolvimento pode ser usado o servidor interno do PHP, através do console do Symfony. Para isso, na pasta raiz do projeto execute o comando `php bin/console server:run`, o servidor será subir e a aplicação pode ser acessada pelo navegador em `127.0.0.1:8000`.  
Tambem é possível executar a aplicação com um Virtual Hosts para o dominio de desenvolvimento.  
Exemplo de Virtual Host

    <VirtualHost symfony.exemplo.dev:80>
        DocumentRoot "Caminho_para_a_pasta_raiz_do_projeto/web"
        ServerName symfony.exemplo.dev
        <Directory "Caminho_para_a_pasta_raiz_do_projeto/web/">
            Options All
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
    
**Fluxo das pincipais pastas**  
* **app**: Contem alguns arquivos de inicialização do Kernel da aplicação.
    * **config**: contem os arquivos de configurações da aplicação (banco de dados, seguranaça, rotas, email);
    * **Resources**: Contem os arquivos de views da aplicação (por padrão o symfony utiliza o Twig template engine para gerar as views);
* **bin**: Contem os arquivos usados para executar o console do symfony;
* **src**: Contem as pastes dos Bundles do projeto (por padrão o symfony gera o "AppBundle" para aplicação);
    * **AppBundle**: Contem  as pastas de "backend" da aplicação, inicialmente somente contem a pasta "Controller", tambem pode conter outras pastas para dividir melhor o projeto, como Model, Libraries, Entities, etc;
* **web**: Contem os arquivos que serão usados no frontend (css, JS, imagens, etc)
  
**Criando página (view)**  
Para criar uma página, primeiramente é definido sua rota. Por padrão o symfony define as rotas usando o "Annotation", diretamente nas classes de "Controllers". Para esse exemplo vamos definir as rotas pelo arquivo **app/config/routing.yml**. inicialmente este arquivo contem:
 ```
app:
    resource: "@AppBundle/Controller/"
    type:     annotation
```
Comente ou delete essas linha.  
Segue um exemplo para criar uma nova rota no arquivo routing.yml.  
``` 
route_nova_pagina:
    path: /nova-pagina
    defaults : {_controller : AppBundle:Site:pagina}
``` 
Explicando: 
`route_nova_pagina:` É o nome da rota, usado para fazer referencias internas para essa rota.  
` path: /nova-pagina` É a URI de acesso no navegador.
`defaults : {_controller : AppBundle:Site:pagina}` Define o Bundle(AppBundle), Controller(Site) e Action(pagina) que fará a execução da rota.
 Para entender mais sobre rotas veja a documentação de rotas do symfony, [nesse link][1].

**Criando um Controller**
Para a rota criada `/nova-pagina` Será criado o controller `SiteController` que terá o método `paginaAction`.
Arquivo "src/AppBundle/Controller/SiteController.php"
```
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller {   
    public function paginaAction(Request $request) {
         $list = ['Iten 01', 'Iten 02', 'Iten 03'];
        return $this->render('site/pagina.html.twig', ['list' => $list]);
    }
}
``` 

Explicando:  
`namespace AppBundle\Controller;` Define o namespace do controller.

Importa as classes necessárias de Rota, Request e Controller
`use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;`
`use Symfony\Bundle\FrameworkBundle\Controller\Controller;`
`use Symfony\Component\HttpFoundation\Request;`

`class SiteController extends Controller {` Cria a classe do controller extendendo a classe "Controller" do Symfony.

`public function paginaAction(Request $request) {` Cria o método `pagina`, recebendo a variável `$request` como parâmetro, onde contem os dados da requisição (parâmetros de GET, POST, SERVER, etc)

`$list = ['Iten 01', 'Iten 02', 'Iten 03'];` Um array simples somente para exemplificar a passarem de dados para a view.

`return $this->render('site/pagina.html.twig', ['list' => $list]);` Chama o método "render" do Controller, passando a página view como primeiro parâmetro, nesse caso o view é o arquivo "app/Resources/views/site/pagina.html.twig", e como segundo parâmetro passa um array com variáveis que poden ser lidas pela view.

**View**
As views padrões do symfony são executadas com o Twig template engine. Pode ser usado HTML normalmente, porem o Twig oferece alguns recursos para manipular a página.
Arquivo "app/Resources/views/site/pagina.html.twig"
```
<!DOCTYPE html>
<html>
<head>
  <title>Aplicação de exemplo Symfony</title>
</head>
<body>
  <div>
    <h1>Site - Página</h1>
    <ul>
      {% for iten in list %}
        <li>{{ iten }}</li>
      {% endfor %}
    </ul>
  </div>
</body>
</html>
```
Explicando:
Além da estrutura HTML normal esse arquivo tem alguns elementos Twig. No é um "for" usado para criar uma lista de itens.
`{% for iten in list %}` As instruções do Twig ficam dentro de `{% %}`.
A variável "list" é o mesmo indice do array passado como segundo parâmetro no controller para o método "$this->render('site/pagina.html.twig', ['list' => $list]);"
`<li>{{ iten }}</li>` Para exibir uma variável PHP pelo Twig é preciso colocar entre `{{  }}`
`{% endfor %}` Finaliza a instrução "for"

Para mais detalhes sobre como usar o Twig, veja na documentação, [neste link][2]

 [1]: https://symfony.com/doc/current/routing.html
 [2]: http://symfony.com/doc/current/templating.html