# CRM Premium com Laravel 12 + Tailwind CSS

Sistema completo de captura de leads (Quiz) e CRM (Kanban) com classificação via IA (Gemini).

## Requisitos

- PHP 8.2+
- Composer
- MySQL
- Node.js (opcional, pois usamos CDN para Tailwind/Alpine)

## Instalação

1. **Configurar Banco de Dados**
   - Crie um banco de dados MySQL (ex: `crm_fred`).
   - Renomeie o arquivo `.env.example` para `.env`.
   - Configure as credenciais do banco no `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=crm_fred
     DB_USERNAME=root
     DB_PASSWORD=
     ```

2. **Configurar API do Gemini**
   - Adicione sua chave de API do Google Gemini no `.env`:
     ```
     GEMINI_API_KEY=sua_chave_aqui
     ```

3. **Instalar Dependências**
   ```bash
   composer install
   ```

4. **Gerar Chave da Aplicação**
   ```bash
   php artisan key:generate
   ```

5. **Rodar Migrations**
   ```bash
   php artisan migrate
   ```
   *Ou use o arquivo `database.sql` para criar a tabela manualmente.*

6. **Iniciar Servidor**
   ```bash
   php artisan serve
   ```

## Acesso

- **Quiz (Captura)**: `http://localhost:8000/`
- **Admin (CRM)**: `http://localhost:8000/admin/login`
  - **Email**: `admin@example.com`
  - **Senha**: `admin123`

## Estrutura

- `app/Models/Lead.php`: Modelo de dados.
- `app/Services/GeminiService.php`: Integração com IA.
- `app/Http/Controllers/Api/LeadController.php`: API de captura.
- `app/Http/Controllers/AdminController.php`: Painel administrativo.
- `resources/views/quiz.blade.php`: Frontend do Quiz.
- `resources/views/admin/kanban.blade.php`: Dashboard Kanban.
