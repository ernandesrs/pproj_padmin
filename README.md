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
3. Copiar o '.env.example' e renomear para '.env'.
4. Abrir o '.env' e essencialmente configurar:
   - Dados de acesso ao seu banco de dados local
   - Dados SMTP para envio de emails como o https://mailtrap.io (necessário para envio de emails ao criar uma conta ou criar usuários)
5. Executar o servidor Laravel com:
   > php artisan serve
6. Gerar das tabelas do banco de dados com:
   > php artisan migrate
7. Gerar chave da aplicação:
   > php artisan key:generate
8. Gerar link simbólico para a pasta pública:
   > php artisan storage:link
9. Por fim, acesse no navegador a seguinte url: <b><i>http://127.0.0.1:8000</i>/builder</b> (funcionará apenas se sua aplicação estiver configurada com <b>APP_LOCAL</b> como 'local' e não 'production'). Esta url irá criar os dados básicos para a aplicação como usuário principal e um usuário comum; além de algumas páginas e dados de configuração para o front da aplicação.

#### Dados do usuário principal:
   - E-mail: master@master.mail ou então o email configurado na variável ambiente <b>MAIL_ADMIN_ADDRESS</b>.
   - Senha: masterpassword
   
#### Dados do usuário comum:
   - E-mail: guest@guest.mail.
   - Senha: guestpassword

#### Acesso a página inicial:
   - <b><i>http://127.0.0.1:8000</i></b>

#### Acesso a página de login:
   - <b><i>http://127.0.0.1:8000</i>/auth/login</b>

#### Acesso ao painel:
   - <b><i>http://127.0.0.1:8000</i>/admin</b>