# Api para controle de pátios e containers

## Instalação e configuração:

Instalar na máquina as seguintes ferramentas:</br>
[Docker](https://www.docker.com/products/docker-desktop) </br>
[Git](https://git-scm.com/downloads) </br>

Após clonar o projeto, acesse o diretório e digite os seguintes comandos:

```
docker-compose up -d --build
docker exec -i -u root dockyard chmod 777 -R storage
docker exec -i -u root dockyard php -r "file_exists('.env') || copy('.env.example', '.env');"
docker exec -i -u root dockyard composer install
docker exec -i -u root dockyard php artisan key:generate
docker exec -i -u root dockyard php artisan migrate
```

Após isso, o ambiente estará pronto para uso sendo:
1.  Aplicação Web - http://localhost:8080
2.  Admin Web Mysql - http://localhost:8081


## Regras gerais:

Essa aplicação deve usar o sistema internacional de unidades. (https://pt.wikipedia.org/wiki/Sistema_Internacional_de_Unidades)

## Papéis de usuários
1.  Gerente de Imóveis
2.  Gerente de Logística
3.  Operador de Logística
      
## Pátios

Cada galpão deve possuir os seguintes atributos no banco de dados

-   Id    
-   Localizador (único e formado por 3 letras)
-   Comprimento (em cm) - inteiro
-   Largura (em cm) - inteiro
    
E os seguintes atributos calculados

-   Área (m<sup>2</sup>) - duas casas decimais

Além disso ele deve obedecer os seguintes padrões:
  
1.  Possui formato retangular  
2.  Apenas usuários com o papel gerente de imóveis podem gerenciar pátios
3.  Pátios podem ser listados, cadastrados, editados e excluídos
4.  Apenas pátios vazios podem ser excluídos
5.  O pátio não pode ter a área diminuída
6.  A área mínima do pátio é a de um container padrão
7.  Os pátios podem armazenar contêineres de acordo com a área máxima sem limite de peso total.
8.  O armazenamento de containers sempre será feito mantendo a direção dos mesmos conforme imagem abaixo:

![](https://lh6.googleusercontent.com/lFYb-RGQ7bEqWwDFKfwUQrqRlfVma4WmDbGN7BhjVd-wrnmKk0lA2uB6Qs342QgbM-U_N__WxybSJjxpqd99CEvzMLfsRN1BrSbrhMXttMs50ekY0Ck5tBrLFwkcr5ojXxxxeycTvcKn2tsIrA)

## Containers

Cada contêiner deve possuir os seguintes atributos

-   Localizador (Único e formado por uma letra maiúscula e 2 dígitos, exemplo: X34)    
-   Altura (cm) - inteiro
-   Comprimento (cm) - inteiro
-   Largura (cm) - inteiro
-   Peso da Tara (kg) - inteiro
-   Peso máximo de armazenamento (kg) - inteiro
-   Pátio de armazenamento

E os seguintes atributos calculados

-   Volume (m<sup>3</sup>) - duas casas decimais
-   Peso Bruto (Peso da tara + peso das caixas) (tonelada)
-   Volume livre (m<sup>3</sup>) - duas casas decimais
-   Volume preenchido (m<sup>3</sup>) - duas casas decimais

Além disso eles devem obedecer às seguintes normas:

1.  Todo container nessa aplicação deverá ter as medidas pré-definidas como na imagem abaixo:

![](https://lh4.googleusercontent.com/ISWW7au9J00pKDRCy0qE0h6nmBRCkUJJd9XFauIyl4nP977RrojNoeSpQ9m317i78m7m6jC_8mDfO69lfZ6N2qoDg-4FUXXo5rvILRpXTyjOY31-eN1yjnyw1N9GwgH1byiJoMI5LeiNwJARKQ)

2.  Apenas usuários com o papel gerente de logística podem gerenciar containers
3.  Containers podem ser cadastrados, excluídas e restauradas (soft delete)
4.  Apenas containers vazios podem ser inativados
5.  Os containers podem armazenar caixas de acordo com a área e volume máximos
6.  Cada container pode armazenar no máximo 18 toneladas (fora as 2.44 toneladas de tara)
7.  Os containers podem ser empilhados desde que a quantidade empilhada não ultrapasse 9 containers.

## Caixas

As caixas devem possuir os seguintes atributos:
-   Identificador (GUID)
-   Altura (em cm) - inteiro
-   Comprimento (em cm) - inteiro
-   Largura (em cm) - inteiro
-   Peso (em gramas) - inteiro
-   Container de armazenamento

E os seguintes atributos calculados
- Volume (m<sup>3</sup>) - duas casas decimais

Além disso eles devem obedecer às seguintes normas:
1.  Toda caixa tem formato cúbico
2.  Qualquer usuário autenticado pode gerenciar caixas
3.  Caixas podem ser cadastradas e excluídas
4.  As caixas podem ser empilhados livremente desde que haja espaço vertical