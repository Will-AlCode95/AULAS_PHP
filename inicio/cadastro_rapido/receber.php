<?php
/**
 * receber.php — Processamento, validação e resposta do Cadastro Rápido
 *
 * Fluxo:
 *   1. Aceita apenas POST
 *   2. Sanitiza e valida cada campo
 *   3. Se houver erros → exibe página de falha listando todos
 *   4. Se tudo OK    → exibe página de confirmação com os dados
 */

declare(strict_types=1);

/* ──────────────────────────────────────────
   0. SEGURANÇA: apenas POST é permitido
────────────────────────────────────────── */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Location: formulario.html');
    exit;
}

/* ──────────────────────────────────────────
   1. COLETA E SANITIZAÇÃO
────────────────────────────────────────── */
$nome       = trim(htmlspecialchars($_POST['nome']      ?? '', ENT_QUOTES, 'UTF-8'));
$email      = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
$assunto    = trim(htmlspecialchars($_POST['assunto']   ?? '', ENT_QUOTES, 'UTF-8'));
$idadeRaw   = trim($_POST['idade'] ?? '');
$newsletter = isset($_POST['newsletter']) && $_POST['newsletter'] === '1';

/* ──────────────────────────────────────────
   2. VALIDAÇÃO
────────────────────────────────────────── */
$erros = [];

// Nome — obrigatório, máx 50 chars
if ($nome === '') {
    $erros[] = 'O campo <strong>Nome</strong> é obrigatório.';
} elseif (mb_strlen($nome) > 50) {
    $erros[] = 'O campo <strong>Nome</strong> deve ter no máximo 50 caracteres.';
}

// E-mail — obrigatório, formato válido
if ($email === '') {
    $erros[] = 'O campo <strong>E-mail</strong> é obrigatório.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = 'O campo <strong>E-mail</strong> está em formato inválido.';
}

// Assunto — obrigatório, apenas valores permitidos
$assuntosPermitidos = ['duvida', 'sugestao', 'suporte'];
if ($assunto === '') {
    $erros[] = 'O campo <strong>Assunto</strong> é obrigatório.';
} elseif (!in_array($assunto, $assuntosPermitidos, true)) {
    $erros[] = 'O campo <strong>Assunto</strong> contém um valor inválido.';
}

// Idade — opcional, mas se preenchida deve ser 1–120
$idade = null;
if ($idadeRaw !== '') {
    if (!ctype_digit($idadeRaw)) {
        $erros[] = 'O campo <strong>Idade</strong> deve conter apenas números.';
    } else {
        $idadeInt = (int)$idadeRaw;
        if ($idadeInt < 10 || $idadeInt > 120) {
            $erros[] = 'O campo <strong>Idade</strong> deve estar entre 10 e 120 anos.';
        } else {
            $idade = $idadeInt;
        }
    }
}

/* ──────────────────────────────────────────
   3. MAPA DE RÓTULOS
────────────────────────────────────────── */
$assuntoLabels = [
    'duvida'   => 'Dúvida',
    'sugestao' => 'Sugestão',
    'suporte'  => 'Suporte',
];

