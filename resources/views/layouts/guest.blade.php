<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MentorConnect') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"></noscript>
    <style>
        :root { --primary: #2563EB; --primary-dark: #1d4ed8; --primary-light: #dbeafe; --bg-light: #f8fafc; }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-light); min-height: 100vh; margin: 0; padding: 0; }
        .auth-card { border: none; border-radius: 1.25rem; box-shadow: 0 4px 24px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04); }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); border-radius: 0.75rem; padding: 0.625rem 1.25rem; font-weight: 600; transition: all .2s ease; }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
        .form-control { border-radius: 0.75rem; padding: 0.625rem 1rem; border: 1.5px solid #e2e8f0; transition: all .2s ease; font-size: 0.9375rem; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
        .form-control.is-invalid { border-color: #dc3545; }
        .form-control.is-invalid:focus { border-color: #dc3545; box-shadow: 0 0 0 3px rgba(220,53,69,0.12); }
        .input-group-text { border-radius: 0.75rem; border: 1.5px solid #e2e8f0; background: #f8fafc; color: #64748b; }
        .input-group .form-control { border-radius: 0 0.75rem 0.75rem 0; }
        .input-group .input-group-text + .form-control { border-radius: 0 0.75rem 0.75rem 0; }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }
        .form-check-input:focus { box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
        .auth-logo { width: 56px; height: 56px; background: var(--primary); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto; }
        .auth-logo i { font-size: 1.75rem; color: #fff; }
        .illustration-box { background: linear-gradient(135deg, var(--primary) 0%, #7c3aed 100%); border-radius: 1.25rem; min-height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 3rem; color: #fff; text-align: center; }
        .illustration-box i { font-size: 5rem; margin-bottom: 1.5rem; opacity: 0.9; }
        .illustration-box h3 { font-weight: 700; margin-bottom: 0.75rem; }
        .illustration-box p { opacity: 0.85; max-width: 280px; line-height: 1.6; }
        .role-card { border: 2px solid #e2e8f0; border-radius: 1rem; padding: 1rem; cursor: pointer; transition: all .2s ease; text-align: center; }
        .role-card:hover { border-color: var(--primary); background: var(--primary-light); }
        .role-card.active { border-color: var(--primary); background: var(--primary-light); }
        .role-card i { font-size: 1.75rem; color: var(--primary); }
        .role-card .role-label { font-weight: 600; color: #1e293b; margin-top: 0.5rem; }
        .role-card .role-desc { font-size: 0.8rem; color: #64748b; }
        .divider { display: flex; align-items: center; gap: 0.75rem; color: #94a3b8; font-size: 0.875rem; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
        .text-muted-small { font-size: 0.875rem; color: #64748b; }
        @media (max-width: 991.98px) { .illustration-box { display: none; } }
    </style>
</head>
<body>
    {{ $slot }}
    <script>
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('.password-input');
            if (!input) return;
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                if (icon) { icon.classList.remove('bi-eye'); icon.classList.add('bi-eye-slash'); }
            } else {
                input.type = 'password';
                if (icon) { icon.classList.remove('bi-eye-slash'); icon.classList.add('bi-eye'); }
            }
        });
    });
    document.querySelectorAll('.role-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.role-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const radio = this.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        });
    });
    </script>
</body>
</html>
