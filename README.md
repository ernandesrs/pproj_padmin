# PADMIN - Painel Administrativo
PADMIN é um painel administrativo criado com o intuito de colocar em prática conhecimentos adquiridos em programação web fullstack, utilizando o Vue 3 com o Inertia JS e Bootstrap 5 no frontend; e Laravel 8 no backend.

## Alguns recursos implementados
### Autenticação
1. Login
2. Registro
3. Verificação de conta
4. Solicitação de recuperação de senha
5. Atualização de senha

### Painel administrativo
1. Gerenciamento de usuários(crud)
   - Promoção e rebaixamento de nível de usuário
2. Gerenciamento de mídias
   - Imagens(crud)
   - Vídeos(curd)
3. Gerencimento de um site
   - Gerenciamento de seções(crud)
   - Gerenciamento de páginas(crud)
   - Gerenciamento de menus
   - Configurações

## Instalação
### Requisitos
Necessário todas as ferramentas básicas para um desenvolvimento em Laravel e Vue JS.

### Passos
1. Obtenha o código fonte do seu jeito(clone, download) e coloque-o onde for melhor para você.
2. Acesse a pasta da aplicação via terminal e execute os seguintes comandos:
   > npm install
   > composer install
3. Copie o '.env.example' e renomear para '.env'.
4. Abra o '.env' e essencialmente configurar:
   - Dados de acesso ao seu banco de dados local
   - Dados SMTP para envio de emails como o https://mailtrap.io (necessário para envio de emails ao criar uma conta ou criar usuários)
5. Gere as tabelas do banco de dados com:
   > php artisan migrate
6. Gere a chave da aplicação:
   > php artisan key:generate
7. Gere o link simbólico para a pasta pública:
   > php artisan storage:link
8. Execute o comando abaixo para criar um super usuário e criar os dados básicos da aplicação:
   > php artisan padmin:start --mail=emailvalidoaqui --pass=senhaaqui
9. Por fim, execute o servidor Laravel com:
   > php artisan serve
   
#### Dados do usuário comum:
   - E-mail: guest@guest.mail
   - Senha: guestpassword

#### Acesso a página inicial:
   - <b><i>http://127.0.0.1:8000</i></b>

#### Acesso a página de login:
   - <b><i>http://127.0.0.1:8000</i>/auth/login</b>

#### Acesso ao painel:
   - <b><i>http://127.0.0.1:8000</i>/admin</b>