/* ──────────────────────────────────────────
   4. RESPOSTA HTML (erro ou sucesso)
────────────────────────────────────────── */
$temErro = count($erros) > 0;
$titulo  = $temErro ? 'Erros no Cadastro' : 'Cadastro Confirmado';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $titulo ?> — Cadastro Rápido</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <style>
    :root {
      --bg:      #0d0f14;
      --surface: #161a23;
      --border:  #262c3a;
      --accent:  #c9a84c;
      --text:    #e8e4dc;
      --muted:   #7a7f90;
      --error:   #e05c5c;
      --success: #5cbf8a;
      --radius:  10px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
      background-image:
        radial-gradient(ellipse 60% 40% at 80% 10%,
          <?= $temErro ? 'rgba(224,92,92,.07)' : 'rgba(92,191,138,.07)' ?> 0%, transparent 60%),
        radial-gradient(ellipse 50% 40% at 10% 90%, rgba(201,168,76,.05) 0%, transparent 60%);
    }

    .card {
      width: 100%;
      max-width: 520px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 2.8rem 2.6rem;
      box-shadow: 0 24px 64px rgba(0,0,0,.5);
      animation: fadeUp .55s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(22px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .status-icon {
      width: 56px; height: 56px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.6rem;
      margin-bottom: 1.2rem;
      <?= $temErro
          ? 'background: rgba(224,92,92,.12); border: 1px solid rgba(224,92,92,.3);'
          : 'background: rgba(92,191,138,.12); border: 1px solid rgba(92,191,138,.3);'
      ?>
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-size: 1.75rem;
      font-weight: 700;
      margin-bottom: .45rem;
      color: <?= $temErro ? 'var(--error)' : 'var(--success)' ?>;
    }

    .subtitle {
      font-size: .88rem;
      color: var(--muted);
      margin-bottom: 1.8rem;
    }

    /* ── BLOCO DE ERROS ── */
    .error-list {
      list-style: none;
      padding: 0;
      margin: 0 0 1.8rem;
      display: flex;
      flex-direction: column;
      gap: .6rem;
    }

    .error-list li {
      display: flex;
      align-items: flex-start;
      gap: .65rem;
      background: rgba(224,92,92,.07);
      border: 1px solid rgba(224,92,92,.2);
      border-left: 3px solid var(--error);
      border-radius: 6px;
      padding: .65rem .9rem;
      font-size: .86rem;
      color: #e8aaaa;
      line-height: 1.5;
    }

    .error-list li::before {
      content: '✕';
      color: var(--error);
      font-size: .7rem;
      margin-top: 3px;
      flex-shrink: 0;
    }

    /* ── BLOCO DE SUCESSO ── */
    .data-grid {
      display: grid;
      gap: .8rem;
      margin-bottom: 1.8rem;
    }

    .data-row {
      display: flex;
      flex-direction: column;
      gap: .25rem;
      background: rgba(255,255,255,.03);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: .8rem 1rem;
    }

    .data-label {
      font-size: .7rem;
      font-weight: 500;
      letter-spacing: .1em;
      text-transform: uppercase;
      color: var(--muted);
    }

    .data-value {
      font-size: .96rem;
      color: var(--text);
    }

    .pill {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      font-size: .78rem;
      font-weight: 500;
      padding: .25rem .75rem;
      border-radius: 99px;
    }

    .pill-assunto {
      background: rgba(201,168,76,.12);
      border: 1px solid rgba(201,168,76,.3);
      color: var(--accent);
    }

    .pill-sim {
      background: rgba(92,191,138,.12);
      border: 1px solid rgba(92,191,138,.3);
      color: var(--success);
    }

    .pill-nao {
      background: rgba(122,127,144,.1);
      border: 1px solid rgba(122,127,144,.2);
      color: var(--muted);
    }

    /* ── BOTÕES ── */
    .actions { display: flex; gap: .8rem; flex-wrap: wrap; }

    .btn {
      flex: 1;
      min-width: 130px;
      padding: .8rem 1rem;
      border-radius: var(--radius);
      font-family: 'DM Sans', sans-serif;
      font-size: .88rem;
      font-weight: 500;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
      transition: all .18s;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--accent) 0%, #a8862f 100%);
      color: #0d0f14;
      border: none;
      box-shadow: 0 4px 16px rgba(201,168,76,.22);
    }

    .btn-primary:hover { opacity: .9; transform: translateY(-1px); }

    .btn-outline {
      background: transparent;
      color: var(--muted);
      border: 1px solid var(--border);
    }

    .btn-outline:hover {
      border-color: var(--accent);
      color: var(--accent);
    }

    strong { font-weight: 600; }
  </style>
</head>
<body>
<div class="card">

<?php if ($temErro): ?>
  <!-- ════════════ PÁGINA DE ERRO ════════════ -->
  <div class="status-icon">✕</div>
  <h1>Dados Inválidos</h1>
  <p class="subtitle">
    Encontramos <?= count($erros) ?> problema<?= count($erros) > 1 ? 's' : '' ?>
    no formulário. Corrija-<?= count($erros) > 1 ? 'os' : 'o' ?> e tente novamente.
  </p>

  <ul class="error-list">
    <?php foreach ($erros as $erro): ?>
      <li><?= $erro /* já sanitizado acima */ ?></li>
    <?php endforeach; ?>
  </ul>

  <div class="actions">
    <a href="javascript:history.back()" class="btn btn-primary">← Corrigir formulário</a>
    <a href="formulario.html" class="btn btn-outline">Recomeçar</a>
  </div>

<?php else: ?>
  <!-- ════════════ PÁGINA DE SUCESSO ════════════ -->
  <div class="status-icon">✓</div>
  <h1>Cadastro Confirmado</h1>
  <p class="subtitle">Seus dados foram recebidos com sucesso.</p>

  <div class="data-grid">
    <div class="data-row">
      <span class="data-label">Nome</span>
      <span class="data-value"><?= $nome ?></span>
    </div>

    <div class="data-row">
      <span class="data-label">E-mail</span>
      <span class="data-value"><?= $email ?></span>
    </div>

    <div class="data-row">
      <span class="data-label">Assunto</span>
      <span class="data-value">
        <span class="pill pill-assunto">
          <?= $assuntoLabels[$assunto] ?>
        </span>
      </span>
    </div>

    <div class="data-row">
      <span class="data-label">Idade</span>
      <span class="data-value">
        <?= $idade !== null ? $idade . ' anos' : '<em style="color:var(--muted);font-size:.88rem">Não informada</em>' ?>
      </span>
    </div>

    <div class="data-row">
      <span class="data-label">Newsletter</span>
      <span class="data-value">
        <?php if ($newsletter): ?>
          <span class="pill pill-sim">✓ Inscrito</span>
        <?php else: ?>
          <span class="pill pill-nao">— Não inscrito</span>
        <?php endif; ?>
      </span>
    </div>
  </div>

  <div class="actions">
    <a href="formulario.html" class="btn btn-primary">Novo cadastro</a>
    <a href="#" class="btn btn-outline" onclick="window.print();return false;">Imprimir</a>
  </div>

<?php endif; ?>

</div>
</body>
</html>
